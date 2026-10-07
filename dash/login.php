<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/site.php';

start_app_session();

if (!empty($_SESSION['admin_id'])) {
    redirect_to('/dash');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_text((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $attempts = (int)($_SESSION['login_attempts'] ?? 0);
    $attemptedAt = (int)($_SESSION['login_attempted_at'] ?? 0);

    if ($attemptedAt > 0 && time() - $attemptedAt > 300) {
        $attempts = 0;
        unset($_SESSION['login_attempts'], $_SESSION['login_attempted_at']);
    }

    if (!csrf_is_valid()) {
        $error = 'your session is invalid. please try again.';
    } elseif ($attempts >= 5) {
        $error = 'too many sign-in attempts. please wait a few minutes.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'enter your email and password.';
    } else {
        $statement = db()->prepare('SELECT id, password_hash FROM admins WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $admin = $statement->fetch();
        $fallbackHash = '$2y$12$HVNMlwDW1Vj8Um3eZuXAbuq3MyXfah6kBchuAjrqIav9OFUXrzuH.';
        $passwordIsValid = password_verify($password, (string)($admin['password_hash'] ?? $fallbackHash));

        if ($admin && $passwordIsValid) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$admin['id'];
            unset($_SESSION['login_attempts'], $_SESSION['login_attempted_at']);
            redirect_to('/dash');
        }

        $_SESSION['login_attempts'] = $attempts + 1;
        $_SESSION['login_attempted_at'] = time();
        $error = 'incorrect email or password.';
    }
}

send_security_headers();
header('X-Robots-Tag: noindex, nofollow');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>login — lou</title>
    <link rel="icon" href="<?= e(asset_url('/assets/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/style.css')) ?>">
</head>
<body class="login-page">
    <main id="main" class="login-main">
        <a class="wordmark" href="/">lou</a>
        <form class="form login-form" method="post" action="/dash/login" autocomplete="on">
            <header>
                <p class="eyebrow">dashboard</p>
                <h1>sign in</h1>
            </header>
            <?php if ($error): ?>
                <div class="notice error" role="alert"><?= e($error) ?></div>
            <?php endif; ?>
            <?= csrf_input() ?>
            <div class="field">
                <label for="email">email</label>
                <input id="email" name="email" type="email" value="<?= e($email) ?>" required maxlength="190" autocomplete="email">
            </div>
            <div class="field">
                <label for="password">password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password">
            </div>
            <div class="form-actions">
                <button class="button" type="submit">sign in</button>
                <a class="text-link" href="/">back to site</a>
            </div>
        </form>
    </main>
</body>
</html>
