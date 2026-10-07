<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../_layout.php';

require_admin();

$errors = [];
$project = ['name' => '', 'url' => '', 'description' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$project, $errors] = validate_project_input($_POST);

    if (!csrf_is_valid()) {
        $errors[] = 'your session is invalid. please try again.';
    }

    if (!$errors) {
        $statement = db()->prepare('INSERT INTO projects (name, url, description) VALUES (:name, :url, :description)');
        $statement->execute($project);
        set_flash('project created.');
        redirect_to('/dash');
    }
}

admin_header('add project', 'add project', 'new');
?>
<form class="form" method="post" action="/dash/projects/new" novalidate>
    <p class="form-note">add a project to the public portfolio.</p>
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
        <input id="url" name="url" type="url" value="<?= e($project['url']) ?>" required maxlength="255" placeholder="https://example.com" inputmode="url">
    </div>
    <div class="field">
        <label for="description">description</label>
        <textarea id="description" name="description" required maxlength="1000"><?= e($project['description']) ?></textarea>
    </div>
    <div class="form-actions">
        <button class="button" type="submit">save project</button>
        <a class="text-link" href="/dash">cancel</a>
    </div>
</form>
<?php admin_footer(); ?>
