<?php
declare(strict_types=1);

use Phalcon\Escaper;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Url as UrlResolver;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'path' => $config->application->cacheDir,
                'separator' => '_'
            ]);

            return $volt;
        },
//        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'charset' => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    $escaper = new Escaper();
    $flash = new Flash($escaper);
//    $flash->setImplicitFlush(false);
    $flash->setCssClasses([
        'error' => 'alert alert-danger alert-dismissible fade show',
        'success' => 'alert alert-success alert-dismissible fade show',
        'notice' => 'alert alert-info alert-dismissible fade show',
        'warning' => 'alert alert-warning alert-dismissible fade show'
    ]);

    return $flash;
});

/**
 * Change Flash session css Classes
 */
$di->set('flashSession', function (){
    $escaper = new Escaper();
    $flash = new FlashSession($escaper);
    $flash->setCssClasses([
        'error' => 'alert alert-danger alert-dismissible fade show',
        'success' => 'alert alert-success alert-dismissible fade show',
        'notice' => 'alert alert-info alert-dismissible fade show',
        'warning' => 'alert alert-warning alert-dismissible fade show'
    ]);

    return $flash;
});

//var_dump($di->get('flashSession'));
//die();

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionManager();
    $files = new SessionAdapter([
        'savePath' => sys_get_temp_dir(),
    ]);
    $session->setAdapter($files);
    $session->start();

    return $session;
});

/**
 * Add default configuration for router and dispatch manager
 */
$di->setShared('dispatcher', function () {
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace(
        'Dex\Microblog\Controller'
    );

    $dispatcher->setDefaultController('post');
    $dispatcher->setDefaultAction('index');

    $eventManager = new Manager();
    $eventManager->attach(
        'dispatch:beforeException',
        function (
            Event $event,
            $dispatcher,
            Exception $exception
        ) {
            // Default error 404 page
            if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
                $dispatcher->forward(
                    [
                        'controller' => 'index',
                        'action' => 'fourOhFour',
                    ]
                );
                return false;
            }

            return true;
        }
    );

    $dispatcher->setEventsManager($eventManager);
    return $dispatcher;
});

/**
 * Router
 */
$di->setShared('router', function () {
    $router = new Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true);

    return $router;
});

//$di->setShared('assets', function (){
//    $asset = new \Phalcon\Assets\Asset(
//        ''
//    );
//});
