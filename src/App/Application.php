<?php namespace App;

use Silex\Application as SilexApplication;

use App\Error;
use App\ServiceProvider;
use App\Route;

define('ROOT_DIR', realpath(__DIR__.'/../../').'/');

class Application extends SilexApplication
{
    private $env;

    public function __construct($env = 'prod')
    {
        parent::__construct();

        foreach (glob(ROOT_DIR.'etc/helper/*.php') as $helper) {
            require $helper;
        }

        $this->env = $env;
        $app = $this;

        $config = ROOT_DIR.'etc/setting/'.$env.'.php';
        if (!file_exists($config)) {
            throw new \RuntimeException(sprintf('The file "%s" does not exist.', $config));
        }
        require $config;

        $app['asset_path'] = baseurl();

        $loader = require ROOT_DIR . 'vendor/autoload.php';
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

        $app = Error::register($app);
        $app = ServiceProvider::register($app);
        $app = Route::register($app);
    }
}