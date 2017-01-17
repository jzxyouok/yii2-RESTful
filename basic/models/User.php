<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\Link;
use yii\web\Linkable;

class User extends ActiveRecord implements IdentityInterface, Linkable
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
        return static::findOne(['access_token' => $token]);
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
}
