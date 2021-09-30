<?php

namespace app\controllers;

use Yii;
use app\models\CertificacionLeterago;
use app\models\CertificacionLeteragoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CertificacionLeteragoController implements the CRUD actions for CertificacionLeterago model.
 */
class CertificacionLeteragoController extends Controller
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
     * Lists all CertificacionLeterago models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CertificacionLeteragoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CertificacionLeterago model.
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
     * Creates a new CertificacionLeterago model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
        public function actionCreate()
    {
        $model = new CertificacionLeterago();
        $model->attributes = \Yii::$app->request->post('CertificacionLeterago');        
        $aprobaciones = $model->attributes['id_usuario'];
        
        $contador = count($aprobaciones);
                            if(!empty($aprobaciones)){                               
                                 for($i=0; $i<$contador; $i++){
                                     $connection = Yii::$app->getDb();
                                     $command = $connection->createCommand('                                   
                                     INSERT INTO certificacion_leterago (id_usuario)
                                     values ("'.$aprobaciones[$i].'")
                                     ');                   
                                     $resultado = $command->execute(); 
                                 }                                                                                        
                                ?>
                                    <?=Yii::$app->session->setFlash('success', 'Su aprobacion ha sido grabada con éxito');  ?>  
                                <?php
                                 return $this->redirect('index');
                            }
                            else{
                                return $this->render('create', [
                                    'model' => $model,
                                ]);
                            } 
    }

    /**
     * Updates an existing CertificacionLeterago model.
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
     * Deletes an existing CertificacionLeterago model.
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
     * Finds the CertificacionLeterago model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CertificacionLeterago the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CertificacionLeterago::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
