<?php

return [
    'class' => 'yii\authclient\Collection',
    'clients' => [
        'github' => [
            'class' => 'yii\authclient\clients\GitHub',
            'clientId' => 'f9cbc7feb7f3cb0ca7fc',
            'clientSecret' => 'b481635a89fb4c9df50932073ccbe515ce4494ac',
        ],
        'qq' => [
            'class'=>'yii\authclient\clients\QqOAuth',
            'clientId'=>'1105885289',
            'clientSecret'=>'VpcITXqiz4VnHEmr',
        ],
        // etc.
    ],
];
