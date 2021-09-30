<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Aprobadores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aprobadores-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <?= $form->field($model, 'user_id')->label('Seleccione un Aprobador:')
        ->dropDownList(
                    ArrayHelper::map(app\models\Profilesoporte::find()->orderby('full_name')
                    ->all(),'user_id','full_name')
                    ,['prompt' => '--Seleccione un Aprobador--']) 
    ?>  


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
