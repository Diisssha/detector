<?php
require_once "./fn/Groups.php";
use Core\Fn\Groups\Groups;

$id = $_POST['id'] ?? null;

if ($id) {
    $deleted = Groups::deleteGroupById($id);
    echo json_encode(['success' => $deleted]);
} else {
    echo json_encode(['success' => false, 'error' => 'ID не указан']);
}
