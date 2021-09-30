<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Gestión Documental - Química Ariston';
?>
<div class="site-index">

    <div class="jumbotron">
        <!--<h1>Gestión Documental - Química Ariston</h1>-->
        <div class="row">            
            <h1><?php echo Html::img('@web/images/main_logo.png', ['alt' => 'My logo']);?></h1>
            <h5 class="elegantshadow">Gestión Documental</h5>     
    </div>
</div>


<?php 
$rol = Yii::$app->user->identity['role_id'];
/****************** TRAIGO EL NOMBRE A PARTIR DEL USUARIO*********************/
$id = Yii::$app->user->identity['id'];
$sql = "select p.full_name FROM
soporte.user u, soporte.profile p
where 
u.id = p.user_id
and u.id = ('$id')";
$data = Yii::$app->getDb()
->createCommand($sql)
->queryAll();
foreach($data as $d){
 $nombre = $d['full_name'];
}  
//                   print_r($nombre);
/****************** FIN TRAIGO EL NOMBRE A PARTIR DEL USUARIO*********************/ 
if((Yii::$app->user->identity['role_id']==1) || (Yii::$app->user->identity['role_id']==2) || (Yii::$app->user->identity['role_id']==3 ) || (Yii::$app->user->identity['role_id']==4 ) || (Yii::$app->user->identity['role_id']==7 )){
    ?> 
    <?php  print_r("<center><h1>Bienvenid@ ".$nombre."</h1></center>");?>
    <?php
}
else{
    ?>   
    <center><h2>Para iniciar sesión, logueate <?= Html::a('Aqui', Url::toRoute(['user/login', 'param' => 'value']), ['data-method' => 'post']) ?></h2></center>
    <center><h2>¿No te has registrado? Hazlo <?= Html::a('Aqui', Url::toRoute(['user/login', 'param' => 'value']), ['data-method' => 'post']) ?></h2></center>
    <?php
}
?>
    <div class="body-content">
        <div class="row">
            <?php
            if(($rol ==3)|| ($rol ==1)){ //Agente
                ?>    
                <div class="col-lg-6">                
                    <h2 style="text-shadow: 0.1em 0.1em 0.15em #333;">Documentos Disponibles</h2>
                    <p>Desde aquí puedes revisar y descargar la documentación aprobada en su versión final.</p>
                    <p><a class="btn btn-danger btn-lg" href=" <?= Url::toRoute(['documento/indexusuario']) ?> ">Documentos Disponibles &raquo;</a></p>
                </div>                                                                                                                                           

                <div class="col-lg-6">                
                    <h2 style="text-shadow: 0.1em 0.1em 0.15em #333;">Crear Nuevo Documento</h2>
                    <p>Puede crear un nuevo documento, el mismo que será enviado a un Aprobador para su revisión.</p>                
                    <p><a class="btn btn-success btn-lg" href=" <?= Url::toRoute(['documento/create']) ?> ">Nuevo Documento &raquo;</a></p>
                </div>
                <?php
            }
            else if($rol == 2){
                ?>
                <div class="col-lg-4"></div>
                <div class="col-lg-4 ">
                    <h2 style="text-shadow: 0.1em 0.1em 0.15em #333;">Documentos Disponibles</h2>
                    <p>Desde aquí puedes revisar y descargar la documentación aprobada en su versión final.</p>
                    <p><a class="btn btn-danger btn-lg col-md-offset-2" href=" <?= Url::toRoute(['documento/indexusuario']) ?> ">Documentos Disponibles &raquo;</a></p>
                </div>
                <div class="col-lg-4"></div>            
                <?php
            }
            ?>
        </div>
    </div>        

</div>

<style>

h5.elegantshadow {
    color: #131313;
    background-color: #e7e5e4;
    letter-spacing: .15em;
    text-shadow: 1px -1px 0 #767676, -1px 2px 1px #737272, -2px 4px 1px #767474, -3px 6px 1px #787777, -4px 8px 1px #7b7a7a, -5px 10px 1px #7f7d7d, -6px 12px 1px #828181, -7px 14px 1px #868585, -8px 16px 1px #8b8a89, -9px 18px 1px #8f8e8d, -10px 20px 1px #949392, -11px 22px 1px #999897, -12px 24px 1px #9e9c9c, -13px 26px 1px #a3a1a1, -14px 28px 1px #a8a6a6, -15px 30px 1px #adabab, -16px 32px 1px #b2b1b0, -17px 34px 1px #b7b6b5, -18px 36px 1px #bcbbba, -19px 38px 1px #c1bfbf, -20px 40px 1px #c6c4c4, -21px 42px 1px #cbc9c8, -22px 44px 1px #cfcdcd, -23px 46px 1px #d4d2d1, -24px 48px 1px #d8d6d5, -25px 50px 1px #dbdad9, -26px 52px 1px #dfdddc, -27px 54px 1px #e2e0df, -28px 56px 1px #e4e3e2;
}
h5 {
    font-family: "Avant Garde", Avantgarde, "Century Gothic", CenturyGothic, "AppleGothic", sans-serif;
    font-size: 85px;
    /*padding: 60px 30px;*/
    text-align: center;
    text-transform: uppercase;
    text-rendering: optimizeLegibility;
}

.wrap > .container {
    width: 90%;
}

                </style>    