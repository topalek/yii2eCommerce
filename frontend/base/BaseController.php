<?php
/**
 * Created by topalek
 * Date: 25.01.2021
 * Time: 20:39
 */

namespace frontend\base;


use common\models\CartItem;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemCount'] = CartItem::findBySql(
            "SELECT SUM(quantity) FROM cart_item WHERE created_by = :userId",
            [':userId' => Yii::$app->user->id]
        )->scalar();

        return parent::beforeAction($action);
    }
}
