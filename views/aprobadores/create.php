<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Aprobadores */

$this->title = 'Create Aprobadores';
$this->params['breadcrumbs'][] = ['label' => 'Aprobadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aprobadores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
