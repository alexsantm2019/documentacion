<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumnAction;
//use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use kartik\editable\Editable;
?>

<?php
$this->title = 'Solicitudes de Cambio';
?>
<div class ="row">
    <div class="col-lg-8">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-lg-4">
        <div id="leyenda" class="pull-right">
                    <h5 style="color: black;"><strong>Leyenda:</strong></h5>   
                        <div style="background-color:#5FC163; width: 95px; height: 20px; display: inline; color: white; padding: 5px 5px;">Documento publicado</div>
        </div>
    </div>
</div>

<h4>Instrucciones:</h4>
<li>Ingrese el nombre del Documento</li>
<li>En la columna USUARIO, escoga el nombre del nuevo Propietario</li><br>
<div class="documento-index">
<?php
echo GridView::widget([
    'dataProvider'=>$dataProvider_solicitud,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
     'rowOptions'=>function($model){
                        $estado = $model->estado; 
                         if($estado == 5){
                             return ['style' => 'background-color: #5FC163; color: white;'];
                         }
        },
    'panel'=>['type'=>'primary', 'heading'=>'Nuevas Solicitudes de Cambio',  'footer'=>false],
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
             'contentOptions' => function ($model, $key, $index, $column) {
                       return ['style' => 'color: black'];                                                  
            },         
            'group'=>true,        
        ],
        
//        'nombre_archivo',
        [
            'attribute' => 'nombre_archivo',
            //'width' => '20px !important',
            'label' => 'Nombre del Archivo',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'filter' => true,        
//            'filterType' => GridView::FILTER_SELECT2,
            'filterInputOptions' => [
                'class'       => 'form-control',
                'placeholder' => 'Ingrese el Nombre del Documento...'
             ]           
        ],              
                    
                    
        'codigo',            
       [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_usuario',
            'contentOptions' => ['style'=>'background-color: #F0AD4E !important;'] ,
            'label' => 'Usuario',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'format'=>'raw',
            'filter'=>false,
            'value' => function($model, $key, $index, $column) {                
                   $service = app\models\Profilesoporte::findOne($model->id_usuario);
                   return $service ? $service->full_name : '-';
            },
            'editableOptions' => [
                'header' => 'Estado',
                'placement'=> 'left',
                'format' => Editable::FORMAT_BUTTON,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => ArrayHelper::map(\app\models\Profilesoporte::find()->orderBy('full_name')->all(), 'user_id', 'full_name'),
                'editableValueOptions' => ['class' => 'text-success h4'],
            ],      
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