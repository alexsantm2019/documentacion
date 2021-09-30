<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Aprobacion */
/* @var $form yii\widgets\ActiveForm */


$id_aprobacion = Yii::$app->request->get('id_aprobador'); 
$id_documento = Yii::$app->request->get('id_documento'); 
?>

<div class="aprobacion-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?php
    $data = ArrayHelper::map(app\models\Profilesoporte::find()->all(),'user_id','full_name');    
    echo $form->field($model, 'id_usuario_autorizado')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\Profilesoporte::find()->orderBy('full_name')->all(), 'id', 'full_name'),
//        'data' => ArrayHelper::map(\app\models\Documento::find()->all(),'id','id'),
        'language' => 'es',
        'options' => ['multiple' => true, 'placeholder' => 'Seleccione Usuario autorizados...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Usuarios autorizados");
    ?>
    
    <?= $form->field($model, 'id_aprobador')->hiddenInput(['value'=>$id_aprobacion])->label(false); ?>

    
    <?= $form->field($model, 'id_documento')->hiddenInput(['value'=>$id_documento])->label(false); ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Autorizar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
