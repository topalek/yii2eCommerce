<?php
/**
 * Created by topalek
 * Date: 11.01.2021
 * Time: 19:22
 */

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Product]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
        {
            return $this->andWhere('[[status]]=1');
        }*/

    /**
     * {@inheritdoc}
     * @return \common\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
