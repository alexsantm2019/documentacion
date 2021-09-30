<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CertificacionLeterago */

$this->title = 'Usuarios autorizados para Certificación Leterago';
//$this->params['breadcrumbs'][] = ['label' => 'Certificacion Leteragos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificacion-leterago-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
