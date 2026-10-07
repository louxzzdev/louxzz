<?php
declare(strict_types=1);

header('Location: /dash/projects/new', true, $_SERVER['REQUEST_METHOD'] === 'POST' ? 307 : 302);
exit;
