<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',
    // preloading 'log' component
    'preload' => ['log'],
    // autoloading model and component classes
    'import' => [
        'application.models.*',
        'application.components.*',
    ],
    'modules' => [
//        'gii' => [
//            'class' => 'system.gii.GiiModule',
//            'password' => 'password',
//            // If removed, Gii defaults to localhost only. Edit carefully to taste.
//            'ipFilters' => ['127.0.0.1', '::1'],
//        ],
    ],
    // application components
    'components' => [
        'user' => [
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ],
        'urlManager' => [
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => [
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
            ],
        ],
//        'mailer' => require(dirname(__FILE__) . '/mail.php'),
    ],
    'params' => file_exists(dirname(__FILE__) . '/params.php') ? require(dirname(__FILE__) . '/params.php') : [],
];
