<?php

namespace app\controllers;

use app\controllers\BaseApiController;
use app\models\Esqueleto;
use app\models\responses\Response;
use app\models\responses\ResponseList;
use app\models\searchs\EsqueletoSearch;
use app\widgets\ResultHelper;
use Exception;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class EsqueletoController extends BaseApiController
{
    public function actionIndex()
    {
        try {
            $post = Yii::$app->request->post();

            if (Yii::$app->request->isGet) {
                $data = Esqueleto::find()->all();
                $response = new ResponseList(
                    ResultHelper::json($data),
                    count($data)
                );
            } else {
                $data = $post['data'] ?? [];
                $searchModel = new EsqueletoSearch();
                $searchModel->setAttributes($data);
                $searchModel->setOldAttributes($data);
                $dataProvider = $searchModel->search();

                $response = new ResponseList(
                    ResultHelper::json(
                        $dataProvider->getModels(),
                        [
                            'usuarioCriacao',
                            'usuarioAlteracao',
                        ]
                    ),
                    $dataProvider->getTotalCount()
                );
            }

            return $this->asJson($response);
        } catch (Exception $ex) {
            $this->error($ex);
        }
    }

    public function actionGet($id)
    {
        try {
            $model = $this->findModel($id);
            // Implemente da forma abaixo pra garantir a empresa
            // $model = Esqueleto::find()->loadModel($id)->one();
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

    public function actionCreate()
    {
        try {
            $model = new Esqueleto();
            // $model->id_usuario_criacao = Auxiliares::getIdUsuario();
            $model->id_usuario_criacao = 1; // temporario pra salvar no app
            $model->setAttributes(Yii::$app->request->post());

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
        // if (($model = Esqueleto::find()->findModelEmpresa($id)) !== null) {
        if (($model = Esqueleto::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
