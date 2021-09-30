<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\alert\Alert;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AprobacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Autorizaciones';
//$this->params['breadcrumbs'][] = $this->title;

if($flash = Yii::$app->session->getFlash('success')){
echo Alert::widget([
    'type' => Alert::TYPE_SUCCESS,
    'title' => 'Felicidades!',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'La audiencia se creó correctamente.',
    'showSeparator' => true,
    'delay' => 2000
]);
}



if($flash = Yii::$app->session->getFlash('warning')){
echo Alert::widget([
    'type' => Alert::TYPE_WARNING,
    'title' => '<strong>ATENCION!</strong>',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'Tu Documento  ha sido <strong>APROBADO</strong> <br>Por favor seleccione un <strong>CUSTODIO</strong> y la <strong>AUDIENCIA</strong> para el Documento que aprobó.',
    'showSeparator' => true,
    'delay' => 7000
]);
}



?>
<div class="aprobacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Añadir Aprobacion', ['createnuevo'], ['class' => 'btn btn-success']) ?>
    </p>
    
        
    <!--/*******************************************************************************************/-->
    <!--/*******************************************************************************************/-->
        
     <?= GridView::widget([
        'dataProvider' => $dataProvider_suscriptor,
        'filterModel' => $searchModel,
         'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'DOCUMENTOS APROBADOS SIN AUDIENCIA',
        'footer'=>false
    ],
        'columns' => [
            [
              'attribute' => 'nombre_archivo',
              'hAlign'=>'center',
              'vAlign'=>'middle',  
              'label' => 'Nombre Archivo',  
              'filter'=>false,  
            ], 
            [
              'attribute' => 'codigo',
              'hAlign'=>'center',
              'vAlign'=>'middle',  
              'label' => 'Código',  
              'filter'=>false,  
            ], 
            [
                'attribute' => 'id_categoria',
                'label' => 'Categoria',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Categoria::findOne($model->id_categoria);
                   return $service ? $service->categoria : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Categoria::find()->asArray()->all(), 'id', 'categoria'),
                'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga..'],    
            ],
            [
                'attribute' => 'id_tipo',
                'label' => 'Tipo',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Tipo::findOne($model->id_tipo);
                   return $service ? $service->tipo : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Tipo::find()->asArray()->all(), 'id', 'tipo'),
                'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga..'],    
            ],            
            [
                'attribute' => 'path',
                'label' => 'Archivo',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'format' => 'raw',
//                'options' => 'color: green',
                'value' => function($data){
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                        $path = str_replace($basepath, '', $data->path);
                        $nameFichero = substr($data->path, strrpos($data->path, '/'));                                     
                        //return  Html::a($nameFichero, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                        return  Html::a($data->nombre_archivo, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
//                        return  Html::a($nameFichero, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank'], ['class' => 'linksWithTarget'], ['data' => ['pjax' => 0]]);
                },
               'filter' =>false,        
            ],
                        
//             'fecha',
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
                    'options' => ['placeholder' => 'Escoga'], //this code not giving any changes in browser
                    'type' => kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND, //this give error Class 'DatePicker' not found
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],            
//             'version',
            [
              'attribute' => 'version',
              'hAlign'=>'center',
              'vAlign'=>'middle',  
              'label' => 'Versión',  
              'filter'=>false,  
            ],             
            [
                 'label' =>"Creado por",               
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
                    
         [
            'attribute' => 'estado',
            'label' => 'Estado',
            'hAlign' => 'center',
            'vAlign' => 'middle',
             'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white;'] ,
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Tipo::find()->asArray()->all(), 'id', 'tipo'),
                'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga..'],    
            ],            
                   
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_custodio',
            'contentOptions' => ['style'=>'background-color: #F0AD4E !important; color: white !important;'] ,
            'label' => 'Custodio',
            'hAlign' => 'center',
            'vAlign' => 'middle',
//            'filterType' => GridView::FILTER_SELECT2,
//            'filter' => ArrayHelper::map(\app\models\Profilesoporte::find()->orderBy('full_name')->all(), 'id', 'full_name'),
//            'filterWidgetOptions' => [
//                'pluginOptions' => ['allowClear' => true],
//            ],
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Profilesoporte::findOne($model->id_custodio);
                   return $service ? $service->full_name : 'No existe custodio';
            },                        
//            'filterInputOptions' => ['placeholder' => 'Escoga..'],    
            'editableOptions' => [
                'header' => 'Custodio',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
//                'editableValueOptions' => ['class' => 'text-success h4'],
                'data' => ArrayHelper::map(\app\models\Profilesoporte::find()->orderBy('full_name')->all(), 'id', 'full_name'),
            ],        
        ],
                                        
        ['class' => 'kartik\grid\ActionColumn', 'template'=>'{custom_view}',
                    'header'=>'Audiencia',
            'hAlign' => 'center',
            'vAlign' => 'middle',
                    'buttons' => 
                    [   'custom_view' => function ($url, $model) {
                                // Html::a args: title, href, tag properties.                               
                                return Html::a( '<i class="glyphicon glyphicon-user" style="color:white"></i>',
                                    ['aprobacion/create',  
                                        'id_documento'=>$model['id'],
                                        'id_aprobador'=>$model['id_aprobacion']
                                    ],
                                    ['class'=>'btn btn-success btn-md modalButton' ]
                                );  
                        },
                    ],
        ],   
                      
                                
        ],
    ]); ?>
    
    <!--/*******************************************************************************************/-->
    <!--/*******************************************************************************************/-->

    <?php Pjax::end(); ?>
    
    <?php Pjax::begin(); ?>
    <?php
    echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>['type'=>'primary', 'heading'=>'COLABORADORES AUTORIZADOS POR DOCUMENTO', 'footer'=>false],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
//        'id',
        [
            'attribute'=>'id_documento', 
            'label'=>'Documento Aprobado',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'width'=>'310px',
//            'value'=>function ($model, $key, $index, $widget) { 
//                return $model->id_documento;
//            },
             'value'=>function($model) {
                   $service = app\models\Documento::find()->select('nombre_archivo')->where(['id'=>$model->id_documento])->asArray()->one();
                     return $service ? $service['nombre_archivo'] : '-';
                 },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(\app\models\Documento::find()->orderBy('id')->asArray()->all(), 'id', 'nombre_archivo'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
        ],'id_documento',
        [
            'attribute'=>'id_aprobador', 
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'label'=>'Aprobado por:',
            'width'=>'250px',
            'value'=>function($model) {
                   $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_aprobador])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->orderBy('full_name')->asArray()->all(), 'user_id', 'full_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Seleccione....'],
            'group'=>true,  // enable grouping
            'subGroupOf'=>1 // supplier column index is the parent group
        ],
        [
                'label' =>"Usuario Autorizado",               
                'attribute' => 'id_usuario_autorizado',            
                'hAlign'=>'center',
                'vAlign'=>'middle',
                 'value'=>function($model) {
                   $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_usuario_autorizado])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->asArray()->all(), 'id', 'full_name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Seleccione..'],              
        ], 
        'fecha',
                         
        [
         'class' => '\kartik\grid\ActionColumn',         
        'template' => '{delete}',
            ],
    ],
]);
    ?>
    
    <?php Pjax::end(); ?>
    
</div>

<!--/************************************************** BOTON MODAL*************************************************/-->
<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
    ]);
        echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

        $this->registerJs(
        "$(document).on('ready pjax:success', function() {
                $('.modalButton').click(function(e){
                   e.preventDefault(); //for prevent default behavior of <a> tag.
                   var tagname = $(this)[0].tagName;
                   $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
               });
            });
        ");
?>
<!--/************************************************** BOTON MODAL*************************************************/-->


<style>
     th{
        color: #337AB7 !important;
    }
    #w1-filters{
        display:none;
    }
    .container{
        width: 99%;
    }
</style>    