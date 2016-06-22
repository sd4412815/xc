<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('dzRaty', dirname(__FILE__) . '/../extensions/dzRaty');
Yii::setPathOfAlias('star', dirname(__FILE__) . '/../widget/star');
Yii::setPathOfAlias('city', dirname(__FILE__) . '/../widget/city');
Yii::setPathOfAlias('select2', dirname(__FILE__) . '/../extensions/yii-select2');
Yii::setPathOfAlias('RestfullYii', dirname(__FILE__) . '/../extensions/starship/RestfullYii');

$db = require (__DIR__ . '/db.php');
$modules = require (__DIR__ . '/modules.php');
$log = require (__DIR__ . '/log.php');

$restful_url = require (dirname(__FILE__) . '/../extensions/starship/RestfullYii/config/routes.php');
;

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    // 'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
    // 'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '我洗车',
    'language' => 'zh_CN',
    // preloading 'log' component
    'preload' => array(
        'log',
        'userCounter'
    ),
    
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.models.base.*',
        'application.modules.srbac.controllers.SBaseController',
        'ext.cascadedropdown.ECascadeDropDown'
    ),
    
    'defaultController' => 'site',
    'theme' => 'v1', // requires you to copy the theme under your themes directory
    
    'modules' => $modules,
    
    // application components
    'components' => array(
        'session' => array(
            
            'timeout' => 3600
        )
        ,
//         'userCounter' => array(
//             'class' => 'application.components.UserCounter'
//         ),
        'geoip' => array(
            'class' => 'ext.PcMaxmindGeoIp.PcMaxmindGeoIp'
        ),
//     		'mobileDetect' => array(
//     				'class' => 'ext.MobileDetect.MobileDetect'
//     		),
        
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'returnUrl'=>'site/login',
            
        ),
        'request' => array(
            // 'class' => 'application.components.HttpRequest',
            'enableCookieValidation' => true
        )
        // 'enableCsrfValidation'=>true,
        ,
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap'
        ),
    		'cache'=>array(
    				'class'=>'system.caching.CDbCache',
//     				'servers'=>array(
//     						array('host'=>'server1', 'port'=>11211, 'weight'=>60),
//     						array('host'=>'server2', 'port'=>11211, 'weight'=>40),
//     				),
    		),
    
        
        'authManager' => array(
            'class' => 'srbac.components.SDbAuthManager',
            'connectionID' => 'db',
            'defaultRoles' => array(
                'car_user'
            ), // 默认角色
            'itemTable' => 'tb_auth_item', // 认证项表名称
            'itemChildTable' => 'tb_auth_item_child', // 认证项父子关系
            'assignmentTable' => 'tb_auth_assignment'
        ) // 认证项赋权关系
,
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => $restful_url,
            // 'rules' => array (
            // '<controller:\w+>/<id:\d+>' => '<controller>/view',
            // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            // '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            // ),
            'showScriptName' => false
        ) // 注意false不要用引号括上
,
        
        // 'urlSuffix'=>'.html',
        // )
        
//         'clientScript' => array(
//         'class' => 'application.vendors.yii-EClientScript.EClientScript',
//         'combineScriptFiles' => true, // By default this is set to true, set this to true if you'd like to combine the script files
//         'combineCssFiles' => true, // By default this is set to true, set this to true if you'd like to combine the css files
//         'optimizeScriptFiles' =>! YII_DEBUG, // @since: 1.1
//         'optimizeCssFiles' =>!YII_DEBUG, // @since: 1.1
//         'optimizeInlineScript' => true, // @since: 1.6, This may case response slower
//         'optimizeInlineCss' => true, // @since: 1.6, This may case response slower
//         ),
        'db' => $db,
        // uncomment the following to use a MySQL database
        /*
         * 'db'=>array( 'connectionString' => 'mysql:host=localhost;dbname=testdrive', 'emulatePrepare' => true, 'username' => 'root', 'password' => '', 'charset' => 'utf8', ),
         */
        'errorHandler' => array (
        // use 'site/error' action to display errors
        'errorAction' => 'site/error'
        ),
        'log' => $log
    ),
    
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'RestfullYii' => [
            'req.auth.user' => function ($application_id, $username, $password) {
                return false;
            }
        ],
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'province' => '1',
        'city' => '1',
        'area' => '1',
        'pageSize' => '8',
        // 'xicheTime'=>'20',
        // 'xicheValue5'=>'30',
        // 'xicheValue7'=>'35',
        // 'dalaTime'=>'40',
        // 'dalaValue5'=>'50',
        // 'dalaValue7'=>'60',
        // 'jingxiTime'=>'150',
        // 'jingxiValue5'=>'180',
        // 'jingxiValue7'=>'200',
        'loadString' => '\'加载中...\',3',
        'carType' => array(
            1 => '&le;5座轿车',
            2 => '&ge;7座/SUV'
        ),
        'autoRefreshTime' => '60000',
        'accountNum' => '1105 8000 0005 52278',
        'accountName' => '沈阳喜车商务服务有限公司',
        'accountOwner' => '华夏银行股份有限公司沈阳南湖支行'
    )
);