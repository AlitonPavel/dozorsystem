<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'language' => 'ru',
        'view' => [
            'class' => 'app\components\BaseView',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['guest'],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'secret_key',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'on afterLogin' => function($event) {
                Yii::$app->user->identity->afterLogin();
            },
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => ['lifetime' => 3600],
            'timeout' => 3600,
            'useCookies' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/'                                             => 'site/index',
                'costcalc/print'                                => 'report/costcalcprint',
                'costcalc/view'                                 => 'costcalcview/index',
                'costcalc/equip'                                => 'costcalcview/equip',
                'costcalc/work'                                 => 'costcalcview/work',
                'costcalc/pays'                                 => 'costcalcview/pays',
                'demand/view'                                   => 'demandview/index',
                'demand/comment'                                => 'demandview/comment',
                'object/view'                                   => 'objectview',
                'object/<action:(contracts)>'                   => 'objectview/<action>',
                'admin/<controller:\w+>/<id:\d+>'               => 'admin/<controller>/update',
                'admin/<controller:\w+>/<action:\w+>/<id:\d+>'  => 'admin/<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                 => '<controller>/<action>',
                '<action:(login|about|contact|logout)>'         => 'site/<action>'
            ],
        ],

    ],
    'params' => $params,
];

// Переключить на хосте версию PHP
//echo 'export PATH=/usr/local/php/cgi/7.1/bin/:$PATH:$HOME/.composer/vendor/bin' >> .bashrc
//source .bashrc

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
//        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
