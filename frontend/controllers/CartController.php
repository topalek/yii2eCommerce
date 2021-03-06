<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use common\models\CartItem;
use common\models\Order;
use common\models\OrderAddress;
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
                'only'    => ['add', 'update-count', 'create-order'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'       => ['post', 'delete'],
                    'update-count' => ['post'],
                    'create-order' => ['post'],
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
        $cartItems = CartItem::getItems();
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

    public function actionCheckout()
    {
        $order = new Order();
        $order->status = Order::STATUS_DRAFT;
        $orderAddress = new OrderAddress();
        $cartItems = CartItem::getItems();
        $order->total_price = CartItem::getTotalPrice();

        if (empty($cartItems)) {
            return $this->goHome();
        }
        $orderAddress->attributes = currUser()->address->attributes;

        if (!isGuest()) {
            $user = currUser();
            $orderAddress->attributes = $user->address->attributes;
            $order->firstname = $user->firstname;
            $order->lastname = $user->lastname;
            $order->email = $user->email;
        }
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            if ($order->load($post)
                && $order->save()
                && $order->saveAddress($post)
                && $order->createItems()) {
                $transaction->commit();
                //todo send admin email
                CartItem::clearCart();
                return $this->redirect('/cart/create-order');
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render(
            'checkout',
            [
                'order'        => $order,
                'orderAddress' => $orderAddress,
                'cartItems'    => $cartItems,
            ]
        );
    }

    public function actionCreateOrder()
    {
        return 'Create order';
        $post = Yii::$app->request->post();
        $order = new Order();
        $order->total_price = CartItem::getTotalPrice();
        $order->created_at = time();
        $order->created_by = currUserId();
        $transaction = Yii::$app->db->beginTransaction();
        if ($order->load($post)
            && $order->save()
            && $order->saveAddress($post)
            && $order->createItems()) {
            $transaction->commit();
            //todo send admin email
            CartItem::clearCart();
            return ['success' => true];
        } else {
            $transaction->rollBack();
            return ['success' => false, 'errors' => $order->errors];
        }
    }
}
