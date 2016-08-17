<?php namespace App;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Route
{
    public static function register($app)
    {
        $app['routes'] = $app->extend('routes', function (RouteCollection $routes, Application $app) {
            $loader = new YamlFileLoader(new FileLocator(ROOT_DIR.'etc/route'));
            $collection = $loader->load('route.yml');
            $routes->addCollection($collection);

            return $routes;
        });

        $app->error(function (\Exception $e, Request $request, $code) use ($app) {
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