<?php
declare(strict_types=1);

function admin_header(string $title): void
{
    $flash = get_flash();
    $adminName = (string)($_SESSION['admin_name'] ?? 'Admin');
    ?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title) ?> - louxzz.net</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="topo">
        <a class="marca" href="/admin/dashboard.php">louxzz.net</a>
        <nav class="menu" aria-label="Navegacao do painel">
            <a href="/admin/dashboard.php">Painel</a>
            <a href="/admin/projects/create.php">Novo projeto</a>
            <a href="/admin/logout.php">Sair</a>
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
