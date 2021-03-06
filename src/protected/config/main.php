<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',

	'name' => 'TaskAPI',

	// preloading 'log' component
	'preload' => array('log'),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'ext.giix-components.*',
	),

	'modules' => array(
		// Gii tool should be removed in production
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => 'here',
            'ipFilters' => array('127.0.0.1','192.168.201.*', '10.0.2.*'), 
			'generatorPaths' => array(
				'ext.giix-core', // giix generators
			),
		),
	),

	'defaultController' => 'default',
	// application components
	'components' => array(
        'urlManager' => [
            'class' => 'Common\UrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            // 'caseSensitive' => false,
            'rules' => [
                // REST patterns
                ['api/list', 'pattern' => 'api/<model:\w+>', 'verb' => 'GET'],
                ['api/view', 'pattern' => 'api/<model:\w+>/<id:\d+>', 'verb' => 'GET'],
                ['api/update', 'pattern' => 'api/<model:\w+>/<id:\d+>', 'verb' => 'PUT'],
                ['api/delete', 'pattern' => 'api/<model:\w+>/<id:\d+>', 'verb' => 'DELETE'],
                ['api/create', 'pattern' => 'api/<model:\w+>', 'verb' => 'POST'],
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=TaskAPIDB',
			'username' => 'root',
			'password' => 'default_password',
			'emulatePrepare' => true,
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class' => 'CWebLogRoute',
				),
				*/
			),
		),
        'hash' => ['class' => 'Common\PBKDF2Hash'],
        'random' => ['class' => 'Common\RandomString']
	),

	// application-level parameters that can be accessed using Yii::app()->params['paramName']
	'params' => require(dirname(__FILE__) . '/params.php'),
	
	'controllerMap' => array(
		'default' => 'application.controllers.TaskController',
	),
);
