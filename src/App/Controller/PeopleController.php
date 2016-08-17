<?php namespace App\Controller;

use App\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PeopleController
{
    public function index(Application $app)
    {
        $data = array(
            'title'  => 'Public/People',
            'people' => array(),
        );

        return $app['twig']->render('public/people/index.twig', $data);
    }

    public function read(Application $app, Request $request)
    {
        $data = array(
            'title'  => 'Public/People',
            'people' => array(),
        );

        return $app['twig']->render('public/people/read.twig', $data);
    }
}