<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\authclient\widgets\AuthChoice;
use yii\web\Controller;
use app\modules\v1\components\AuthHandler;


class SiteController extends Controller
{
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    public function actionIndex()
    {
        echo AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
        ]);
    }
}
