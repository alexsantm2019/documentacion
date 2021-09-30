<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CertificacionLeterago */

$this->title = 'Update Certificacion Leterago: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Certificacion Leteragos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="certificacion-leterago-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
