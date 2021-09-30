<?php

use leandrogehlen\treegrid\TreeGrid;
?>
<?= TreeGrid::widget([
    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'id',
    'parentRootValue' => '0', //first parentId value
    'pluginOptions' => [
        'initialState' => 'collapsed',
    ],
    'columns' => [
        'id',
        'nombre_archivo',
        'id_categoria',
        ['class' => 'yii\grid\ActionColumn']
    ]     
]); ?>
