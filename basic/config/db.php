<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2restful',
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
    'tablePrefix' => 'yii2_',
    //开启 Schema 缓存
    //Schema 缓存是一个特殊的缓存功能， 每当你使用活动记录时应该要开启这个缓存功能。
    //如你所知， 活动记录能智能检测数据库对象的集合（例如列名、列类型、约束）而不需要手动地描述它们。
    // 活动记录是通过执行额外的SQL查询来获得该信息。
    // 通过启用 Schema 缓存，检索到的数据库对象的集合将被保存在缓存中并在将来的请求中重用。
    //要开启 Schema 缓存，需要配置一个 cache 应用组件来储存 Schema 信息， 并在 配置 中设置 yii\db\Connection::enableSchemaCache 为 true :
    'schemaCache' => 'cache',
];
