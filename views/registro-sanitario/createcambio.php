<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Equipo */

$id = Yii::$app->request->get('id');
$codigo = Yii::$app->request->get('codigo');	
$producto = Yii::$app->request->get('producto');
$fecha_vigencia = Yii::$app->request->get('fecha_vigencia');

$this->title = 'Nuevo Registro del Equipo: '. $producto;
?>
<div class="equipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcambio', [
        'model' => $model,
        'id'=>$id,
        'codigo'=>$codigo,
        'producto'=>$producto,
        'fecha_vigencia'=>$fecha_vigencia,
    ]) ?>

</div>
