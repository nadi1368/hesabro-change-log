<?php

use hesabro\helpers\Module as HesabroHelpersModule;
use yii\base\Application;
use yii\mongodb\Connection;

/**
 * @var Application $app
 */

return [
    'components' => [
        'mongodb' => [
            'class' => Connection::class,
            'dsn' => $app->modules['change-log']['mongo_dsn'] ?? ''
        ]
    ],
    'modules' => [
        'helpers' => [
            'class' => HesabroHelpersModule::class,
        ]
    ]
];
