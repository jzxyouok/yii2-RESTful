<?php

/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/19
 * Time: 16:43
 */

namespace app\modules\v1\models;

use yii\db\ActiveRecord;

class Auth extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth}}';
    }
}