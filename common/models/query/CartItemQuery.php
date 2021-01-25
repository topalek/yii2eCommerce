<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\CartItem]].
 *
 * @see \common\models\CartItem
 */
class CartItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\CartItem[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\CartItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $userId
     *
     * @return CartItemQuery
     */
    public function byUser($userId): CartItemQuery
    {
        return $this->andWhere(['created_by' => $userId]);
    }

    /**
     * @param $id
     *
     * @return CartItemQuery
     */
    public function productId($id): CartItemQuery
    {
        return $this->andWhere(['product_id' => $id]);
    }
}
