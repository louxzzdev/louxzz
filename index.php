<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/site.php';

$projects = db()
    ->query('SELECT id, name, url, description FROM projects ORDER BY created_at DESC, id DESC')
    ->fetchAll();

site_header('lou — projects', 'lou — developer and creator. selected projects and links.', 'https://louxzz.net/', 'home');
?>
<section class="hero-card" aria-labelledby="intro-title">
    <div class="hero-pattern" aria-hidden="true"></div>
    <div class="profile-block">
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
        <div class="profile-copy">
            <p class="eyebrow">// portfolio</p>
            <h1 id="intro-title">lou<span aria-hidden="true">.</span></h1>
            <p>developer &amp; creator</p>
        </div>
    </div>
    <div class="hero-links" aria-label="social links">
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
</section>

<section class="projects" id="projects" aria-labelledby="projects-title">
    <header class="section-heading">
        <div>
            <p class="eyebrow">// selected work</p>
            <h2 id="projects-title">projects</h2>
        </div>
        <span><?= count($projects) ?> <?= count($projects) === 1 ? 'project' : 'projects' ?></span>
    </header>

    <?php if (!$projects): ?>
        <p class="empty-state">no projects yet.</p>
    <?php else: ?>
        <div class="project-grid">
            <?php foreach ($projects as $index => $project): ?>
                <?php $projectUrl = safe_external_url((string)$project['url']); ?>
                <?php $projectHost = $projectUrl !== '' ? (string)parse_url($projectUrl, PHP_URL_HOST) : ''; ?>
                <article class="project-card">
                    <div class="project-meta">
                        <span><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        <?php if ($projectHost !== ''): ?><span><?= e($projectHost) ?></span><?php endif; ?>
                    </div>
                    <div class="project-copy">
                        <h3><?= e($project['name']) ?></h3>
                        <p><?= nl2br(e($project['description'])) ?></p>
                    </div>
                    <?php if ($projectUrl !== ''): ?>
                        <a class="project-link" href="<?= e($projectUrl) ?>" target="_blank" rel="noopener noreferrer">
                            visit project <span aria-hidden="true">&#8599;</span>
                            <span class="visually-hidden">: <?= e($project['name']) ?></span>
                        </a>
                    <?php else: ?>
                        <span class="project-link">project unavailable</span>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="connect-card" aria-labelledby="connect-title">
    <div>
        <p class="eyebrow">// contact</p>
        <h2 id="connect-title">find me online.</h2>
    </div>
    <div class="connect-links">
        <a href="https://github.com/louxzzdev" target="_blank" rel="noopener noreferrer">github <span aria-hidden="true">&#8599;</span></a>
        <a href="https://instagram.com/notlourenco" target="_blank" rel="noopener noreferrer">instagram <span aria-hidden="true">&#8599;</span></a>
    </div>
</section>
<?php site_footer(); ?>
