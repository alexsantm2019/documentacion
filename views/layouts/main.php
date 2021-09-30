<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<!--<link rel="shortcut icon" href="<?php // echo Yii::$app->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />-->
<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    
    
    /******************************************* CONFIGURACION DE MENU SEGUN ROL *************************************************/    

     
    $id_usuario = Yii::$app->user->identity['id'];
    $rol = Yii::$app->user->identity['role_id'];
    
    $rol_soporte = \app\models\Usersoporte::find()->select(['role_id'])->where(['id'=>$id_usuario])->asArray()->one();
    
    /************************************************** SI EL USUARIO LOGUEADO PERTENECE AL GRUPO DE APROBADORES***************************************/
    $aprobadores = \app\models\Aprobadores::find()->select(['user_id'])->where(['user_id'=>$id_usuario])->asArray()->all();
    if((!empty($aprobadores)) &&($rol == 2) ||($rol == 3)){
        $items[] = ['label' => '<i class="glyphicon glyphicon-file"></i> Opciones de Aprobación',    
        'items' => [     
                ['label' => '<i class="glyphicon glyphicon-ok"></i> Aprobar Documentos', 'url' => ['/documento/index']],
                ['label' => '<i class="glyphicon glyphicon-check"></i> Autorizar Documentos', 'url' => ['aprobacion/index']],
        ],
            ];
    }
    /************************************************** SI EL USUARIO LOGUEADO PERTENECE AL GRUPO DE APROBADORES***************************************/
    

if($rol == 1){ //Admin
//        $items[] = ['label' => '<i class="glyphicon glyphicon-cloud-upload"></i> Control de Documentos', 'url' => ['documento/indexcalidad'],'visible' => Yii::$app->user->identity['id']==36 ];                
         $items[] = ['label' => '<i class="glyphicon glyphicon-cog"></i> Configuración', 'visible' => Yii::$app->user->can("admin"),
        'items' => [  
                ['label' => 'GENERAL:'],
                ['label' => '<i class="glyphicon glyphicon-th-large"></i>Categoria', 'url' => ['/categoria/index']],                                     
                ['label' => '<i class="glyphicon glyphicon-th"></i>Tipo', 'url' => ['/tipo/index']],  
                ['label' => '<i class="glyphicon glyphicon-user"></i> Usuarios Certificaciones', 'url' => ['/certificacion-leterago/index']], 
        ],
        ];
        $items[] = ['label' => '<i class="glyphicon glyphicon-search"></i> Auditoria', 'url' => ['auditoria/index']];    
        $items[] = ['label' => '<i class="glyphicon glyphicon-cloud-upload"></i> Publicaciones',  'visible' => Yii::$app->user->identity['id']==36,  //Alex Renteria
        'items' => [     
                ['label' => '<i class="glyphicon glyphicon-open-file"></i> Publicar Documento', 'url' => ['documento/indexpublicador'] ],
                ['label' => '<i class="glyphicon glyphicon-folder-close"></i> Estado Documentos', 'url' => ['/documento/indexestado']],
                ['label' => '<i class="glyphicon glyphicon-copy"></i> Solicitud de Cambio', 'url' => ['/documento/indexsolicitud']],
                 '<li class="divider"></li>', 
                ['label' => '<i class="glyphicon glyphicon-save"></i> Administración de Descargas', 'url' => ['/descargas/index']], 
                ['label' => '<i class="glyphicon glyphicon-check"></i> Autorizar todos los Documentos', 'url' => ['aprobacion/indexpublicador']],
                ['label' => '<i class="glyphicon glyphicon-user"></i> Aprobadores',  'url' => ['/aprobadores/index']],  
        ],
    ];  
       
        $items[] = ['label' => '<i class="glyphicon glyphicon-file"></i> Administrar Documentos',    
        'items' => [     
                ['label' => '<i class="glyphicon glyphicon-pencil"></i> Nuevo Documento', 'url' => ['documento/create'] ],
                ['label' => '<i class="glyphicon glyphicon-ok"></i> Aprobar Documentos', 'url' => ['/documento/index']],
                ['label' => '<i class="glyphicon glyphicon-check"></i> Autorizar Documentos', 'url' => ['aprobacion/index']],
                ['label' => '<i class="glyphicon glyphicon-search"></i> Documentos con Observaciones', 'url' => ['/documento/indexsuscriptor']],
                ['label' => '<i class="glyphicon glyphicon-floppy-remove"></i> Estado y Baja de Documentos', 'url' => ['/documento/indexconsulta']],
        ],
            ];
        $items[] = ['label' => '<i class="glyphicon glyphicon-folder-open"></i> Documentos disponibles', 'url' => ['documento/indexusuario'] ];                 
        $items[] = ['label' => '<i class="glyphicon glyphicon-user"></i> Opciones de Usuario', 'visible' => Yii::$app->user->can("admin"),
        'items' => [                        
                ['label' => 'Cambio de Contraseña', 'url' => ['/user/account']],
                ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],        
        ],
            ];                 
}

else if ($rol == 2) { //Usuario
                $items[] = ['label' => '<i class="glyphicon glyphicon-open"></i> Documentos disponibles', 'url' => ['documento/indexusuario'] ];                     
                $items[] = ['label' => '<i class="glyphicon glyphicon-user"></i> Opciones de Usuario', 'visible' => Yii::$app->user->can("admin"),    
                            'items' => [                        
                                    ['label' => 'Perfil de Usuario', 'url' => ['/user/profile']],            
                                    ['label' => 'Cambio de Contraseña', 'url' => ['/user/account']],
                                    ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                                            'url' => ['/user/logout'],
                                            'linkOptions' => ['data-method' => 'post']],
                                    ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],        
                            ],
                ]; 
}

else if($rol == 3){ //suscriptor - Agente
  
//$items[] = ['label' => '<i class="glyphicon glyphicon-cloud-upload"></i> Publicaciones', 'url' => ['documento/indexpublicador'],'visible' => Yii::$app->user->identity['id']==21 ];                

$items[] = ['label' => '<i class="glyphicon glyphicon-cloud-upload"></i> Publicaciones',  'visible' => Yii::$app->user->identity['id']==21,  //Giss
        'items' => [     
                ['label' => '<i class="glyphicon glyphicon-open-file"></i> Publicar Documento', 'url' => ['documento/indexpublicador'] ],
                ['label' => '<i class="glyphicon glyphicon-folder-close"></i> Estado Documentos', 'url' => ['/documento/indexestado']],
                ['label' => '<i class="glyphicon glyphicon-copy"></i> Solicitud de Cambio', 'url' => ['/documento/indexsolicitud']],
             '<li class="divider"></li>', 
                ['label' => '<i class="glyphicon glyphicon-save"></i> Administración de Descargas', 'url' => ['/descargas/index']], 
                ['label' => '<i class="glyphicon glyphicon-check"></i> Autorizar todos los Documentos', 'url' => ['aprobacion/indexpublicador']],
                ['label' => '<i class="glyphicon glyphicon-user"></i> Aprobadores',     'url' => ['/aprobadores/index']],     
        ],
    ];   


 $items[] = ['label' => '<i class="glyphicon glyphicon-file"></i> Administrar Documentos',  'visible' => Yii::$app->user->identity['id']==7,    //Hernan Paz
        'items' => [     
                ['label' => '<i class="glyphicon glyphicon-pencil"></i> Nuevo Documento', 'url' => ['documento/create'] ],
                ['label' => '<i class="glyphicon glyphicon-ok"></i> Aprobar Documentos', 'url' => ['/documento/index']],
                ['label' => '<i class="glyphicon glyphicon-check"></i> Autorizar Documentos', 'url' => ['aprobacion/index']],                
        ],
            ]; 


//$items[] = ['label' => '<i class="glyphicon glyphicon-cloud-upload"></i> Control de Documentos', 'url' => ['documento/indexcalidad'],'visible' => Yii::$app->user->identity['id']==36 ];                
     $items[] = ['label' => '<i class="glyphicon glyphicon-folder-open"></i> Documentos disponibles', 'url' => ['documento/indexusuario'] ]; 
     
     $items[] = ['label' => '<i class="glyphicon glyphicon-file"></i> Administrar Documentos',    
        'items' => [     
                ['label' => '<i class="glyphicon glyphicon-pencil"></i> Nuevo Documento', 'url' => ['documento/create'] ],
                ['label' => '<i class="glyphicon glyphicon-search"></i> Documentos con Observaciones', 'url' => ['/documento/indexsuscriptor']],
                ['label' => '<i class="glyphicon glyphicon-check"></i> Versionador', 'url' => ['documento/indexversionador']],
        ],
    ];     
     $items[] = ['label' => '<i class="glyphicon glyphicon-user"></i> Opciones de Usuario',    
        'items' => [                        
                ['label' => 'Cambio de Contraseña', 'url' => ['/user/account']],
                ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],        
        ],
            ]; 
}

else if ($rol == 4) { //SuperAdmin     
     $items[] = ['label' => '<i class="glyphicon glyphicon-cog"></i> Configuración', 'visible' => Yii::$app->user->can("admin"),
        'items' => [  
                ['label' => 'GENERAL:'],
                ['label' => 'Departamentos', 'url' => ['/departamento/index']],                                        
                ['label' => 'Categoria', 'url' => ['/categoria/index']],                                     
                ['label' => 'Tipo', 'url' => ['/tipo/index']],                                                        
                ['label' => 'Codificación', 'url' => ['/codificacion/index']],                                        
                ['label' => 'Estados', 'url' => ['/estado/index']],                                        
                ['label' => 'Aprobadores', 'url' => ['/aprobadores/index']],                                        
                ['label' => 'Audiencia Certificados Leterago', 'url' => ['/certificacion-leterago/index']],                                        
                
        ],
        ];
    $items[] = ['label' => '<i class="glyphicon glyphicon-open"></i> Documentos disponibles', 'url' => ['documento/indexadmin'] ];
    $items[] = ['label' => '<i class="glyphicon glyphicon-search"></i> Auditoria', 'url' => ['auditoria/index']];    
    $items[] =[ 'label' =>'<i class="glyphicon glyphicon-folder-close"></i> Estado Documentos', 'url' => ['/documento/indexsuperadmin']];
     $items[] = ['label' => '<i class="glyphicon glyphicon-user"></i> Opciones de Usuario',    
        'items' => [                        
                ['label' => 'Cambio de Contraseña', 'url' => ['/user/account']],
                ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],        
        ],
            ]; 
}

else if ($rol == 7) { //Proveedores
    $items[] = ['label' => '<i class="glyphicon glyphicon-open"></i> Documentos disponibles', 'url' => ['documento/indexusuario'] ];    
     $items[] = ['label' => '<i class="glyphicon glyphicon-user"></i> Opciones de Usuario',    
        'items' => [                        
                ['label' => 'Cambio de Contraseña', 'url' => ['/user/account']],
                ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],        
        ],
            ]; 
}


    $items[] = ['label' => '<i class="glyphicon glyphicon-log-in"></i> Loguearse', 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest] ;
    $items[] = ['label' => '<i class="glyphicon glyphicon-pencil"></i> Registrarse', 'url' => ['/user/register'], 'visible' => Yii::$app->user->isGuest];

    NavBar::begin([
        'brandLabel' => '<i class="glyphicon glyphicon-home"></i> Inicio',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',            
        ],
    ]);


echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
    'encodeLabels' => false,
]);
  NavBar::end();  
    
/******************************************* FIN CONFIGURACION DE MENU SEGUN ROL *************************************************/  
    
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Química Ariston <?= date('Y') ?></p>

        <p class="pull-right"><?php echo("Desarrollado por: Departamento de Sistemas");?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



<style>
    .dropdown-header{
        /*background-color: #3D89CE;*/
        color:black;
        font-weight: bold;
        text-decoration: underline;
    }
</style>   