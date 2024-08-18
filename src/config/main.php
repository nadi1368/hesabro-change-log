<?php

use hesabro\helpers\Module as HesabroHelpersModule;
use yii\mongodb\Connection;

/**
 * @var array $config
 */

return [
    'components' => [
        'mongodb' => [
            'class' => Connection::class,
            'dsn' => $config['mongo_dsn'] ?? ''
        ]
    ],
    'modules' => [
        'helpers' => [
            'class' => HesabroHelpersModule::class,
        ]
    ]
];
