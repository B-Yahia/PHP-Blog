<?php

require_once "vendor/autoload.php";

use Dotenv\Dotenv;

function setEnvVar()
{
    $dotenv = Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();
}

function checkIfEnvVarAreSet()
{
    if (isset($_ENV["DB_PASSWORD"]) && isset($_ENV["DB_USERNAME"]) && isset($_ENV["DB_HOST"]) && isset($_ENV["DB_NAME"])) {
        return true;
    } else {
        return false;
    }
}
function getConnectionInst()
{
    if (checkIfEnvVarAreSet()) {

        return new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    } else {
        setEnvVar();
        return new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    }
}
