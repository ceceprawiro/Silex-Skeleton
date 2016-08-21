<?php namespace App;

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        
        $app->error(function (\Exception $e, Request $request, $code) use ($app) {
            // return $app->json(array('error' => $e->getMessage()), $code);
            
            if ($app['debug']) {
                return;
            }

            $templates = array(
                'error/'.$code.'.twig',
                'error/'.substr($code, 0, 2).'x.twig',
                'error/'.substr($code, 0, 1).'xx.twig',
                'error/error.twig',
            );

            return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
        });

        return $app;
    }
}
