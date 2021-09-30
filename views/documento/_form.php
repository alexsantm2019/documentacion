<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use kartik\widgets\TouchSpin;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="documento-form" >    
    <?php 
    $id_usuario = Yii::$app->user->identity['id'];

//    $form = ActiveForm::begin(); 
     $form = ActiveForm::begin([
            'options' => [ 'enctype' => 'multipart/form-data']
    ]);
    ?>
    
    <?php
    $flag = Yii::$app->request->get('flag'); 
   ?>
    
    <div class="row" style ="border-style: ridge ; border-radius: 25px;; padding: 15px 15px;">
    
                    <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'codigo')->label("Ingrese el Código Manual:")->textInput(['maxlength' => true, 'placeholder' => "Ingrese el Código Manual (Ej. SIS-POE-PRO-055)"]) ?>   
                            </div>
                    </div><br>    

                      <div class="row">
                          <div class="col-md-4">    
                                    <?php
                                           echo $form->field($model, 'id_departamento')->label('Seleccione un Departamento:')
                                            ->dropDownList(
                                                    ArrayHelper::map(\app\models\Departamento::find()->all(), 'id', 'departamento'),
                                                    ['prompt' => '--Seleccione un Departamento--', 
                                                                         //'class'=>'adjust',
                                                          'onchange'=>'
                                                                    $.post("'.Yii::$app->urlManager->createUrl('codificacion/lists?id=').
                                                                  '"+$(this).val(),function( data ) 
                                                   {
                                                              $( "select#departamento_id" ).html( data );
                                                            });
                                                        ']
                                            )
                                    ?>
                          </div>    

                          <div class="col-md-4">  
                              <?php
                                        $dataPost=ArrayHelper::map(\app\models\Categoria::find()->asArray()->all(), 'id', 'categoria');
                                                 echo $form->field($model, 'id_categoria')
                                                       ->dropDownList(
                                                           $dataPost,  
                                                            ['id'=>'departamento_id', 'prompt'=>'--Seleccione una Categoria--']
                                                       )->label('Seleccione una Categoria');
                              ?>   
                        </div>  

                        <div class="col-md-4">                   
                                    <?= $form->field($model, 'id_tipo')->label('Seleccione un Tipo:')
                                           ->dropDownList(
                                                       ArrayHelper::map(app\models\Tipo::find()
                                                       ->all(),'id','tipo')
                                                       ,['prompt' => '--Seleccione un Tipo--']) 
                                    ?> 
                        </div>  
                  </div>            
            
    </div><br> 
    
            
    <div class="row" style ="border-style: ridge ; border-radius: 25px;; padding: 20px 20px;">
    
    <div class="col-md-6">     
            <?= $form->field($model, 'nombre_archivo')->label('Nombre del Documento:')->textInput(['maxlength' => true, 'placeholder' => "Ingrese el nombre del Documento", 'style' => 'text-transform: uppercase', ]) ?>       
    </div>  
    
    <div class="col-md-6">     
            <?= $form->field($model, 'version')->textInput(['maxlength' => true, 'placeholder' => "Ingrese la versión del Documento"]) ?>    
    </div>  
    
    <div class="col-md-6">     
                <?php
                $aprobadores = (new \yii\db\Query())
                ->select(["p.user_id as user_id", "p.full_name as full_name"])
                ->from('soporte.profile p, aprobadores a')
                ->where('a.user_id = p.user_id')
                ->orderBy('full_name')
                ->all();

                $data = ArrayHelper::map($aprobadores, 'user_id', 'full_name');    
                ?> 
                <?=
                $form->field($model, 'id_aprobacion')->label('Aprobador del Documento:')
                   ->dropDownList($data,['prompt' => '--Seleccione quien Aprobará el Documento--'])             
               ?>
    </div>  
    
        <div class="col-md-6">
                        <?= $form->field($model, 'path')->label('Seleccione el Documento:')->widget(\kartik\widgets\FileInput::classname(),[
                    'pluginOptions' => [
                    'showRemove' => true,
                    'showUpload' => false,
                    'browseLabel' =>  'Seleccione Archivo'
                    ]
                    ])
                ?>
                	
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model,'copias')->label('Número de copias Controladas')->hint('ATENCION: Si solo requiere el documento ORIGINAL, coloque 0')->widget(TouchSpin::className(),[  
                           //'readonly' => true,
                           'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                           'pluginOptions' => [        
                           'buttonup_class' => 'btn btn-primary', 
                           'buttondown_class' => 'btn btn-info', 
                           'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                           'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                       ],
                   ]) 
               ?>
            
            
        </div>
        <div class="col-md-6">    
                <?=
                          $form->field($model, 'detalle_copias')->label('Detalle de Copias Controladas:')->hint('ATENCION: Si es documento ORIGINAL, escriba "ORIGINAL"')->widget(CKEditor::className(), [
                              'options' => ['rows' => 1],
                             // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                              'preset' => 'basic',
                              'clientOptions' => [
                                  'allowedContent' => true,
                              ],
                          ])
               ?>
       </div>     
                
    <?= $form->field($model, 'id_usuario')->hiddenInput(['value'=>$id_usuario])->label(false); ?>
   
    <div class="col-md-12">  
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear Documento' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>    

    <?php ActiveForm::end(); ?>
</div>



</div>


<?php
 yii\bootstrap\Modal::begin([
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-lg',
        'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cerrar</a>',
]);
echo "<div class='modalContent'></div>";
yii\bootstrap\Modal::end();

?>


<style>
    .vertical-align {
   -webkit-box-align : center;
  -webkit-align-items : center;
       -moz-box-align : center;
       -ms-flex-align : center;
          align-items : center;
}
</style>    


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
</script>
