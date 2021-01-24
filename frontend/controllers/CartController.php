<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use common\models\CartItem;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CartController extends Controller
{
    public function actionAdd($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            return ['status' => true, 'msg' => 'Added to cart'];
        }
        return ['status' => false, 'msg' => 'Only POST method is allowed'];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            // get cart items from session
        } else {
            // get cart items from db
            $cartItems = CartItem::findBySql(
                "SELECT c.id,c.product_id,p.image,p.name,p.price,c.quantity,c.quantity*p.price as total_price FROM cart_item c LEFT JOIN product p ON p.id=c.product_id WHERE c.created_by=:user_id",
                [':user_id' => Yii::$app->user->id]
            )->asArray()->all();
        }
        return $this->render('index', ['items' => $cartItems]);
    }
}
