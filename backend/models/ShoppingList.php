<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopping_list".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $created_at
 *
 * @property ShoppingItem[] $shoppingItems
 * @property User $user
 */
class ShoppingList extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopping_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[ShoppingItems]].
     *
     * @return \yii\db\ActiveQuery|\app\querys\ShoppingItemQuery
     */
    public function getShoppingItems()
    {
        return $this->hasMany(ShoppingItem::className(), ['list_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\app\querys\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\querys\ShoppingListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\querys\ShoppingListQuery(get_called_class());
    }

}
