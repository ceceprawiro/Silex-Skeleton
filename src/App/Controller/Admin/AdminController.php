<?php namespace App\Controller\Admin;

use App\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    public function home(Application $app)
    {
        $data = array(
            'title' => 'Admin/Home',
        );

        return $app['twig']->render('admin/home.twig', $data);
    }
}