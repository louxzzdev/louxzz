<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/site.php';

http_response_code(404);
site_header('404 — lou', 'page not found.', 'https://louxzz.net/404');
?>
<section class="not-found" aria-labelledby="not-found-title">
    <p class="eyebrow">404</p>
    <h1 id="not-found-title">page not found.</h1>
    <a class="text-link" href="/"><span aria-hidden="true">&#8592;</span> home</a>
</section>
<?php site_footer(); ?>
