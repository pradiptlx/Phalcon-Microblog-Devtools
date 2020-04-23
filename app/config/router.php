<?php

use Phalcon\Mvc\Router;

/**
 * @var Router $router
 */
$router = $di->getShared('router');

/**
 * USER
 */
$userRouter = new Router\Group([
    'controller' => 'user'
]);
$userRouter->setPrefix('/user');
$userRouter->add(
    '/:action',
    [
        'action' => 1
    ]
);

/**
 * Post
 */
$postRouter = new Router\Group([
    'controller' => 'post'
]);
$postRouter->setPrefix('/post');
$postRouter->add(
    '/createPost',
    [
        'action' => 'createPost'
    ]
)->setName('create-post');
$postRouter->add(
    '/:params',
    [
        'action' => 'index',
        'params' => 1
    ]
)->setName('get-post');
$postRouter->add(
    '/editPost/:params',
    [
        'action' => 'editPost',
        'params' => 1
    ]
)->setName('edit-post');
$postRouter->add(
    'deletePost/:params',
    [
        'action' => 'deletePost',
        'params' => 1
    ]
)->setName('delete-post');

/**
 * File
 */
$fileRouter = new Router\Group([
    'controller' => 'fileManager'
]);



$router->mount($userRouter);
$router->mount($postRouter);

$router->handle($_SERVER['REQUEST_URI']);
