<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\widgets\Pjax;

                                       /*****************
                                        * FUNCIONALIDAD DE COMENTARIO
                                        *****************/
  $id_documento = Yii::$app->request->get('id_documento');  
  $nombre_archivo = Yii::$app->request->get('nombre_archivo'); 
//  $membrete = Yii::$app->request->get('membrete'); 
  ?>
<h3>Comentarios del Documento: <?php echo $nombre_archivo;?></h3><br><br>
<?php
    $datos_comentario = \app\models\Comentarios::find()->select('autor, comentario, fecha')
                        ->where(['id_documento'=>$id_documento])->asArray()->all();
    foreach ($datos_comentario as $c) {
            $autor= $c['autor'];
            $nombre = app\models\Profilesoporte::find()->where(['user_id'=>$autor])->asArray()->all();
            foreach($nombre as $n){
                $nombre_usuario = $n['full_name'];
            }              
            $comentario= $c['comentario'];
            $fecha= $c['fecha'];

            //--------Membrete--------                                               
            $membrete_suscriptor = app\models\Documento::find()->where(['id_usuario'=>$autor])->asArray()->count();
            $membrete_aprobador = app\models\Documento::find()->where(['id_aprobacion'=>$autor])->asArray()->count();
            $membrete_publicador = app\models\Documento::find()->where(['id_publicador'=>$autor])->asArray()->count();                                               

            if($membrete_suscriptor > 0){
                $membrete = 'Suscriptor';
            }                                               
            else if($membrete_aprobador > 0){                                                   
                $membrete = 'Aprobador';
            }                                               
            else if($membrete_publicador > 0){
                $membrete = 'Publicador';
            }
            else{
                $membrete = 'Publicador';
            }
            
            
            //--------Fin Membrete-------- 

            $model = new app\models\Comentarios;

        Pjax::begin();
                echo DetailView::widget([
                    'model'=>$model,
                    'condensed'=>true,
                    'hover'=>true,
                    'mode'=>DetailView::MODE_VIEW,
                    'enableEditMode' => false,
                    'bordered'=>true,
                    // 'buttons1'=>'{update}',
                    'panel'=>[
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> ' .  $nombre_usuario. ' ('.$membrete.')</h3>',
                        'type'=>DetailView::TYPE_WARNING,
                    ],
                    'attributes'=>[
                        [
                        'label' => 'Comentario',
                        'value' => $comentario
                        ],
                        [
                        'label' => 'fecha',
                        'value' => $fecha
                        ],
                    ]
                ]);   
        Pjax::end();                  
    }
    ?>
</div>