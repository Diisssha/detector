<?php
require_once "./fn/Users.php";
use Core\Fn\Users\Users;
$id = $_GET['groupId'] ?? null;
if(empty($id)) {
    echo json_encode(['success' => false, 'message' => 'Необходимо выбрать группу']);
} else {
    header('Content-Type: application/json');
    echo json_encode(Users::getUsers($id));
}

