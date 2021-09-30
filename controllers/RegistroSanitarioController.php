<?php

namespace app\controllers;

use Yii;
use app\models\RegistroSanitario;
use app\models\RegistroSanitarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * RegistroSanitarioController implements the CRUD actions for RegistroSanitario model.
 */
class RegistroSanitarioController extends Controller
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
     * Lists all RegistroSanitario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistroSanitarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
             if (Yii::$app->request->post('hasEditable')) {
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);
            $post = [];
            $posted = current($_POST['RegistroSanitario']);
            $post['RegistroSanitario'] = $posted;

// Load model like any single model validation
            if ($model->load($post)) {               
                // When doing $result = $model->save(); I get a return value of false
                $model->save();                 
                if(!$model->save()){
                    $errores = $model->getErrors();
                     ?><?=Yii::$app->session->setFlash('error', $errores);?><?php
                }
                else{
                        if (isset($posted['estado'])) {                    
                            $output = $model->estado; 
                            if($output == 5){
                        /**********************CORREO********************************/
//                                $nombre_documento = $model->nombre_archivo;
//                                $observaciones = $model->observacion;
//                                $email = \app\models\Usersoporte::findOne($model->id_usuario);
//                                $email_suscriptor = $email['email'];
//                                $this->emailobservacionesdocumento($email_suscriptor, $nombre_documento, $observaciones); 
                        /******************************************************/                        
                            }
                        }  
                            $out = Json::encode(['output' => $output, 'message' => '']);               
                }      
            }
// Return AJAX JSON encoded response and exit

            return $this->redirect('index');  
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
     public function actionIndexpublicador()
    {
        $searchModel = new RegistroSanitarioSearch();
        $dataProvider_publicador = $searchModel->searchpublicador(Yii::$app->request->queryParams);
                
//        if (Yii::$app->request->post('hasEditable')) {
//            $_id = $_POST['editableKey'];
//            $model = $this->findModel($_id);
//            $post = [];
//            $posted = current($_POST['RegistroSanitario']);
//            $post['RegistroSanitario'] = $posted;
//
//// Load model like any single model validation
//            if ($model->load($post)) {               
//                // When doing $result = $model->save(); I get a return value of false
//                $model->save();                 
//                if(!$model->save()){
//                    $errores = $model->getErrors();

//                }
//                else{
//                        if (isset($posted['estado'])) {                    
//                            $output = $model->estado; 
//                            if($output == 5){
//                        /**********************CORREO********************************/
//                             $id = $model->id;     
//                            \app\models\RegistroSanitario::updateAll(['fecha_publicacion' => date("Y-m-d H:i")], 'id = '. "'".$id."'" );
////                                $nombre_documento = $model->nombre_archivo;
////                                $observaciones = $model->observacion;
////                                $email = \app\models\Usersoporte::findOne($model->id_usuario);
////                                $email_suscriptor = $email['email'];
////                                $this->emailobservacionesdocumento($email_suscriptor, $nombre_documento, $observaciones); 
//                        /******************************************************/                        
//                            }
//                        }  
//                            $out = Json::encode(['output' => $output, 'message' => '']);               
//                }      
//            }
//// Return AJAX JSON encoded response and exit
//
//            return $this->redirect('indexpublicador');  
//        }
        if (Yii::$app->request->post('hasEditable')) {
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);
            $post = [];
            $posted = current($_POST['RegistroSanitario']);
            $post['RegistroSanitario'] = $posted;
// Load model like any single model validation
            if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false
                $model->save();  
                if(!$model->save()){
                    $errores = $model->getErrors();
                     ?><?=Yii::$app->session->setFlash('error', $errores);?><?php
                }
                else{
                if (isset($posted['estado'])) {                    
                    $output = $model->estado; 

                    if($output == 5){
                         $id = $model->id;                         
//                        /**********************CORREO********************************/
                             $id = $model->id;     
                            \app\models\RegistroSanitario::updateAll(['fecha_publicacion' => date("Y-m-d H:i")], 'id = '. "'".$id."'" );
////                                $nombre_documento = $model->nombre_archivo;
////                                $observaciones = $model->observacion;
////                                $email = \app\models\Usersoporte::findOne($model->id_usuario);
////                                $email_suscriptor = $email['email'];
////                                $this->emailobservacionesdocumento($email_suscriptor, $nombre_documento, $observaciones); 
//                        /******************************************************/                        
                    }                    
                }
                 if (isset($posted['copias'])) {
                    $output = $model->copias;                     
                }
                if (isset($posted['detalle_copias'])) {
                    $output = $model->detalle_copias;                    
                }
                $out = Json::encode(['output' => $output, 'message' => '']);                             
// Return AJAX JSON encoded response and exit
            //echo $out;
            //return;
             }
          } 
            return $this->redirect('indexpublicador');  
           
        }
        

        return $this->render('indexpublicador', [
            'searchModel' => $searchModel,
            'dataProvider_publicador' => $dataProvider_publicador,
        ]);
    }

    /**
     * Displays a single RegistroSanitario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RegistroSanitario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistroSanitario();
        $model->fecha_modificacion=date("Y-m-d H:i"); 
        $model->status= "ACTIVO"; 
        $model->estado= 3; 

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
        
        /*************************************************/
         if ($model->load(Yii::$app->request->post())) {
            $nombre = strtoupper($model->producto);
            $model->producto = $nombre;
    
          $image = UploadedFile::getInstance($model, 'path');
           if (!is_null($image)) {
             $model->path = $image->name;
             $ext = end((explode(".", $image->name)));
              $model->path = Yii::$app->security->generateRandomString().".{$ext}";
              Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/registros_sanitarios/';
              $path = Yii::$app->params['uploadPath'] . $model->path;
               $image->saveAs($path);
            }                        
            if ($model->save()) {                 
             
                /**********************CORREO********************************/
//                        $nombre_documento = $model->nombre_archivo;
//                        $email = \app\models\Usersoporte::findOne($model->id_aprobacion);
//                        $email_aprobador = $email['email'];
//                        
//                        $this-> $this->emailnuevoregistrosanitario(); 
                /******************************************************/                              
                ?>
                <?=Yii::$app->session->setFlash('success', 'Su aprobacion ha sido grabada con éxito');  ?>  
                <?php
                return $this->redirect(['index']);
            }  
              }
              return $this->render('create', [
                  'model' => $model,
              ]);
        /*************************************************/
    }
    
        public function actionCreatecambio()
    {
        $model = new RegistroSanitario();
        $model->fecha_modificacion=date("Y-m-d H:i"); 
        $model->status= "ACTIVO"; 
        $model->estado= 3; 
        if ($model->load(Yii::$app->request->post())) {
                    $nombre = strtoupper($model->producto);
                    $model->producto = $nombre;
                    $codigo = $model->codigo;
                    $fecha_modificacion = $model->fecha_modificacion;
                    
                    //ACTUALIZO ESTADO DE DEMAS ARCHIVOS:
                    RegistroSanitario::updateAll(['status' => 'INACTIVO'], 'fecha_modificacion <> '. "'".$fecha_modificacion."'".' and '. 'codigo = '. "'".$codigo."'" );
                    
                     $image = UploadedFile::getInstance($model, 'path');
                   if (!is_null($image)) {
                        $model->path = $image->name;
                        $ext = end((explode(".", $image->name)));
                         $model->path = Yii::$app->security->generateRandomString().".{$ext}";
                         Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/registros_sanitarios/';
                         $path = Yii::$app->params['uploadPath'] . $model->path;
                          $image->saveAs($path);
                    }                        
                    if ($model->save()) {                 

                        /**********************CORREO********************************/
        //                        $nombre_documento = $model->nombre_archivo;
        //                        $email = \app\models\Usersoporte::findOne($model->id_aprobacion);
        //                        $email_aprobador = $email['email'];
        //                        
        //                        
        //                        $this->emailnuevamodificacionregistro($email_aprobador, $nombre_documento); 
                        /******************************************************/                              
                        ?>
                        <?=Yii::$app->session->setFlash('success', 'Su aprobacion ha sido grabada con éxito');  ?>  
                        <?php
                        return $this->redirect(['index']);
                    }  
        }
        else {
            return $this->render('createcambio', [
                'model' => $model,
            ]);
        }
    }
    
    
    
    

    /**
     * Updates an existing RegistroSanitario model.
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
     * Deletes an existing RegistroSanitario model.
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
     * Finds the RegistroSanitario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistroSanitario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistroSanitario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    /********************************************************/
    
    public function actionHistorial()
    {
            return $this->render('historial');

    }
    
    
    public function emailnuevoregistrosanitario()
    {
            $email_aprobador = $email;
            $nombre_documento = $nombre;
                Yii::$app->mailer->compose()         
                 ->setFrom('soporte@qariston.com')
                 ->setTo(['arenteria@qariston.com', 'gllerena@qariston.com'])            
                 ->setSubject("Nuevo Registro Sanitario creado")
                 ->setHtmlBody(''
                         . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
                          . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
                          . '<p>Hola,</p>'
                          . '<p>Se ha creado un nuevo Registro Sanitario'        
                          . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['registro-sanitario/index'])).'</p>'              
                          . '<p>Atentamente<p>'
                          . '<p>Soporte Química Ariston</p>'
                          . '</body>'
                          )   
                 ->send();
            return; 
    }
    
     public function emailnuevamodificacionregistro()
    {
            $email_aprobador = $email;
            $nombre_documento = $nombre;
                Yii::$app->mailer->compose()         
                 ->setFrom('soporte@qariston.com')
                 ->setTo(['arenteria@qariston.com', 'gllerena@qariston.com'])            
                 ->setSubject("Nueva modificación en Registro Sanitario")
                 ->setHtmlBody(''
                         . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
                          . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
                          . '<p>Hola,</p>'
                          . '<p>Se ha agregado una nueva modificación a un Registro Sanitario'        
                          . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['registro-sanitario/index'])).'</p>'              
                          . '<p>Atentamente<p>'
                          . '<p>Soporte Química Ariston</p>'
                          . '</body>'
                          )   
                 ->send();
            return; 
    }
}
