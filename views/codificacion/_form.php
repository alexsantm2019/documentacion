<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Codificacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="codificacion-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
<div class="row">
    <div class="col-lg-6">
        
<!--/***********************************************************DEPDROP DROPDOWN DEPENDIENTES************************************************/-->
<?php

echo $form->field($model, 'codigo_departamento')->dropDownList(ArrayHelper::map(app\models\Departamento::find()->all(), 'id', 'departamento'), ['id'=>'id']);
 
// Child # 1 
echo $form->field($model, 'codigo_categoria')->widget(DepDrop::classname(), [
  'options'=>['id'=>'categoria'],
//  'options'=>ArrayHelper::map(\app\models\Categoria::find()->all(), 'id', 'categoria'),
  'pluginOptions'=>[
      'depends'=>['id'],
      'placeholder'=>'Selecione una Categoria...',
      'url'=>Url::to(['subcat'])
  ]
]);

  ?>
<!--/***********************************************************DEPDROP DROPDOWN DEPENDIENTES************************************************/-->        
        
    
 <?= $form->field($model, 'codigo_tipo')->label('Seleccione un Tipo:')
        ->dropDownList(
                    ArrayHelper::map(app\models\Tipo::find()
                    ->all(),'codigo','codigo')
                    ,['prompt' => '--Seleccione un Tipo--']) 
 ?>   
   </div> 
<div class="col-lg-6">
    <?= $form->field($model, 'ultimo_registro')->textInput(['value'=>1]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
</div>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
