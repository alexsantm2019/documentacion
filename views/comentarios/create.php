<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comentarios */

$this->title = 'Ingrese un comentario:';
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $id_documento = Yii::$app->request->get('id_documento'); 
    $flag = Yii::$app->request->get('flag'); 
    ?>
    <?= $this->render('_form', [
        'model' => $model,
        'id_documento' => $id_documento,
        'flag' => $flag,
    ]) ?>

</div>
