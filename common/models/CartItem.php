<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cart_item}}".
 *
 * @property int      $id
 * @property int      $product_id
 * @property int      $quantity
 * @property int|null $created_by
 *
 * @property User     $createdBy
 * @property Product  $product
 */
class CartItem extends \yii\db\ActiveRecord
{
    const SESSION_KEY = 'cart_items';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cart_item}}';
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CartItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CartItemQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['product_id', 'quantity', 'created_by'], 'integer'],
            [
                ['created_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
                'targetAttribute' => ['created_by' => 'id'],
            ],
            [
                ['product_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Product::className(),
                'targetAttribute' => ['product_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'product_id' => 'Product ID',
            'quantity'   => 'Quantity',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function getTotalCount()
    {
        if (isGuest()) {
            $count = 0;
            $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($items as $item) {
                $count += $item['quantity'];
            }
        } else {
            $count = CartItem::findBySql(
                "SELECT SUM(quantity) FROM cart_item WHERE created_by = :userId",
                [':userId' => currUserId()]
            )->scalar();
        }
        return $count;
    }


    public static function getTotalPrice()
    {
        if (isGuest()) {
            $count = 0;
            $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($items as $item) {
                $count += $item['quantity'] * $item['price'];
            }
        } else {
            $count = CartItem::findBySql(
                "SELECT SUM(c.quantity*p.price) FROM cart_item c LEFT JOIN product p on p.id = c.product_id WHERE c.created_by = :userId",
                [':userId' => currUserId()]
            )->scalar();
        }
        return $count;
    }

    public static function getItems(): array
    {
        if (Yii::$app->user->isGuest) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
        } else {
            $cartItems = CartItem::findBySql(
                "SELECT  c.product_id as id,p.image,p.name,p.price,c.quantity,c.quantity*p.price as total_price FROM cart_item c LEFT JOIN product p ON p.id=c.product_id WHERE c.created_by=:user_id",
                [':user_id' => currUserId()]
            )->asArray()->all();
        }
        return $cartItems;
    }

    public static function clearCart()
    {
        if (isGuest()) {
            Yii::$app->session->set(CartItem::SESSION_KEY, []);
        } else {
            CartItem::deleteAll(['created_by' => currUserId()]);
        }
    }
}
