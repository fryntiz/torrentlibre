<?php
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$log = require __DIR__ . '/log.php';
$translations = '@app/translations';  // Directorio con las traducciones

$config = [
    'id' => 'torrentlibre',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@sitename' => $params['sitename'],
        '@sitedescription' => $params['sitedescription'],
        '@r_avatar' => $params['rutaAvatar'],
        '@r_iconos' => $params['rutaIconos'],
        '@r_imgTorrent' => $params['rutaImagenTorrent'],
        '@r_img' => $params['rutaImagenes'],
        '@r_imgLicencias' => $params['rutaImagenLicencias'],
        '@r_torrents' => '@app/web' . $params['rutaTorrent'],
        '@p_torrents' => $params['paginaciontorrents'],
        '@tmp' => $params['tmp'],
        '@maxErrorsLogin' => $params['maxErrorsLogin'],
        '@downloads' => $params['downloads'],
        '@uploadImages' => $params['uploadImages'],
        '@adminEmail' => $params['adminEmail'],
    ],
    'language' => $params['language_default'],
    'name' => $params['sitename'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1xzMOiIvDjXyX_krLg1_m4kEduwGkndi',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UsuariosDatos',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            /*
            // comment the following array to send mail using php's mail function:
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $params['smtpUsername'],
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
            */
        ],
        'log' => $log,
        'db' => $db,
        'formatter' => [
            'timeZone' => getenv('SITE_TIMEZONE'),
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@yii2mod/comments/messages',
                ],
                '*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => $translations,
                    //'sourceLanguage' => 'en-US',
                    /*
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                    */
                ],
            ],
        ],

        's3' => [
            'class' => \frostealth\yii2\aws\s3\Service::class,
            'credentials' => [
                'key' => getenv('AMAZON_S3_ACCESS'),
                'secret' => getenv('AMAZON_S3_SECRET'),
            ],
            'region' => getenv('AMAZON_S3_REGION'),
            'defaultBucket' => getenv('AMAZON_S3_BUCKET'),
            'defaultAcl' => getenv('AMAZON_S3_ACL'),
        ],
    ],

    'modules' => [
        'comment' => [
            'class' => \yii2mod\comments\Module::class,
            //'class' => app\models\Comentarios::class,
            //'controllerNamespace' => 'app\controllers',
            'commentModelClass' => app\models\Comentarios::class,
            'controllerMap' => [
                'manage' => [
                    'class' => app\controllers\ComentariosController::class,
                    'layout' => '@app/modules/admin/views/layouts/column2',
                    'on afterSave' => function ($event) {
                        die("afterSave");
                    },
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
