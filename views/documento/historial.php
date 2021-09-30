<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial">

    <h1><?=  Html::encode($this->title) ?></h1>

     <?php
    $codigo = Yii::$app->request->get('codigo');
    
    $query = \app\models\Documento::find()->where(['codigo'=>$codigo]);
    $dataProvider_historial = new ActiveDataProvider([
            'query' => $query,
             'sort' => [
                    'defaultOrder' => [
                        //'id' => SORT_DESC,                        
                        'fecha' => SORT_DESC,                        
                    ],
            ],
        ]);
    ?>
    
    
<?php Pjax::begin(); ?>   
 <?php    
echo GridView::widget([
    'id'=>'module',
    'dataProvider'=>$dataProvider_historial,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
     'rowOptions'=>function($model){
                        $estado = $model->estado; 
                         if($estado == 1){
                              return ['style' => 'background-color: #D9EDF7;'];
                         }
                         if($estado == 2){
                              return ['style' => 'background-color: #F2DEDE;'];
                         }
                         if($estado == 3){
                              return ['style' => 'background-color: #DFF0D8;'];
                         }
                         if($estado == 5){
                             return ['style' => 'background-color: #5FC163; color: white;'];
                         }
        },
    'panel'=>['type'=>'primary', 'heading'=>'Documentos',  'footer'=>false],
    'columns'=>[
//        ['class'=>'kartik\grid\SerialColumn'],
//        'id',
          [
            'attribute' => 'id_categoria',
            //'width' => '20px !important',
            'label' => 'Categoria',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            //            'filterInputOptions'=>['placeholder'=>'Escoga una Zona...'],
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Categoria::findOne($model->id_categoria);
                   return $service ? $service->categoria : '-';
            }, 
            'filter' => false,        
              'group'=>true, 
             'contentOptions' => function ($model, $key, $index, $column) {
                       return ['style' => 'color: black'];                                                  
            },         
            'group'=>true,        
        ],
        
        'nombre_archivo',
           
//        'codigo',    
        [
            'label' =>"Código",               
            'attribute' => 'codigo',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'filter' => true,
        ],             
       
        [
        'attribute' => 'path',
//                'width'=>'60px',
        'label' => 'Descargable',
        'format' => 'raw',
        'value' => function($data){
                $id_documento = $data->id;
                
                //Numero de descargas
                $numero_descargas = app\models\Descargas::find()->where(['id_documento'=>$id_documento])->count();
                
                
                $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                $path = str_replace($basepath, '', $data->path);
                $nameFichero = substr($data->path, strrpos($data->path, '/'));                                     
//                        return  Html::a($data->nombre_archivo, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);     
return Html::a('Descargar Archivo ('.$numero_descargas.')', ['descargas/create', 'id_documento' =>$id_documento], ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);   
        },
        'filter'=> false,   
       ],                 
      [
             'label' =>"Creado por",               
             'attribute' => 'id_usuario',
             'hAlign'=>'center',
            'vAlign'=>'middle',
             'value'=>function($model) {
//                 print_r($model); die();     
               $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_usuario])->asArray()->one();
                 return $service ? $service['full_name'] : '-';
             },
                          'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->orderBy('full_name')->asArray()->all(), 'user_id', 'full_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Seleccione....'],           
      ],  
       [
             'label' =>"Fecha Creación",               
             'attribute' => 'fecha',
             'hAlign'=>'center',
            'vAlign'=>'middle',   
           'filter'=>false,
       ],              

        [
            'label' =>"Aprobado por",               
            'attribute' => 'id_aprobacion',
            'hAlign'=>'center',
            'vAlign'=>'middle',
             'value'=>function($model) {                                  
               $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_aprobacion])->asArray()->one();
                 return $service ? $service['full_name'] : '-';
             },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->orderBy('full_name')->asArray()->all(), 'user_id', 'full_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Seleccione....'],           
          ],  
                     
//          'fecha_aprobacion',
        [
             'label' =>"Fecha Aprobación",               
             'attribute' => 'fecha_aprobacion',
             'hAlign'=>'center',
            'vAlign'=>'middle',  
            'filter'=>false,
       ],                           
        [
            'label' =>"Custodio",               
            'attribute' => 'id_custodio',
            'hAlign'=>'center',
            'vAlign'=>'middle',
             'value'=>function($model) {                  
               $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_custodio])->asArray()->one();
                 return $service ? $service['full_name'] : '-';
             },
              'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->orderBy('full_name')->asArray()->all(), 'user_id', 'full_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Seleccione....'],           
        ], 
  
        [
//            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'estado',
//            'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white;'] ,
            'label' => 'Estado',                
            'hAlign' => 'center',
            'vAlign' => 'middle',
            //            'filterInputOptions'=>['placeholder'=>'Escoga una Zona...'],
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
            },            
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(app\models\Estado::find()->asArray()->all(), 'id', 'estado'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],                
            ],
            'filterInputOptions' => ['placeholder' => 'Escoga..'],                        
        ],
                    
                    //modal                    
             ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Detalles',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'contentOptions' => function ($model, $key, $index, $column) {
                       return ['style' => 'background-color: white'];                           
                       
                    }, 
                    'buttons' => 
                    [   
                        
                        'custom_view' => function ($url, $model) {
                                // Html::a args: title, href, tag properties.
                                return Html::a( '<i class="glyphicon glyphicon-eye-open" style="color:white"></i>',
                                                        ['documento/view', 'id'=>$model['id']],
                                                        ['class'=>'btn btn-success btn-md modalButton', 'title'=>'view/edit', ]
                                                );
                        },
                    ]
                ],            
                    
                     
    ],
]);
 ?><?php Pjax::end(); ?></div>



<!--/************************************************** BOTON MODAL*************************************************/-->
<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
        'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cerrar</a>',
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
        .kv-page-summary-container{
               display:none;
           }

           .container{
               width:90%;
           }

           .kv-grid-group{
               color: black !important;
           }
           
           .container{
               width: 98%;
           }
</style> 