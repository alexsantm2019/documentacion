<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
//use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use kartik\widgets\Alert;

use kartik\dynagrid\DynaGrid;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documentos a Aprobar';
//$this->params['breadcrumbs'][] = $this->title;


if($flash = Yii::$app->session->getFlash('error')){
        //    print_r($flash); 
            $items = array();
            $count = 0;
            foreach($flash as $i => $d) { 
                $items[$count++] = $d; 
            } 
            $serialized_array = serialize($items); 
            $unserialized_array = unserialize($serialized_array);     
            $exampleEncoded = json_encode($items);    

            echo Alert::widget([
            'type' => Alert::TYPE_DANGER,
            'title' => 'Atención',
            'icon' => 'glyphicon glyphicon-remove-sign',
            'body' => 'No se actualizar por lo siguiente:<br>'.$exampleEncoded,
            'showSeparator' => true,
            'delay' => 8000
        ]);	
    } 
?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->

<div class="documento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <h3>OBSERVACIONES:</h3>
    <li>Revise los Comentarios realizados. Si necesita realizar uno, haga click en COMENTAR</li>   <br> 
<!--    <li>En caso de APROBAR un documento, debe seleccionar la persona que custodia el mismo en CUSTODIO</li>
    <li>En caso de APROBAR un documento, debe seleccionar los usuarios autorizados que accedan al documento en AUDIENCIA</li><br>-->
    <p>
        <?= Html::a('Nuevo Documento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    
    <?php
//Funcion Para actualizar la pagina automaticamente
$script = <<< JS
$(module).ready(function() {
    setInterval(function() {     
      //$.pjax.reload({container:'#myPjax'});
      $.pjax.reload({container:'#module'});
    }, 2500000); 
});
JS;
$this->registerJs($script);
?>
    
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'id'=>'module',
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Documentos Enviados' 
    ],
        'columns' => [
             [
              'attribute' => 'nombre_archivo',
              'label' => 'Nombre Archivo',  
              'hAlign'=>'center',
              'vAlign'=>'middle',  
              'filter'=>true,  
            ],
//            'codigo',
            [
              'attribute' => 'codigo',
              'label' => 'Código',  
              'hAlign'=>'center',
              'vAlign'=>'middle',  
              'filter'=>true,  
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
                        
                        if(empty($data->path)){
                            return "<div style='background-color: #D9534F; color: white !important;'>No hay documento adjunto</div>";
                        }
                        else{
                        return  Html::a($data->nombre_archivo, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                        }
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
              'label' => 'Versión',  
              'hAlign'=>'center',
              'vAlign'=>'middle',  
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
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'copias',
            //'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
            'contentOptions' => ['class'=>'bg-warning'] ,
            'label' => 'Copias',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value' => function($model, $key, $index, $column) {                
                   if(empty($model->copias)){
                     return '  ';
                   }
                   else{
                       return $model->copias;
                   }
            },
            'editableOptions' => [
                'header' => 'Observacion',
                'placement'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_SPIN,
                'value' => "Raw denim you...",
                'editableValueOptions' => ['class' => 'text-success h4'],
                 
            ],        
        ], 
                    
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'detalle_copias',
            //'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
            'contentOptions' => ['class'=>'bg-warning'] ,
            'label' => 'Detalle Copias',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'format'=>'html',
            'value' => function($model, $key, $index, $column) {                
                   if(empty($model->detalle_copias)){
                     return '  ';
                   }
                   else{
                       return $model->detalle_copias;
                   }
            },
            'editableOptions' => [
                'header' => 'Detalle',
                'placement'=> 'left',
                'format'=>'html',
//                'autotext'=> 'left',   
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_TEXTAREA,
                'value' => "Raw denim you...",
                'editableValueOptions' => ['class' => 'text-success h4'],
//                'data' => ArrayHelper::map(\app\models\Estado::find()->all(), 'id', 'estado'),
            ],        
        ],  
                   
        [
            'attribute' => '',
            //'width' => '20px !important',
            'label' => 'Comentarios',
            'hAlign' => 'center',
            'vAlign' => 'middle',
             'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                $id_documento = $model->id;
                $nombre_archivo = $model->nombre_archivo;
                $numero_comentarios = app\models\Comentarios::find()->where(['id_documento'=>$id_documento])->count();
                if(empty($numero_comentarios)){
                    return '(0)';
                }
                else{
                return Html::a( $numero_comentarios.' <i class="glyphicon glyphicon-search"></i>',
                        ['comentarios/comentarios', 
                            'id_documento' =>$id_documento, 
                            'nombre_archivo' =>$nombre_archivo,
//                                                            'membrete' =>'Aprobador',
                        ],
                        ['class'=>'btn btn-warning modalButton', 'title'=>'Editar Documento', ]
                ); 
                }                
            },  
        ],            
        ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Detalles',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
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
                                
        ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Comentar',
                    'width'=>'10px',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                return Html::a( '<i class="glyphicon glyphicon-comment" style="color:white"></i>',
                                                        ['/comentarios/create', 
                                                            'id_documento'=>$model['id'],
                                                            'flag'=>'CORRECTOR'
                                                        ],
                                                        ['class'=>'btn btn-success btn-md modalButton', 'title'=>'Añade un Comentario', ]
                                                );
                        },
                    ]
            ],
                               
          [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'estado',
            'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white;'] ,
            'label' => 'Estado',                
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
            },            
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(app\models\Estado::find()->where(['IN', 'id', [1,2]])->asArray()->all(), 'id', 'estado'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],                
            ],
            'filterInputOptions' => ['placeholder' => 'Escoga..'],                        
            'editableOptions' => [
                'header' => 'Estado',
                'placement'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
//                'editableValueOptions' => ['class' => 'text-success h4'],
                'data' => ArrayHelper::map(\app\models\Estado::find()->where(['IN', 'id', [2,3]])->all(), 'id', 'estado'),
//                'data' => ArrayHelper::map(\app\models\Estado::find()->all(), 'id', 'estado'),
            ],        
        ],                        
                    
       
                      
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<style>

    .wrap > .container{
        width: 99%;
        /*padding: 0;*/
        height: auto !important;
        /*border: solid 2px red;*/
        margin-bottom: 1px;
    }
    
    .wrap{
        /*border: solid 3px blue;*/
        padding: 0 !important;
    }
    
    th{
        color: #337AB7 !important;
    }
    
</style>    

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
