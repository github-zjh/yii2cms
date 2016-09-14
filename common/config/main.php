<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host'   => '127.0.0.1',
                    'port'   => 11211,
                    'weight' => 100,
                ],
            ]
        ],
        'authManager' => [
            'class'           => 'yii\rbac\DbManager',
            'itemTable'       => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable'  => 'auth_item_child'
        ]
    ],
];
