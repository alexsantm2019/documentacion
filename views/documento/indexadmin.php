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
$this->title = 'Documentos Aprobados (Super Administrador)';
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

<?php
echo GridView::widget([
    'dataProvider'=>$dataProvider_usuarioadmin,
//    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
     'rowOptions'=>function($model){
            return ['style' => 'background-color: #5FC163; color: white;'];                           

        },
    'panel'=>['type'=>'primary', 'heading'=>'Documentos únicos',  'footer'=>false],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
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
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(app\models\Estado::find()->asArray()->all(), 'id', 'estado'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Escoga un Estado'],
              'group'=>true, 
             'contentOptions' => function ($model, $key, $index, $column) {
                       return ['style' => 'color: black'];                                                  
            },         
            'group'=>true,        
        ],
        
        'nombre_archivo',
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
            'label' =>"Aprobado por",               
            'attribute' => 'id_aprobacion',
            'hAlign'=>'center',
            'vAlign'=>'middle',
             'value'=>function($model) {                  
               $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_aprobacion])->asArray()->one();
                 return $service ? $service['full_name'] : '-';
             },
          ],  
                     
          'fecha_aprobacion',
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
    ],
]);
 ?>
<!--/*******************************************************************************************************************************************/-->
<?php
echo GridView::widget([
    'dataProvider'=>$dataProvider_usuario2admin,
//    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'showFooter'=>false,
    
        'rowOptions'=>function($model){
                       $id_original = $model->id_original; 
                       $service = app\models\Documento::find()->where(['id_original'=>$id_original])->orderBy(['id' => SORT_DESC])->limit(1)->asArray()->one();
                       if($service['id'] == $model->id){
                       return ['style' => 'background-color: #5FC163; color: white;'];                           

                        }
      
                       },
    
    'panel'=>['type'=>'primary', 'heading'=>'Documentos versionados', 'footer'=>false],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
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
              'group'=>true,               
        ],
 
        'version',             
        [
            'attribute' => 'id_original',
            //'width' => '20px !important',
            'label' => 'Versiones',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            //            'filterInputOptions'=>['placeholder'=>'Escoga una Zona...'],
            'value' => function($model, $key, $index, $column) {
                   return $model->nombre_archivo;
            },
        ],
 
       [
                'attribute' => 'path',
                'label' => 'Descargable',
                'format' => 'raw',
                'value' => function($data){
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                        $path = str_replace($basepath, '', $data->path);
                        $nameFichero = substr($data->path, strrpos($data->path, '/'));                                     
                        //return  Html::a($nameFichero, \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
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
//                 print_r($model->id_usuario); die();     
               $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_usuario])->asArray()->one();
                 return $service ? $service['full_name'] : '-';
             },
          ], 
           [
            'label' =>"Aprobado por",               
            'attribute' => 'id_aprobacion',
            'hAlign'=>'center',
            'vAlign'=>'middle',
             'value'=>function($model) {                  
               $id_documento = $model->id; 
               $service = app\models\Aprobacion::find()->select('id_aprobador')->where(['id_documento'=>$id_documento])->asArray()->one();
               $id_aprobador = $service['id_aprobador'];               
               $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$id_aprobador])->asArray()->one();
                 return $service ? $service['full_name'] : '-';
             },
          ],           
          'fecha_aprobacion',
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

    ],
]);
 ?>


<style>

    .kv-page-summary-container{
        display:none;
    }
    
    .container{
        width:90%;
    }

</style>    