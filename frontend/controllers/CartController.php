<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use common\models\CartItem;
use common\models\Product;
use frontend\base\BaseController;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends BaseController
{
    public function behaviors()
    {
        return [
            [
                'class'   => ContentNegotiator::class,
                'only'    => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionAdd($id)
    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $product = Product::findOne(['id' => $id, 'status' => Product::STATUS_PUBLISHED]);
            if (!$product) {
                throw new NotFoundHttpException();
            }

            if (Yii::$app->user->isGuest) {
                //todo add to SESSION if user is guest

            } else {
                $userId = Yii::$app->user->getId();
                $item = CartItem::find()->byUser($userId)->productId($id)->one();
                if ($item) {
                    $item->quantity++;
                } else {
                    $item = new CartItem();
                    $item->product_id = $id;
                    $item->created_by = $userId;
                    $item->quantity = 1;
                }
                if ($item->save()) {
                    return ['success' => true];
                }
                return ['success' => false, 'errors' => $item->errors];
            }
        }
        return ['success' => false, 'msg' => 'Only POST method is allowed'];
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
