<?php

use kartik\mpdf\Pdf;
use kartik\datecontrol\Module;

$params = require __DIR__ . '/params.php';
require(__DIR__ . '/config-local.php');
$mainDb = require __DIR__ . '/mainDb.php';

//setlocale(LC_ALL, null);
//setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$config = [
    'id' => 'dynquesapp',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
//    'language' => 'pt-BR',
    'timeZone' => 'UTC',
    'aliases' => 
    [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => 
    [
        'user' => 
        [
            'class' => 'app\modules\user\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'datecontrol' => 
        [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd/MM/yyyy',
                Module::FORMAT_TIME => 'HH:mm',
                Module::FORMAT_DATETIME => 'dd/MM/yyyy HH:mm',
            ],
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'displayTimezone' => 'UTC',
            'saveTimezone' => 'UTC',
            'autoWidget' => true,
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => [
                    'type' => 3,
                    'pluginOptions' => [
                        'language' => 'pt-BR',
                        'todayHighlight' => true,
                        'orientation' => 'bottom left',
                        'autoClose' => true,
                        'saveTimezone' => 'UTC',
                    ]
                ],
                Module::FORMAT_DATETIME => [
                    'type' => 3,
                    'pluginOptions' => [
                        'language' => 'pt-BR',
                        'autoclose' => true,
                        'minuteStep' => 1,
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'orientation' => 'bottom left',
                        'autoClose' => true,
                        'saveTimezone' => 'UTC',
                    ]
                ], 
                Module::FORMAT_TIME => [
                    'pluginOptions' => [
                        'language' => 'pt-BR',
                        'autoclose' => true,
                        'minuteStep' => 1,
                        'orientation' => 'bottom left',
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'saveTimezone' => 'UTC',
                    ]
                ],
            ],
            'widgetSettings' => [
                Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker',
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options' => ['class' => 'form-control'],
                    ],
                    'pluginOptions' => [
                        'language' => 'pt-BR',
                        'autoclose' => true,
                        'minuteStep' => 1,
                        'orientation' => 'bottom left',
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'saveTimezone' => 'UTC',
                    ]
                ]
            ],
        ]
    ],
    'components' => 
    [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@app/messages',
//                    'sourceLanguage' => 'pt-BR',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'pdf' => 
        [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
        ],
        'formatter' => 
        [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
        ],
        'request' => 
        [
            'cookieValidationKey' => 'mlKdROOiahYA_57c3jx2D3SkysNb7Vm4',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => 
        [
            'theme' => 
            [
                'pathMap' => 
                [
                   '@app/views' => '@app/views/layout'
                ],
            ],
        ],
        'assetManager' => 
        [
            'bundles' => 
            [
                'dmstr\web\AdminLteAsset' => 
                [
                    'skin' => 'skin-black',
                ],
            ],
        ],
        'user' => 
        [
            'loginUrl' => '/user/login',
            'class' => 'app\modules\user\components\User',
            'identityClass' => 'app\models\UserM',
            'enableAutoLogin' => false,
            'enableSession' => true,
            'identityCookie' => 
            [
                'name' => '_dynquesuser'
            ]
        ],
        'session' => 
        [
            'class' => 'yii\web\Session',
            'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],
            'timeout' => 3600 * 4,
            'useCookies' => true,
        ],
        'errorHandler' => 
        [
            'errorAction' => 'site/error',
        ],
        'mailer' =>
        [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' =>
            [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtplw.com.br',
                'username' => 'bpone',
                'password' => 'vdqmeezV2399',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => 
        [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => 
            [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $mainDb,
        'urlManager' =>
        [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (false)
{
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 
    [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 
    [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
