<?php namespace App;

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

class Error
{
    public static function register($app)
    {

        ErrorHandler::register();

        if ($app['debug']) {
            ExceptionHandler::register();
        } else {
            ExceptionHandler::register(false);
        }

        return $app;
    }
}