<?php

return [
    'class' => 'yii\authclient\Collection',
    'clients' => [
        'google' => [
            'class' => 'yii\authclient\clients\Google',
            'clientId' => 'google_client_id',
            'clientSecret' => 'google_client_secret',
        ],
        'facebook' => [
            'class' => 'yii\authclient\clients\Facebook',
            'clientId' => 'facebook_client_id',
            'clientSecret' => 'facebook_client_secret',
        ],
        'github' => [
            'class' => 'yii\authclient\clients\GitHub',
            'clientId' => 'github_client_id',
            'clientSecret' => 'github_client_secret',
        ],
        // etc.
    ],
];
