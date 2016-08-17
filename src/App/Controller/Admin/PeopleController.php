<?php namespace App\Controller\Admin;

use App\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PeopleController
{
    public function index(Application $app)
    {
        $data = array(
            'title'  => 'Admin/Poeple',
            'people' => array(),
        );

        return $app['twig']->render('admin/people/index.twig', $data);
    }

    public function read(Application $app, Request $request)
    {
        $data = array(
            'title'  => 'Admin\Poeple',
            'people' => array(),
        );

        return $app['twig']->render('admin/people/read.twig', $data);
    }
}