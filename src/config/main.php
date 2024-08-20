<?php

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

    ]
];
