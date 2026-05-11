<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to('/admin/dashboard.php');
}

if (!csrf_is_valid()) {
    set_flash('Sessao invalida. Tenta outra vez.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash('Projeto nao encontrado.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$statement = db()->prepare('DELETE FROM projects WHERE id = :id');
$statement->execute(['id' => $id]);

set_flash('Projeto apagado com sucesso.');
redirect_to('/admin/dashboard.php');
