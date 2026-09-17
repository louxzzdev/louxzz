<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

// Fetch projects managed through /admin, newest first.
$projects = db()
    ->query('SELECT name, url, description FROM projects ORDER BY created_at DESC, id DESC')
    ->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>louxzz — Independent developer building focused digital products.</title>
    <meta name="description" content="The portfolio of louxzz — focused digital products, web experiments, and ideas in progress.">
    <meta name="theme-color" content="#0b0c0e">

    <!-- Open Graph: controla a pre-visualizacao quando partilhas o link (WhatsApp, X, Discord...) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="louxzz — Independent developer building focused digital products.">
    <meta property="og:description" content="Focused digital products, web experiments, and ideas in progress.">
    <meta property="og:url" content="https://louxzz.net">
    <!-- Replace this placeholder with a real 1200×630 social image when available. -->
    <meta property="og:image" content="/assets/img/og-cover.png">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='14' fill='%230b0c0e'/><path d='M22 18 L42 32 L22 46' fill='none' stroke='%23c9cdd3' stroke-width='6' stroke-linecap='round' stroke-linejoin='round'/></svg>">

    <!-- Fontes do Google Fonts: Space Grotesk (titulos), Inter (texto), JetBrains Mono (detalhes) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="topo">
        <a class="marca" href="/">louxzz.net</a>
        <nav class="menu" aria-label="Primary navigation">
            <a href="#projects">Projects</a>
            <a href="/contacto.php">Contact</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <!-- Decorative dot grid and ambient glow. -->
            <div class="hero-fundo" aria-hidden="true"></div>

            <div class="hero-conteudo">
                <p class="sinal">// Independent developer</p>
                <h1 class="hero-nome">louxzz<span class="cursor">_</span></h1>
                <p class="hero-tagline">Building focused digital products, one sharp idea at a time.</p>
                <p class="hero-descricao">I design and ship considered web experiences, useful tools, and experiments that turn ambitious ideas into something real.</p>
                <div class="acoes">
                    <a class="botao" href="#projects">View projects</a>
                    <a class="botao secundario" href="/contacto.php">Get in touch</a>
                </div>
            </div>

            <aside class="resumo" aria-label="Creative statement">
                <span>louxzz</span>
                <strong>Clear thinking.<br>Useful work.</strong>
            </aside>
        </section>

        <section class="secao" id="projects">
            <div class="secao-cabeca">
                <p class="sinal">// Selected work</p>
                <h2>What I’m building</h2>
            </div>

            <?php if (!$projects): ?>
                <p class="vazio">No projects have been published yet.</p>
            <?php else: ?>
                <div class="grelha">
                    <?php foreach ($projects as $index => $project): ?>
                        <article class="cartao">
                            <span class="cartao-numero"><?= sprintf('%02d', $index + 1) ?></span>
                            <h3><?= e($project['name']) ?></h3>
                            <p><?= nl2br(e($project['description'])) ?></p>
                            <a class="cartao-link" href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer">
                                <?= e(display_url($project['url'])) ?>
                                <span class="seta" aria-hidden="true">&#8599;</span>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="rodape">
        <div class="rodape-texto">
            <span>louxzz.net</span>
            <span>Built with PHP, MySQL, and ambient music.</span>
        </div>
        <nav class="rodape-links" aria-label="Social links and contact">
            <a href="https://github.com/louxzzdev" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a href="mailto:lourenco@louxzz.net">Email</a>
            <a href="/contacto.php">Contact</a>
        </nav>
    </footer>

    <script src="/assets/js/main.js" defer></script>
</body>
</html>
