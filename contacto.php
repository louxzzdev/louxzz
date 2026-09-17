<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Get in touch with louxzz.">
    <meta name="theme-color" content="#0b0c0e">
    <title>Contact — louxzz.net</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='14' fill='%230b0c0e'/><path d='M22 18 L42 32 L22 46' fill='none' stroke='%23c9cdd3' stroke-width='6' stroke-linecap='round' stroke-linejoin='round'/></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="topo">
        <a class="marca" href="/">louxzz.net</a>
        <nav class="menu" aria-label="Primary navigation">
            <a href="/#projects">Projects</a>
            <a href="/contacto.php" aria-current="page">Contact</a>
        </nav>
    </header>

    <main class="pagina-contacto">
        <section class="contacto-cabeca">
            <p class="sinal">// Contact</p>
            <h1>Let’s make something useful.</h1>
            <p>For collaboration, a thoughtful question, or a bug report, this is the place.</p>
        </section>

        <section class="contacto-cartao" aria-label="Contact details">
            <img
                class="contacto-avatar imagem"
                src="https://thegamercave.blog/uploads/avatars/avatar_2_1775910789.png"
                alt="Portrait of lou"
            >

            <h2>lou</h2>
            <p class="contacto-funcao">Full stack developer</p>

            <p class="contacto-texto">
                For support, partnerships, and anything related to my work.
            </p>

            <div class="contacto-links">
                <a class="contacto-link" href="https://www.instagram.com/notlourenco" target="_blank" rel="noopener noreferrer">
                    <span>Instagram</span>
                    <strong>@notlourenco</strong>
                </a>

                <a class="contacto-link" href="mailto:lourenco@louxzz.net">
                    <span>E-mail</span>
                    <strong>lourenco@louxzz.net</strong>
                </a>

                <a class="contacto-link" href="https://louxzz.net" target="_blank" rel="noopener noreferrer">
                    <span>Portfolio</span>
                    <strong>louxzz.net</strong>
                </a>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <span>louxzz.net</span>
        <a href="/">Back to portfolio</a>
    </footer>
</body>
</html>
