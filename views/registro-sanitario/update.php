<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroSanitario */

$this->title = 'Update Registro Sanitario: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Registro Sanitarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registro-sanitario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
