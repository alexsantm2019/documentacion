<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use kartik\widgets\TouchSpin;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
//use yii\jui\DatePicker;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroSanitario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registro-sanitario-form">

    <?php 
     $id_usuario = Yii::$app->user->identity['id'];
     $form = ActiveForm::begin([
            'options' => [ 'enctype' => 'multipart/form-data']
    ]); ?>

    <div class="col-md-6">  <?= $form->field($model, 'codigo')->textInput(['value'=>$codigo,'readonly' => true]) ?></div>
     
    <div class="col-md-6"> <?= $form->field($model, 'producto')->textInput(['value'=>$producto,'readonly' => true]) ?> </div>

    <?=
          $form->field($model, 'modificacion')->label('Modificaciones')->widget(CKEditor::className(), [
              'options' => ['rows' => 1],
             // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
              'preset' => 'basic',
              'clientOptions' => [
                  'allowedContent' => true,
              ],
          ])
    ?>
    
    <?= $form->field($model, 'id_usuario')->hiddenInput(['value'=>$id_usuario])->label(false); ?>
    
  
    <div class="col-md-6"> <?= $form->field($model, 'fecha_vigencia')->textInput(['value'=>$fecha_vigencia,'readonly' => true]) ?> </div>
    
    <div class="col-md-6">
    <?= $form->field($model, 'path')->label('Seleccione el Documento:')->widget(\kartik\widgets\FileInput::classname(),[
                'pluginOptions' => [
                'showRemove' => true,
                'showUpload' => false,
                'showPreview' => false,    
                'browseLabel' =>  'Seleccione Archivo'
                ]
                ])
    ?>
    </div> 

    <div class="col-md-6">
    <?php echo $form->field($model,'copias')->label('Número de copias Controladas')->hint('ATENCION: Si solo requiere el documento ORIGINAL, coloque 0')->widget(TouchSpin::className(),[  
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
    
    <div class="col-md-6">
    <?=
                          $form->field($model, 'detalle_copias')->label('Detalle de Copias Controladas:')->hint('ATENCION: Si es documento ORIGINAL, escriba "ORIGINAL"')->widget(CKEditor::className(), [
                              'options' => ['rows' => 1],
                             // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                              'preset' => 'basic',
                              'clientOptions' => [
                                  'allowedContent' => true,
                              ],
                          ])
    ?>
    </div>   
    


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
