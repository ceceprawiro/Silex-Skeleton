<?php namespace App\Controller;

use App\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicController
{
    public function home(Application $app)
    {
        $data = array(
            'title' => 'Public/Home',
        );

        return $app['twig']->render('public/home.twig', $data);
    }

    public function login(Request $request, Application $app)
    {
        $data = array(
            'title'         => 'Public/Login.',
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        );

        return $app['twig']->render('public/login.twig', $data);
    }
}