<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroSanitarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registro-sanitario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'producto') ?>

    <?= $form->field($model, 'fecha_modificacion') ?>

    <?= $form->field($model, 'modificacion') ?>

    <?php // echo $form->field($model, 'fecha_vigencia') ?>

    <?php // echo $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fecha_publicacion') ?>

    <?php // echo $form->field($model, 'copias') ?>

    <?php // echo $form->field($model, 'detalle_copias') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
