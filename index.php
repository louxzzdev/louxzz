<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

// Vai buscar todos os projetos guardados na base de dados (geridos pelo /admin),
// dos mais recentes para os mais antigos.
$projects = db()
    ->query('SELECT name, url, description FROM projects ORDER BY created_at DESC, id DESC')
    ->fetchAll();
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>louxzz — Dev de 14 anos com ideias a mais e tempo a menos.</title>
    <meta name="description" content="Portfolio de louxzz: projetos pequenos, rapidos e diretos. Conhece o schedlio, o thegamercave e o cagating.">
    <meta name="theme-color" content="#0a0a0a">

    <!-- Open Graph: controla a pre-visualizacao quando partilhas o link (WhatsApp, X, Discord...) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="louxzz — Dev de 14 anos com ideias a mais e tempo a menos.">
    <meta property="og:description" content="Construo projetos pequenos, rapidos e diretos, sempre com vontade de experimentar mais uma ideia.">
    <meta property="og:url" content="https://louxzz.net">
    <!-- placeholder: substitui por uma imagem real (1200x630px) quando tiveres uma -->
    <meta property="og:image" content="/assets/img/og-cover.png">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon: um ">" desenhado em SVG direto aqui, sem precisar de ficheiro de imagem -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='14' fill='%230a0a0a'/><path d='M22 18 L42 32 L22 46' fill='none' stroke='%236366f1' stroke-width='6' stroke-linecap='round' stroke-linejoin='round'/></svg>">

    <!-- Fontes do Google Fonts: Space Grotesk (titulos), Inter (texto), JetBrains Mono (detalhes) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="topo">
        <a class="marca" href="/">louxzz.net</a>
        <nav class="menu" aria-label="Navegacao principal">
            <a href="#projetos">Projetos</a>
            <a href="/contacto.php">Contacto</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <!-- Camada decorativa (grelha de pontos + brilho animado). Puramente visual. -->
            <div class="hero-fundo" aria-hidden="true"></div>

            <div class="hero-conteudo">
                <p class="sinal">// Portfolio</p>
                <h1 class="hero-nome">louxzz<span class="cursor">_</span></h1>
                <p class="hero-tagline">Dev de 14 anos com ideias a mais e tempo a menos.</p>
                <p class="hero-descricao">Construo projetos pequenos, rapidos e diretos, sempre com vontade de experimentar mais uma ideia.</p>
                <div class="acoes">
                    <a class="botao" href="#projetos">Ver projetos</a>
                    <a class="botao secundario" href="/contacto.php">Falar comigo</a>
                </div>
            </div>

            <aside class="resumo" aria-label="Resumo">
                <span>louxzz</span>
                <strong>Pensamentos inúteis, ideias úteis.</strong>
            </aside>
        </section>

        <section class="secao" id="projetos">
            <div class="secao-cabeca">
                <p class="sinal">// Projetos</p>
                <h2>Coisas que ando a criar</h2>
            </div>

            <?php if (!$projects): ?>
                <p class="vazio">Ainda nao ha projetos publicados.</p>
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
            <span>Feito com PHP, MySQL e música ambiente.</span>
        </div>
        <!-- Edita estes links: troca pelo teu GitHub, email ou outras redes sociais -->
        <nav class="rodape-links" aria-label="Redes e contacto">
            <a href="https://github.com/louxzzdev" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a href="mailto:lourenco@louxzz.net">Email</a>
            <a href="/contacto.php">Contacto</a>
        </nav>
    </footer>

    <script src="/assets/js/main.js" defer></script>
</body>
</html>
