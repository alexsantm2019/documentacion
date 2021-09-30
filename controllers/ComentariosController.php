<?php

namespace app\controllers;

use Yii;
use app\models\Comentarios;
use app\models\ComentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComentariosController implements the CRUD actions for Comentarios model.
 */
class ComentariosController extends Controller
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
     * Lists all Comentarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComentariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comentarios model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    
    
      public function actionComentarios()
    {
        return $this->renderAjax('comentarios');
    }
    

    /**
     * Creates a new Comentarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comentarios();
        $model->fecha = date("Y-m-d H:i"); 
        $flag = Yii::$app->request->get('flag'); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // ************** FUNCION AUDITORIA **************
            $flag       = "Comentario";
            $accion     = "Nuevo";
            $detalle    = "Comentario de documento";
            $documento  = Yii::$app->request->get('id_documento');
            AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************
            
            //return $this->redirect(['view', 'id' => $model->id]);
            if($flag == 'SUSCRIPTOR'){
                return $this->redirect('../documento/indexsuscriptor');
            }
            else if($flag == 'CORRECTOR'){
                return $this->redirect('../documento/index');
            }
            else if($flag == 'PUBLICADOR'){
                return $this->redirect('../documento/indexpublicador');
            }
            else{
                return $this->goBack(Yii::$app->request->referrer);
            }
        } else {
//            print_r(" NO envie comentario");die();
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comentarios model.
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
     * Deletes an existing Comentarios model.
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
     * Finds the Comentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
