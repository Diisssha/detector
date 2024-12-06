<?php
namespace Core\Fn\Users;

require_once 'ProtectFile.php';
protectFile('UserEditor.php');

require_once "DBConnector.php";
require_once "Logger.php";
require_once __DIR__ ."/../../config.php";

use Core\Fn\DBConnector\DBConnector,
    Core\Fn\Logger\Logger,
    PDO,
    PDOException,
    Config\Config;

/**
 * Класс для работы со студентами
 */
class Users
{
    /**
     * Добавление нового студента
     * @param string $name ФИО студента
     * @param int $gitId Github ID студента
     * @param int $groupId id группы (приходит из селектора в верстке)
     * @return bool
     */
    public static function addUser(string $name, int $gitId, int $groupId): bool
    {
        try {
            $db = DBConnector::getInstance()->getConnection();
            $stmt = $db->prepare('INSERT INTO ' . Config::STUDENT_TABLE_NAME .
                                       '(FullName, GithubID, GroupID) 
                                        VALUES(:fullname, :githubid, :groupId)');
            $stmt->bindValue(':fullname', $name, PDO::PARAM_STR);
            $stmt->bindValue(':githubid', $gitId, PDO::PARAM_INT);
            $stmt->bindValue(':groupId', $groupId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            Logger::log('Ошибка при добавлении пользователя: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Получение всех студентов (join с группами, выводятся названия групп, а не id)
     * @param int $groupId - id группы для выборки студентов
     * @return array
     */
    public static function getUsers(int $groupId): array
    {
        try {
            $db = DBConnector::getInstance()->getConnection();
            $stmt = $db->prepare('SELECT ' . Config::STUDENT_TABLE_NAME .'.id, 
                                      '. Config::STUDENT_TABLE_NAME . '.FullName, 
                                      ' . Config::STUDENT_TABLE_NAME . '.GithubID, 
                                      '. Config::GROUP_TABLE_NAME . '.GroupName
                                      FROM ' . Config::STUDENT_TABLE_NAME . '
                                      INNER JOIN ' . Config::GROUP_TABLE_NAME . ' 
                                      ON ' . Config::STUDENT_TABLE_NAME . '.GroupID = ' . Config::GROUP_TABLE_NAME . '.id
                                      WHERE ' . Config::STUDENT_TABLE_NAME . '.GroupID = :groupId');
            $stmt->bindValue(':groupId', $groupId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Logger::log('Ошибка при получении всех пользователей: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Получение студента по GithubId
     * @param int $GithubID GithubId студента
     * @return array|null
     */
    public static function getUserByGithubId(int $GithubID): ?array
    {
        try {
            $db = DBConnector::getInstance()->getConnection();
            $stmt = $db->prepare('SELECT * FROM ' . Config::STUDENT_TABLE_NAME . ' WHERE GithubID = :GithubID');
            $stmt->bindValue(':GithubID', $GithubID, PDO::PARAM_INT);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user : null;
        } catch (PDOException $e) {
            Logger::log('Ошибка при получении пользователя по ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Редактирование студента
     * @param int $id id студента (приходит из верстки)
     * @param string|null $newName новое имя студента
     * @param int|null $newGithubId новый GithubId студента
     * @param int|null $newGroupId новая группа студента
     * @return bool
     */
    public static function editUserById(int $id, ?string $newName = null, ?int $newGithubId = null, ?int $newGroupId = null): bool
    {
        try {
            $db = DBConnector::getInstance()->getConnection();

            $sql = 'UPDATE ' . Config::STUDENT_TABLE_NAME . ' SET';

            $fields = [];
            if ($newName !== null) {
                $fields[] = 'FullName = :fullname';
            }
            if ($newGithubId !== null) {
                $fields[] = 'GithubID = :githubid';
            }
            if ($newGroupId !== null) {
                $fields[] = 'GroupID = :groupid';
            }

            if (empty($fields)) {
                return false;
            }

            $sql .= ' ' . implode(', ', $fields) . ' WHERE ID = :id';

            $stmt = $db->prepare($sql);

            if ($newName !== null) {
                $stmt->bindValue(':fullname', $newName, PDO::PARAM_STR);
            }
            if ($newGithubId !== null) {
                $stmt->bindValue(':githubid', $newGithubId, PDO::PARAM_INT);
            }
            if ($newGroupId !== null) {
                $stmt->bindValue(':groupid', $newGroupId, PDO::PARAM_INT);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            Logger::log('Ошибка при редактировании пользователя: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаление студента
     * @param int $id id студента
     * @return bool
     */
    public static function deleteStudentById(int $id): bool
    {
        try {
            $db = DBConnector::getInstance()->getConnection(); // Получаем соединение через синглтон
            $stmt = $db->prepare('DELETE FROM ' . Config::STUDENT_TABLE_NAME . ' WHERE ID = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Проверяем, был ли удален хотя бы один пользователь
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            Logger::log('Ошибка при удалении пользователя: ' . $e->getMessage());
            return false;
        }
    }
}
