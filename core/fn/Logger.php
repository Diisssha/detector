<?php

namespace Core\Fn\Logger;
require_once 'ProtectFile.php';
protectFile('Logger.php');
class Logger
{
    private static $logFile = __DIR__ . '/../../logs/error_log.txt'; // Путь к файлу логов

    public static function log(string $message): void
    {
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[{$date}] {$message}" . PHP_EOL;

        // Записываем сообщение в файл логов
        file_put_contents(self::$logFile, $formattedMessage, FILE_APPEND);
    }
}
