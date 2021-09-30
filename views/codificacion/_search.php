<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CodificacionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="codificacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo_departamento') ?>

    <?= $form->field($model, 'codigo_categoria') ?>

    <?= $form->field($model, 'codigo_tipo') ?>

    <?= $form->field($model, 'codigo') ?>

    <?php // echo $form->field($model, 'ultimo_registro') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
