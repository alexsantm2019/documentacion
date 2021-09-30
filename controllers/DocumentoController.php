<?php

namespace app\controllers;

use Yii;
use app\models\Documento;
use app\models\DocumentoSearch;
use app\models\Estado;
use app\controllers\AuditoriaController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\widgets\Alert;
//use kartik\growl\Growl;

/**
 * DocumentoController implements the CRUD actions for Documento model.
 */
class DocumentoController extends Controller
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
     * Lists all Documento models.
     * @return mixed
     */
    public function actionIndex()
    {
        AuditoriaController::checkUserLogued();

        $id_supervisor_aprobacion = Yii::$app->user->identity['id'];
        $searchModel = new DocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);
            $post = [];
            $posted = current($_POST['Documento']);
            $post['Documento'] = $posted;

// Load model like any single model validation
            if ($model->load($post)) {               
                // When doing $result = $model->save(); I get a return value of false
                $model->save();                 
                if(!$model->save()){
                    $errores = $model->getErrors();
                    ?><?=Yii::$app->session->setFlash('error', $errores);?><?php
                }
                else{

                    if (isset($posted['copias'])) {
                        $output = $model->copias;                     
                    }
                    if (isset($posted['detalle_copias'])) {
                        $output = $model->detalle_copias;                    
                    }
                    if (isset($posted['estado'])) {                    
                        $output = $model->estado; 
                        if($output == 2){
                            /**********************CORREO********************************/
                            $nombre_documento = $model->nombre_archivo;
                            $observaciones = $model->observacion;
                            $email = \app\models\Usersoporte::findOne($model->id_usuario);
                            $email_suscriptor = $email['email'];
                            $this->emailobservacionesdocumento($email_suscriptor, $nombre_documento, $observaciones); 
                            /******************************************************/                        
                        }
                        if($output == 3){
                           $id = $model->id;                         
                           \app\models\Documento::updateAll(['fecha_aprobacion' => date("Y-m-d H:i")], 'id = '. "'".$id."'" );
                           \app\models\Documento::updateAll(['id_aprobacion' => $id_supervisor_aprobacion], 'id = '. "'".$id."'" );
                           /**********************CORREO********************************/
                           $nombre_documento = $model->nombre_archivo;                        
                           $email = \app\models\Usersoporte::findOne($model->id_usuario);                        
                           $email_suscriptor = $email['email'];
                           $email_aprob = \app\models\Usersoporte::findOne($model->id_aprobacion);
                           $email_aprobador = $email_aprob['email'];
                           $this->emaildocumentoaprobado($email_suscriptor, $email_aprobador, $nombre_documento); 
                           /******************************************************/     
                                //Una vez aprobado, me dirigo a colocar el Custodio y la Audiencia
                           ?><?=Yii::$app->session->setFlash('warning', 'Su cita ha sido grabada con éxito');  ?><?php
                           return $this->redirect('../aprobacion/index');
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

   public function actionIndexsuscriptor()
   {

        AuditoriaController::checkUserLogued();

    if (!Yii::$app->user->isGuest) {
        $searchModel = new DocumentoSearch();
    //        $searchModel2 = new DocumentoSearch();
        $dataProvider_suscriptor = $searchModel->searchsuscriptor(Yii::$app->request->queryParams);
        $dataProvider_suscriptor2 = $searchModel->searchsuscriptor2(Yii::$app->request->queryParams);

        return $this->render('indexsuscriptor', [
            'searchModel' => $searchModel,
    //            'searchModel' => $searchModel,
            'dataProvider_suscriptor' => $dataProvider_suscriptor,
            'dataProvider_suscriptor2' => $dataProvider_suscriptor2,
        ]);
    }else{
       return $this->goHome();
   }
}

public function actionIndexversionador()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_versionador = $searchModel->searchversionador(Yii::$app->request->queryParams);

    return $this->render('indexversionador', [
        'searchModel' => $searchModel,
        'dataProvider_versionador' => $dataProvider_versionador,
    ]);
}

public function actionIndexusuario()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_usuario = $searchModel->searchusuario(Yii::$app->request->queryParams);
    $dataProvider_usuario2 = $searchModel->searchusuario2(Yii::$app->request->queryParams);

    return $this->render('indexusuario', [
        'searchModel' => $searchModel,
        'dataProvider_usuario' => $dataProvider_usuario,
        'dataProvider_usuario2' => $dataProvider_usuario2,
    ]);
}


public function actionIndexestado()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_estado = $searchModel->searchestado(Yii::$app->request->queryParams);

    if (Yii::$app->request->post('hasEditable')) {
        $_id = $_POST['editableKey'];
        $model = $this->findModel($_id);
        $post = [];
        $posted = current($_POST['Documento']);
        $post['Documento'] = $posted;
// Load model like any single model validation
        if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false
            $model->save();  
            if(!$model->save()){
                $errores = $model->getErrors();
                ?><?=Yii::$app->session->setFlash('error', $errores);?><?php
            }
            else{
               if (isset($posted['copias'])) {
                $output = $model->copias;                     
            }
            if (isset($posted['detalle_copias'])) {
                $output = $model->detalle_copias;                    
            }
            $out = Json::encode(['output' => $output, 'message' => '']);                             
        }
    } 
    return $this->redirect('indexestado');             
}



return $this->render('indexestado', [
    'searchModel' => $searchModel,
    'dataProvider_estado' => $dataProvider_estado,
]);
}

//               public function actionIndexsuperadmin()
//    {
//        $searchModel = new DocumentoSearch();
//        $dataProvider_estado = $searchModel->searchestado(Yii::$app->request->queryParams);
//
//        return $this->render('indexsuperadmin', [
//            'searchModel' => $searchModel,
//            'dataProvider_estado' => $dataProvider_estado,
//        ]);
//    }

public function actionIndexsuperadmin()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_estado = $searchModel->searchestado(Yii::$app->request->queryParams);

    /******************eDITABLE COLUMN**************/
    if(Yii::$app->request->post('hasEditable')){
        $Id = Yii::$app->request->post('editableKey');
        $model1 = $this->findModel($Id);
        $posted = current($_POST['Documento']);
        $model1->estado = $posted['estado'];
        $model1->save(false);
        $output =  $model1->estado;
        $out = Json::encode(['output'=>$output, 'message'=>'']); 
        echo $out;

            // ************** FUNCION AUDITORIA **************
            $estado = "";
            $service = Estado::findOne($model1->estado);
            $estado = $service ? $service->estado : '-';

            $flag       = "Estado";
            $accion     = "Cambio de estado";
            $detalle    = $estado;
            $documento  = $model1->id;

            AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************

        return $this->redirect('indexsuperadmin'); 
    }        
    /**********************************************/        
    return $this->render('indexsuperadmin', [
        'searchModel' => $searchModel,
        'dataProvider_estado' => $dataProvider_estado,
    ]);
}

public function actionIndexconsulta()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_estado = $searchModel->searchestado(Yii::$app->request->queryParams);

    /******************eDITABLE COLUMN**************/
    if(Yii::$app->request->post('hasEditable')){
        $Id = Yii::$app->request->post('editableKey');
        $model1 = $this->findModel($Id);
        $posted = current($_POST['Documento']);
        $model1->estado = $posted['estado'];
        $model1->save(false);
        $output =  $model1->estado;
        $out = Json::encode(['output'=>$output, 'message'=>'']); 
        echo $out;

            // ************** FUNCION AUDITORIA **************
            $estado = "";
            $service = Estado::findOne($model1->estado);
            $estado = $service ? $service->estado : '-';

            $flag       = "Estado";
            $accion     = "Cambio de estado";
            $detalle    = $estado;
            $documento  = $model1->id;

            AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************

        return $this->redirect('indexsuperadmin'); 
    }        
    /**********************************************/        
    return $this->render('indexconsulta', [
        'searchModel' => $searchModel,
        'dataProvider_estado' => $dataProvider_estado,
    ]);
}

public function actionIndexsolicitud()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_solicitud = $searchModel->searchsolicitud(Yii::$app->request->queryParams);

    if (Yii::$app->request->post('hasEditable')) {
        $_id = $_POST['editableKey'];
        $model = $this->findModel($_id);
        $post = [];
        $posted = current($_POST['Documento']);
        $post['Documento'] = $posted;
// Load model like any single model validation
        if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false
            $model->save();               
            if (isset($posted['id_usuario'])) {                    
                $output = $model->id_usuario; 
                /**********************CORREO********************************/
                $nombre_documento = $model->nombre_archivo;
                $id = $model->id;  
                \app\models\Documento::updateAll(['fecha' => date("Y-m-d H:i")], 'id = '. "'".$id."'" );
                \app\models\Documento::updateAll(['estado' => 1], 'id = '. "'".$id."'" );
                $email = \app\models\Usersoporte::findOne($model->id_usuario);
                $email_suscriptor = $email['email'];
                $this->emailnuevasolicitud($email_suscriptor, $nombre_documento); 
                /**********************CORREO********************************/
            }
            $out = Json::encode(['output' => $output, 'message' => '']);
        }
// Return AJAX JSON encoded response and exit
        echo $out;
            //return;
        return $this->redirect('indexsolicitud');  
    }


    return $this->render('indexsolicitud', [
        'searchModel' => $searchModel,
        'dataProvider_solicitud' => $dataProvider_solicitud,
    ]);
}


public function actionIndexpublicador()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_publicador = $searchModel->searchpublicador(Yii::$app->request->queryParams);
    $id_supervisor_aprobacion = Yii::$app->user->identity['id'];
//        $dataProvider_publicador2 = $searchModel->searchpublicador2(Yii::$app->request->queryParams);

    if (Yii::$app->request->post('hasEditable')) {
        $_id = $_POST['editableKey'];
        $model = $this->findModel($_id);
        $post = [];
        $posted = current($_POST['Documento']);
        $post['Documento'] = $posted;
// Load model like any single model validation
        if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false
            $model->save();  
            if(!$model->save()){
                $errores = $model->getErrors();
                ?><?=Yii::$app->session->setFlash('error', $errores);?><?php
            }
            else{
              if (isset($posted['id_custodio'])) {
               $output = $model->id_custodio;     
               /**********************CORREO********************************/
               $custodio = $model->id_custodio;
               $id_aprobador = $model->id_aprobacion;
               $nombre_documento = $model->nombre_archivo;                        
               $email = \app\models\Usersoporte::findOne($custodio);                        
               $email_custodio = $email['email'];
               $nombre_aprob = \app\models\Profilesoporte::find()->where(['user_id'=>$id_aprobador])->one();                        
               $nombre_aprobador = $nombre_aprob['full_name'];
               $this->emailcustodiodocumento($email_custodio, $nombre_documento, $nombre_aprobador);                        
               /************************************************************/                        
           }
           if (isset($posted['estado'])) {                    
            $output = $model->estado; 
            if($output == 2){
                /**********************CORREO********************************/
                $nombre_documento = $model->nombre_archivo;
                $observaciones = $model->observacion;
                $email = \app\models\Usersoporte::findOne($model->id_usuario);
                $email_suscriptor = $email['email'];
                $this->emailobservacionesdocumento($email_suscriptor, $nombre_documento, $observaciones); 
                /******************************************************/                        
            }
            if($output == 5){
               $id = $model->id;                         
               $codigo = $model->codigo; 
               \app\models\Documento::updateAll(['fecha_publicacion' => date("Y-m-d H:i")], 'id = '. "'".$id."'" );
               \app\models\Documento::updateAll(['id_publicador' => $id_supervisor_aprobacion], 'id = '. "'".$id."'" );
               \app\models\Documento::updateAll(['estado' => 6], 'codigo = '. "'".$codigo."'".' and id <>'.$id); 
               /**********************CORREO********************************/
               $nombre_documento = $model->nombre_archivo;                        
               $email = \app\models\Usersoporte::findOne($model->id_usuario);                        
               $email_suscriptor = $email['email'];
               $email_aprob = \app\models\Usersoporte::findOne($model->id_aprobacion);
               $email_aprobador = $email_aprob['email'];
               $this->emaildocumentopublicado($email_suscriptor, $email_aprobador, $nombre_documento); 
               /******************************************************/                        
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
//            'dataProvider_publicador2' => $dataProvider_publicador2,
]);
}



public function actionIndexcalidad()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_calidad = $searchModel->searchcalidad(Yii::$app->request->queryParams);
    $id_supervisor_aprobacion = Yii::$app->user->identity['id'];
//        $dataProvider_publicador2 = $searchModel->searchpublicador2(Yii::$app->request->queryParams);

    if (Yii::$app->request->post('hasEditable')) {
        $_id = $_POST['editableKey'];
        $model = $this->findModel($_id);
        $post = [];
        $posted = current($_POST['Documento']);
        $post['Documento'] = $posted;

// Load model like any single model validation
        if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false
            $model->save();               
            if (isset($posted['estado'])) {                    
                $output = $model->estado; 
                if($output == 2){
                    /**********************CORREO********************************/
                    $nombre_documento = $model->nombre_archivo;
                    $observaciones = $model->obs_calidad;
                    $email = \app\models\Usersoporte::findOne($model->id_usuario);
                    $email_suscriptor = $email['email'];
                    $this->emailobservacionescalidaddocumento($email_suscriptor, $nombre_documento, $observaciones); 
                    /******************************************************/                        
                }                    
                if($output == 4){
                   $id = $model->id;                         
                   \app\models\Documento::updateAll(['fecha_autorizacion' => date("Y-m-d H:i")], 'id = '. "'".$id."'" );
                   \app\models\Documento::updateAll(['id_autorizador' => $id_supervisor_aprobacion], 'id = '. "'".$id."'" );
                   /**********************CORREO********************************/
                   $nombre_documento = $model->nombre_archivo;                        
                   $email = \app\models\Usersoporte::findOne($model->id_usuario);                        
                   $email_suscriptor = $email['email'];
                   $email_aut = \app\models\Usersoporte::findOne($model->id_autorizador);
                   $email_autorizador = $email_aprob['email'];
                   $this->emaildocumentoautorizado($email_suscriptor, $email_autorizador, $nombre_documento); 
                   /******************************************************/                        
               }
           }
           if (isset($posted['obs_calidad'])) {
            $output = $model->obs_calidad;                    
        }
        $out = Json::encode(['output' => $output, 'message' => '']);
    }
// Return AJAX JSON encoded response and exit
    echo $out;
            //return;
    return $this->redirect('indexcalidad');  
}        
return $this->render('indexcalidad', [
    'searchModel' => $searchModel,
    'dataProvider_calidad' => $dataProvider_calidad,
//            'dataProvider_publicador2' => $dataProvider_publicador2,
]);
}


public function actionIndexadmin()
{

        AuditoriaController::checkUserLogued();

    $searchModel = new DocumentoSearch();
    $dataProvider_usuarioadmin = $searchModel->searchusuarioadmin(Yii::$app->request->queryParams);
    $dataProvider_usuario2admin = $searchModel->searchusuario2admin(Yii::$app->request->queryParams);

    return $this->render('indexadmin', [
        'searchModel' => $searchModel,
        'dataProvider_usuarioadmin' => $dataProvider_usuarioadmin,
        'dataProvider_usuario2admin' => $dataProvider_usuario2admin,
    ]);
}

    /**
     * Displays a single Documento model. 
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);

       return $this->renderAjax('view', [
        'model' => $this->findModel($id),
    ]);
   }

    /**
     * Creates a new Documento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


//  public function actionCreate(){
//
//        $model = new Documento();
//        $uploadPath = Yii::getAlias('@webroot') . '/documentos/' ;
//
//        if (isset($_FILES['path'])) {
//            $file = \yii\web\UploadedFile::getInstanceByName('path');
//          $original_name = $file->baseName;  
//          $newFileName = \Yii::$app->security->generateRandomString().'.'.$file->extension;
//           // you can write save code here before uploading.
//            if ($file->saveAs($uploadPath . '/' . $newFileName)) {
//                $model->image = $newFileName;
//                $model->original_name = $original_name;
//                if($model->save(false)){
//                    echo \yii\helpers\Json::encode($file);
////                     return $this->redirect(['view', 'id' => $model->id]);
//                }
//                else{
//                    echo \yii\helpers\Json::encode($model->getErrors());
//                }
//                
//            }
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//        else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//
//        return false;
//    }  


    public function actionCreate()
    {


     AuditoriaController::checkUserLogued();


 $model = new Documento();
        $model->fecha=date("Y-m-d H:i"); 
        $model->estado = 1;
        
        if ($model->load(Yii::$app->request->post())) {
            $nombre = strtoupper($model->nombre_archivo);
            $model->nombre_archivo = $nombre;
            
            //Verifico si el codigo está duplicado o existen otros registros con el mismo codigo
            $nuevo_codigo =  $model->codigo;
            $consulta_codigo = \app\models\Documento::find()->where(['codigo'=>$nuevo_codigo])->count();
            if($consulta_codigo > 0){
               ?><?=Yii::$app->session->setFlash('error', 'Su aprobacion ha sido grabada con éxito');  ?>
<?php
               return $this->redirect(['create']);
           }
           $image = UploadedFile::getInstance($model, 'path');
           if (!is_null($image)) {
               $model->path = $image->name;
               $ext = end((explode(".", $image->name)));
              // generate a unique file name to prevent duplicate filenames
               $model->path = Yii::$app->security->generateRandomString().".{$ext}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
               Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/documentos/';
               $path = Yii::$app->params['uploadPath'] . $model->path;
               $image->saveAs($path);
           }                        
           if ($model->save()) { 





            /**********************FUNCIONALIDAD LETERAGO********************************/
            $id =  $model->id;
            $id_departamento =  $model->id_departamento;
            $id_categoria =  $model->id_categoria;
            $id_tipo =  $model->id_tipo;
            $id_aprobador =  54;
            if(($id_departamento == 8) && ($id_categoria == 32)&& ($id_tipo == 15)){
                \app\models\Documento::updateAll(['id_publicador' => 54], 'id = '. "'".$id."'" );
                \app\models\Documento::updateAll(['id_aprobacion' => 54], 'id = '. "'".$id."'" );
                \app\models\Documento::updateAll(['id_custodio' => 54], 'id = '. "'".$id."'" );
                \app\models\Documento::updateAll(['fecha_aprobacion' => $model->fecha], 'id = '. "'".$id."'" );
                \app\models\Documento::updateAll(['fecha_publicacion' => $model->fecha], 'id = '. "'".$id."'" );
                \app\models\Documento::updateAll(['estado' => 5], 'id = '. "'".$id."'" );

                $id_usuarios_let = \app\models\CertificacionLeterago::find()->asArray()->all();
                $id_usuarios_let_contador = \app\models\CertificacionLeterago::find()->count();
                if($id_usuarios_let_contador > 1){
                    foreach($id_usuarios_let as $u){
                        $connection = Yii::$app->getDb();
                        $command = $connection->createCommand('                                   
                           INSERT INTO aprobacion (id_usuario_autorizado, id_aprobador, id_documento, fecha)
                           values ('.$u['id_usuario'] .', '.$id_aprobador.', '.$id.', "'.$model->fecha.'")
                           ');                   
                                                 $resultado = $command->execute();  //print_r("u: ");print_r($u); echo("<br>");
                                                 /********* Mail*******/ 
                                                 $mails = \app\models\Usersoporte::find()->where(['id'=>$u])->asArray()->all();    
                                                 $lista = array();

                                                 foreach($mails as $m){
                                                        $mail = $m['email'];   //print_r("mail: ");print_r($mail);  
                                                        $list[] = $m['email'] ;                                       

                                                    } 

                                                  //print_r("------------------------mail-----------------: ");print_r($m['email']); echo("<br>");
                                                    /********* Fin Mail*******/                                                                                  
                                                }
                                                $lista = implode(", ",$list);
                                                print_r($lista);
                                                die();
                                            }
                                            else{
                                                print_r("No existen usuarios autorizados para los Certificados Leterago"); die();
                                            }                                            
                                        }
//                                else{
//                                    print_r("El departamento, categoria o tipo no coinciden"); die();
//                                }
                                        /**********************FIN FUNCIONALIDAD LETERAGO********************************/

                // ************** FUNCION AUDITORIA **************
                                        $flag       = "Documento";
                                        $accion     = "Creación";
                                        $detalle    = "Creación de un documento";
                                        $documento  =$model->id;                    
                                        AuditoriaController::audit( $flag, $accion, $detalle, $documento);
                // ************** FIN FUNCION AUDITORIA **************

                                        /**********************CORREO********************************/
                                        $nombre_documento = $model->nombre_archivo;
                                        $email = \app\models\Usersoporte::findOne($model->id_aprobacion);
                                        $email_aprobador = $email['email'];
                                        //$this->emailnuevodocumento($email_aprobador, $nombre_documento); 
                                        /******************************************************/                          
                //return $this->redirect(['view', 'id' => $model->id]);             
                                        ?>
<?=Yii::$app->session->setFlash('success', 'Su aprobacion ha sido grabada con éxito');  ?>
<?php
                                        return $this->redirect(['indexsuscriptor']);
                                    }  else {
//                var_dump ($model->getErrors()); die();
                                    }
                                }
                                return $this->render('create', [
                                  'model' => $model,
                              ]);     
                            }


                            public function actionCreateversion()
                            {
                                $model = new Documento();
                                $model->fecha=date("Y-m-d H:i"); 
                                $model->estado = 1;
//        $original = $model->id_original;
//        print_r($original); die();
                                if ($model->load(Yii::$app->request->post())) {
                                    $nombre = strtoupper($model->nombre_archivo);
                                    $model->nombre_archivo = $nombre;

                                    $image = UploadedFile::getInstance($model, 'path');
                                    if (!is_null($image)) {
                                       $model->path = $image->name;
                                       $ext = end((explode(".", $image->name)));
              // generate a unique file name to prevent duplicate filenames
                                       $model->path = Yii::$app->security->generateRandomString().".{$ext}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
                                       Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/documentos/';
                                       $path = Yii::$app->params['uploadPath'] . $model->path;
                                       $image->saveAs($path);
                                   }                        
                                   if ($model->save()) {                 

                                    /**********************CORREO********************************/
                                    $nombre_documento = $model->nombre_archivo;
                                    $email = \app\models\Usersoporte::findOne($model->id_aprobacion);
                                    $email_aprobador = $email['email'];
                                    $this->emailnuevaversiondocumento($email_aprobador, $nombre_documento); 
                                    /******************************************************/                          
                //return $this->redirect(['view', 'id' => $model->id]);             
                                    ?>
<?=Yii::$app->session->setFlash('success', 'Su aprobacion ha sido grabada con éxito');  ?>
<?php
                                    return $this->redirect(['indexsuscriptor']);
                                }  else {
//                var_dump ($model->getErrors()); die();
                                }
                            }
                            else {
                                return $this->render('createversion', [
                                    'model' => $model,
                                ]);
                            }


    }


                        public function actionHistorial()
                        {
                            return $this->render('historial');

                        }

    /**
     * Updates an existing Documento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdateformulario($id)
    {

        AuditoriaController::checkUserLogued();

      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post())) {
          $newCover = UploadedFile::getInstance($model, 'path');

          if (!empty($newCover)) {
            $newCoverName = Yii::$app->security->generateRandomString();
            unlink($model->cover);
            $model->cover = 'documentos/' . $newCoverName . '.' . $newCover->extension;
            $newCover->saveAs('documentos/' . $newCoverName . '.' . $newCover->extension);
        }

        if ($model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            // error saving model
        }

    } else {
      return $this->renderAjax('updateformulario', [
          'model' => $model,
      ]);
  }

}

public function actionUpdate($id)
{

        AuditoriaController::checkUserLogued();

    $model = $this->findModel($id);        
    $model->fecha=date("Y-m-d H:i"); 
    $model->estado = 1;
    $codigo_original = $model->codigo;        
    $path_original = $model->path;
//        print_r($path_original); echo ("<br>");
//        die(); 
    if ($model->load(Yii::$app->request->post())) {


            // ************** FUNCION AUDITORIA **************
            $flag       = "Documento";
            $accion     = "Edición";
            $detalle    = "Edición de documento";
            $documento  = $model->id;
            AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************

       $image = UploadedFile::getInstance($model, 'path');
       if (!is_null($image)) {
           $model->path = $image->name;
           $ext = end((explode(".", $image->name)));
              // generate a unique file name to prevent duplicate filenames
           $model->path = Yii::$app->security->generateRandomString().".{$ext}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
           Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/documentos/';
           $path = Yii::$app->params['uploadPath'] . $model->path;
           $image->saveAs($path);
       }       

//            $nombre = strtoupper($model->nombre_archivo);
//            $model->nombre_archivo = $nombre;
//
//             $model->path = UploadedFile::getInstance($model, 'path');
//             $ext = substr(strrchr($model->path,'.'),1);
//                if ($ext != null) {
//                        $newfname = $model->path . '.' . $ext;
//                        $model->path->saveAs(Yii::getAlias('@webroot') . '/documentos/' . $model->path = $newfname);                
//                    }                                                
       $path_enviado = $model->path;

       if(($path_original == $path_enviado) || empty($path_enviado))
       {
        $model->path = $path_original; 
    } 
    if ($model->validate()) {                                        
        $model->save();                                                
        if($model->save()){
           ?>
<?=Yii::$app->session->setFlash('success', 'Su cita ha sido grabada con éxito');  ?>
<?php
                                                //return $this->redirect(['view', 'id' => $model->id]);
           return $this->redirect('../indexsuscriptor');
       }
       else{
        print_r("Error al guardar"); die();
    }

}
else{
   print_r("Error de validación"); echo("<br>");
   $errores = $model->getErrors();
   var_dump($model->errors);
                                        //print_r("Problemas al validar el formulario"); 
   die();
}   
}
else {
//            return $this->render('createversion', [
//                'model' => $model,
//            ]);
    return $this->render('create', [
        'model' => $model,
    ]);
}
}

    /**
     * Deletes an existing Documento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {


        $model = \app\models\Documento::findOne($id);    
        $documento = $model['path'];
        if(empty($documento)){
            $this->findModel($id)->delete();
        }
        else{
            // ************** FUNCION AUDITORIA **************
            $flag       = "Documento";
            $accion     = "Eliminación";
            $detalle    = "Eliminación de documento";
            $documento  = $model->id;
            AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************

            unlink(Yii::$app->basePath. '/web/documentos/'.$documento);        
            $this->findModel($id)->delete();
            //Una vez eliminado el documento, elimino las audiencias de la tabla Aprobacion
            \app\models\Aprobacion::deleteAll(['id_documento' => $id]);
        }
        return $this->redirect(['indexsuperadmin']);
    }

    /**
     * Finds the Documento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Documento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


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
         $out = Documento::getAtributo($cat_id);
         echo json_encode(['output' => $out, 'selected' => '']);
         return;
     }
 }
 echo json_encode(['output' => '', 'selected' => '']);
}


/**************************************************** Funciones de Correo************************************/

public function emailnuevodocumento($email, $nombre)
{
    $email_aprobador = $email;
    $nombre_documento = $nombre;
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
    ->setTo([$email_aprobador])            
    ->setSubject("Nuevo Documento creado")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Se ha creado un nuevo documento con los siguientes detalles:'        
       . '<p><strong>Nombre del Documento.</strong>: '.$nombre_documento.'</p>'
       . '<br>'              
       . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/index'])).'</p>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();
    return; 
}



public function emailnuevaversiondocumento($email, $nombre)
{
    $email_aprobador = $email;
    $nombre_documento = $nombre;
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
    ->setTo([$email_aprobador, 'smunoz@qariston.com'])            
    ->setSubject("Nueva versión de Documento creado")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Se ha creado una nueva versión de un documento con los siguientes detalles:'        
       . '<p><strong>Nombre del Documento.</strong>: '.$nombre_documento.'</p>'
       . '<br>'              
       . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/index'])).'</p>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();
    return; 
}


//    $this->emailobservacionesdocumento($email_suscriptor, $nombre_documento, $nombre_documento); 
public function emailobservacionesdocumento($email, $nombre, $obs)
{
    $email_aprobador = $email;
    $nombre_documento = $nombre;
    $observaciones = $obs;
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
    ->setTo([$email_aprobador])            
    ->setSubject("Nueva observacion realizada")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Se ha añadido una observacion por parte de la persona que Aprueba con los siguientes detalles:'        
       . '<p><strong>Nombre del Documento.</strong>: '.$nombre_documento.'</p>'
       . '<p><strong>Observacion.</strong>: '.$observaciones.'</p>'
       . '<br>'              
       . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/indexsuscriptor'])).'</p>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();
    return; 
}

public function emailnuevasolicitud($email, $nombre)
{
    $email_aprobador = $email;
    $nombre_documento = $nombre;            
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
    ->setTo([$email_aprobador, 'gllerena@qariston.com', 'arenteria@qariston.com','smunoz@qariston.com'])            
    ->setSubject("Cambio de Propietario de Documento")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Usted ha sido designado como nuevo propietario del documento '.$nombre_documento.'</strong> con las siguientes caracteristicas:'        
       . '<br>'              
       . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/indexsuscriptor'])).'</p>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();
    return; 
}



public function emailobservacionescalidaddocumento($email, $nombre, $obs)
{
    $email_aprobador = $email;
    $nombre_documento = $nombre;
    $observaciones = $obs;
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
    ->setTo([$email_aprobador])            
    ->setSubject("Nueva observacion de Calidad realizada")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Se ha añadido una observacion por parte de la persona que Aprueba con los siguientes detalles:'        
       . '<p><strong>Nombre del Documento.</strong>: '.$nombre_documento.'</p>'
       . '<p><strong>Observacion.</strong>: '.$observaciones.'</p>'
       . '<br>'              
       . ' <p>Ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/indexsuscriptor'])).'</p>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();
    return; 
}


//    $this->emaildocumentoaprobado($email_suscriptor, $email_aprobador, $nombre_documento); 

public function emaildocumentoaprobado($email_s, $email_a, $nombre)
{
    $email_aprobador = trim($email_a);
    $email_suscriptor = trim($email_s);
    $nombre_documento = $nombre;   

    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
                 //->setTo([$email_suscriptor, 'smunoz@qariston.com', 'gllerena@qariston.com','arenteria@qariston.com' ])            
    ->setTo([$email_suscriptor, 'smunoz@qariston.com'])            
    ->setSubject("Nuevo Documento Aprobado")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>El documento <strong>'.$nombre_documento.'</strong> ha sido aprobado:'                                  
       . '<br>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();

    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
                // ->setTo([$email_aprobador, 'smunoz@qariston.com', 'arenteria@qariston.com'])            
    ->setTo([$email_aprobador])            
    ->setSubject("Nuevo Documento Aprobado")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Has aprobado el documento:  <strong>'.$nombre_documento.'</strong>'                                  
       . '<br>'              
       . ' <p><strong>ATENCION:</strong> Debe añadir un CUSTORIO y la AUDIENCIA a quien va dirigido el documento haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['aprobacion/index'])).'</p>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();

    return; 
}





public function emaildocumentoautorizado($email_s, $email_a, $nombre)
{
    $email_aprobador = trim($email_a);
    $email_suscriptor = trim($email_s);
    $nombre_documento = $nombre;                   
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
                // ->setTo([$email_aprobador, 'smunoz@qariston.com', 'gllerena@qariston.com'])            
    ->setTo([$email_aprobador, 'smunoz@qariston.com'])            
    ->setSubject("Nuevo Documento Aprobado")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Has aprobado el documento '.$nombre_documento.' :'                                  
       . '<br>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();                
    return; 
}


public function emaildocumentopublicado($email_s, $email_a, $nombre)
{
    $email_autorizador = trim($email_a);
    $email_suscriptor = trim($email_s);
    $nombre_documento = $nombre;                   
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
                // ->setTo([$email_aprobador, 'smunoz@qariston.com', 'gllerena@qariston.com'])            
    ->setTo([$email_autorizador, 'smunoz@qariston.com'])            
    ->setSubject("Nuevo Documento Publicado")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>El documento: <strong>'.$nombre_documento.'</strong> ha sido publicado'                                  
       . '<br>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();                
    return; 
}



public function emailcustodiodocumento($email, $nombre, $nombre_aprob)
{
    $email_custodio = $email;
    $nombre_documento = $nombre;
    $nombre_aprobador = $nombre_aprob;            
    Yii::$app->mailer->compose()         
    ->setFrom('soporte@qariston.com')
    ->setTo([$email_custodio])            
    ->setSubject("Nuevo Custodio de Documento")
    ->setHtmlBody(''
       . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
       . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
       . '<p>Hola,</p>'
       . '<p>Usted ha sido designado como <strong> CUSTODIO </strong> del documento <strong> '.$nombre_documento.' </strong>'        
       . '<p>Por favor, coordine con <strong> '.$nombre_aprobador.' </strong> para la entrega física del Documento</p>'
       . '<br>'              
       . '<p>Atentamente<p>'
       . '<p>Soporte Química Ariston</p>'
       . '</body>'
   )   
    ->send();
    return; 
}


/**************************************************** Funciones de Correo************************************/





}