<?php
declare(strict_types=1);
/**
 * Vérifie si un utilisateur est bien connecté
 * Conditions: l'utilisateur doit avoir une session ouverte
 * @return void
 */
function verifyUser()
{

}

function reportErrorDBInLogFile($file, $e): void
{
    error_log("ERROR_DATE:" . date("Y-m-d H:i:s") . " --- " . "ERROR_MESSAGE: " . $e->getMessage() . " --- " . "ERROR_CODE:" . $e->getCode() . PHP_EOL, 3, $file);
}

function reportErrorCrudInLogFile($file, $message): void
{
    error_log("ERROR_DATE:" . date("Y-m-d H:i:s") . " --- " . "ERROR_MESSAGE: " . $message . PHP_EOL, 3, $file);
}