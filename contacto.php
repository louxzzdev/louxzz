<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Contacto de louxzz.net">
    <meta name="theme-color" content="#0a0a0a">
    <title>Contacto - louxzz.net</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='14' fill='%230a0a0a'/><path d='M22 18 L42 32 L22 46' fill='none' stroke='%236366f1' stroke-width='6' stroke-linecap='round' stroke-linejoin='round'/></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- Os estilos desta pagina (.contacto-*) vivem agora todos em
         assets/css/style.css, na secção "PAGINA DE CONTACTO" -->
</head>
<body>
    <header class="topo">
        <a class="marca" href="/">louxzz.net</a>
        <nav class="menu" aria-label="Navegacao principal">
            <a href="/#projetos">Projetos</a>
            <a href="/contacto.php" aria-current="page">Contacto</a>
        </nav>
    </header>

    <main class="pagina-contacto">
        <section class="contacto-cabeca">
            <p class="sinal">// Contacto</p>
            <h1>Contacto</h1>
            <p>Reportar algum bug, pedir uma opinião ou até propostas é aqui!</p>
        </section>

        <section class="contacto-cartao" aria-label="Dados de contacto">
            <img
                class="contacto-avatar imagem"
                src="https://thegamercave.blog/uploads/avatars/avatar_2_1775910789.png"
                alt="Avatar de lou"
            >

            <h2>lou</h2>
            <p class="contacto-funcao">Full stack developer</p>

            <p class="contacto-texto">
                Contacto para suporte, parcerias e assuntos relacionados com a plataforma.
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
                    <span>Portfólio</span>
                    <strong>louxzz.net</strong>
                </a>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <span>louxzz.net</span>
        <a href="/">Voltar ao portfolio</a>
    </footer>
</body>
</html>
