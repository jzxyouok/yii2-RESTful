<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: Api调用频率相关数据模型（居于Redis实现）
 */

namespace app\models;


use yii\redis\ActiveRecord;

class RateLimit extends ActiveRecord
{
    /**
     * 一定要确保你有一个id属性定义，如果你不指定自己的主键
     * @return array
     */
    public function attributes()
    {
        return ['id', 'allowance', 'allowance_updated_at'];
    }
}