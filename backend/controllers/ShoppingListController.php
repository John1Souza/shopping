<?php

namespace app\controllers;

use app\controllers\BaseApiController;
use app\models\ShoppingList;
use app\models\responses\Response;
use app\models\responses\ResponseList;
use app\models\searchs\ShoppingListSearch;
use app\widgets\ResultHelper;
use Exception;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class ShoppingListController extends BaseApiController
{
    public function actionIndex()
    {
        try {
            $post = Yii::$app->request->post();

            if (Yii::$app->request->isGet) {
                $data = ShoppingList::find()->all();
                $response = new ResponseList(
                    ResultHelper::json($data),
                    count($data)
                );
            } else {
                $data = $post['data'] ?? [];
                $searchModel = new ShoppingListSearch();
                $searchModel->setAttributes($data);
                $searchModel->setOldAttributes($data);
                $dataProvider = $searchModel->search();

                $response = new ResponseList(
                    ResultHelper::json(
                        $dataProvider->getModels(),
                        []
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

            return $this->asJson(
                ResultHelper::json(
                    $model,
                    []
                )
            );
        } catch (Exception $ex) {
            $this->error($ex);
        }
    }

    public function actionCreate()
    {
        try {
            $post = Yii::$app->request->post(); // { title: 'My List', user_id: 1 }

            $model = new ShoppingList();
            $model->setAttributes($post);

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

    public function actionUpdate($id) // id of the ShoppingList
    {
        try {
            $post = Yii::$app->request->post();

            $model = $this->findModel($id); // { title: 'My List', user_id: 1 }
            $model->setAttributes($post);

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
            $model = $this->findModel($id); // id of the ShoppingList
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
        if (($model = ShoppingList::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
