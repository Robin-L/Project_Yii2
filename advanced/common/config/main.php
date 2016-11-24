<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=project_yii2',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'enableSchemaCache' => true,
			'schemaCacheDuration' => 24*3600,
			'schemaCache' => 'cache',
		],
    ],
	'language' => 'zh-CN',
	'timezone' => 'Asia/Shanghai',
];
