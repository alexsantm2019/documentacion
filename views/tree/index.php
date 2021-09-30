<?php
use yii\helpers\Html;
use leandrogehlen\treegrid\TreeGrid;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
?>

<h2>Documentación aprobada</h2>
  <?= TreeGrid::widget([
      'dataProvider' => $dataProvider,
      'keyColumnName' => 'id',
      'parentColumnName' => 'id_original',
      'columns' => [
          'id',
          'nombre_archivo',
//          'estado',
          
          [
                'attribute' => 'path',
                'label' => 'Archivo',
                'format' => 'raw',
                'value' => function($data){
                        $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/documentos';
                        $path = str_replace($basepath, '', $data->path);
                        $nameFichero = substr($data->path, strrpos($data->path, '/'));                                     
                        return  Html::a('Descargar archivo', \yii\helpers\Url::base().'/documentos/'.$nameFichero, ['target'=>'_blank', 'class' => 'linksWithTarget', 'data' => ['pjax' => 0]]);
                },
          ],           
          [
            'attribute' => 'estado',
            //'width' => '20px !important',
            'label' => 'Estado',
            'value' => function($model, $key, $index, $column) {
                $service = app\models\Estado::findOne($model->estado);
                   return $service ? $service->estado : '-';
            },            
          ],               
         'id_original',           
         'version',  
         'fecha_aprobacion',           
          
//          ['class' => 'yii\grid\ActionColumn']
      ]        
  ]); ?>


