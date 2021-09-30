<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentoSearch */
/* @var $dataProvider_suscriptor yii\data\ActiveDataProvider */

$this->title = 'Versionar Documentos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

 <h1><?= Html::encode($this->title) ?></h1>
 <h4>Los siguientes documentos han sido aprobados. Si desea realizar una nueva versión del documento, haga click en el ícono de VERSIONAR</h4><br><br>


<div class="documento-index">
    
     <?php Pjax::begin(); ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider_versionador,
        'filterModel' => $searchModel,
        'panel' => [
                'type' => GridView::TYPE_SUCCESS,
                'heading'=>'DOCUMENTOS PUBLICADOS'     
        ],
        'columns' => [
//            'id',
            'nombre_archivo',
            'codigo',
            [
                'attribute' => 'id_categoria',
                'label' => 'Categoria',
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Categoria::findOne($model->id_categoria);
                   return $service ? $service->categoria : '-';
                },
                'filter'=> true,   
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Categoria::find()->asArray()->all(), 'id', 'categoria'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Seleccione..'],                         
            ],
            [
                'attribute' => 'id_tipo',
                'label' => 'Tipo',
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Tipo::findOne($model->id_tipo);
                   return $service ? $service->tipo : '-';
                },
                'filter'=> true,   
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Tipo::find()->asArray()->all(), 'id', 'tipo'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Seleccione..'],                      
            ],  
//            'codigo',            
            [
                'attribute' => 'path',
                'label' => 'Archivo',
                'format' => 'raw',
                'value' => function($data){
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                        $path = str_replace($basepath, '', $data->path);
                        $nameFichero = substr($data->path, strrpos($data->path, '/'));                                     
                        //return  Html::a($nameFichero, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                        return  Html::a('Descargar Documento', \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                },
                'filter'=> false,   
            ],
            [
                'attribute' => 'fecha',
                'label' => 'Fecha',
                'filterType' => GridView::FILTER_DATE,                 
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'width'=>'20%',                
                'headerOptions'=>['class'=>'kv-sticky-column'],
                'contentOptions'=>['class'=>'kv-sticky-column'],            
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Seleccione'], //this code not giving any changes in browser
                    'type' => kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND, //this give error Class 'DatePicker' not found
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ], 
             'version',
//             'id_original',  
              [
                 'label' =>"Doc Padre",               
                 'attribute' => 'id_original',
                'filter'=> false,                  
            ],            
            [
                'label' =>"Enviado a",               
                'attribute' => 'id_aprobacion',
                'hAlign'=>'center',
                    'vAlign'=>'middle',
                     'value'=>function($model) {
                        $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_aprobacion])->asArray()->one();
                        return $service ? $service['full_name'] : '-';
                     },
                'filter'=> true,                  
               'filterType'=>GridView::FILTER_SELECT2,
               'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->asArray()->all(), 'user_id', 'full_name'), 
               'filterWidgetOptions'=>[
                   'pluginOptions'=>['allowClear'=>true],
               ],
               'filterInputOptions'=>['placeholder'=>'Seleccione..'],              
            ],                       

                                
            ['class' => 'kartik\grid\ActionColumn', 'template'=>'{custom_view}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                    'header'=>'Versionar',
                    'buttons' => 
                    [   'custom_view' => function ($url, $model) {
                                // Html::a args: title, href, tag properties.
                                return Html::a( '<i class="glyphicon glyphicon-paste"></i>',
                                                        ['documento/createversion', 
                                                            'id'=>$model['id'],
                                                            'id_categoria'=>$model['id_categoria'],
                                                            'id_tipo'=>$model['id_tipo'],
                                                            'nombre_archivo'=>$model['nombre_archivo'],
                                                            'id_padre'=>$model['id_original'],
                                                            'codigo'=>$model['codigo'],
                                                            'version'=>$model['version'],
                                        ],
                                                        ['class'=>'btn btn-success ', 'title'=>'Versionar Documento', ]
                                                );
                        },
                    ]
            ],             
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>  



<style>
th a {
    color: #337AB7 !important;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

    td i {
    color: white !important;
}

.wrap > .container {
    width: 98%;
}
.ui-widget-content a {
    color: #337AB7 !important; 
}

.kv-grid-container {
    overflow-x: hidden;
}
</style>    