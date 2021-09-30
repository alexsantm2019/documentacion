<?php

namespace app\controllers;

use Yii;
use app\models\Descargas;
use app\models\DescargasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DescargasController implements the CRUD actions for Descargas model.
 */
class DescargasController extends Controller
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

    /**
     * Lists all Descargas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DescargasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Descargas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Descargas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
    
        public function actionCreate()
    {
        $model = new Descargas();
        
        $id_usuario_logueado = Yii::$app->user->identity['id'];
        $id_documento = Yii::$app->request->get('id_documento');  
        $fecha = date("Y-m-d H:i"); 
        
        $model->id_documento = $id_documento;
        $model->id_usuario = $id_usuario_logueado;
        $model->fecha = $fecha;
        $model->save();

        // ************** FUNCION AUDITORIA **************
        $flag       = "Descarga";
        $accion     = "Downloaded";
        $detalle    = "Descarga de documento";
        $documento  = $id_documento;
        AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************
        
        if($model->save()){
            $download = \app\models\Documento::findOne($id_documento); 
                            $path = Yii::getAlias('@webroot').'/documentos/'.$download->path;
                            if (file_exists($path)) {
                                return Yii::$app->response->sendFile($path);
                            }                        
                //return $this->redirect(['documento/indexusuario']);
                return $this->render(['documento/indexusuario']);
        }
        else{
            print_r("NO SE PUDO DESCARGAR");
            die();
        }
    }


    /**
     * Updates an existing Descargas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Descargas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Descargas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Descargas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Descargas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
