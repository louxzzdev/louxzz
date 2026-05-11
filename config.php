<?php
declare(strict_types=1);

const APP_DEBUG = false;
const DB_HOST = 'localhost';
const DB_NAME = 'louxzz_net';
const DB_USER = 'louxzz_portfolio';
const DB_PASS = 'GiggaNinja55%';
const DB_CHARSET = 'utf8mb4';

if (APP_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        http_response_code(500);
        exit('Erro ao ligar a base de dados.');
    }

    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function start_app_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    session_name('louxzz_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function redirect_to(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function require_admin(): void
{
    start_app_session();

    if (empty($_SESSION['admin_id'])) {
        redirect_to('/admin/login.php');
    }
}

function csrf_token(): string
{
    start_app_session();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_input(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_is_valid(): bool
{
    start_app_session();

    $token = (string)($_POST['csrf_token'] ?? '');
    return $token !== '' && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function set_flash(string $message, string $type = 'sucesso'): void
{
    start_app_session();
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type,
    ];
}

function get_flash(): ?array
{
    start_app_session();

    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function clean_text(string $value): string
{
    return trim(str_replace("\0", '', $value));
}

function text_length(string $value): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($value, 'UTF-8');
    }

    return strlen($value);
}

function validate_project_input(array $source): array
{
    $name = clean_text((string)($source['name'] ?? ''));
    $url = clean_text((string)($source['url'] ?? ''));
    $description = clean_text((string)($source['description'] ?? ''));
    $errors = [];

    if (text_length($name) < 2 || text_length($name) > 120) {
        $errors[] = 'O nome deve ter entre 2 e 120 caracteres.';
    }

    if (text_length($url) > 255 || !filter_var($url, FILTER_VALIDATE_URL)) {
        $errors[] = 'Indica um URL valido.';
    } else {
        $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));

        if (!in_array($scheme, ['http', 'https'], true)) {
            $errors[] = 'O URL deve comecar por http:// ou https://.';
        }
    }

    if (text_length($description) < 3 || text_length($description) > 1000) {
        $errors[] = 'A descricao deve ter entre 3 e 1000 caracteres.';
    }

    return [
        [
            'name' => $name,
            'url' => $url,
            'description' => $description,
        ],
        $errors,
    ];
}
