<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CodificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ayuda';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codificacion-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <h1><?= Html::encode('Codificación') ?></h1>
    
 <?php // Pjax::begin(); 
 Pjax::begin([
   'id' => 'yourId',
   'enablePushState' => false,
   'enableReplaceState' => false,
])
 ?>   
    <?php
    echo GridView::widget([
    'dataProvider'=>$dataProvider,
//    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>['type'=>'primary', 'heading'=>'Codificación por Departamento', 'footer'=>false],
    'columns'=>[
//        ['class'=>'kartik\grid\SerialColumn'],
        [
            'attribute'=>'codigo_departamento', 
            'label'=>'Departamento',
            'width'=>'110px',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'value' => function($model, $key, $index, $column) {
                     $service = \app\models\Departamento::findOne($model->codigo_departamento);
                    return $service ? $service['departamento'] : '-';
                },
            'filter'=>false,
            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
        ],
        [
            'attribute'=>'codigo_categoria', 
            'label'=>'Categoría',
            'width'=>'150px',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'value' => function($model, $key, $index, $column) {
                    $service = \app\models\Categoria::findOne($model->codigo_categoria);
                    return $service ? $service['categoria'] : '-';
                },
            'filter'=>false,            
            'filterInputOptions'=>['placeholder'=>'Any category'],
            'group'=>true,  // enable grouping
            'subGroupOf'=>1 // supplier column index is the parent group
        ],

       [
            'attribute'=>'codigo_tipo',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'width'=>'100px',
            'label'=>'Tipo de Documento',
            'filter'=>false,
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            'value' => function($model, $key, $index, $column) {
                   //$service = app\models\Tipo::findOne($model->id_tipo);
                   $service = app\models\Tipo::find()->where(['codigo'=>$model->codigo_tipo])->one();
                   return $service ? $service->tipo : '-';
                },
        ],                 
                        
       [
            'attribute'=>'codigo',
            'width'=>'150px',
            'hAlign'=>'center',  
            'filter'=>false,
            'contentOptions' => function ($model, $key, $index, $column) {
                       return ['style' => 'background-color: #449D44; color: white;'];                           
            },
        ],
        'ultimo_registro',        

    ],
]);
 
    
    ?>
    
    
    
    
    <?php Pjax::end(); ?>
</div>



<style>
      #w1-filters, .kv-page-summary, .kv-panel-before, .summary{
        display:none;
    }
    
</style>    