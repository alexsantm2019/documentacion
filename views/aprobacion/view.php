<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Aprobacion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aprobacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aprobacion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'id_usuario_autorizado',  
             [
                'attribute' => 'id_usuario_autorizado',
                'label' => 'Usuario Autorizado',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $id = $model->id_usuario_autorizado;
                            $sql = " select full_name  FROM Profile where user_id ='$id'";
                            $data = Yii::$app->getDb()
                          ->createCommand($sql)
                          ->queryOne();
                            $nombre = $data['full_name'];
                          return $nombre;
               }, $model),                        
             ], 
//            'id_aprobador',
            [
                'attribute' => 'id_aprobador',
                'label' => 'Usuario Autorizado',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $id = $model->id_aprobador;
                            $sql = " select full_name  FROM Profile where user_id ='$id'";
                            $data = Yii::$app->getDb()
                          ->createCommand($sql)
                          ->queryOne();
                            $nombre = $data['full_name'];
                          return $nombre;
               }, $model),                        
             ],            
            'id_documento',
            'fecha',
        ],
    ]) ?>

</div>
