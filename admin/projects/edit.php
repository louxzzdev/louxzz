<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../_layout.php';

require_admin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash('Project not found.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$statement = db()->prepare('SELECT id, name, url, description FROM projects WHERE id = :id LIMIT 1');
$statement->execute(['id' => $id]);
$project = $statement->fetch();

if (!$project) {
    set_flash('Project not found.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$projectData, $errors] = validate_project_input($_POST);

    if (!csrf_is_valid()) {
        $errors[] = 'Your session is invalid. Please try again.';
    }

    if (!$errors) {
        $update = db()->prepare('UPDATE projects SET name = :name, url = :url, description = :description WHERE id = :id');
        $update->execute([
            'name' => $projectData['name'],
            'url' => $projectData['url'],
            'description' => $projectData['description'],
            'id' => $id,
        ]);
        set_flash('Project updated successfully.');
        redirect_to('/admin/dashboard.php');
    }

    $project = array_merge($project, $projectData);
}

admin_header('Edit project');
?>
<form class="formulario" method="post" action="/admin/projects/edit.php?id=<?= (int)$id ?>" novalidate>
    <p>Update the details shown in the public portfolio.</p>

    <?php if ($errors): ?>
        <ul class="erro-lista">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?= csrf_input() ?>

    <div class="campo">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="<?= e($project['name']) ?>" required minlength="2" maxlength="120">
    </div>

    <div class="campo">
        <label for="url">URL</label>
        <input id="url" name="url" type="url" value="<?= e($project['url']) ?>" required maxlength="255">
    </div>

    <div class="campo">
        <label for="description">Description</label>
        <textarea id="description" name="description" required maxlength="1000"><?= e($project['description']) ?></textarea>
    </div>

    <div class="acoes">
        <button class="botao" type="submit">Save changes</button>
        <a class="botao secundario" href="/admin/dashboard.php">Cancel</a>
    </div>
</form>
<?php
admin_footer();
