<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistroSanitarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administrador de Registros Sanitarios';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-sanitario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>    

    <p>
        <?php 
            
            
            if($flash = Yii::$app->session->getFlash('error')){
            $items = array();
            $count = 0;
            foreach($flash as $i => $d) { 
                $items[$count++] = $d; 
            } 
            $serialized_array = serialize($items); 
            $unserialized_array = unserialize($serialized_array);     
            $exampleEncoded = json_encode($items);    

            echo Alert::widget([
            'type' => Alert::TYPE_SUCCESS,
            'title' => 'Bien Hecho',
            'icon' => 'glyphicon glyphicon-remove-sign',
            'body' => 'El Registro Sanitario ha sido almacenado correctamente',
            'showSeparator' => true,
            'delay' => 8000
        ]);	
    } 
            
            
            ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider_publicador,
        'filterModel' => $searchModel,
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Registros Sanitarios' 
    ],
        
        'rowOptions'=>function($model){
                        $estado = $model->estado; 
                         if($estado ==3){
                              return ['style' => 'background-color: #F2DEDE;'];
                         }
                         else{
                             return ['style' => 'background-color: #DFF0D8;'];
                         }
        },

        'columns' => [
            'codigo',
            'producto',
            'fecha_modificacion',
//            'modificacion:html',
            'fecha_vigencia',
            [
                'attribute' => 'path',
                'label' => 'Archivo',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'format' => 'raw',
//                'options' => 'color: green',
                'value' => function($data){
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/registros_sanitarios';
                        $path = str_replace($basepath, '', $data->path);
                        $nameFichero = substr($data->path, strrpos($data->path, '/'));                         
                        if(empty($data->path)){
                            return "<div style='background-color: #D9534F; color: white !important;'>No hay documento adjunto</div>";
                        }
                        else{
                        return  Html::a($data->producto, \yii\helpers\Url::base().'/registros_sanitarios/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                        }
                },
               'filter' =>false,        
            ],
            // 'id_usuario',
            // 'estado',
            // 'fecha_publicacion',
 [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'copias',
//            'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
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
//            'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
            'label' => 'Detalle Copias',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'format'=>'raw',
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
                'format'=>'raw',
//                'autotext'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_TEXTAREA,
                'value' => "Raw denim you...",
                'editableValueOptions' => ['class' => 'text-success h4'],
//                'data' => ArrayHelper::map(\app\models\Estado::find()->all(), 'id', 'estado'),
            ],        
        ],        
//             'status',
            [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'estado',
            //'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white;'] ,
//            'contentOptions'=>['class'=>'alert alert-success'],
            'label' => 'Estado',                
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
            },            
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(app\models\Estado::find()->where(['IN', 'id', [3,5]])->asArray()->all(), 'id', 'estado'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],                
            ],
            'filterInputOptions' => ['placeholder' => 'Escoga..'],                        
            'editableOptions' => [
                'header' => 'Estado',
                'placement'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => ArrayHelper::map(\app\models\Estado::find()->where(['IN', 'id', [5]])->all(), 'id', 'estado'),
            ],        
        ],             
            ['class' => 'kartik\grid\ActionColumn',
                          'template'=>'{view}{update}{delete}',
                            'buttons'=>[
                                    'view' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                                              'class'=>'btn btn-success btn-md modalButton','title' => Yii::t('yii', 'View'),
                                      ]); 
                                    },
                                    'update' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                              'class'=>'btn btn-success btn-md','title' => Yii::t('yii', 'Update'),
                                      ]); 
                                    },
                                    'delete' => function($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-success btn-md',
                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
                                    }        
                            ]  
                                    
            ],                     
                                
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>



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
    
.container{
        width:99%;
    }
            th{
        color: #337ab7 !important;
    }       
           
</style> 