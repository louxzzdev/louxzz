<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/_layout.php';

require_admin();

$projects = db()
    ->query('SELECT id, name, url, description FROM projects ORDER BY created_at DESC, id DESC')
    ->fetchAll();

admin_header('dashboard', 'projects', 'dashboard');
?>
<div class="admin-intro">
    <p>manage the projects displayed on louxzz.net.</p>
    <a class="button" href="/dash/projects/new">add project</a>
</div>

<?php if (!$projects): ?>
    <div class="empty-state admin-empty">
        <p>no projects yet.</p>
        <a class="text-link" href="/dash/projects/new">add project</a>
    </div>
<?php else: ?>
    <section class="admin-projects" aria-label="project list">
        <?php foreach ($projects as $project): ?>
            <?php $projectUrl = safe_external_url((string)$project['url']); ?>
            <article class="admin-project">
                <div>
                    <h2><?= e($project['name']) ?></h2>
                    <p><?= nl2br(e($project['description'])) ?></p>
                </div>
                <div class="row-actions">
                    <?php if ($projectUrl !== ''): ?>
                        <a href="<?= e($projectUrl) ?>" target="_blank" rel="noopener noreferrer">view <span aria-hidden="true">&#8599;</span></a>
                    <?php endif; ?>
                    <a href="/dash/projects/edit?id=<?= (int)$project['id'] ?>">edit</a>
                    <a class="danger-link" href="/dash/projects/delete?id=<?= (int)$project['id'] ?>">delete</a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php admin_footer(); ?>
