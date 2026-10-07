<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../_layout.php';

require_admin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    set_flash('project not found.', 'error');
    redirect_to('/dash');
}

$statement = db()->prepare('SELECT id, name, url, description FROM projects WHERE id = :id LIMIT 1');
$statement->execute(['id' => $id]);
$project = $statement->fetch();

if (!$project) {
    set_flash('project not found.', 'error');
    redirect_to('/dash');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$projectData, $errors] = validate_project_input($_POST);

    if (!csrf_is_valid()) {
        $errors[] = 'your session is invalid. please try again.';
    }

    if (!$errors) {
        $update = db()->prepare('UPDATE projects SET name = :name, url = :url, description = :description WHERE id = :id');
        $update->execute([
            'name' => $projectData['name'],
            'url' => $projectData['url'],
            'description' => $projectData['description'],
            'id' => $id,
        ]);
        set_flash('project updated.');
        redirect_to('/dash');
    }

    $project = array_merge($project, $projectData);
}

admin_header('edit project', 'edit project');
?>
<form class="form" method="post" action="/dash/projects/edit?id=<?= (int)$id ?>" novalidate>
    <p class="form-note">update the details shown in the public portfolio.</p>
    <?php if ($errors): ?>
        <div class="notice error" role="alert">
            <ul>
                <?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?= csrf_input() ?>
    <div class="field">
        <label for="name">name</label>
        <input id="name" name="name" type="text" value="<?= e($project['name']) ?>" required minlength="2" maxlength="120">
    </div>
    <div class="field">
        <label for="url">url</label>
        <input id="url" name="url" type="url" value="<?= e($project['url']) ?>" required maxlength="255" inputmode="url">
    </div>
    <div class="field">
        <label for="description">description</label>
        <textarea id="description" name="description" required maxlength="1000"><?= e($project['description']) ?></textarea>
    </div>
    <div class="form-actions">
        <button class="button" type="submit">save changes</button>
        <a class="text-link" href="/dash">cancel</a>
    </div>
</form>
<?php admin_footer(); ?>
