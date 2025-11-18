<?php

namespace app\controllers;

use app\controllers\BaseApiController;
use app\models\User;
use app\models\responses\Response;
use app\models\responses\ResponseList;
use app\models\searchs\EsqueletoSearch;
use app\widgets\ResultHelper;
use Exception;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class UserController extends BaseApiController
{
  public function actionIndex()
  {
    try {
      $email = Yii::$app->request->post('username');
      $password = Yii::$app->request->post('password');

      $user = User::find()->login($email, $password);

      return $this->asJson(new Response(
        Yii::t('app', 'Login Successful'),
        $user
      ));
    } catch (\Exception $ex) {
      return $this->error($ex);
    }
  }

  public function actionCreate()
  {
    try {
      $model = User::find()->preCreate();

      return $this->asJson(new Response(
        Yii::t('app', 'Saved Successfully'),
        $model
      ));
    } catch (Exception $ex) {
      $this->error($ex);
    }
  }


  public function actionGet($id)
  {
    try {
      $model = $this->findModel($id);
      // Implemente da forma abaixo pra garantir a empresa
      // $model = User::find()->loadModel($id)->one();
      return $this->asJson(
        ResultHelper::json(
          $model,
          [
            'usuarioCriacao',
            'usuarioAlteracao',
          ]
        )
      );
    } catch (Exception $ex) {
      $this->error($ex);
    }
  }

  public function actionUpdate($id)
  {
    try {
      $model = $this->findModel($id);
      $model->setAttributes(Yii::$app->request->post());
      // $model->id_usuario_alteracao = Auxiliares::getIdUsuario();
      $model->id_usuario_alteracao = 1; // temporario pra salvar no app

      if (!$model->save()) {
        throw new Exception(Html::errorSummary($model));
      }

      return $this->asJson(new Response(
        Yii::t('app', 'Saved Successfully'),
        $model
      ));
    } catch (Exception $ex) {
      $this->error($ex);
    }
  }

  public function actionDelete($id)
  {
    try {
      $model = $this->findModel($id);
      if (!$model->delete()) {
        throw new Exception(Html::errorSummary($model));
      }

      return $this->asJson(new Response(
        Yii::t('app', 'Deleted Successfully')
      ));
    } catch (Exception $ex) {
      $this->error($ex);
    }
  }

  private function findModel($id)
  {
    // if (($model = User::find()->findModelEmpresa($id)) !== null) {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
