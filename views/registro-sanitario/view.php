<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroSanitario */

$this->title = 'Registro Sanitario: '.$model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Registro Sanitarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-sanitario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
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
            'codigo',
            'producto',
            'fecha_modificacion',
            'modificacion:html',
            'fecha_vigencia',
//            'path',
            [
                'attribute' => 'path',
                'label' => 'Link de Descarga',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/registros_sanitarios';
                        $path = str_replace($basepath, '', $model->path);
                        $nameFichero = substr($model->path, strrpos($model->path, '/'));  
                        return  Html::a('Descargar Documento', \yii\helpers\Url::base().'/registros_sanitarios/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
               }, $model),                        
             ],
//            'id_usuario',
             [
                'attribute' => 'id_usuario',
                'label' => 'Autor',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $id_tipo_equipo = $model['id_usuario'];
                        $service = \app\models\Profilesoporte::findOne($id_tipo_equipo);
                        return $service ? $service->full_name : '-';
               }, $model),                        
             ],            
//            'estado',
             [
                'attribute' => 'estado',
                'label' => 'Estado',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $estado = $model['estado'];
                        $service = app\models\Estado::findOne($estado);
                        return $service ? $service->estado : '-';
               }, $model),                        
             ],           
            'fecha_publicacion',
            'copias',
            'detalle_copias:html',
            'status',
        ],
    ]) ?>

</div>
