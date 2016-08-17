<?php

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'dbname'   => 'silex',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => 'root',
    'port'     => '3306',
    'charset'  => 'utf8',
);

$app['swiftmailer.options'] = array(
    'host'       => 'localhost',
    'port'       => '25',
    'username'   => 'username',
    'password'   => 'password',
    'encryption' => null,
    'auth_mode'  => null,
);

$app['session.db_options'] = array(
    'db_table'        => 'sessions',
    'db_id_col'       => 'session_id',
    'db_data_col'     => 'session_value',
    'db_lifetime_col' => 'session_lifetime',
    'db_time_col'     => 'session_time',
);

$app['debug'] = false;

$app['monolog.logfile'] = ROOT_DIR.'var/log/error.log';
$app['monolog.level']   = Monolog\Logger::ERROR;

$app['api.version'] = 1;