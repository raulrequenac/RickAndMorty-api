<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Use Loader() to autoload our model
$loader = new Loader();

$loader->registerNamespaces(
    [
        'RickAndMorty' => __DIR__ . '/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Set up the database service
$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'rickandmorty',
            ]
        );
    }
);

// Create and bind the DI to the application
$app = new Micro($di);

$app->get(
    '/api/character',
    function () use ($app){
        $phql = 'SELECT * FROM RickAndMorty\Characters';

        $characters = $app->modelsManager->executeQuery($phql);

        if (is_null(count($characters))) {
            $url = "https://rickandmortyapi.com/api/character/";
            $jsondata = file_get_contents($url);
            $obj = json_decode($jsondata);
        }

        $data = [];
    }
);

$app->get(
    '/api/character/{id}',
    function ($id) {
    }
);

$app->get(
    '/api/character/{ids}',
    function ($ids) {
    }
);

$app->get(
    '/api/character?{filter}',
    function ($filter) {

    }
);

$app->post(
    '/api/character',
    function () {
    }
);

$app->delete(
    '/api/character/{id}',
    function ($id) {
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);