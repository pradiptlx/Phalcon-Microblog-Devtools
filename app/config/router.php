<?php

use Phalcon\Mvc\Router;

/**
 * @var Router $router
 */
$router = $di->getRouter();

// Define your routes here
$router->add(
    '/:controller/:action',
    [
        'controller' => 'User',
        'action' => 'login'
    ]
);

$router->handle($_SERVER['REQUEST_URI']);
