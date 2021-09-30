<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Descargas */

$this->title = 'Update Descargas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Descargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="descargas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
