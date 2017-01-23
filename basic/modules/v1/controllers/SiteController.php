<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use app\modules\v1\models\LoginForm;

class SiteController extends Controller
{

    /*public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                //这是你的回调之后的处理方法
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }*/

    /*public function successCallback($client)
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
    }*/

    /**
     * 有时你可能想通过直接在响应主体内包含分页信息来简化客户端的开发工作。
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    /**
     * 用户登录action
     */
    public function actionLogin()
    {
        $loginForm = new LoginForm();//实例化登陆模型
        $loginForm->setScenario('login');//设置登陆场景
        if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate()) {//绑定登陆信息 && 验证登陆信息
            return $loginForm->login();
        } else {
            return $loginForm->getErrors();
        }
    }

    /**
     * 用户注册action
     */
    public function actionRegister()
    {
        $loginForm = new LoginForm();//实例化登陆模型
        $loginForm->setScenario('register');//设置注册场景
        if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate()) {//绑定登陆信息 && 验证登陆信息
            return $loginForm->register();
        } else {
            return $loginForm->getErrors();
        }
    }

}
