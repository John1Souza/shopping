<?php

namespace app\querys;

/**
 * This is the ActiveQuery class for [[\app\models\ShoppingItem]].
 *
 * @see \app\models\ShoppingItem
 */
class ShoppingItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\ShoppingItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ShoppingItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
