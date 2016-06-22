<?php
$criteria = new CDbCriteria();
$criteria->addCondition('oh_user_ack=0');
// $criteria->addBetweenCondition('oh_', $valueStart, $valueEnd)
$criteria->addCondition('oh_state>0');
$criteria->addCondition('oh_date_time<:autoAckDate');
$criteria->params[':autoAckDate'] = date('Y-m-d 23:59:59',time()-3*24*2600);
$criteria->order = "oh_order_date_time ASC";

$orderList = OrderHistory::model()->findAll($criteria);
foreach ($orderList as $key=>$order){
    $rlt = OrderHistory::model()->getOrderAckbyUser($order['id'],$order['oh_user_id'],1,5,null);
    if($rlt['status'])
    {
        
        $rlt['status']=true;
    } else {
        $rlt['status']=false;
    
    }
    
    Yii::log("订单自动确认".$order['id'].";".CJSON::encode($rlt),CLogger::LEVEL_INFO,'mngr.autoAckOrderForUser');
}


?>