<?php namespace App;

/*
use Silex\Provider\FormServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
*/

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;

class ServiceProvider
{
    public static function register($app)
    {
        /*
        $app->register(new FormServiceProvider());
        $app->register(new CsrfServiceProvider());
        $app->register(new RoutingServiceProvider());
        $app->register(new SwiftmailerServiceProvider());
        $app->register(new SerializerServiceProvider());
        $app->register(new LocaleServiceProvider());

        $app->register(new TranslationServiceProvider());
        $app->extend('translator', function($translator, $app) {
            $translator->addLoader('yaml', new \Symfony\Component\Translation\Loader\YamlFileLoader());

            $translator->addResource('yaml', ROOT_DIR.'etc/locale/en.yml', 'en');
            $translator->addResource('yaml', ROOT_DIR.'etc/locale/id.yml', 'id');

            return $translator;
        });

        $app->register(new ValidatorServiceProvider());
        $app['validator.mapping.class_metadata_factory'] = new \Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory(
            new \Symfony\Component\Validator\Mapping\Loader\YamlFileLoader(ROOT_DIR.'etc/validation/validation.yml')
        );
        */

        $app->register(new DoctrineServiceProvider());
        $app->register(new HttpFragmentServiceProvider());
        $app->register(new MonologServiceProvider());
        $app->register(new ServiceControllerServiceProvider());

        $app->register(new HttpCacheServiceProvider(), array(
            'http_cache.cache_dir' => ROOT_DIR.'var/cache/http',
            'http_cache.esi'       => null,
        ));

        $app->register(new DoctrineOrmServiceProvider, array(
            'orm.proxies_dir' => ROOT_DIR.'var/cache/proxies/doctrine',
            'orm.em.options' => array(
                'mappings' => array(
                    array(
                        'type' => 'annotation',
                        'namespace' => 'App\\Entity',
                        'path' => ROOT_DIR.'src/App/Entity',
                        'use_simple_annotation_reader' => false,
                    ),
                ),
            ),
        ));

        $app->register(new DoctrineOrmManagerRegistryProvider());

        $app->register(new SessionServiceProvider(), array(
            'session.storage.options' => array(
                'name' => 'silex',
            ),
        ));
        $app['session.storage.handler'] = function () use ($app) {
            return new \Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler(
                $app['db']->getWrappedConnection(),
                $app['session.db_options'],
                $app['session.storage.options']
            );
        };

        $app->register(new SecurityServiceProvider(), array(
            'security.firewalls' => array(
                'admin' => array(
                    'pattern'=> '^/admin',
                    'http' => true,
                    'form' => array(
                        'login_path' => '/login',
                         'check_path' => '/admin/login_check',
                        'default_target_path' => '/admin',
                    ),
                    'logout' => array(
                        'logout_path' => '/admin/logout',
                        'invalidate_session' => true
                    ),
                    'users' => function () use ($app) {
                        return new \Symfony\Bridge\Doctrine\Security\User\EntityUserProvider(
                            $app['doctrine'],
                            'App\Entity\User'
                        );
                    },
                    'remember_me' => array(
                        'key'                => hash('sha256', 'silex'),
                        'lifetime'           => 604800, # 1 week in seconds
                        'always_remember_me' => false,
                    ),
                ),
            ),
        ));

        $app->register(new RememberMeServiceProvider());

        $app->register(new TwigServiceProvider(), array(
            'twig.path'    => ROOT_DIR.'src/App/View',
            'twig.options' => array(
                'cache'            => ($app['debug'] ? false : ROOT_DIR.'var/cache/twig'),
                'strict_variables' => false,
            ),
        ));

        if ($app['debug']) {
            $app->register(new VarDumperServiceProvider());

            $app->register(new WebProfilerServiceProvider(), array(
                'profiler.cache_dir' => ROOT_DIR.'var/cache/profiler',
            ));
        }

        return $app;
    }
}
