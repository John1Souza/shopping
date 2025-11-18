<?php

namespace app\querys;

use app\models\User;
use app\widgets\XDebug;
use Exception;
use Yii;
use yii\helpers\Html;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function preCreate()
    {
        $post = Yii::$app->request->post();

        $name = $post['name'] ?? null;
        $email = isset($post['email']) ? strtolower(trim($post['email'])) : null;
        $password = $post['password'] ?? null;

        if (empty($email)) throw new Exception("E-mail é obrigatório");
        if (empty($password)) throw new Exception("Senha é obrigatória");
        if (empty($name)) throw new Exception("Nome é obrigatório");

        $model = new User();
        $model->name = $name;
        $model->email = $email;
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);

        if (!$model->save()) {
            throw new Exception(Html::errorSummary($model));
        }

        return true;
    }


    public function login($email, $password)
    {
        $normalizedEmail = strtolower(trim($email));

        $user = User::find()->where(['email' => $normalizedEmail])->one();

        if (!$user || !Yii::$app->security->validatePassword($password, $user->password_hash)) {
            throw new Exception("Usuário ou senha inválidos");
        }

        $user->auth_key = Yii::$app->security->generateRandomString();

        return [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
