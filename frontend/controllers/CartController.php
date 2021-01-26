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
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends BaseController
{
    public function behaviors()
    {
        return [
            [
                'class'   => ContentNegotiator::class,
                'only'    => ['add', 'update-count'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'       => ['post', 'delete'],
                    'update-count' => ['post'],
                ],
            ],
        ];
    }

    public function actionAdd($id)
    {
        if (Yii::$app->request->isPost) {
            $product = Product::findOne(['id' => $id, 'status' => Product::STATUS_PUBLISHED]);
            if (!$product) {
                throw new NotFoundHttpException();
            }

            if (Yii::$app->user->isGuest) {
                $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
                $found = false;
                if (array_key_exists($id, $items)) {
                    $items[$id]['quantity']++;
                    $found = true;
                }

                if (!$found) {
                    $items[$id] = [
                        'id'          => $id,
                        'name'        => $product->name,
                        'image'       => $product->image,
                        'price'       => $product->price,
                        'quantity'    => 1,
                        'total_price' => $product->price,
                    ];
                }

                Yii::$app->session->set(CartItem::SESSION_KEY, $items);
                return ['success' => true];
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
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
        } else {
            $cartItems = CartItem::findBySql(
                "SELECT  c.product_id as id,p.image,p.name,p.price,c.quantity,c.quantity*p.price as total_price FROM cart_item c LEFT JOIN product p ON p.id=c.product_id WHERE c.created_by=:user_id",
                [':user_id' => currUserId()]
            )->asArray()->all();
        }
        return $this->render('index', ['items' => $cartItems]);
    }

    public function actionDelete($id)
    {
        if (isGuest()) {
            $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            if (array_key_exists($id, $items)) {
                unset($items[$id]);
                Yii::$app->session->set(CartItem::SESSION_KEY, $items);
            }
        } else {
            CartItem::deleteAll(['product_id' => $id, 'created_by' => currUserId()]);
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateCount()
    {
        $post = Yii::$app->request->post();
        $itemId = $post['id'];
        $count = $post['count'];
        $product = Product::find()->where(['product_id' => $itemId, 'status' => Product::STATUS_PUBLISHED]);
        if (!$product) {
            throw new NotFoundHttpException('Product id=' . $itemId . ' not found');
        }
        if (isGuest()) {
            $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            if (array_key_exists($itemId, $items)) {
                $items[$itemId]['quantity'] = $count;
            }
            Yii::$app->session->set(CartItem::SESSION_KEY, $items);
        } else {
            CartItem::updateAll(['quantity' => $count], ['product_id' => $itemId, 'created_by' => currUserId()]);
        }
        return CartItem::getTotalCount();
    }
}
