<?php

namespace common\models;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int         $id
 * @property string      $name        Name of the product
 * @property string|null $description Description
 * @property string|null $image       Image
 * @property float       $price       Price
 * @property int         $status      Status
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 * @property int|null    $updated_by
 *
 * @property CartItem[]  $cartItems
 * @property OrderItem[] $orderItems
 * @property User        $createdBy
 * @property User        $updatedBy
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'status'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 2000],
            [
                ['created_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['created_by' => 'id'],
            ],
            [
                ['updated_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['updated_by' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Name of the product',
            'description' => 'Description',
            'image'       => 'Image',
            'price'       => 'Price',
            'status'      => 'Status',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
            'created_by'  => 'Created By',
            'updated_by'  => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CartItemQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrderItemQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
