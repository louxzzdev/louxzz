<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to('/admin/dashboard.php');
}

if (!csrf_is_valid()) {
    set_flash('Your session is invalid. Please try again.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash('Project not found.', 'erro');
    redirect_to('/admin/dashboard.php');
}

$statement = db()->prepare('DELETE FROM projects WHERE id = :id');
$statement->execute(['id' => $id]);

set_flash('Project deleted successfully.');
redirect_to('/admin/dashboard.php');
