<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CertificacionLeterago */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificacion-leterago-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
    $data = ArrayHelper::map(app\models\Profilesoporte::find()->all(),'user_id','full_name');    
    echo $form->field($model, 'id_usuario')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\Profilesoporte::find()->orderBy('full_name')->all(), 'id', 'full_name'),
//        'data' => ArrayHelper::map(\app\models\Documento::find()->all(),'id','id'),
        'language' => 'es',
        'options' => ['multiple' => true, 'placeholder' => 'Seleccione Usuario autorizados...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Usuarios autorizados");
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Autorizar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
