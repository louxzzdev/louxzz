<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../_layout.php';

require_admin();

$id = filter_input($_SERVER['REQUEST_METHOD'] === 'POST' ? INPUT_POST : INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    set_flash('project not found.', 'error');
    redirect_to('/dash');
}

$statement = db()->prepare('SELECT id, name FROM projects WHERE id = :id LIMIT 1');
$statement->execute(['id' => $id]);
$project = $statement->fetch();

if (!$project) {
    set_flash('project not found.', 'error');
    redirect_to('/dash');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid()) {
        set_flash('your session is invalid. please try again.', 'error');
        redirect_to('/dash');
    }

    $delete = db()->prepare('DELETE FROM projects WHERE id = :id');
    $delete->execute(['id' => $id]);
    set_flash('project deleted.');
    redirect_to('/dash');
}

admin_header('delete project', 'delete project');
?>
<div class="form confirm-panel">
    <p>delete <strong><?= e($project['name']) ?></strong>?</p>
    <p class="form-note">this cannot be undone.</p>
    <form method="post" action="/dash/projects/delete">
        <?= csrf_input() ?>
        <input type="hidden" name="id" value="<?= (int)$id ?>">
        <div class="form-actions">
            <button class="button danger" type="submit">delete project</button>
            <a class="text-link" href="/dash">cancel</a>
        </div>
    </form>
</div>
<?php admin_footer(); ?>
