<?php

namespace app\controllers;

use Yii;
use app\models\Aprobacion;
use app\models\AprobacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * AprobacionController implements the CRUD actions for Aprobacion model.
 */
class AprobacionController extends Controller
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
     * Lists all Aprobacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AprobacionSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModel = new AprobacionSearch();
        $dataProvider_suscriptor = $searchModel->searchsuscriptor(Yii::$app->request->queryParams);
        /**************************************************************************/
                if (Yii::$app->request->post('hasEditable')) {
                    $HID = Yii::$app->request->post('editableKey');
                    $model = \app\models\Documento::findOne($HID);
                    $out = Json::encode(['output' => '', 'message' => '']);
                    $post = [];
                    $posted = current($_POST['Documento']);
                    $post['Documento'] = $posted;
                    if ($model->load($post)) {
                        $model->save();
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
                        $out = Json::encode(['output' => $output, 'message' => '']);                
                    }
                    echo $out;
                    return $this->redirect('index');            
                }
        /**************************************************************************/
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
            'dataProvider_suscriptor' => $dataProvider_suscriptor,
        ]);
    }
    
    
    public function actionIndexpublicador()
    {
        $searchModel = new AprobacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchModel = new AprobacionSearch();
        $dataProvider_publicador = $searchModel->searchpublicador(Yii::$app->request->queryParams);
        /**************************************************************************/
                if (Yii::$app->request->post('hasEditable')) {
                    $HID = Yii::$app->request->post('editableKey');
                    $model = \app\models\Documento::findOne($HID);
                    $out = Json::encode(['output' => '', 'message' => '']);
                    $post = [];
                    $posted = current($_POST['Documento']);
                    $post['Documento'] = $posted;
                    if ($model->load($post)) {
                        $model->save();
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
                        $out = Json::encode(['output' => $output, 'message' => '']);                
                    }
                    echo $out;
                    return $this->redirect('indexpublicador');            
                }
        /**************************************************************************/
        return $this->render('indexpublicador', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
            'dataProvider_publicador' => $dataProvider_publicador,
        ]);
    }

    /**
     * Displays a single Aprobacion model.
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
     * Creates a new Aprobacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Aprobacion();
        $model->fecha = date("Y-m-d H:i"); 

//        Traigo los datos uno por uno
        $model->attributes = \Yii::$app->request->post('Aprobacion');        
        $model->id_aprobador= $model->attributes['id_aprobador'];
        $model->id_documento = $model->attributes['id_documento'];   
        $aprobaciones = $model->attributes['id_usuario_autorizado'];
        
        $nombre_doc = \app\models\Documento::findOne($model->id_documento);  
        $nombre_documento = $nombre_doc['nombre_archivo'];
        
        $contador = count($aprobaciones);
                            if(!empty($aprobaciones)){                               
                                 for($i=0; $i<$contador; $i++){
                                     $connection = Yii::$app->getDb();
                                     $command = $connection->createCommand('                                   
                                     INSERT INTO aprobacion (id_usuario_autorizado, id_aprobador, id_documento, fecha)
                                     values ("'.$aprobaciones[$i].'", '.$model->id_aprobador.', '.$model->id_documento.', "'.$model->fecha.'")
                                     ');                   
                                     $resultado = $command->execute(); 
                                 }
                            /**************************************CORREO MASIVO******************************************/
                                        foreach($aprobaciones as $a){
                                            $mails = \app\models\Usersoporte::find()->where(['id'=>$a])->asArray()->all();
                                             foreach($mails as $m){
                                                 $mail = $m['email'];
                                                     Yii::$app->mailer->compose()         
                                                     ->setFrom('soporte@qariston.com')
                                                     ->setTo([$mail])            
                                                     ->setSubject("Nuevo Documento creado")
                                                     ->setHtmlBody(''
                                                             . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
                                                              . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
                                                              . '<p>Hola,</p>'
                                                              . '<p>Se ha aprobado el documento <strong> '.$nombre_documento.' </strong>al que Usted tiene acceso </strong>'        
                                                              . '<p>El documento debe ser Publicado para su visualización y descarga</p>'
                                                              . '<p>Para descargarlo, ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/index'])).'</p>'              
                                                              . '<br>'              
                                                              . '<p>Atentamente<p>'
                                                              . '<p>Soporte Química Ariston</p>'
                                                              . '</body>'
                                                              )   
                                                     ->send();                                     
                                             }                                            
                                        }
                        /**********************CORREO PUBLICADOR********************************/                        
                        $id_doc = $model->id_documento;
                        $doc = \app\models\Documento::findOne($id_doc);                        
                        $nombre_documento = $doc ['nombre_archivo'] ;
                        $codigo = $doc ['codigo'] ;
                        $this->emailpublicaciondocumento($nombre_documento, $codigo);                        
                        /************************************************************/                        
                                        
                            /***********************************************************************************/ 
                                ?>
                                    <?=Yii::$app->session->setFlash('success', 'Su aprobacion ha sido grabada con éxito');  ?>  
                                <?php
                                 return $this->redirect('index');
                            }
                            else{
                                return $this->renderAjax('create', [
                                    'model' => $model,
                                ]);
                            } 
    }
    
       public function actionCreatenuevo()
    {
        $model = new Aprobacion();
        $model->fecha = date("Y-m-d H:i"); 

//        Traigo los datos uno por uno
        $model->attributes = \Yii::$app->request->post('Aprobacion');        
        $model->id_aprobador= $model->attributes['id_aprobador'];
        $model->id_documento = $model->attributes['id_documento'];   
        $aprobaciones = $model->attributes['id_usuario_autorizado'];
        
        $contador = count($aprobaciones);
//        print_r($contador); die();
                            if(!empty($aprobaciones)){                               
                                 for($i=0; $i<$contador; $i++){
                                     $connection = Yii::$app->getDb();
                                     $command = $connection->createCommand('                                   
                                     INSERT INTO aprobacion (id_usuario_autorizado, id_aprobador, id_documento, fecha)
                                     values ("'.$aprobaciones[$i].'", '.$model->id_aprobador.', '.$model->id_documento.', "'.$model->fecha.'")
                                     ');                   
                                     $resultado = $command->execute(); 
                                 }
                                                             /**************************************CORREO MASIVO******************************************/
                                        foreach($aprobaciones as $a){
                                            $mails = \app\models\Usersoporte::find()->where(['id'=>$a])->asArray()->all();
                                             foreach($mails as $m){
                                                 $mail = $m['email'];
                                                     Yii::$app->mailer->compose()         
                                                     ->setFrom('soporte@qariston.com')
                                                     ->setTo([$mail])            
                                                     ->setSubject("Nuevo Documento creado")
                                                     ->setHtmlBody(''
                                                             . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
                                                              . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
                                                              . '<p>Hola,</p>'
                                                              . '<p>Se ha subido el documento <strong> '.$nombre_documento.' </strong>al que Usted tiene acceso </strong> '        
                                                              . ' <p>Para descargarlo, ingrese al Sistema de Documentacion haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/index'])).'</p>'              
                                                              . '<br>'              
                                                              . '<p>Atentamente<p>'
                                                              . '<p>Soporte Química Ariston</p>'
                                                              . '</body>'
                                                              )   
                                                     ->send();                                     
                                             }                                            
                                        }
                        /**********************CORREO PUBLICADOR********************************/                        
                        $id_doc = $model->id_documento;
                        $doc = \app\models\Documento::findOne($id_doc);                        
                        $nombre_documento = $doc ['nombre_archivo'] ;
                        $codigo = $doc ['codigo'] ;
                        $this->emailpublicaciondocumento($nombre_documento, $codigo);                        
                        /************************************************************/                        
            
                            /***********************************************************************************/ 
                                 
                                 return $this->redirect('index');
                            }
                            else{
                                return $this->render('createnuevo', [
                                    'model' => $model,
                                ]);
                            } 
    }
    
    
//     public function actionCreate()
//    {
//        $model = new Aprobacion();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->renderAjax('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Aprobacion model.
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
     * Deletes an existing Aprobacion model.
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
     * Finds the Aprobacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Aprobacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Aprobacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**************************************************** Funciones de Correo************************************/

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
    
         public function emailpublicaciondocumento($nombre, $cod)
    {
            $nombre_documento = $nombre;
            $codigo = $cod;
                Yii::$app->mailer->compose()         
                 ->setFrom('soporte@qariston.com')
                 //->setTo(['gllerena@qariston.com', 'arenteria@qariston.com', 'smunoz@qariston.com'])            
                 ->setTo(['smunoz@qariston.com'])            
                 ->setSubject("Nuevo Documento aprobado y listo para Publicar")
                 ->setHtmlBody(''
                         . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
                          . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
                          . '<p>Hola,</p>'
                          . '<p>El siguiente documento ha sido aprobado:'        
                          . '<p><strong>Nombre del Documento.</strong>: '.$nombre_documento.'</p>'
                          . '<p><strong>Código.</strong>: '.$codigo.'</p>'
                          . '<br>'              
                          . ' <p>Ingrese al Sistema de Documentacion para publicarlo haciendo click'. Html::a(' Aquí', Yii::$app->urlManager->createAbsoluteUrl(['documento/indexpublicador'])).'</p>'              
                          . '<p>Atentamente<p>'
                          . '<p>Soporte Química Ariston</p>'
                          . '</body>'
                          )   
                 ->send();
            return; 
    }
    
    /**************************************************** Funciones de Correo************************************/
}
