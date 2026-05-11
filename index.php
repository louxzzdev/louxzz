<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$projects = db()
    ->query('SELECT name, url, description FROM projects ORDER BY created_at DESC, id DESC')
    ->fetchAll();
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portfolio de projetos de louxzz.net">
    <title>louxzz.net</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="topo">
        <a class="marca" href="/">louxzz.net</a>
        <nav class="menu" aria-label="Navegacao principal">
            <a href="#projetos">Projetos</a>
            <a href="mailto:louxzz@louxzz.net">Contacto</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-texto">
                <p class="sinal">Portfolio</p>
                <h2>Dev de 14 anos com ideias a mais e tempo a menos.</h2>
                <p>Construo projetos pequenos, rapidos e diretos, sempre com vontade de experimentar mais uma ideia.</p>
                <div class="acoes">
                    <a class="botao" href="#projetos">Ver projetos</a>
                    <a class="botao secundario" href="mailto:louxzz@louxzz.net">Falar comigo</a>
                </div>
            </div>
            <div class="resumo" aria-label="Resumo">
                <span>louxzz</span>
                <strong>Pensamentos ínuteis, ideias úteis.</strong>
            </div>
        </section>

        <section class="secao" id="projetos">
            <div class="secao-cabeca">
                <p class="sinal">Projetos</p>
                <h2>Coisas que ando a criar</h2>
            </div>

            <?php if (!$projects): ?>
                <p class="vazio">Ainda nao ha projetos publicados.</p>
            <?php else: ?>
                <div class="grelha">
                    <?php foreach ($projects as $project): ?>
                        <article class="cartao">
                            <h3><?= e($project['name']) ?></h3>
                            <p><?= nl2br(e($project['description'])) ?></p>
                            <a href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer">
                                <?= e($project['url']) ?>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="rodape">
        <span>louxzz.net</span>
        <span>Feito com PHP, MySQL e música ambiente.</span>
    </footer>
</body>
</html>
