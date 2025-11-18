<?php

namespace app\querys;

/**
 * This is the ActiveQuery class for [[\app\models\ShoppingList]].
 *
 * @see \app\models\ShoppingList
 */
class ShoppingListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\ShoppingList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ShoppingList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
