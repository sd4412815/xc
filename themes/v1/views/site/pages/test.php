<?php
// $connection = Yii::app()->db;
// $sql = "SELECT * FROM `project` ORDER BY id DESC";
// $command = $connection->createCommand($sql);
// $result = $command->queryAll();
// $criteria->w
// $sfs=array(8,9);
// $criteria = new CDbCriteria();
// $criteria->select = 'wsf_ws_id';
// foreach ($sfs as $key=>$sf){
// 	$criteria->addCondition('wsf_sf_id=:sf'.$key,'or');
// 	$criteria->params[':sf'.$key]=$sf;
// }
// $criteria->group = 'wsf_ws_id';
// $criteria->having = 'count(*) = '.count($sfs);
// $criteria->distinct = true;

$rlt = WashShopFeature::model()->getShopIds(array(8,1));
echo CJSON::encode($rlt);
?>