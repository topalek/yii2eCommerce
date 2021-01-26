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
        $count = 0;
        if (Yii::$app->user->isGuest) {
            $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($items as $item) {
                $count += $item['quantity'];
            }
        } else {
            $count = CartItem::findBySql(
                "SELECT SUM(quantity) FROM cart_item WHERE created_by = :userId",
                [':userId' => Yii::$app->user->id]
            )->scalar();
        }
        $this->view->params['cartItemCount'] = $count;

        return parent::beforeAction($action);
    }
}
