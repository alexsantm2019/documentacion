<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DescargasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Descargas por Archivo';
?>
<div class="descargas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>'Administración de Descargas',  'footer'=>false],    
        'columns' => [
            [
                'attribute' => 'id_documento',
                'label' => 'Nombre del Archivo',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model, $key, $index, $column) {
                        $id_documento = $model->id_documento;                        
                   $service = app\models\Documento::findOne($model->id_documento);
                   return $service ? $service->nombre_archivo : '-';
                },
                 'group'=>true,         
            ],
            [
                'attribute' => 'id_documento',
                'label' => 'Código',
                'value' => function($model, $key, $index, $column) {
                        $id_documento = $model->id_documento;                        
                   $service = app\models\Documento::findOne($model->id_documento);
                   return $service ? $service->codigo : '-';
                },
            ], 
                        
            [
                 'label' =>"Usuario",               
                 'attribute' => 'id_usuario',
                 'hAlign'=>'center',
                'vAlign'=>'middle',
                 'value'=>function($model) {
                   $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_usuario])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->asArray()->all(), 'id', 'full_name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga..'],    
          ],            
                        
//            'id_usuario',
            'fecha',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
