<?php
require_once "./fn/Users.php";
use Core\Fn\Users\Users;

$id = $_POST['id'] ?? null;

if ($id) {
    // Используем метод deleteStudentById из класса UserEditor
    $deleted = Users::deleteStudentById($id);

    if ($deleted) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Ошибка при удалении студента']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID не указан']);
}