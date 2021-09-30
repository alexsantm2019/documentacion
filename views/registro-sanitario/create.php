<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegistroSanitario */

$this->title = 'Nuevo Registro Sanitario';
//$this->params['breadcrumbs'][] = ['label' => 'Registro Sanitarios', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-sanitario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
