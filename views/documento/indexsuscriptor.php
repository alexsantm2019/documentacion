<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\alert\Alert;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentoSearch */
/* @var $dataProvider_suscriptor yii\data\ActiveDataProvider */

$this->title = 'Documentos Enviados';

?>


<?php
if($flash = Yii::$app->session->getFlash('success')){
    echo Alert::widget([
    'type' => Alert::TYPE_SUCCESS,
    'title' => 'Felicidades!',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'Tu documento ha sido creado correctamente. .',
    'showSeparator' => true,
    'delay' => 2000
]);
} ?>

 <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="row">
     <div class="col-md-8">
            <h4>INSTRUCCIONES:</h4>
            <p>Si necesita realizar un comentario al <strong>APROBADOR</strong>, haga click en <strong>COMENTAR</strong></p>  <br>
     </div>
          
     <div class="col-md-4" style="text-align: right">
            <p><?= Html::a('Nuevo Documento', ['create'], ['class' => 'btn btn-success']) ?></p>
     </div>
 </div>    


<div class="documento-index">

<!--<div id="tabs-1">-->     
   
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id'=>'module',
        'pjax'=>true,
        'dataProvider' => $dataProvider_suscriptor,
        'filterModel' => $searchModel,
         'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Estado de Documentos Enviados' 
    ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'nombre_archivo',
            'codigo',            
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
 
             'version',
  
          [
            'attribute' => 'estado',
            //'width' => '20px !important',
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
            'filterInputOptions' => ['placeholder' => 'Seleccione..'],
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
                                            ],
                                            ['class'=>'btn btn-warning modalButton', 'title'=>'Editar Documento', ]
                                    ); 
                }                
            },  
        ],             

             ['class' => 'kartik\grid\ActionColumn', 
                'template'=>'{custom_view}',
                'header'=>'Editar',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'buttons' =>                  
                [   
                        'custom_view' => function ($url, $model) {
                                // Html::a args: title, href, tag properties.
                                return Html::a( '<i class="glyphicon glyphicon-pencil"></i>',
                                                        ['documento/update', 'id'=>$model['id'], 'flag'=>'UPDATE'],
//                                                        ['documento/update', 'id'=>$model['id']],
                                                        ['class'=>'btn btn-success', 'title'=>'Editar Documento', ]
                                                );
                        },   
                ],
            ],   
                               
            //modal                    
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
                                                            'flag'=>'SUSCRIPTOR'
                                                        ],
                                                        ['class'=>'btn btn-success btn-md modalButton', 'title'=>'Añade un Comentario', ]
                                                );
                        },
                    ]
            ],                     
                                
                                
                                
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    
</div>


<?php
 yii\bootstrap\Modal::begin([
//        'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-lg',
        'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cerrar</a>',
    ]);
echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();
?>


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

th{
color: #337AB7 !important;
}
</style>    
                                        