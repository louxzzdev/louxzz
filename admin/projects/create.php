<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../_layout.php';

require_admin();

$errors = [];
$project = [
    'name' => '',
    'url' => '',
    'description' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$project, $errors] = validate_project_input($_POST);

    if (!csrf_is_valid()) {
        $errors[] = 'Your session is invalid. Please try again.';
    }

    if (!$errors) {
        $statement = db()->prepare('INSERT INTO projects (name, url, description) VALUES (:name, :url, :description)');
        $statement->execute($project);
        set_flash('Project created successfully.');
        redirect_to('/admin/dashboard.php');
    }
}

admin_header('Create project');
?>
<form class="formulario" method="post" action="/admin/projects/create.php" novalidate>
    <p>Add a new project to the public portfolio.</p>

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
        <input id="url" name="url" type="url" value="<?= e($project['url']) ?>" required maxlength="255" placeholder="https://example.com">
    </div>

    <div class="campo">
        <label for="description">Description</label>
        <textarea id="description" name="description" required maxlength="1000"><?= e($project['description']) ?></textarea>
    </div>

    <div class="acoes">
        <button class="botao" type="submit">Save project</button>
        <a class="botao secundario" href="/admin/dashboard.php">Cancel</a>
    </div>
</form>
<?php
admin_footer();
