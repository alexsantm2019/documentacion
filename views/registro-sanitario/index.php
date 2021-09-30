<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\editable\Editable;
use kartik\alert\Alert;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistroSanitarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registros Sanitarios';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-sanitario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Nuevo Registro Sanitario', ['create'], ['class' => 'btn btn-success']) ;

if($flash = Yii::$app->session->getFlash('success')){
    echo Alert::widget([
    'type' => Alert::TYPE_SUCCESS,
    'title' => 'Bien Hecho',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'El Registro Sanitario ha sido almacenado correctamente',
    'showSeparator' => true,
    'delay' => 800
]);
} 
     ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Registros Sanitarios' 
    ],
        'rowOptions'=>function($model){
                        $estado = $model->estado; 
                         if($estado ==3){
                              return ['style' => 'background-color: #D9EDF7;'];
                         }
                         else{
                             return ['style' => 'background-color: #DFF0D8;'];
                         }
        },
        'columns' => [
            'codigo',
            'producto',
            'fecha_modificacion',
            'modificacion:html',
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
            [

            'attribute' => 'estado',
            'label' => 'Estado',                
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                return $service ? $service->estado : '-';
            },            
        ],             

            ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Historial',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                $codigo = $model['codigo'];
                                $query = app\models\RegistroSanitario::find()->where(['codigo'=>$codigo])->count();
                                if($query >1){                                        
                                         return Html::a( '<i class="glyphicon glyphicon-list-alt " style="color:white"></i>',
                                                        ['registro-sanitario/historial', 
                                                            'codigo'=>$model['codigo'],
                                                        ],
                                                        ['class'=>'btn btn-success btn-md', 'title'=>'view/edit', ]
                                                );
                                }
                        },
                    ]
            ],             
             ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Modificación',
                    'width'=>'10px',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                return Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>',
                                                        ['/registro-sanitario/createcambio', 
                                                            'id'=>$model['id'],
                                                            'codigo'=>$model['codigo'],
                                                            'producto'=>$model['producto'],
                                                            'fecha_vigencia'=>$model['fecha_vigencia'],
                                                        ],
                                                        ['class'=>'btn btn-success btn-md ', 'title'=>'Añade un Comentario', ]
                                                );
                        },
                    ]
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