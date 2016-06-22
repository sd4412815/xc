<?php
class Order{
	
	/**
	 * 生产订单号
	 * @param int $userId 用户编号
	 * @return string 16位订单编号
	 */
	public static  function getOrderNo($userId){
		$currentDate =  date_create(date('Y-m-d'));
		$baseDate = date_create('2014-10-01');
		
		return date_diff($currentDate,$baseDate)->format('%a')
			.substr(time(),-5).substr(microtime(),2,5)
			.substr($userId,-2).sprintf('%02d',rand(1,99));
	}
	

	/**
	 * 根据车行id，服务时间段，服务时长，偏移量返回服务时间信息
	 * @param int $shopId
	 * @param int $timeIndex
	 * @param int $intervalNum
	 * @param int $bias
	 * @return array [state,msg,data]
	 */
	public static  function getOrderTime($shopId, $timeIndex,$intervalNum, $bias=0){
		$timeIndex -=1;
		$rlt=UTool::iniFuncRlt();
		$shop=WashShop::model()->findByPk($shopId);
		if (!isset($shop)) {
			$rlt['msg']='00001';
			return $rlt;
		}
		$timeZone=$shop->wsTimeZone;
	
		// 		$startTime=$timeZone['tz_start'];
		$startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $timeZone ['tz_start'] );
		$startTime = $startTime->getTimestamp ();
		$interval=$timeZone['tz_interval'];
		if ($interval <=0 ) {
			$rlt['msg']='00002';
			return $rlt;
		}
		// 标准服务时间单元数
// 		$intervalNum = ceil($serviceTime/$interval);
		// 起始服务时间
		$begin = $startTime + $timeIndex * $interval * 60 + floor($timeIndex/$intervalNum)*  $shop['ws_rest']*60;
		

		// 结束服务时间
		$end = $begin + $intervalNum * $interval * 60;
		$nextBegin = $end+ $shop['ws_rest']*60;
// 		Yii::log($timeIndex,'error','order.getordertime0');
// 		Yii::log(date('Y-m-d H:i:s',$begin),
// 		'error','order.getordertime1');
// 		Yii::log(date('Y-m-d H:i:s',$end),
// 		'error','order.getordertime2');
		
		$rlt['data'] = array(
				'begin'=>date('Y-m-d H:i:s', $begin ),
				'end'=>date('Y-m-d H:i:s', $end),
				'nextBegin'=>date('Y-m-d H:i:s',$nextBegin),
				'serviceIntervalNum'=>$intervalNum,
		);
		$rlt['status']=true;
		return $rlt;
	
	}
	
	/**
	 * 根据车行id，服务时间计算服务用标准用时单元
	 * @param unknown $shopId
	 * @param unknown $orderTime
	 * @return string|boolean
	 */
	public static function getOrderUnit($shopId, $serviceTime){
		$rlt=UTool::iniFuncRlt();
		$shop=WashShop::model()->findByPk($shopId);
		if (!isset($shop)) {
			$rlt['msg']='00001';
			return $rlt;
		}
		$timeZone=$shop->wsTimeZone;
		
		$interval=$timeZone['tz_interval'];
		if ($interval <=0 ) {
			$rlt['msg']='00002';
			return $rlt;
		}
		// 标准服务时间单元数
// 		$intervalNum = ceil($serviceTime/$interval);
		
		$rlt['data']=array(
				'serviceIntervalNum' => ceil($serviceTime/$interval),
				'extraTime'=>$interval - $serviceTime % $interval,
		);

		$rlt['status']=true;
		return $rlt;
	}
	
	
	
}