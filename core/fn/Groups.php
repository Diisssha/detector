<?php
namespace Core\Fn\Groups;
require_once 'ProtectFile.php';
protectFile('GroupEditor.php');

require_once "DBConnector.php";
require_once "Logger.php";
require_once __DIR__ ."/../../config.php";

use Config\Config;
use Core\Fn\DBConnector\DBConnector;
use Core\Fn\Logger\Logger;
use PDO;
use PDOException;

/**
 * Класс для работы с группами
 */
class Groups
{
    /**
     * Получение всех групп
     * @return array
     */
    public static function getGroups(): array
    {
        try {
            $db = DBConnector::getInstance()->getConnection();
            $stmt = $db->query('SELECT * FROM ' . Config::GROUP_TABLE_NAME);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return (['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Проверка существует ли группа с таким названием
     * @param string $groupName
     * @return bool
     */
    public static function isExistGroup(string $groupName): bool
    {
        try {
            $db = DBConnector::getInstance()->getConnection();
            $stmt = $db->prepare('SELECT 1 FROM ' . Config::GROUP_TABLE_NAME . ' WHERE GroupName = :groupName');
            $stmt->bindValue(':groupName', $groupName, PDO::PARAM_STR);
            $stmt->execute();
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            Logger::log('Ошибка при проверки существования группы ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Добавление группы
     * @param string $groupName название группы
     * @return bool
     */
    public static function addGroup(string $groupName): bool
    {
        try {
            if(!self::isExistGroup($groupName)){
                $db = DBConnector::getInstance()->getConnection();
                $stmt = $db->prepare('INSERT INTO '. Config::GROUP_TABLE_NAME . '(GroupName) VALUES(:groupName)');
                $stmt->bindValue(':groupName', $groupName, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            Logger::log('Ошибка при добавлении группы: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Редактирование существующей группы
     * @param int $id id группы (приходит из hidden поля в верстке)
     * @param string $newGroupName название группы
     * @return bool
     */
    public static function editGroupById(int $id, string $newGroupName): bool
    {
        try {
            if(!self::isExistGroup($newGroupName)){
                $db = DBConnector::getInstance()->getConnection();
                $stmt = $db->prepare('UPDATE ' . Config::GROUP_TABLE_NAME . ' SET GroupName = :newGroupName WHERE ID = :ID');
                $stmt->bindValue(':newGroupName', $newGroupName, PDO::PARAM_STR);
                $stmt->bindValue(':ID', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->rowCount() > 0;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            Logger::log('Ошибка при редактировании группы: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаление группы
     * @param int $id id группы (приходит из hidden поля в верстке)
     * @return bool
     */
    public static function deleteGroupById(int $id): bool
    {
        try {
            $db = DBConnector::getInstance()->getConnection();
            $stmt = $db->prepare('DELETE FROM ' . Config::GROUP_TABLE_NAME . ' WHERE ID = :ID');
            $stmt->bindValue(':ID', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            Logger::log('Ошибка при удалении группы: ' . $e->getMessage());
            return false;
        }
    }

}
