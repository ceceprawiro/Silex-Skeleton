<?php

$permitted = array(
    '127.0.0.1',
    'fe80::1',
    '::1',
);
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], $permitted)
) {
    //header('HTTP/1.0 403 Forbidden');
    //exit('Forbidden access.');
}

require_once __DIR__.'/../vendor/autoload.php';

Symfony\Component\Debug\Debug::enable();
Symfony\Component\Debug\ErrorHandler::register();
Symfony\Component\Debug\ExceptionHandler::register(true);

$app = new App\Application('dev');
$app->run();
