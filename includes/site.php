<?php
declare(strict_types=1);

function send_security_headers(): void
{
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header("Content-Security-Policy: default-src 'self'; img-src 'self' https://avatars.githubusercontent.com data:; style-src 'self'; script-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; object-src 'none'");
}

function asset_url(string $path): string
{
    $file = dirname(__DIR__) . '/' . ltrim($path, '/');
    $version = is_file($file) ? (string)filemtime($file) : '1';
    return $path . '?v=' . rawurlencode($version);
}

function site_header(string $title, string $description, string $canonical, string $active = ''): void
{
    send_security_headers();
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <meta name="theme-color" content="#f5f4ef" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#11110f" media="(prefers-color-scheme: dark)">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="lou">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= e($title) ?>">
    <meta name="twitter:description" content="<?= e($description) ?>">
    <link rel="icon" href="<?= e(asset_url('/assets/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/style.css')) ?>">
</head>
<body>
    <a class="skip-link" href="#main">skip to content</a>
    <header class="site-header">
        <a class="wordmark" href="/"<?= $active === 'home' ? ' aria-current="page"' : '' ?>>
            <span class="wordmark-mark" aria-hidden="true"></span>
            lou
        </a>
        <nav class="site-nav" aria-label="primary navigation">
            <a href="/#projects">projects</a>
            <a href="/contact"<?= $active === 'contact' ? ' aria-current="page"' : '' ?>>contact</a>
            <a href="https://github.com/louxzzdev" target="_blank" rel="noopener noreferrer">github <span aria-hidden="true">&#8599;</span></a>
        </nav>
    </header>
    <main id="main" class="site-main">
    <?php
}

function site_footer(): void
{
    ?>
    </main>
    <footer class="site-footer">
        <span class="footer-name"><span class="wordmark-mark" aria-hidden="true"></span>lou</span>
        <nav aria-label="social links">
            <a href="https://github.com/louxzzdev" target="_blank" rel="noopener noreferrer">github <span aria-hidden="true">&#8599;</span></a>
            <a href="https://instagram.com/notlourenco" target="_blank" rel="noopener noreferrer">instagram <span aria-hidden="true">&#8599;</span></a>
        </nav>
    </footer>
</body>
</html>
    <?php
}
