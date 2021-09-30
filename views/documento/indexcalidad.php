<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
?>

<?php
$this->title = 'Gestión de Calidad';
?>
<div class ="row">
    <div class="col-lg-8">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-lg-4">
        <div id="leyenda" class="pull-right">
                    <h5 style="color: black;"><strong>Leyenda:</strong></h5>   
                        <div style="background-color:#5FC163; width: 95px; height: 20px; display: inline; color: white; padding: 5px 5px;">Documentos en su última versión</div>
        </div>
    </div>
</div>

<p>Haga click en el link que contiene el nombre del archivo para poder descargarlo</p>
<div class="documento-index">
<?php
echo GridView::widget([
    'dataProvider'=>$dataProvider_calidad,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
     'rowOptions'=>function($model){
                       return ['style' => 'background-color: white;'];                           

        },
    'panel'=>['type'=>'primary', 'heading'=>'Documentos únicos',  'footer'=>false],
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
        'codigo',            
       [
                'attribute' => 'path',
//                'width'=>'60px',
                'label' => 'Descargable',
                'format' => 'raw',
                'value' => function($data){
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                        $path = str_replace($basepath, '', $data->path);
                        $nameFichero = substr($data->path, strrpos($data->path, '/'));                                     
                        return  Html::a($data->nombre_archivo, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
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
          ],  
       [
             'label' =>"Fecha Creación",               
             'attribute' => 'fecha',
             'hAlign'=>'center',
            'vAlign'=>'middle',             
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
          ],  
                     
//          'fecha_aprobacion',
        [
             'label' =>"Fecha Aprobación",               
             'attribute' => 'fecha_aprobacion',
             'hAlign'=>'center',
            'vAlign'=>'middle',             
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
        ], 
                     
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'obs_calidad',
            'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
            'label' => 'Observaciones Calidad',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value' => function($model, $key, $index, $column) {                
                   if(empty($model->obs_calidad)){
                     return ' ';
                   }
                   else{
                       return $model->obs_calidad;
                   }
            },
            'editableOptions' => [
                'header' => 'Observacion',
                'placement'=> 'left',
//                'autotext'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_TEXTAREA,
                'value' => "Raw denim you...",
                'editableValueOptions' => ['class' => 'text-success h4'],
                'data' => ArrayHelper::map(\app\models\Estado::find()->all(), 'id', 'estado'),
            ],        
        ],              
                     
                     
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'estado',
            'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white;'] ,
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
            'editableOptions' => [
                'header' => 'Estado',
                 'placement'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'editableValueOptions' => ['class' => 'text-success h4'],
                'data' => ArrayHelper::map(\app\models\Estado::find()->where(['IN', 'id', [2, 4]])->all(), 'id', 'estado'),
//                'data' => ArrayHelper::map(\app\models\Estado::find()->all(), 'id', 'estado'),
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
//                                                        ['class'=>'btn btn-success btn-md ', 'title'=>'view/edit', ]
                                                );
                        },
                    ]
                ],            
                    
                     
    ],
]);
 ?>
</div>    
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