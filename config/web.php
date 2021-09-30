<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'America/Guayaquil',
    'language' => 'es-ES',
    'bootstrap' => ['log'],
    'components' => [
	
	'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => true,
//            'messageConfig' => [
//                'from' => ['admin@website.com' => 'Admin'], // this is needed for sending emails
//                'charset' => 'UTF-8',
//            ]
//        ],
        
        
                //        AGREGADOS ULTIMAMENTE

        
       'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@app/mail',
            'messageConfig' => [
                'from' => 'soporte@qariston.com' // sender address goes here
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '192.168.0.254',
                'username' => 'informatica',
                'password' => 'INFORMATICA2017**',
                'port' => '25',
            ],
        ],
        
        
        
	
	
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VnCRN52xhLNb1FhMBLx95kGibEe_lgdn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => true,
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'db2' => require(__DIR__ . '/db2.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
              'urlManager' => [
            'class' => 'yii\web\UrlManager', //clase UrlManager
            'showScriptName' => false, //eliminar index.php
            'enablePrettyUrl' => true, //urls amigables   
            'enableStrictParsing' => false,
          'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
    ],
    
    
     'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        ],
        'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ] ,
         
        'dynagrid'=> [
        'class'=>'\kartik\dynagrid\Module',
        // other module settings
    ], 
         'treemanager' =>  [
        'class' => '\kartik\tree\Module',
        // other module settings, refer detailed documentation
        ]
    ],
    
   
    'params' => $params,
];




if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
