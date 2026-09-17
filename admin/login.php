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
        $error = 'Your session is invalid. Please try again.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter your email and password.';
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

        $error = 'Incorrect email or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - louxzz.net</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='14' fill='%230b0c0e'/><path d='M22 18 L42 32 L22 46' fill='none' stroke='%23c9cdd3' stroke-width='6' stroke-linecap='round' stroke-linejoin='round'/></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <main class="pagina-login">
        <form class="login-caixa" method="post" action="/admin/login.php" autocomplete="on">
            <p class="sinal">Admin</p>
            <h1>Sign in</h1>
            <p>Access the dashboard to manage your portfolio projects.</p>

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
                <button class="botao" type="submit">Sign in</button>
                <a class="botao secundario" href="/">Back to site</a>
            </div>
        </form>
    </main>
</body>
</html>
