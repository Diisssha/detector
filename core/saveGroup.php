<?php
require_once "./fn/Groups.php";
use Core\Fn\Groups\Groups;

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;

if ($id) {
        $result = Groups::editGroupById($id, $name);
} else {
        $result = Groups::addGroup($name);
}

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Группа с таким названием уже существует.']);
}
