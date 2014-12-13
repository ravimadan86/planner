<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('chartjs', dirname(__FILE__).'/../extensions/chartjs');

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
require_once $basePath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'commonFunctions.php';

return array(
    'theme'=> 'bootstrap',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'e-Planner',

	// preloading 'log' component
	'preload'=>array('log', 'chartjs'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'ext.bootstrap.widgets.*',
        'ext.bootstrap.helpers.*',
        'ext.bootstrap.behaviors.*',
		'ext.phpmailer.JPhpMailer',
        'ext.tinymce.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array($_SERVER['REMOTE_ADDR'], '127.0.0.1','::1'),
            'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
		'auth' => array(
            'strictMode' => true,   // true = authorization items can not be assigned to children of same type
            'userClass' => 'User',  // name of the user model class
            'userIdColumn' => 'user_id', // name of user id column in db
            'userNameColumn' => 'email', // name of the username column in db
            'appLayout' => 'webroot.themes.bootstrap.views.layouts.main',   // used to use bootstrap theme
            'viewDir' => null, // the path to view files to use with this module
        ),
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class' => 'auth.components.AuthWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                'gii'=>'gii',
                'gii/<controller:\w+>'=>'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				'auth'=>'auth',
                'auth/<controller:\w+>'=>'auth/<controller>',
                'auth/<controller:\w+>/<action:\w+>'=>'auth/<controller>/<action>',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
            'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=planner',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
		'authManager' => array(
            'class' => 'CDbAuthManager',
            'defaultRoles'=>array('Guest'),
            'connectionID' => 'db',
            'behaviors' => array(
                'auth' => array(
                    'class' => 'auth.components.AuthBehavior',
                    'admins' => array('Admin'),
                ),
            ),
            'itemTable' => 'authitem',
            'itemChildTable' => 'authitemchild',
            'assignmentTable' => 'authassignment',
        ),
        'chartjs'=>array(
            'class' => 'chartjs.components.ChartJs',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail' => 'ravimadan86@gmail.com',
        'adminName' => 'e-Planner - Admin',
		'roleNames'=>array(
            'Admin'=>'Admin',
            'AccountAdmin' => 'Account Manager',
            'Account' => 'Account User',
            'Templator' => 'Templator'
        ),
        'sampleCsvFiles' => array(
            'mailgroups'=>'mailgroups.csv',
        ),
        'custom_fields_type'=>array(
            'TEXT'=>'Text',
            //'NUMBER' => 'Number',
            //'RADIO' => 'Radia Button',
        ),
	),
);