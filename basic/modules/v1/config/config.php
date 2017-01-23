<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'components' => [
        //数据库配置
        'db' => require(__DIR__ . '/db.php'),
        //Redis配置
        'redis' => require(__DIR__ . '/redis.php'),
        //Oauth 2 相关配置
        //'authClientCollection' => require(__DIR__ . '/authClientCollection.php'),
    ],
    'params' => $params,
];

return $config;
