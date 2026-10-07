<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/site.php';

site_header('contact — lou', 'contact lou on github or instagram.', 'https://louxzz.net/contact', 'contact');
?>
<section class="contact-page" aria-labelledby="contact-title">
    <header class="page-heading">
        <p class="eyebrow">// contact</p>
        <h1 id="contact-title">contact</h1>
    </header>
    <div class="contact-card">
        <div class="contact-profile">
            <div class="avatar-frame">
                <img
                    class="avatar"
                    src="https://avatars.githubusercontent.com/u/228095571?s=400&amp;u=6798d3179194ef2b8edb976f70ab7d5cbaf6aa14&amp;v=4"
                    alt="lou"
                    width="400"
                    height="400"
                    decoding="async"
                    fetchpriority="high"
                    referrerpolicy="no-referrer"
                >
            </div>
            <div>
                <h2>lou</h2>
                <p>developer &amp; creator</p>
            </div>
        </div>
        <div class="contact-links">
            <a href="https://github.com/louxzzdev" target="_blank" rel="noopener noreferrer">
                <span class="social-label">github</span>
                <strong>louxzzdev</strong>
                <span class="link-arrow" aria-hidden="true">&#8599;</span>
            </a>
            <a href="https://instagram.com/notlourenco" target="_blank" rel="noopener noreferrer">
                <span class="social-label">instagram</span>
                <strong>notlourenco</strong>
                <span class="link-arrow" aria-hidden="true">&#8599;</span>
            </a>
        </div>
    </div>
</section>
<?php site_footer(); ?>
