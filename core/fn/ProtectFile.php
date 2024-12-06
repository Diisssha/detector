<?php
function protectFile(string $filename): void
{
    if (basename($_SERVER['PHP_SELF']) === $filename) {
        die('Доступ к этому файлу запрещен.');
    }
}