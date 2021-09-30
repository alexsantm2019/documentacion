<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use kartik\widgets\Alert;
?>

<?php
$this->title = 'Documentos a Publicar';
?>
<div class ="row">
    <div class="col-lg-8">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>

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
            'type' => Alert::TYPE_DANGER,
            'title' => 'Atención',
            'icon' => 'glyphicon glyphicon-remove-sign',
            'body' => 'No se puede actualizar por lo siguiente:<br>'.$exampleEncoded,
            'showSeparator' => true,
            'delay' => 8000
        ]);	
    }     
?>
<h4>Insrucciones:</h4>
<li>Haga click en el link que contiene el nombre del archivo para poder descargarlo</li>
<li>Si necesita añadir un COMENTARIO, haga click en el ícono COMENTAR</li>
<li>Puede editar el número de copias y Detalle copias si fuera necesario</li><br>

<div class="documento-index">
<?php
echo GridView::widget([
     'id'=>'module',
    'dataProvider'=>$dataProvider_publicador,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>['type'=>'primary', 'heading'=>'Documentos únicos'],
    'columns'=>[
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
                        //return  Html::a($data->nombre_archivo, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                        return  Html::a('Descargar', \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
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
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_custodio',
            'contentOptions' => ['style'=>'background-color: #F0AD4E !important; color: white !important;'] ,
            'label' => 'Custodio',
            'hAlign' => 'center',
            'vAlign' => 'middle',
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
             'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->orderBy('full_name')->asArray()->all(), 'user_id', 'full_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Seleccione....'],        
        ],              
  
            [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'copias',
            'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
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
            'contentOptions' => ['style'=>'background-color: #5BC0DE !important;'] ,
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
//                                                            'membrete' =>'Publicador',
                                        ],
                                        ['class'=>'btn btn-warning modalButton', 'title'=>'Editar Documento', ]
                                ); 
                }                
            },  
        ],               
   
                    //modal                    
             ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Detalles',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'contentOptions' => ['style'=>'background-color: #5CB85C !important; color: white;'] ,
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
                                
               ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                   'contentOptions' => function ($model, $key, $index, $column) {
                       return ['style' => 'background-color: white'];                           
                       
                    },
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
                                                            'flag'=>'PUBLICADOR'
                                                        ],
                                                        ['class'=>'btn btn-success btn-md modalButton', 'title'=>'Añade un Comentario', ]
                                                );
                        },
                    ]
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
                'data' => ArrayHelper::map(\app\models\Estado::find()->where(['IN', 'id', [2,5]])->all(), 'id', 'estado'),
            ],        
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
        'size' => 'modal-md',
        'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cerrar</a>',
    ]);
echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

?>

<style>
        .kv-page-summary-container{
               display:none;
           }

           .container{
               width:99%;
           }

           .kv-grid-group{
               color: black !important;
           }

           th{
        color: #337AB7 !important;
    } 
</style>    