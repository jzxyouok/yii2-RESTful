<?php
/**
 * Created by PhpStorm.
 * User: QiQi-04-PC
 * Date: 2017/1/17
 * Time: 14:29
 */

namespace app\controllers;

/**
 * Yii 提供两个控制器基类来简化创建RESTful 操作的工作: yii\rest\Controller 和 yii\rest\ActiveController，
 * 两个类的差别是后者提供一系列将资源处理成Active Record 的操作。
 * 因此如果使用Active Record 内置的操作会比较方便，
 * 可考虑将控制器类继承yii\rest\ActiveController，
 * 它会让你用最少的代码完成强大的RESTful APIs.
 */
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\HttpException;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    /**
     * 通过RESTful APIs显示数据时，
     * 经常需要检查当前用户是否有权限访问和操作所请求的资源，
     * 在yii\rest\ActiveController中，
     * 可覆盖yii\rest\ActiveController::checkAccess() 方法来完成权限检查。
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws HttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
//        switch($action){
//            case "view":
//                throw new HttpException(403);
//                break;
//        }
    }

    /**
     * 自定义操作
     * yii\rest\ActiveController 默认提供一下操作:
     * yii\rest\IndexAction: 按页列出资源;
     * yii\rest\ViewAction: 返回指定资源的详情;
     * yii\rest\CreateAction: 创建新的资源;
     * yii\rest\UpdateAction: 更新一个存在的资源;
     * yii\rest\DeleteAction: 删除指定的资源;
     * yii\rest\OptionsAction: 返回支持的HTTP方法.
     * 所有这些操作通过yii\rest\ActiveController::actions() 方法申明，可覆盖actions()方法配置或禁用这些操作
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();

        // 禁用"delete" 和 "create" 操作
        unset($actions['delete'], $actions['create']);

        // 使用"prepareDataProvider()"方法自定义数据provider
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * 为"index"操作准备和返回数据provider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }


    /**
     * 创建控制器类
     * 创建新的操作和Web应用中创建操作类似，
     * 唯一的差别是Web应用中 调用render()方法渲染一个视图作为返回值，
     * 对于RESTful操作 直接返回数据，
     * yii\rest\Controller::serializer 和 yii\web\Response 会处理原始数据到请求格式的转换
     * @param $id
     * @return static
     */
    public function actionView($id)
    {
        return User::findOne($id);
    }
}