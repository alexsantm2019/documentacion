<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
?>

<?php
$this->title = 'Consulta y Baja de Documentos';
?>
<div class ="row">
    <div class="col-lg-8">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-lg-4">
        <div id="leyenda" class="pull-right">
                    <h5 style="color: black;"><strong>Leyenda:</strong></h5>   
                        <div style="background-color:#5FC163; width: 95px; height: 20px; display: inline; color: white; padding: 5px 5px;">Documentos Publicados</div>
        </div>
    </div>
</div>

<!--<p>Haga click en el link que contiene el nombre del archivo para poder descargarlo</p>-->
<div class="documento-index">
<?php    
//print_r($searchModel); 
echo GridView::widget([
    'id'=>'module',
    'dataProvider'=>$dataProvider_estado,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
//    'hover'=>true,
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
    'panel'=>['type'=>'primary', 'heading'=>'Documentos',  'footer'=>true],
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
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'estado',
            'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white !important; padding: 5px 5px;'] ,
            'label' => 'Estado',                
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'filter' => false,    
            //            'filterInputOptions'=>['placeholder'=>'Escoga una Zona...'],
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
            },            
            'filterInputOptions' => ['placeholder' => 'Escoga..'],                        
            'editableOptions' => [
                'header' => 'Estado',
                'placement'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => ArrayHelper::map(\app\models\Estado::find()->all(), 'id', 'estado'),
            ],        
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
                                
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{delete}',
                ],
    ],
]);
 ?>
</div>    
<!--/*******************************************************************************************************************************************/-->
<!--/*******************************************************************************************************************************************/-->

<?php
 yii\bootstrap\Modal::begin([
//        'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-lg',
    ]);
echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

?>

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