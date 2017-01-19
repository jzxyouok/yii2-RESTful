<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: Api调用频率相关数据模型（居于Redis实现）
 */

namespace app\modules\v1\models;


use yii\redis\ActiveRecord;

class RateLimit extends ActiveRecord
{
    //Api在 $second 秒内能请求 $rateLimit 次
    public static $rateLimit = 1;
    public static $second = 1;

    /**
     * 一定要确保你有一个id属性定义，如果你不指定自己的主键
     * @return array
     */
    public function attributes()
    {
        return ['id', 'allowance', 'allowance_updated_at'];
    }
}