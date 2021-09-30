<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AprobadoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aprobadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aprobadores-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aprobadores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                 'label' =>"Aprobador",               
                 'attribute' => 'user_id',
                 'value'=>function($model) {
                   $service = app\models\Profilesoporte::find()->select('full_name')->where(['user_id'=>$model->user_id])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
          ],
            'estado',
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
