<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
    ]
);

$loader->registerNamespaces([
    'Dex\Microblog\Models' => APP_PATH . '/models/',
    'Dex\Microblog\Controller' => APP_PATH . '/controllers'
]);

$loader->register();
