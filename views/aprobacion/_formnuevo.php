<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Aprobacion */
/* @var $form yii\widgets\ActiveForm */

 
$id_usuario = Yii::$app->user->identity['id'];
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
    
    <?= $form->field($model, 'id_aprobador')->dropDownList(ArrayHelper::map(app\models\Profilesoporte::find()
                    ->all(),'user_id','full_name'), 
            ['value' => $id_usuario])->label('Autorizado por:'); 
    ?>

    <?php //$form->field($model, 'id_documento')->textInput(['value' => $id_documento,'maxlength' => true]) ?>
    <?= $form->field($model, 'id_documento')->dropDownList(ArrayHelper::map(app\models\Documento::find()
                    ->all(),'id','nombre_archivo'),  ['prompt' => '--Seleccione un Documento--'])->label('Documento:'); 
    ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Autorizar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
