<?php

$criteria =new CDbCriteria();
$criteria->addCondition('ws_state>=1');
$shops = WashShop::model()->findAll($criteria);

foreach ($shops as $shop){
	WashShop::model()->deleteOrderTempTable($shop['id'], 0);
	$rlt = WashShop::model()->updateOrderTempTable($shop['id'], 1, 0);
	echo CJSON::encode($rlt);
	WashShop::model()->updateOrderTempTable($shop['id'], 2, 1);
	WashShop::model()->generateOrderTempTable($shop['id'], 2);
// 	echo $shop['id'];
// 	OrderHistory::model()->deleteAll();

// 	WashShop::model()->deleteOrderTempTable($shop['id'], 1);
// 	WashShop::model()->deleteOrderTempTable($shop['id'], 2);
// 	echo $shop->generateOrderTempTable($shop['id'], 0)['state'];
// 	$shop->generateOrderTempTable($shop['id'], 1);
// 	$shop->generateOrderTempTable($shop['id'], 2);
	
}
?>