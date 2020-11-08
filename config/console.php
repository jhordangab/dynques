<?php

$params = require __DIR__ . '/params.php';
require(__DIR__ . '/config-local.php');
$mainDb = require __DIR__ . '/mainDb.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $mainDb,
    ],
    'params' => $params,
];

return $config;
