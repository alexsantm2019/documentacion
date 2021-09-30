<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Aprobacion */

$this->title = 'Usuarios Autorizados';
$this->params['breadcrumbs'][] = ['label' => 'Aprobacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aprobacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formnuevo', [
        'model' => $model,
    ]) ?>

</div>
