<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Codificacion */

$this->title = 'Create Codificacion';
$this->params['breadcrumbs'][] = ['label' => 'Codificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
