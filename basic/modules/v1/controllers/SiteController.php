<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\LoginForm;
use app\modules\v1\models\User;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;


class SiteController extends Controller
{

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                //这是你的回调之后的处理方法
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        // 用户的信息在$attributes中，以下是您根据您的实际情况增加的代码
        // 如果您同时有QQ互联登录，新浪微博等，可以通过 $client->id 来区别。
        $attributes = $client->getUserAttributes();
        $LoginForm = new LoginForm();
        $LoginForm->setScenario('Oauth2');//定义动作场景为Oauth2
        $LoginForm->load(
            [
                'LoginForm' => [
                    'Oauth2' => $client->id,
                    'UserAttributes' => $attributes
                ]
            ]
        );//Oauth2登录数据绑定
        if ($LoginForm->validate()) {//数据验证通过
            return $LoginForm->loginOauth2();
        } else {//数据异常
            throw new HttpException(422, '数据异常...');//数据验证失败
        }
    }
}
