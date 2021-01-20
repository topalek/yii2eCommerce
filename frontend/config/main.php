<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-frontend',
    'name'                => 'Yii2 e-commerce',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'language'            => 'ru_RU',
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'request'      => [
            'csrfParam'           => '_csrf',
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity',
                'httpOnly' => true,
                'domain'   => $params['cookieDomain'],
            ],
        ],
        'session'      => [
            'name'         => $params['cookieDomain'] . '_session',
            'cookieParams' => [
                'httpOnly' => true,
                'domain'   => $params['cookieDomain'],
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'profile'       => 'profile/index',
                '<action>'      => 'site/<action>',
                //                'site/<action>/<year:\d{4}>/<category>' => 'post/index',
                'post/<id:\d+>' => 'post/view',
            ],
        ],
    ],
    'params'              => $params,
];
