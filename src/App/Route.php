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

        return $app;
    }
}
