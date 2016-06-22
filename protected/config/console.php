<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'genOrderTemp',
		'import'=>array(
				'application.models.*',
				'application.components.*',
				'application.extensions.*',
		),
	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
// 		'db'=>array(
// 			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
// 		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
			// 				'db'=>array(
			// 				'connectionString' => 'mysql:host=rdsnyun2arnuaev.mysql.rds.aliyuncs.com;dbname=xc',
			// 				'emulatePrepare' => true,
			// 				'username' => 'xcadmin',
			// 				'password' => 'woshimima',
			// 				'charset' => 'utf8',
			// 				'tablePrefix' => 'tb_',
			// 				),
			'db' => array (
					'connectionString' => 'mysql:host=localhost;dbname=xc',
					'emulatePrepare' => true,
					'username' => 'root',
					'password' => 'woshimima',
					'charset' => 'utf8',
					'tablePrefix' => 'tb_'
			),
			'log' => array (
						'class' => 'CLogRouter',
						'routes' => array (
								array (
										'class' => 'CFileLogRoute',
										'categories' => 'system.db.*',
										'logFile' => 'sql.log' 
								),
								// array(
								// 'class'=>'CFileLogRoute',
								// 'levels'=>'error,warning,info,trace',
								// 'categories'=>'debug.*',
								// 'logFile'=>'debug.log',
								// ),
								
								array (
										'class' => 'CDbLogRoute',
										'autoCreateLogTable' => 'true',
										'connectionID' => 'db',
										'levels' => 'info,warning,error, profile, debug',
										'logTableName' => 'logsSystem',
										// 'categories'=>
										'except' => 'system.db.*,debug.*,user.*,mngr.*' 
								),
								array (
										'class' => 'CDbLogRoute',
										'autoCreateLogTable' => 'true',
										'connectionID' => 'db',
										'levels' => 'info,warning,error, profile, debug',
										'logTableName' => 'logsMngr',
										'categories' => 'mngr.*' 
								),
								array (
										'class' => 'CDbLogRoute',
										'autoCreateLogTable' => 'true',
										'connectionID' => 'db',
										'levels' => 'info,warning,error, profile, debug',
										'logTableName' => 'logsUser',
										'categories' => 'user.*' 
								) 
						
						// uncomment the following to show log messages on web pages
						// array(
						// 'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
						// //'ipFilters'=>array('127.0.0.1','192.168.1.215'),
						// ),
						// array(
						// 'class'=>'CWebLogRoute',
						// 'levels'=>'trace,info.error.warning.xdebug',
						// 'categories'=>'system.*',
						// 'showInFireBug'=>true,
						// //还可以通过 'showInFireBug'=>true, //显示在Firebug里
						// //显示在Firebug里我们就可以调整提示级别，来显示更多
						// //例如'levels'=>'trace,info,error,warning,xdebug',
						// ),
												)

						 
				) ,
	),
);