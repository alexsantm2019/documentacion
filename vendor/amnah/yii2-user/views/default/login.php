<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row " style="margin-top:50px;">

        <div class="col-md-3"></div>

        <div class="col-md-6">
            <center>
            <div class="user-default-login">
                
                <center style="margin-top:30px; margin-bottom: 10px;">
                    <h1><?php echo Html::img('@web/images/main_logo.png', ['alt' => 'My logo']);?></h1>
                    
                    
                </center>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-offset-2 col-lg-8\">{input}</div>\n<div class=\"col-lg-offset-2 col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 control-label'],
//            'labelOptions' => ['class' => 'col-lg-12 control-input'],
                    ],

                ]); ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => "Ingrese su usuario"])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput()->textInput(['placeholder' => "Ingrese su contraseña", 'type' => "password"])->label(false) ?>                

                <div class="form-group">
                    <center>
                    <div class="col-lg-offset-2 col-lg-8">
                        <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-block btn-primary']) ?>
                    </div>
                        <br/><br/><br/><br/>
                        <?= Html::a(Yii::t("user", "Register"), ["/user/register"]) ?> /
                        <?= Html::a(Yii::t("user", "Forgot password") . "?", ["/user/forgot"]) ?> /
                        <?= Html::a(Yii::t("user", "Resend confirmation email"), ["/user/resend"]) ?>
                    
                </center>
                </div>

                <?php ActiveForm::end(); ?>

                <?php if (Yii::$app->get("authClientCollection", false)): ?>
                    <div class="col-lg-offset-2 col-lg-10">
                        <?= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['/user/auth/login']
                        ]) ?>
                    </div>
                <?php endif; ?>

<!--    <div class="col-lg-offset-2" style="color:#999;">
        You may login with <strong>neo/neo</strong>.<br>
        To modify the username/password, log in first and then <?php // HTML::a("update your account", ["/user/account"]) ?>.
    </div>-->
        </center>
    </div>
</div>


<div class="col-md-3"></div>

</div> 

</div>    


<style>
.user-default-login{
    padding: 5px 5px;                
    vertical-align:middle;
    display: block;
}

.form-horizontal .control-label {
    text-align: left !important;
}

</style>    