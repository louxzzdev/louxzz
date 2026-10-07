<?php
declare(strict_types=1);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$query = $id ? '?id=' . $id : '';
header('Location: /dash/projects/delete' . $query, true, $_SERVER['REQUEST_METHOD'] === 'POST' ? 307 : 302);
exit;
