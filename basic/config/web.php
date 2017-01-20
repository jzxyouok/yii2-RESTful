<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        //数据库配置
        'db' => require(__DIR__ . '/db.php'),
        //Redis配置
        'redis' => require(__DIR__ . '/redis.php'),
        //请求相关配置
        'request' => require(__DIR__ . '/request.php'),
        //响应相关配置
        'response' => require(__DIR__ . '/response.php'),
        //路由配置
        'urlManager' => require(__DIR__ . '/urlManager.php'),
        //用户验证相关配置
        'user' => require(__DIR__ . '/user.php'),
        //Oauth 2 相关配置
        //'authClientCollection' => require(__DIR__ . '/authClientCollection.php'),
    ],
    //模块相关配置
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
