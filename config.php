<?php
namespace Config;

require_once __DIR__ . '/core/fn/ProtectFile.php';
protectFile('config.php');

/**
 * Класс конфигураций
 */
class Config
{
    //API токен Github
    public const string API_TOKEN = '';
    public const string STUDENT_TABLE_NAME = 'StudentsInfo';
    public const string GROUP_TABLE_NAME = 'StudentsGroup';
}
