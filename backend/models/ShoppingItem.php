<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopping_item".
 *
 * @property int $id
 * @property int $list_id
 * @property string $name
 * @property int|null $quantity
 * @property float|null $price
 * @property int|null $checked
 * @property string|null $created_at
 *
 * @property ShoppingList $list
 */
class ShoppingItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopping_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'default', 'value' => null],
            [['quantity'], 'default', 'value' => 1],
            [['checked'], 'default', 'value' => 0],
            [['list_id', 'name'], 'required'],
            [['list_id', 'quantity', 'checked'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShoppingList::className(), 'targetAttribute' => ['list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'list_id' => Yii::t('app', 'List ID'),
            'name' => Yii::t('app', 'Name'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'checked' => Yii::t('app', 'Checked'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[List]].
     *
     * @return \yii\db\ActiveQuery|\app\querys\ShoppingListQuery
     */
    public function getList()
    {
        return $this->hasOne(ShoppingList::className(), ['id' => 'list_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\querys\ShoppingItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\querys\ShoppingItemQuery(get_called_class());
    }

}
