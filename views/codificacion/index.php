<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CodificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Codificaciones';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Codificación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Codificación' 
    ],
        'columns' => [
            [
                'attribute' => 'codigo_departamento',
                'label' => 'Departamento',
                'value' => function($model, $key, $index, $column) {
                   $service = \app\models\Departamento::findOne($model->codigo_departamento);
                    return $service ? $service['departamento'] : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Departamento::find()->orderBy('departamento')->asArray()->all(), 'id', 'departamento'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Any supplier'],
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
                        
            [
                'attribute' => 'codigo_categoria',
                'label' => 'Categoria',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value' => function($model, $key, $index, $column) {
                   $service = \app\models\Categoria::findOne($model->codigo_categoria);
                    return $service ? $service['categoria'] : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Categoria::find()->orderBy('categoria')->asArray()->all(), 'id', 'categoria'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Any category'],
                'group'=>true,  // enable grouping
                'subGroupOf'=>1 // supplier column index is the parent group  
            ],
       
            [
                'attribute' => 'codigo_tipo',
                'label' => 'Tipo',
                'value' => function($model, $key, $index, $column) {
                   //$service = app\models\Tipo::findOne($model->codigo_tipo);
                   $service = app\models\Tipo::find()->where(['codigo'=>$model->codigo_tipo])->one();
                   return $service ? $service->tipo : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Tipo::find()->asArray()->all(), 'id', 'tipo'),
                'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga..'],    
            ], 
            'codigo',
//            'ultimo_registro',
            [
                'attribute' => 'ultimo_registro',
                'width' => '20px',
                'label' => 'Ultimo Registro',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'filter' => false,        
            ],            
//            'descripcion',
            [
                'attribute' => 'descripcion',
                //'width' => '20px !important',
                'label' => 'Descripción',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'filter' => false,        
            ],             
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>



<style>
    .kv-grouped-row {
    background-color: #449D44 !important;
    color: white !important;
    /*padding: 25px 25px !important;*/
}

</style>    