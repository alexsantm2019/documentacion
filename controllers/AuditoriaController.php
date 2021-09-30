<?php

namespace app\controllers;

use Yii;
use app\models\Auditoria;
use app\models\AuditoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\filters\VerbFilter;

class AuditoriaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public static function audit($flag, $accion, $detalle, $documento)
    {
        $id_usuario_logueado = Yii::$app->user->identity['id'];
        $model = new Auditoria();
        $model->audUsuarioLogueado = $id_usuario_logueado; 
        $model->audFlag= $flag;
        $model->audAccion = $accion; 
        $model->audDetalle= $detalle; 
        $model->audDocumentoId= $documento; 
        $model->audFecha = date("Y-m-d H:i"); 
        $model->audIp = Yii::$app->request->userIP;
        $model->save();

        if ($model->save()) {
            $out = Json::encode(['output' => $model, 'message' => 'OK']); 
            return "OK";
        } else {
            $out = Json::encode(['output' => $model, 'message' => 'No paso nada']); 
            return "Error";
        }
    }

   public static function checkUserLogued(){
        if (Yii::$app->user->isGuest) {
            return  Yii::$app->controller->redirect(['user/login']);
        }
    }

    /**
     * Lists all Aprobadores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuditoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



}
