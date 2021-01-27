<?php

namespace common\models;

/**
 * This is the model class for table "{{%order_address}}".
 *
 * @property int         $order_id
 * @property string      $address
 * @property string      $city
 * @property string      $state
 * @property string      $country
 * @property string|null $zipcode
 *
 * @property Order       $order
 */
class OrderAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_address}}';
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\OrderAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderAddressQuery(get_called_class());
    }

    /**
     * @param $UserAddress
     *
     * @return OrderAddress
     */
    public static function createFromAddress($UserAddress): OrderAddress
    {
        $oAddress = new self();
        $oAddress->address = $UserAddress->address;
        $oAddress->city = $UserAddress->city;
        $oAddress->state = $UserAddress->state;
        $oAddress->country = $UserAddress->country;
        $oAddress->zipcode = $UserAddress->zipcode;
        return $oAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'address', 'city', 'state', 'country'], 'required'],
            [['order_id'], 'integer'],
            [['address', 'city', 'state', 'country', 'zipcode'], 'string', 'max' => 255],
            [['order_id'], 'unique'],
            [
                ['order_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Order::class,
                'targetAttribute' => ['order_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'address'  => 'Address',
            'city'     => 'City',
            'state'    => 'State',
            'country'  => 'Country',
            'zipcode'  => 'Zipcode',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrderQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}
