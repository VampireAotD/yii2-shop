<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'class' => 'frontend\components\Bootstrap'
        ,
    ],
    'controllerNamespace' => 'frontend\controllers',
    'name' => 'Yii shop',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                'good/<id:\d+>' => 'good/default/index',
                'wishlist' => 'wishlist/default/index',
                'wishlist/add/<id:\d+>' => 'wishlist/default/add',
                'wishlist/remove/<id:\d+>' => 'wishlist/default/delete',
                'wishlist/clear' => 'wishlist/default/clear',
                'cart' => 'cart/default/index',
                'cart/add/<id:\d+>' => 'cart/default/add',
                'cart/remove/<id:\d+>' => 'cart/default/delete',
                'cart/clear' => 'cart/default/clear',
                'cart/checkout-confirm' => 'cart/default/checkout-confirm',
                'category/<id_cat:\d+>' => 'site/search',
                'index/page/<page:\d+>' => 'site/index',
                'index' => 'site/index',
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd MMMM yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'UA',
        ],
        'cookiesAndSession' => [
            'class' => 'frontend\components\CookiesAndSessionsHelper',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ]
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '790416528148468',
                    'clientSecret' => 'd776ea98c27351facc5fff2bfc07b882',
                ],
            ],
        ],
    ],
    'modules' => [
        'good' => [
            'class' => 'frontend\modules\good\Module',
        ],
        'wishlist' => [
            'class' => 'frontend\modules\wishlist\Module',
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
        'cart' => [
            'class' => 'frontend\modules\cart\Module',
        ],
    ],
    'params' => $params,
];
