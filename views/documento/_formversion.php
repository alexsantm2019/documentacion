<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */
/* @var $form yii\widgets\ActiveForm */
?>

<!--<div class="documento-form">-->
    <?php     
    //Capturo las variables enviadas desde indexsuscriptior
    $id_tipo = Yii::$app->request->get('id_tipo'); 
    $id_categoria = Yii::$app->request->get('id_categoria'); 
    $nombre_archivo = Yii::$app->request->get('nombre_archivo'); 
    $id_original = Yii::$app->request->get('id'); 
    $id_padre = Yii::$app->request->get('id_padre'); 
    $codigo = Yii::$app->request->get('codigo'); 
    $version = Yii::$app->request->get('version');            
    $id_usuario = Yii::$app->user->identity['id'];
    ?>

    <div class="row">  
        <div class="col-md-4 "> 
         </div> 
         <div class="col-md-4" style="border-style: dotted; padding: 5px 5px;">      
            <p> El código del Documento Original es: <strong><?php echo $codigo; ?></strong>
            <p> La Versión original es: <strong><?php echo $version; ?></strong>
         </div>
         <div class="col-md-4 "> 
         </div>    
    </div> <br>

<div class="documento-form" style ="border-style: ridge; border-radius: 15px;; padding: 10px 10px;">    


   
    <?php    
    //$form = ActiveForm::begin(); 
    $form = ActiveForm::begin([
            'options' => [ 'enctype' => 'multipart/form-data']
    ]);
    ?>
    
    <?= $form->field($model, 'codigo')->hiddenInput(['value'=>$codigo])->label(false); ?>
    
    
      <div class="row">
                          <div class="col-md-4">    
                                    <?php
                                           echo $form->field($model, 'id_departamento')->label('Seleccione un Departamento:')
                                            ->dropDownList(
                                                    ArrayHelper::map(\app\models\Departamento::find()->all(), 'id', 'departamento'),
                                                    ['prompt' => '--Seleccione un Departamento--', 
                                                                         //'class'=>'adjust',
                                                          'onchange'=>'
                                                                    $.post("'.Yii::$app->urlManager->createUrl('codificacion/lists?id=').
                                                                  '"+$(this).val(),function( data ) 
                                                   {
                                                              $( "select#departamento_id" ).html( data );
                                                            });
                                                        ']
                                            )
                                    ?>
                          </div>    

                          <div class="col-md-4">  
                              <?php
                                        $dataPost=ArrayHelper::map(\app\models\Categoria::find()->asArray()->all(), 'id', 'categoria');
                                                 echo $form->field($model, 'id_categoria')
                                                       ->dropDownList(
                                                           $dataPost,  
                                                            ['id'=>'departamento_id', 'prompt'=>'--Seleccione una Categoria--']
                                                       )->label('Seleccione una Categoria');
                              ?>   
                        </div>  

                        <div class="col-md-4">                   
                                    <?= $form->field($model, 'id_tipo')->label('Seleccione un Tipo:')
                                           ->dropDownList(
                                                       ArrayHelper::map(app\models\Tipo::find()
                                                       ->all(),'id','tipo')
                                                       ,['prompt' => '--Seleccione un Tipo--']) 
                                    ?> 
                        </div>  
                  </div> 
    
    
    
    <?= $form->field($model, 'nombre_archivo')->textInput(['value' => $nombre_archivo,'maxlength' => true, 'style' => 'text-transform: uppercase']) ?>
        
    <?php // $form->field($model, 'path')->fileInput()->label('Adjunte el archivo')?>
        <?= $form->field($model, 'path')->label('Seleccione el Documento:')->widget(\kartik\widgets\FileInput::classname(),[
         'pluginOptions' => [
        'showRemove' => true,
        'showUpload' => false,
        'browseLabel' =>  'Seleccione Archivo'     
        ]
        ])
    ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true])->label('Nueva Versión') ?>
    
        <?php
    $aprobadores = (new \yii\db\Query())
    ->select(["p.user_id as user_id", "p.full_name as full_name"])
    ->from('soporte.profile p, aprobadores a')
    ->where('a.user_id = p.user_id')
    ->orderBy('full_name')
    ->all();
    
    $data = ArrayHelper::map($aprobadores, 'user_id', 'full_name');    
    ?>
           
     <?=
     $form->field($model, 'id_aprobacion')->label('Seleccione quien Aprobará el Documento:')
        ->dropDownList($data,['prompt' => '--Seleccione quien Aprobará el Documento--'])             
    ?>
    
    <?= $form->field($model, 'id_usuario')->hiddenInput(['value'=>$id_usuario])->label(false); ?>
    
    <?php
    if(!empty($id_padre)){
    ?>
        <?= $form->field($model, 'id_original')->hiddenInput(['value'=>$id_padre])->label(false); ?>
        
    <?php }
    else {
    ?>
        <?= $form->field($model, 'id_original')->hiddenInput(['value'=>$id_original])->label(false); ?>
    <?php
    }
    ?>  
    
     <div class="row">
        <div class="col-md-4">
                <?php echo $form->field($model,'copias')->label('Número de copias Controladas')->
                       widget(TouchSpin::className(),[  
                           //'readonly' => true,
                           'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                           'pluginOptions' => [        
                           'buttonup_class' => 'btn btn-primary', 
                           'buttondown_class' => 'btn btn-info', 
                           'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                           'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                       ],
                   ]) 
               ?>	
        </div>
        <div class="col-md-8">    
                <?=
                          $form->field($model, 'detalle_copias')->label('Detalle de Copias Controladas:')->widget(CKEditor::className(), [
                              'options' => ['rows' => 1],
                              'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                              'preset' => 'basic',
                              'clientOptions' => [
                                  'allowedContent' => true,
                              ],
                          ])
               ?>
       </div>     
      
    </div>  
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear Nueva Vesión' : 'Crear Nueva Versión', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

