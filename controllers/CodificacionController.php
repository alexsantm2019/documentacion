<?php

namespace app\controllers;

use Yii;
use app\models\Codificacion;
use app\models\CodificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * CodificacionController implements the CRUD actions for Codificacion model.
 */
class CodificacionController extends Controller
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
     * Lists all Codificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CodificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Codificacion model.
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
     * Creates a new Codificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Codificacion();
        
       

        if ($model->load(Yii::$app->request->post()) ) {
            
        $cod_departamento = $model->codigo_departamento;
        $cod_categoria = $model->codigo_categoria;
        $codigo_tipo = $model->codigo_tipo;
        
        $cod_dep = \app\models\Departamento::findOne($cod_departamento);
        $cod_cat = \app\models\Categoria::findOne($cod_categoria);
        
        $codigo_departamento = $cod_dep['codigo'];
        $codigo_categoria = $cod_cat['codigo'];
        
        $codigo = $codigo_departamento.'-'.$codigo_categoria.'-'.$codigo_tipo;
                
        $model->codigo = $codigo;        

        $model->save();   
                        
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Codificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($model->load(Yii::$app->request->post()) ) {
            
        $cod_departamento = $model->codigo_departamento;
        $cod_categoria = $model->codigo_categoria;
        $codigo_tipo = $model->codigo_tipo;
        
        $cod_dep = \app\models\Departamento::findOne($cod_departamento);
        $cod_cat = \app\models\Categoria::findOne($cod_categoria);
        
        $codigo_departamento = $cod_dep['codigo'];
        $codigo_categoria = $cod_cat['codigo'];
        
        $codigo = $codigo_departamento.'-'.$codigo_categoria.'-'.$codigo_tipo;
                
        $model->codigo = $codigo;        

        $model->save();     
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Codificacion model.
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
     * Finds the Codificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Codificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Codificacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
           public function actionAyuda()
    {
        $searchModel = new CodificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('ayuda', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*********************************************************************************************************/
    
     public function actionLists($id)
      {
         //echo "<pre>";print_r($id);die;
         $countPosts = \app\models\Categoria::find()
         ->where(['departamento_id' => $id])
         ->count();

         $posts = \app\models\Categoria::find()
         ->where(['departamento_id' => $id])
         ->orderBy('id ASC')
         ->all();

         if($countPosts>0){
         foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->categoria."</option>";
         }
         }
         else{
                echo "<option>-</option>";
         }

 }
 

    public function actionSubcat() {
           $out = [];
           if (isset($_POST['depdrop_parents'])) {
               $parents = $_POST['depdrop_parents'];
               if ($parents != null) {
                   $cat_id = $parents[0];
                   $out = Codificacion::getAtributo($cat_id);
                   echo json_encode(['output' => $out, 'selected' => '']);
                   return;
               }
           }
           echo json_encode(['output' => '', 'selected' => '']);
       }

}
