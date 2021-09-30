<?php

use app\models\Profile;

    use yii\helpers\Html;
    //use yii\grid\GridView;
    use yii\widgets\Pjax;
    use kartik\grid\GridView;
    use kartik\grid\EditableColumnAction;
    use kartik\editable\Editable;
    use yii\helpers\ArrayHelper;

$this->title = 'Auditoria';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auditoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'rowOptions' => function ($model) {

            // return ['style' => 'background-color: #5FC163; color: white;'];
        },
        'panel' => ['type' => 'primary', 'heading' => 'Registros de auditoría',  'footer' => false],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'audUsuarioLogueado',
                'label' => 'Responsable',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    $service = app\models\Profile::findOne($model->audUsuarioLogueado);
                    return $service ? $service->full_name : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Profile::find()->asArray()->all(), 'id', 'full_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga un Autor'],
                'group' => true,
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'color: black'];
                },
                'group' => false,
            ],
            'audFlag',
            'audAccion',
            'audDetalle',
            [
                'attribute' => 'audFecha',
                'label' => 'A partir de..',
                'filterType' => GridView::FILTER_DATE,
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'width' => '20%',
                'value' => function ($model, $index, $widget) {
                    return date('Y-m-d H:i:s', strtotime($model->audFecha));
                },
                'headerOptions' => ['class' => 'kv-sticky-column'],
                'contentOptions' => ['class' => 'kv-sticky-column'],
                'filterWidgetOptions' => [
                    'convertFormat' => false,
                    'options' => ['placeholder' => 'Seleccione'], //this code not giving any changes in browser
                    'type' => kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND, //this give error Class 'DatePicker' not found
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'locale' => ['format' => 'Y-m-d H:i:s'],
                    ],
                ],
            ],                      
            'audIp',
            [
                'attribute' => 'audDocumentoId',
                'label' => 'Código de Documento',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    $service = app\models\Documento::findOne($model->audDocumentoId);
                    return $service ? $service->codigo : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Documento::find()->asArray()->all(), 'id', 'codigo'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga un Documento por código'],
                'group' => true,
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['style' => 'color: black'];
                },
                'group' => false,
            ],               

        ],
    ]);
    ?>


    <?php Pjax::end(); ?>
</div>