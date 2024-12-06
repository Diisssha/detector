<?php
require_once "./fn/Users.php";
use Core\Fn\Users\Users;

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$githubId = $_POST['githubid'] ?? null;
$groupId = $_POST['groupid'] ?? null;

if ($githubId) {
    $existingUser = Users::getUserByGithubId($githubId);

    if ($existingUser && $existingUser['id'] !== (int)$id) {
        echo json_encode(['success' => false, 'message' => 'Пользователь с таким Github ID уже существует.']);
        exit;
    }
}

if ($id) {
    $result = Users::editUserById($id, $name, $githubId, $groupId);
} else {
    $result = Users::addUser($name, $githubId, $groupId);
}

echo json_encode(['success' => $result]);
