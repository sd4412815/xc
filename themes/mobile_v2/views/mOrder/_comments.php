<?php 
$criteria = new CDbCriteria ();
$criteria->order = 'oc_datetime DESC, oc_order_id DESC';

// $shopId = $shopId;
$criteria->addCondition ( 'oc_washshop_id = :shopId' );
$criteria->params [':shopId'] = $shop['id'];
$criteria->addCondition ( 'oc_comment_user_type = 1' );
$criteria->limit = 8;

$dataProvider = new CActiveDataProvider ( 'OrderComments', array (
		'pagination' => array (
				'pageSize' => Yii::app()->params['pageSize'],
				'route'=>'mOrder/GetCommentList',
		),
		'criteria' => $criteria
) );
$this->renderPartial ( '_commentList', array (
		'dataProvider' => $dataProvider
) );
// 	$shopId =$shop['id'];
// 	$model = new OrderComments ();
		
// 	$criteria = new CDbCriteria ();
// 	$criteria->order = 'oc_datetime DESC, oc_order_id DESC';
		

// 	$criteria->addCondition ( 'oc_washshop_id = :shopId' );
// 	$criteria->params [':shopId'] = $shopId;
// 	$criteria->addCondition ( 'oc_comment_user_type = 1' );
// 	$criteria->limit = 8;
// 	$dataProvider = new CActiveDataProvider ( 'OrderComments', array (
// 			'pagination' => array (
// 					'pageSize' => Yii::app()->params['pageSize'] ,
// 					'route'=>'order/GetCommentList',
// 			),
// 			'criteria' => $criteria
// 	) );

// 	$this->renderPartial ( '_commentList', array (
// 			'model' => $model,
// 			'dataProvider' => $dataProvider
// 	));


?>