<?php
declare(strict_types=1);

function admin_header(string $title): void
{
    $flash = get_flash();
    $adminName = (string)($_SESSION['admin_name'] ?? 'Admin');
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title) ?> - louxzz.net</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='14' fill='%230b0c0e'/><path d='M22 18 L42 32 L22 46' fill='none' stroke='%23c9cdd3' stroke-width='6' stroke-linecap='round' stroke-linejoin='round'/></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="topo">
        <a class="marca" href="/admin/dashboard.php">louxzz.net</a>
        <nav class="menu" aria-label="Admin navigation">
            <a href="/admin/dashboard.php">Dashboard</a>
            <a href="/admin/projects/create.php">New project</a>
            <a href="/admin/logout.php">Sign out</a>
        </nav>
    </header>
    <main class="admin-corpo">
        <?php if ($flash): ?>
            <div class="aviso <?= e((string)$flash['type']) ?>"><?= e((string)$flash['message']) ?></div>
        <?php endif; ?>
        <div class="admin-cabeca">
            <div>
                <p class="sinal"><?= e($adminName) ?></p>
                <h1><?= e($title) ?></h1>
            </div>
        </div>
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
