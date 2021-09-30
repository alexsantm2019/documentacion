<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Documento */

$this->title = 'Nueva Versión de Documento';

?>
<div class="documento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formversion', [
        'model' => $model,
    ]) ?>

</div>
