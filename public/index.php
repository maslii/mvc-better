<?php

require dirname(__DIR__) . '/vendor/autoload.php';

\App\Config::setRuntimeParams();

set_error_handler('\App\Config::errorHandler');
set_exception_handler('\App\Config::exceptionHandler');

new \Core\Router($_GET['uri'] ?? '');