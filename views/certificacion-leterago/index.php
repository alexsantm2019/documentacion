<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Alert;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CertificacionLeteragoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Certificacion Leterago';
$this->params['breadcrumbs'][] = $this->title;


if($flash = Yii::$app->session->getFlash('success')){
            echo Alert::widget([
            'type' => Alert::TYPE_SUCCESS,
            'title' => 'Bien Hecho',
            'icon' => 'glyphicon glyphicon-ok-sign',
            'body' => 'Usuario(s) Agregado(s) correctamente',
            'showSeparator' => true,
            'delay' => 8000
        ]);	
    } 
?>
<div class="certificacion-leterago-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nueva Autorización', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading'=>'Usuarios Habilitados para visualizar Certificaciones Leterago' 
    ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'id_usuario',
              [
                 'label' =>"Usuarios Autorizados",               
                 'attribute' => 'id_usuario',
                 'hAlign'=>'center',
                'vAlign'=>'middle',
                 'value'=>function($model) {
                   $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->id_usuario])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Profilesoporte::find()->asArray()->all(), 'id', 'full_name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga..'],    
          ], 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
