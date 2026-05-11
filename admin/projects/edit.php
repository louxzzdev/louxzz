<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../_layout.php';

require_admin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash('Projeto nao encontrado.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$statement = db()->prepare('SELECT id, name, url, description FROM projects WHERE id = :id LIMIT 1');
$statement->execute(['id' => $id]);
$project = $statement->fetch();

if (!$project) {
    set_flash('Projeto nao encontrado.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$projectData, $errors] = validate_project_input($_POST);

    if (!csrf_is_valid()) {
        $errors[] = 'Sessao invalida. Tenta outra vez.';
    }

    if (!$errors) {
        $update = db()->prepare('UPDATE projects SET name = :name, url = :url, description = :description WHERE id = :id');
        $update->execute([
            'name' => $projectData['name'],
            'url' => $projectData['url'],
            'description' => $projectData['description'],
            'id' => $id,
        ]);
        set_flash('Projeto atualizado com sucesso.');
        redirect_to('/admin/dashboard.php');
    }

    $project = array_merge($project, $projectData);
}

admin_header('Editar projeto');
?>
<form class="formulario" method="post" action="/admin/projects/edit.php?id=<?= (int)$id ?>" novalidate>
    <p>Atualiza os dados que aparecem no portfolio publico.</p>

    <?php if ($errors): ?>
        <ul class="erro-lista">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?= csrf_input() ?>

    <div class="campo">
        <label for="name">Nome</label>
        <input id="name" name="name" type="text" value="<?= e($project['name']) ?>" required minlength="2" maxlength="120">
    </div>

    <div class="campo">
        <label for="url">URL</label>
        <input id="url" name="url" type="url" value="<?= e($project['url']) ?>" required maxlength="255">
    </div>

    <div class="campo">
        <label for="description">Descricao</label>
        <textarea id="description" name="description" required maxlength="1000"><?= e($project['description']) ?></textarea>
    </div>

    <div class="acoes">
        <button class="botao" type="submit">Guardar</button>
        <a class="botao secundario" href="/admin/dashboard.php">Cancelar</a>
    </div>
</form>
<?php
admin_footer();
