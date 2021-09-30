<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comentarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comentarios-form">
<?php
   
   $id_usuario_logueado = Yii::$app->user->identity['id'];
   
//   print_r($flag); 
   //die();
       
?>    
    <?php $form = ActiveForm::begin(); ?>
    
    <?php // $form->field($model, 'id_documento')->textInput() ?>
    <?= $form->field($model, 'id_documento')->hiddenInput(['value'=>$id_documento])->label(false); ?>

    <?= $form->field($model, 'comentario')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'autor')->hiddenInput(['value'=>$id_usuario_logueado])->label(false); ?>    
    
    <input type="hidden" name="flag" value="<?php echo $flag; ?>">

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
