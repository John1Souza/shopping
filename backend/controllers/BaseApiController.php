<?php

namespace app\controllers;

use app\models\responses\ResponseError;
use app\widgets\Auxiliares;
use app\widgets\Criptografia;
use Yii;
use yii\web\Controller;

use app\models\Dispositivo;
use app\models\Usuario;
use app\config\constants\SituacaoUsuario;
use app\config\constants\Constants;
use Exception;

class BaseApiController extends Controller
{
    // public $unauthenticatedUrls = [
    //     'usuario/create',

    // ];

    // public function beforeAction($action)
    // {
    //     $this->enableCsrfValidation = false;

    //     $origin = Yii::$app->request->headers->get('Origin');
    //     $allowedOrigins = [
    //         'http://localhost:3000',
    //         'https://dev.psycs.com.br',
    //         'https://hom.psycs.com.br',
    //         'https://psycs.com.br',
    //         'https://www.psycs.com.br',
    //     ];

    //     if (in_array($origin, $allowedOrigins)) {
    //         header("Access-Control-Allow-Origin: $origin");
    //         header("Access-Control-Allow-Credentials: true");
    //         header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    //         header("Access-Control-Allow-Headers: Authorization, Content-Type, Cache-Control, Pragma, Referer, AccessToken, ClientIp");
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    //         Yii::$app->end();
    //     }

    //     if (!parent::beforeAction($action)) {
    //         return false;
    //     }

    //     if (!in_array(Yii::$app->request->pathInfo, $this->unauthenticatedUrls)) {
    //         $authorization = Auxiliares::getAuthorization();
    //         Criptografia::checkToken($authorization);
    //         $dispositivo = Dispositivo::findOne(['ds_token_authorization' => Auxiliares::getAuthorization()]);

    //         $situacao = Usuario::find()->checarSituacao();

    //         if ($situacao->co_classificar !== SituacaoUsuario::ATIVO) {
    //             Yii::$app->response->statusCode = 401;
    //             $this->error(new Exception(Yii::t('error', 'Usuário excluído!')));
    //             return false;
    //         }

    //         if (!empty($dispositivo)) {
    //             if ($dispositivo->in_login_ativo == Constants::TRUE) {
    //                 $dispositivo->dt_ultima_atividade = date('Y-m-d H:i:s');
    //                 $dispositivo->save();
    //             } else {
    //                 Yii::$app->response->statusCode = 401;
    //                 $this->error(new Exception(Yii::t('error', 'Dispositivo deslogado!')));
    //                 return false;
    //             }
    //         }
    //     }

    //     return true;
    // }

    public function error($ex)
    {
        $message = $ex->getMessage();
        if (Yii::$app->response->statusCode === 200) {
            $code = str_contains($message, 'Por favor, corrija os seguintes erros') ? 400 : 500;
            Yii::$app->response->statusCode = $code;
        }
        $this->asJson(new ResponseError(
            $message
        ), Yii::$app->response->statusCode);
    }
}
