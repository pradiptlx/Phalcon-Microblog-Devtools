<?php

use Phalcon\Mvc\Router;

/**
 * @var Router $router
 */
$router = $di->getShared('router');

$router->add(
    '/home',
    [
        'controller' => 'post',
        'action' => 'index'
    ]
);

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
    '/',
    [
        'action' => 'index'
    ]
)->setName('home');
$postRouter->add(
    '/createPost',
    [
        'action' => 'createPost'
    ]
)->setName('create-post');
$postRouter->add(
    '/viewPost/:params',
    [
        'action' => 'viewPost',
        'params' => 1
    ]
)->setName('view-post');
$postRouter->add(
    '/editPost/:params',
    [
        'action' => 'editPost',
        'params' => 1
    ]
)->setName('edit-post');
$postRouter->add(
    '/deletePost/:params',
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
