<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\filters\RateLimitInterface;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\Link;
use yii\web\Linkable;

class User extends ActiveRecord implements IdentityInterface, Linkable, RateLimitInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * 根据给到的ID查询身份。
     *
     * @param string|integer $id 被查询的ID
     * @return IdentityInterface|null 通过ID匹配到的身份对象
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * 根据 token 查询身份。
     *
     * @param string $token 被查询的 token
     * @return IdentityInterface|null 通过 token 得到的身份对象
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['id' => $token]);
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 资源类通过实现yii\web\Linkable 接口来支持HATEOAS，
     * 该接口包含方法 yii\web\Linkable::getLinks() 来返回 yii\web\Link 列表，
     * 典型情况下应返回包含代表本资源对象URL的 self 链接
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * @return array
     */
    public function fields()
    {
        return [
            'nickname',
            'account' => 'account',
            'register_time',
            'last_login_time',
            'last_login_ip',
            'now_time' => function ($model) {
                return date('Y-m-d H:i:s', time());
            },
        ];
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * @return array
     */
    public function extraFields()
    {
        return [
            'another' => function ($model) {
                return [
                    'another1' => date('Y-m-d H:i:s', time()),
                    'another2' => date('Y-m-d H:i:s', time())
                ];
            }
        ];
    }

    //要启用速率限制, yii\web\User::identityClass 应该实现 yii\filters\RateLimitInterface.
    // 这个接口需要实现以下三个方法：

    /**
     * getRateLimit(): 返回允许的请求的最大数目及时间，例如，[100, 600] 表示在600秒内最多100次的API调用。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function getRateLimit($request, $action)
    {
        return [2, 10];// $rateLimit requests per second
    }

    /**
     * loadAllowance(): 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function loadAllowance($request, $action)
    {
        $id = \Yii::$app->user->id;
        $rateLimit = RateLimit::find()->where([
            'user' => $id
        ])->one();
        return [
            !empty($rateLimit->allowance) ? $rateLimit->allowance : 0,
            !empty($rateLimit->allowance_updated_at) ? $rateLimit->allowance_updated_at : 0
        ];
    }

    /**
     * saveAllowance(): 保存允许剩余的请求数和当前的UNIX时间戳。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @param int $allowance
     * @param int $timestamp
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $rateLimit = new RateLimit();
        $id = \Yii::$app->user->id;
        $rateLimit->id = $id;
        $rateLimit->allowance = $allowance;
        $rateLimit->allowance_updated_at = $timestamp;
        $rateLimit->save();

    }
}
