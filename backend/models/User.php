<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string|null $created_at
 * @property string|null $auth_key
 *
 * @property ShoppingList[] $shoppingLists
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key'], 'default', 'value' => null],
            [['name', 'email', 'password_hash'], 'required'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['password_hash', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'created_at' => Yii::t('app', 'Created At'),
            'auth_key' => Yii::t('app', 'Auth Key'),
        ];
    }

    /**
     * Gets query for [[ShoppingLists]].
     *
     * @return \yii\db\ActiveQuery|\app\querys\ShoppingListQuery
     */
    public function getShoppingLists()
    {
        return $this->hasMany(ShoppingList::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\querys\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\querys\UserQuery(get_called_class());
    }

}
