<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';

start_app_session();

if (!empty($_SESSION['admin_id'])) {
    redirect_to('/admin/dashboard.php');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(clean_text((string)($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL);
    $password = (string)($_POST['password'] ?? '');

    if (!csrf_is_valid()) {
        $error = 'Sessao invalida. Tenta outra vez.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Preenche os dados de acesso.';
    } else {
        $statement = db()->prepare('SELECT id, name, email, password_hash FROM admins WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $admin = $statement->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$admin['id'];
            $_SESSION['admin_name'] = (string)$admin['name'];
            redirect_to('/admin/dashboard.php');
        }

        $error = 'Email ou password incorretos.';
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - louxzz.net</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <main class="pagina-login">
        <form class="login-caixa" method="post" action="/admin/login.php" autocomplete="on">
            <p class="sinal">Admin</p>
            <h1>Entrar</h1>
            <p>Acede ao painel para gerir os projetos do portfolio.</p>

            <?php if ($error): ?>
                <div class="aviso"><?= e($error) ?></div>
            <?php endif; ?>

            <?= csrf_input() ?>

            <div class="campo">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?= e($email) ?>" required maxlength="190" autocomplete="email">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password">
            </div>

            <div class="acoes">
                <button class="botao" type="submit">Entrar</button>
                <a class="botao secundario" href="/">Voltar</a>
            </div>
        </form>
    </main>
</body>
</html>
