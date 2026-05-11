<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/_layout.php';

require_admin();

$projects = db()
    ->query('SELECT id, name, url, description, updated_at FROM projects ORDER BY created_at DESC, id DESC')
    ->fetchAll();

admin_header('Painel');
?>
<div class="admin-acoes">
    <a class="botao" href="/admin/projects/create.php">Criar projeto</a>
    <a class="botao secundario" href="/">Ver site</a>
</div>

<?php if (!$projects): ?>
    <p class="vazio">Ainda nao existem projetos.</p>
<?php else: ?>
    <section class="lista-admin" aria-label="Lista de projetos">
        <?php foreach ($projects as $project): ?>
            <article class="linha-projeto">
                <div>
                    <h2><?= e($project['name']) ?></h2>
                    <a href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($project['url']) ?></a>
                    <p><?= nl2br(e($project['description'])) ?></p>
                </div>
                <div class="linha-acoes">
                    <a class="botao secundario" href="/admin/projects/edit.php?id=<?= (int)$project['id'] ?>">Editar</a>
                    <form method="post" action="/admin/projects/delete.php" onsubmit="return confirm('Apagar este projeto?');">
                        <?= csrf_input() ?>
                        <input type="hidden" name="id" value="<?= (int)$project['id'] ?>">
                        <button class="botao perigo" type="submit">Apagar</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php
admin_footer();
