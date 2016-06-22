<?php
return array (
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
		)
		 
);?>

