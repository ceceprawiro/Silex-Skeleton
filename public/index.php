<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

Symfony\Component\Debug\ErrorHandler::register();
Symfony\Component\Debug\ExceptionHandler::register(false);

$app = new App\Application();
$app->run();