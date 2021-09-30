<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial de Registros Sanitarios';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial">

    <h1><?=  Html::encode($this->title) ?></h1>

     <?php
    $codigo = Yii::$app->request->get('codigo');
    
    $query = \app\models\RegistroSanitario::find()->where(['codigo'=>$codigo]);
    $dataProvider_historial = new ActiveDataProvider([
            'query' => $query,
             'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,                        
                    ],
            ],
        ]);
    ?>
    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider_historial,
//        'filterModel' => $searchModel,
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Historial del Registro Sanitario: '.$codigo,
    ],
            'rowOptions'=>function($model){
                        $status = $model->status; 
                         if($status =='ACTIVO'){
                              return ['style' => 'background-color: #DFF0D8;'];
                         }
                         else{
                             return ['style' => 'background-color: #F2DEDE;'];
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
                'format' => 'raw',
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
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
            },            
        ], 
             'status',
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
<?php Pjax::end(); ?></div>


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
  