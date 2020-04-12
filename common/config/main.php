<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];

//yii migrate --migrationPath=@yii/rbac/migrations
