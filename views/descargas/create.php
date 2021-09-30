<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Descargas */

$this->title = 'Create Descargas';
$this->params['breadcrumbs'][] = ['label' => 'Descargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="descargas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
