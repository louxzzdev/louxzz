<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/site.php';

function admin_header(string $title, string $heading, string $active = ''): void
{
    $flash = get_flash();
    send_security_headers();
    header('X-Robots-Tag: noindex, nofollow');
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title) ?> — lou</title>
    <meta name="theme-color" content="#f5f4ef" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#11110f" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="<?= e(asset_url('/assets/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/style.css')) ?>">
</head>
<body class="admin-body">
    <a class="skip-link" href="#main">skip to content</a>
    <header class="site-header admin-header">
        <a class="wordmark" href="/dash">lou</a>
        <nav class="site-nav" aria-label="dashboard navigation">
            <a href="/dash"<?= $active === 'dashboard' ? ' aria-current="page"' : '' ?>>dashboard</a>
            <a href="/dash/projects/new"<?= $active === 'new' ? ' aria-current="page"' : '' ?>>add project</a>
            <a href="/dash/logout">logout</a>
        </nav>
    </header>
    <main id="main" class="admin-main">
        <?php if ($flash): ?>
            <div class="notice <?= ($flash['type'] ?? '') === 'error' ? 'error' : 'success' ?>" role="status"><?= e((string)$flash['message']) ?></div>
        <?php endif; ?>
        <header class="admin-title">
            <p class="eyebrow">dashboard</p>
            <h1><?= e($heading) ?></h1>
        </header>
    <?php
}

function admin_footer(): void
{
    ?>
    </main>
</body>
</html>
    <?php
}
