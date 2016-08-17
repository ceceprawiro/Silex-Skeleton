<?php

require __DIR__.'/prod.php';

$app['debug'] = true;

$app['monolog.logfile'] = ROOT_DIR.'var/log/debug.log';
$app['monolog.level']   = Monolog\Logger::DEBUG;