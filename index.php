<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii1114/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
// defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

define('YII_DEBUG',TRUE);
defined('YII_TRACE_LEVEL');
// include_once('emoji.php');

require_once($yii);
// Yii::log ( '1', CLogger::LEVEL_INFO, 'mngr.mweixinC' );
// $name='mytest';
// $ak='atV54I5hflatOH00IebtxSwR';
// // $ak='lEQK9ArzAXztjwDIpL8mKzAe';
// // $ak='Uncf3alGs1ZNUxnLDcnwV6yB';
// // $url = 'http://api.map.baidu.com/geodata/v3/geotable/list?name='.$name.'&ak='.$ak;
// // // $fields = array(
// // // 	name=>'mytest',
// // // 	ak=>'atV54I5hflatOH00IebtxSwR',
// // // );
// // $html = file_get_contents($url);
// // echo  $html;
// $url ='http://api.map.baidu.com/geosearch/v3/local?ak='.$ak.'&geotable_id=66526&q=1&region=沈阳市';
// $url = 'http://api.map.baidu.com/geosearch/v3/nearby?ak='.$ak.'&geotable_id=66526&q=&location=123.426422,41.770148&radius=10000';
// $rlts = file_get_contents($url);

// $ff=json_decode($rlts, true);
// var_dump($ff);
// // echo $ff['location'];
// echo $ff['total'];
// $url = 'http://api.map.baidu.com/geodata/v3/geotable/list';
// $curlPostFields = array(
// 	name=>'mytest',
// 	ak=>'atV54I5hflatOH00IebtxSwR',
// );
// http://api.map.baidu.com/geosearch/v3/nearby?ak=您的ak&geotable_id=****&location=116.395884,39.932154&radius=1000&tags=酒店&sortby=distance:1|price:1&filter=price:200,300
// 	$curl = curl_init();
// 	curl_setopt($curl, CURLOPT_URL, $url);
// 	curl_setopt($curl, CURLOPT_HEADER, false);
// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($curl, CURLOPT_NOBODY, true);
// 	curl_setopt($curl, CURLOPT_POST, true);
// 	curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPostFields);
// 	$return_str = curl_exec($curl);
// 	curl_close($curl);
// 	echo  $return_str;
$attributes = array(
		'ak' => 'atV54I5hflatOH00IebtxSwR',
		'geotable_id' => '66526',
		'sn' => 'not use now',
);

$app = Yii::createWebApplication($config);
// $app = Yii::createWebApplication($config);
// $app->onBeginRequest = function($event)
// {
//   return ob_start("ob_gzhandler");
// };

// $app->onEndRequest = function($event)
// {

// return ob_end_flush();
// };
$detect = new Mobile_Detect;
// call methods
// $detect->isMobile();
// $detect->isTablet();
// $detect->isIphone();
$target = Yii::app()->request->getParam('device');

// Any tablet device.
// if( $detect->isTablet() ){
// 	Yii::app()->theme = 'mobile';
// }

// Exclude tablets.
// if( $detect->isMobile() && !$detect->isTablet() ){
// 	Yii::app()->theme = 'v3';
// }
if ($target == 'pc'){
	Yii::app()->theme = 'v1';
}else
if ($detect->isTablet() || $target == 'mobile'){
	Yii::app()->theme = 'mobile_v2';
} else 
	if ($detect->isMobile() || $target=='mobile'){
	Yii::app()->theme = 'mobile_v2';
}else{
	Yii::app()->theme = 'v1';
}
Yii::app()->theme = 'v1';
$app->run();
?>