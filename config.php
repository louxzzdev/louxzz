<?php
declare(strict_types=1);

$localConfigPath = __DIR__ . '/config.local.php';
$localConfig = is_file($localConfigPath) ? require $localConfigPath : [];
$localConfig = is_array($localConfig) ? $localConfig : [];

define('APP_DEBUG', (bool)($localConfig['app_debug'] ?? false));
define('DB_HOST', (string)($localConfig['db_host'] ?? (getenv('DB_HOST') ?: 'localhost')));
define('DB_NAME', (string)($localConfig['db_name'] ?? (getenv('DB_NAME') ?: '')));
define('DB_USER', (string)($localConfig['db_user'] ?? (getenv('DB_USER') ?: '')));
define('DB_PASS', (string)($localConfig['db_pass'] ?? (getenv('DB_PASS') ?: '')));
define('DB_CHARSET', 'utf8mb4');

unset($localConfig, $localConfigPath);

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
        exit('unable to connect to the database.');
    }

    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function safe_external_url(string $url): string
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return '';
    }

    $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));
    return in_array($scheme, ['http', 'https'], true) ? $url : '';
}

function start_app_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $forwardedProto = strtolower((string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $forwardedProto === 'https';

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
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
        redirect_to('/dash/login');
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

function set_flash(string $message, string $type = 'success'): void
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
        $errors[] = 'name must be between 2 and 120 characters.';
    }

    if (text_length($url) > 255 || !filter_var($url, FILTER_VALIDATE_URL)) {
        $errors[] = 'enter a valid url.';
    } else {
        $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));

        if (!in_array($scheme, ['http', 'https'], true)) {
            $errors[] = 'the url must begin with http:// or https://.';
        }
    }

    if (text_length($description) < 3 || text_length($description) > 1000) {
        $errors[] = 'description must be between 3 and 1000 characters.';
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
