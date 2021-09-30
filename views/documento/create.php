<?php

use yii\helpers\Html;
use kartik\widgets\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\Documento */


    $flag = Yii::$app->request->get('flag'); 
    if($flag){
        $this->title = 'Editar Documento';
    }
    else{
        $this->title = 'Nuevo Documento';
    }
    
    if($flash = Yii::$app->session->getFlash('error')){ 
            echo Alert::widget([
            'type' => Alert::TYPE_DANGER,
            'title' => 'Atención',
            'icon' => 'glyphicon glyphicon-remove-sign',
            'body' => 'El código ingresado ya existe. Si desea ingresar un documento con el mismo código, debe realizar una nueva VERSION DEL DOCUMENTO',
            'showSeparator' => true,
            'delay' => 8000
        ]);	
    } 
                                               
?>
<div class="documento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
