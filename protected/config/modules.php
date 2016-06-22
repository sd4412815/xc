<?php 
return  array (
				// uncomment the following to enable the Gii tool
				'gii' => array (
						'class' => 'system.gii.GiiModule',
						'password' => 'woshimima',
						// If removed, Gii defaults to localhost only. Edit carefully to taste.
						'ipFilters' => array (
								'127.0.0.1',
								'::1' 
						),
						'generatorPaths' => array (
								'bootstrap.gii' 
						) 
				),
				'srbac' => array (
						'userclass' => 'User', // default: User 对应用户的model
						'userid' => 'id', // default: userid 用户表标识位对应字段
						'username' => 'u_tel', // default:username 用户表中用户名对应字段
						'delimeter' => '@', // default:- item分隔符
						'debug' => true, // default :false 调试模式，true则所有用户均开放，可以随意修改权限控制
						'pageSize' => 10, // default : 15
						'superUser' => 'liuchangxin', // default: Authorizer 超级管理员，这个账号可以不受权限控制的管理，对所有页面均有访问权限
						'css' => 'srbac.css', // default: srbac.css 样式文件
						
						'layout' => 'application.views.layouts.main', // default: application.views.layouts.main,must be an existing alias
						'notAuthorizedView' => 'srbac.views.authitem.unauthorized', // default:srbac.views.authitem.unauthorized, must be an existing alias
						'alwaysAllowed' => array ( // default: array() 总是允许访问的动作
								'SiteLogin',
								'SiteLogout',
								'SiteIndex',
								'SiteAdmin',
								'SiteError',
								'SiteContact' 
						),
						// 'userActions' => array('Show', 'View', 'List'), //default: array()
						'listBoxNumberOfLines' => 15, // default : 10
						'imagesPath' => 'srbac.images', // default: srbac.images
						'imagesPack' => 'noia', // default: noia
						'iconText' => true, // default : false
						'header' => 'srbac.views.authitem.header', // default : srbac.views.authitem.header,must be an existing alias
						'footer' => 'srbac.views.authitem.footer', // default: srbac.views.authitem.footer,must be an existing alias
						'showHeader' => true, // default: false
						'showFooter' => true, // default: false
						'alwaysAllowedPath' => 'srbac.components'  // default: srbac.components,must be an existing alias
								)

				,
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	);
?>