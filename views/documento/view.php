<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use app\controllers\AuditoriaController;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */

//$this->title = $model->id;
$this->title = $model->codigo.' - '. $model->nombre_archivo;
//$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
//            'heading'=>'Book # ' . $model->id,
            'type'=>DetailView::TYPE_PRIMARY  ,
        ],
        'attributes' => [
            'id',
//            'nombre_archivo',
            [
                'attribute' => 'nombre_archivo',
                'label' => 'Nombre del Documento',
                'format' => 'raw',                       
            ],
            [
                'attribute' => 'codigo',
                'label' => 'Código',
                'format' => 'raw',                       
            ],
//            'id_categoria',
            [
                'attribute' => 'id_departamento',
                'label' => 'Departamento',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $id_categoria = $model['id_departamento'];
                        $service = app\models\Departamento::findOne($id_categoria);
                        return $service ? $service->departamento : '-';
               }, $model),                        
             ],
                       
            [
                'attribute' => 'id_categoria',
                'label' => 'Categoria',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $id_categoria = $model['id_categoria'];
                        $service = app\models\Categoria::findOne($id_categoria);
                        return $service ? $service->categoria : '-';
               }, $model),                        
             ],
             [
                'attribute' => 'id_tipo',
                'label' => 'Tipo',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $id_tipo = $model['id_tipo'];
                        $service = app\models\Tipo::findOne($id_tipo);
                        return $service ? $service->tipo : '-';
               }, $model),                        
             ],
//            'path',
             [
                'attribute' => 'path',
                'label' => 'Link de Descarga',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                        $path = str_replace($basepath, '', $model->path);
                        $nameFichero = substr($model->path, strrpos($model->path, '/'));

                    // ************** FUNCION AUDITORIA **************

                    $flag       = "Descarga";
                    $accion     = "Download";
                    $detalle    = "Descarga de documentos";
                    $documento  = $model->id;

                    AuditoriaController::audit($flag, $accion, $detalle, $documento);
            // ************** FIN FUNCION AUDITORIA **************

                        return  Html::a('Descargar Documento', \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
               }, $model),                        
             ],
            //'fecha',
            [
                'attribute' => 'fecha',
                'label' => 'Fecha de Creación',
                'format' => 'raw',                       
            ],           
            'version',
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

             [
                'attribute' => 'id_original',
                'label' => 'Versión Anterior:',
                //'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $id_original = $model['id_original'];
                        if(empty($id_original)){
                            return "No tiene Versión Anterior";
                        }
                        else{
                            return $id_original;
                        }
                        
               }, $model),                        
             ],
             [
                'attribute' => 'id_aprobacion',
                'label' => 'Aprobador',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                        $id_usuario = $model['id_aprobacion'];
                        $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$id_usuario])->asArray()->one();
                             return $service ? $service['full_name'] : '-';
               }, $model),                        
             ], 
             
             [
                'attribute' => 'fecha_aprobacion',
                'label' => 'Fecha de Aprobacion',
                'format' => 'raw',   
                'value' => call_user_func(function ($model) {
                            $fecha_aprobacion = $model['fecha_aprobacion'];
                        if(empty($fecha_aprobacion)){
                            return "Aún no se aprueba";
                        }
                        else{
                            return $fecha_aprobacion;
                        }
                        
               }, $model),  
            ],          

        ],
    ]) ?>
    
    
    <h3>Observaciones:</h3>
        <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'type'=>DetailView::TYPE_PRIMARY  ,
        ],
        'attributes' => [ 

                       
             [
                'attribute' => 'copias',
                'label' => 'No. de Copias Controladas', 
                'contentOptions' => ['class' => 'text-center'],
             ],          
             [
                'attribute' => 'detalle_copias',
                'label' => 'Detalle de Copias',
                'format' => 'html',                
                'value' => call_user_func(function ($model) {
                        $detalle_copias = $model['detalle_copias'];
                         if(empty($detalle_copias)){
                            return '  ';
                        }
                        else{
                            return $detalle_copias;
                        }  
               }, $model),  
             ],                
       
        ],
    ]) ?>

</div>

<style>
    .kv-buttons-1{
        display:none;
    }
</style>    