<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'categories' => [
            'class' => 'backend\modules\categories\Module',
        ],
        'goods' => [
            'class' => 'backend\modules\goods\Module',
        ],
        'slider' => [
            'class' => 'backend\modules\slider\Module',
        ],
        'orders' => [
            'class' => 'backend\modules\orders\Module',
        ],
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
    ],
    'language' => 'ru-RU',
    'name' => 'Yii shop admin panel',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
    'aliases' => [
        '@uploads' => '@frontend/web/uploads/',
        '@slides' => '@frontend/web/uploads/slides/'
    ]
];
