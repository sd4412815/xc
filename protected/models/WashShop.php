<?php

/**
 * This is the model class for table "{{Wash_Shop}}".
 *
 * The followings are the available columns in table '{{Wash_Shop}}':
 * @property string $id
 * @property integer $ws_no
 * @property string $ws_name
 * @property integer $ws_score
 * @property string $ws_address
 * @property string $ws_boss_id
 * @property integer $ws_state
 * @property integer $ws_num
 * @property string $ws_desc
 *
 * The followings are the available model relations:
 * @property OrderHistory[] $orderHistories
 * @property Boss $wsBoss
 * @property TimeZone $wsTimeZone
 * @property WashShopBoss[] $washShopBosses
 * @property WashShopFeature[] $washShopFeatures
 * @property WashShopService[] $washShopServices
 */
class WashShop extends CActiveRecord {
	
	/**
	 * 暂停预约
	 */
	const SHOP_STATE_STOP_ORDER = 4;
	
	/**
	 * 车行暂停营业
	 */
	const SHOP_STATE_PAUSE = 3;
	
	/**
	 * 车行通过考核
	 */
	const SHOP_STATE_PASS = 2;
	/**
	 * 车行正常营业
	 */
	const SHOP_STATE_NORM = 1;
	/**
	 * 车行被临时屏蔽
	 */
	const SHOP_STATE_MASK = 0;
	/**
	 * 车行位于黑名单
	 */
	const SHOP_STATE_BLACK = - 1;
	/**
	 * 车行废弃
	 */
	const SHOP_STATE_CLOSE = - 2;
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{Wash_Shop}}';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'ws_name, ws_address, ws_boss_id',
						'required' 
				),
				array (
						'ws_no, ws_state, ws_num,ws_rest',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'ws_score',
						'numerical',
		
				),
				array (
						'ws_name',
						'length',
						'max' => 128 
				),
				array (
						'ws_address',
						'length',
						'max' => 250 
				),
				array (
						'ws_boss_id',
						'length',
						'max' => 10 
				),
				array (
						'ws_desc',
						'length',
						'max' => 10000 
				),
				array (
						'ws_rest',
						'length',
						'max' => 8 
				),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'id, ws_no, ws_name, ws_score, ws_address,  ws_boss_id, ws_state, ws_num',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'orderHistories' => array (
						self::HAS_MANY,
						'OrderHistory',
						'oh_wash_shop_id' 
				),
				'wsBoss' => array (
						self::BELONGS_TO,
						'Boss',
						'ws_boss_id' 
				),
				'washShopBosses' => array (
						self::HAS_MANY,
						'WashShopBoss',
						'ws_id' 
				),
				// 'washShopFeatures' => array (
				// self::HAS_MANY,
				// 'WashShopFeature',
				// 'wsf_ws_id'
				// ),
				'washShopFeatures' => array (
						self::MANY_MANY,
						'ShopFeature',
						'tb_Wash_Shop_feature(wsf_sf_id,wsf_ws_id)' 
				),
				'washShopServices' => array (
						self::HAS_MANY,
						'WashShopService',
						'wss_ws_id' ,
						'order'=>'wss_st_id',
						'condition'=>'wss_state='.WashShopService::SHOP_SERVICE_ACTIVE,
// 						'group'=>'wss_st_id'
								),
				'province' => array (
						self::BELONGS_TO,
						'Province',
						'ws_province_id' 
				) ,
				'city' => array (
						self::BELONGS_TO,
						'City',
						'ws_city_id' 
				) ,
		    'area'=> array (
						self::BELONGS_TO,
						'Area',
						'ws_area_id' 
				) ,
				'favorite'=>array (
					self::HAS_MANY,
						'FavoriteShop',
						'fs_shop_id' 
				) ,
				'favoriteCount'=>array (
						self::STAT,
						'FavoriteShop',
						'fs_shop_id'
				) ,
				'member'=>array (
						self::HAS_MANY,
						'ShopMember',
						'sm_shop_id'
				) ,
				'memberCount'=>array (
						self::STAT,
						'ShopMember',
						'sm_shop_id'
				) ,
				'orderCount'=>array (
						self::STAT,
						'OrderHistory',
						'oh_wash_shop_id',
						'condition'=>'oh_state>0'
				) ,
				'latestNews'=>array (
						self::HAS_MANY,
						'ShopNews',
						'sn_shop_id',
						'limit'=>1,
				) ,
				'newsList'=>array (
						self::HAS_MANY,
						'ShopNews',
						'sn_shop_id'
				) ,
				'commentCount'=>array (
						self::STAT,
						'OrderComments',
						'oc_washshop_id',
						'condition'=>'oc_comment_user_type=1 AND oc_state>=0'
				) ,
				'huiList'=>array (
						self::HAS_MANY,
						'ShopHui',
						'sh_shop_id',
// 						'condition'=>'sh_end_date < :endDate',
// 						'params'=>array(':endDate'=>'2016-01-01')
						
				) ,
		);
	}
	
	

	
	
	/**
	 * 车行详细信息
	 * 刘长鑫
	 * 20150320
	 * @param int $shopId
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function getDetailInfo($shopId){
	   $rlt=UTool::iniFuncRlt();

	   $shop = $this->findByPk($shopId);
	   if (!isset($shop)){
	       $rlt['msg'] = '该车行信息不存在';
	       return $rlt; 
	   }
	   
	   $info=array();
	   $info['count'] = $shop['ws_num']; // 车位数量
	   $info['position']=$shop['ws_position'];
	   $info['address']=$shop['ws_address'];
	   
	   $services = WashShopService::model()->getServices($shopId, false)['data'];
	   $info['services']['size']=count($services);
	   $items=array();
	   foreach ($services as $key=>$value){
	       $serviceType = $value->wssSt;
	     $items[] = array('id'=>$serviceType['id'],'name'=>$serviceType['st_name'],
	           'desc'=> $serviceType['st_desc'],'status'=>$value['wss_state'],);
	   }
	  $info['services']['items'] =$items;
	   
	   $rlt['status']=true;
	   $rlt['data']=$info;
	   return $rlt;
	}
	
	
	public function getShopListDistance($location, $radius=3000,
			 $page_index=0, $page_size=8,$q=NULL, $filter=NULL, $sortby='distance:1'){
		
		$mapRltIni = UMap::getLocationDistance($location,$radius,$page_index,$page_size,$q,$filter,$sortby);
		$mapRlt = CJSON::decode($mapRltIni);
		$shopList=array();
		if ($mapRlt['status'] ==0){
			foreach ($mapRlt['contents'] as $key=>$value){
				$shopList['w'.$value['washshop_id']]=array(
						'id'=>$value['washshop_id'],
						'address'=>$value['address'],
						'distance'=>$value['distance'],
						'name'=>$value['title'],
				);
			}
		}
		
		return $shopList;

		
	}
	
	
	
// 	public function getShopListSort($shopList){
// // 		'id'=>$value['washshop_id'],
// // 		'address'=>$value['address'],
// // 		'distance'=>$value['distance'],
// // 		'name'=>$value['title'],
// 		$list = array();
// 		foreach ($shopList as $key=>$shop){
// 			$list[]=array(
// 					'id'=>$shop['id'],
// 					'address'=>$shop['address'],
// 			);
// 		}
		
// 		$list[] = array(
// 			'id'=1,
				
// 		) ;
		
// 	}
	
	
	/**
	 * 获取当前城市车行和当前位置的距离
	 * @param string $currentLocation 当前位置
	 * @param int $cityId 城市id 默认NULL 根据当前位置数据自动获取
	 * @return multitype:number
	 */
	public function getShopDistanceListByLocation($currentLocation, $cityId=NULL){

		
		if ($cityId == NULL){
			$locationInfo =  Yii::app()->geoip->getCityInfoForIp($ip);
			$cityName = @$locationInfo['city'];
			$city = City::model()->getCityByPinyin($cityName);
			$cityId = @$city['id'];
		}
		
		$shopList=array();
		
		$currentLocation = @explode(',', $currentLocation);
		$currentLocation_lon = @$currentLocation[0];
		$currentLocation_lat = @$currentLocation[1];
		
		$criteria = new CDbCriteria();
		$criteria->addCondition('ws_city_id=:cityId');
		$criteria->params[':cityId']=$cityId;
		
		$criteria->addCondition('ws_state=1');
		$shopList = WashShop::model()->findAll($criteria);
		$rltList=array();
		foreach ($shopList as $key=>$shop){
			$shopLocation = @explode(',', $shop['ws_position']);
			$shopLocation_lon = @$shopLocation[0];
			$shopLocation_lat = @$shopLocation[1];
			$distance = UMap::GetShortDistance($currentLocation_lon, $currentLocation_lat, $shopLocation_lon, $shopLocation_lat);
			$rltList[$shop['id']]=$distance;
// 			$rltList[]=array(
// 					'distance'=>$distance,
// 					'score'=>$shop['ws_score'],
// 					'name'=>$shop['ws_name']
// 			);
		}
// 		$distanceArray=array();
// 		$scoreArray=array();
// 		foreach ($rltList as $key=>$value){
// 			$distanceArray[$key]=$value['distance'];
// 			$scoreArray[$key]=$value['score'];
// 		}
		
		
		
// 		array_multisort($distanceArray,SORT_ASC,$scoreArray,SORT_ASC,$rltList);
		return $rltList;
	}
	
	
	/**
	 * 车行通过考核设置
	 * 刘长鑫
	 * 20150315
	 * 
	 * @param int $shopId        	
	 * @return array()
	 */
	public function checkPass($shopId) {
		$rlt = UTool::iniFuncRlt ();
		$shop = $this->findByPk ( $shopId );
		if (isset ( $shop )) {
			$shop ['ws_state'] = WashShop::SHOP_STATE_PASS;
			if ($shop->save ()) {
				
				
// 				$shop->deleteOrderTempTable ( $shopId, 0 );
// 				$shop->deleteOrderTempTable ( $shopId, 1 );
// 				$shop->deleteOrderTempTable ( $shopId, 2 );
// 				$shop->generateOrderTempTable ( $shopId, 0 );
// 				$shop->generateOrderTempTable ( $shopId, 1 );
// 				$shop->generateOrderTempTable ( $shopId, 2 );
				$rlt ['status'] = true;
				$rlt ['msg'] = '车行状态更新成功';
			} else {
				$rlt ['msg'] = '车行状态更新失败';
			}
		} else {
			$rlt ['msg'] = '访问信息不存在';
		}
		
		return $rlt;
	}
	
	/**
	 * 根据车行信息返回员工列表，默认$washShopId=0返回未分配员工列表
	 *
	 * @param int $washshopId
	 *        	车行Id
	 * @return array 员工列表
	 */
	public function getStaffs($washshopId = 0, $isExpOrder = FALSE) {
		$rlt = UTool::iniFuncRlt ();
		
		$criteria = new CDbCriteria ();
		
		// $criteria->select=array('id,s_name,s_score,s_state,s_sex,s_age,s_tag,s_user_id,s_join_date,s_exp');
		$criteria->addCondition ( 's_wash_shop_id = :id' );
		$criteria->params [':id'] = $washshopId;
		$criteria->addCondition ( 's_state>=0' );
		if ($isExpOrder) {
			$criteria->order = 's_exp DESC, s_score DESC, s_tag ASC';
		} else {
			$criteria->order = 's_score DESC, s_exp DESC, s_tag ASC';
		}
		
		$staffs = Staff::model ()->findAll ( $criteria );
		$rlt ['data'] = $staffs;
		$rlt ['status'] = true;
		$rlt ['msg'] = '获取员工信息成功';
		return $rlt;
	}
	
	/**
	 * 返回车行基本信息
	 *
	 * @param WashShop $shop        	
	 * @param int $type        	
	 * @param int $bias        	
	 * @param bool $onlyAvailableNum        	
	 * @return string Ambigous mixed>|boolean
	 */
	public function getBasicInfobyType($shop, $type, $bias, $onlyAvailableNum = FALSE) {
		$rlt = UTool::iniFuncRlt ();
		// $shop=$this->findByPk($shopId);
		if (! isset ( $shop )) {
			$rlt ['msg'] = '00001';
			return $rlt;
		}
		$rlt ['data'] = array (
				'minValue' => 0,
				'numTotal' => 0,
				'numAvailable' => 0,
		    'stdValue'=>0,
		);
		
		$command = Yii::app ()->db->createCommand ();
		$command->select ( 'count(id) as numAvailable' );
		$command->from ( '{{Order_Temp}}' );
		
		if ($bias == 0) {
			$command->where ( 'ot_wash_shop_id=:id AND ot_type=:type AND ot_bias=:bias 
					AND ot_state = 1 AND ot_date_time>:timeBegin', array (
					':id' => $shop ['id'],
					':type' => $type,
					':bias' => $bias,
					':timeBegin' => date ( 'H:i:s',time()+20*60 ) 
			) );
		} else {
			$command->where ( 'ot_wash_shop_id=:id AND ot_type=:type AND ot_bias=:bias AND ot_state = 1', array (
					':id' => $shop ['id'],
					':type' => $type,
					':bias' => $bias 
			) );
		}
		
		
		
		$queryRlt = $command->queryRow ();
		
		if (isset ( $queryRlt )) {
			$rlt ['data'] ['numAvailable'] = $queryRlt ['numAvailable'];
		}
		if ($onlyAvailableNum) {
			$rlt ['status'] = true;
			return $rlt;
		}
		
		// 统计值
		$command = Yii::app ()->db->createCommand ();
		$command->select ( 'min(ot_value1) as valueMin1, 
				min(ot_value2) as valueMin2,
				count(id) as numTotal' );
		$command->from ( '{{Order_Temp}}' );
		$command->where ( 'ot_wash_shop_id=:id AND ot_type=:type AND ot_bias=:bias', array (
				':id' => $shop ['id'],
				':type' => $type,
				':bias' => $bias 
		) );
		$queryRlt = $command->queryRow ();
		
		
		if (isset ( $queryRlt )) {
			@$minValue = $queryRlt ['valueMin1'] > $queryRlt ['valueMin2'] ? $queryRlt ['valueMin2'] : $queryRlt ['valueMin1'];
			if (! is_numeric ( $minValue )) {
				$minValue = 0;
			}
			$rlt ['data'] ['minValue'] = $minValue;
			$rlt ['data'] ['numTotal'] = $queryRlt ['numTotal'];
			$rlt ['status'] = true;
		}
		
		$cri=new CDbCriteria();
		$cri->addCondition('ot_wash_shop_id=:shopId');
		$cri->params[':shopId']=$shop['id'];
		$cri->addCondition('ot_value1_discount=1');
	$cri->addCondition('ot_type=:type');
	$cri->params[':type']=$type;
	$cri->addCondition('ot_bias=:bias');
	$cri->params[':bias']=$bias;
	
	
// 		$cri->condition = 'ot_value1_discount'
		$item = OrderTemp::model()->find($cri);
		
		if (isset($item)){
		    
		    $rlt ['data']['stdValue'] =$item['ot_value1'];
		}
		
		
		
		$rlt ['status'] = true;
		// Yii::log(CJSON::encode($rlt['data']),'info','washshop.order.getBasicInfobyType');
		
		// Yii::log(CJSON::encode($rlt['data']),'info','washshop.order.getBasicInfobyType');
		return $rlt;
	}
	public function updateOrderTempTable($shopId, $biasFrom, $biasTo) {
		$rlt = UTool::iniFuncRlt ();
		
		$count = OrderTemp::model ()->updateAll ( array (
				'ot_bias' => $biasTo 
		), 'ot_wash_shop_id=:shopId AND ot_bias=:biasFrom', array (
				':shopId' => $shopId,
				':biasFrom' => $biasFrom 
		) );
		
		$rlt ['status'] = true;
		$rlt ['data'] = $count;
		return $rlt;
	}
	
	/**
	 * 根据城市id获取可用车行ids
	 * 刘长鑫
	 * 20150317
	 * 
	 * @param int $cityId        	
	 * @return array
	 */
	public function getOnlineShop($cityId = 0) {
		$rlt = UTool::iniFuncRlt ();
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'ws_state=1' );
		if ($cityId != 0) {
			$criteria->addCondition ( 'ws_city_id=:cid' );
			$criteria->params [':cid'] = $cityId;
		}
		// $criteria->order
		$shops = WashShop::model ()->findAll ( $criteria );
		$ids = array ();
		foreach ( $shops as $key => $value ) {
			$ids [] = $value ['id'];
		}
		$rlt ['data'] = $ids;
		$rlt ['status'] = true;
		
		return $rlt;
	}
	
	/**
	 * 按天删除临时订单表
	 *
	 * @param int $shopId        	
	 * @param int $bias        	
	 * @return string
	 */
	public function deleteOrderTempTable($shopId, $bias) {
		$rlt = UTool::iniFuncRlt ();
		$shop = $this->findByPk ( $shopId );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '00001';
			return $rlt;
		}
		
		OrderTemp::model ()->deleteAllByAttributes ( array (
				'ot_wash_shop_id' => $shopId,
				'ot_bias' => $bias 
		) );
	}
	
	/**
	 * 根据车行id生成车行对应服务
	 *
	 * @param int $shopId        	
	 * @return array
	 */
	public function generateShopService($shopId) {
		$rlt = UTool::iniFuncRlt ();
		
		// $criteria = new
		
		$services = ServiceType::model ()->findAll ();
		
		foreach ( $services as $key => $value ) {
			$isExist = WashShopService::model ()->countByAttributes ( array (
					'wss_st_id' => $value ['id'],
					'wss_ws_id' => $shopId 
			) );
			if ($isExist < 1) {
				$shopService = new WashShopService ();
				$shopService ['wss_ws_id'] = $shopId;
				$shopService ['wss_st_id'] = $value ['id'];
				$shopService ['wss_value'] = $value ['st_value'];
				// $shopService ['wss_value2'] = $value ['st_value2'];
				$shopService ['wss_state'] = - 1;
				// $shopService['wss_type']= $value['st_type'];
				
				if (! $shopService->save ()) {
					Yii::log ( CJSON::encode ( $shopService ), 'warning', 'washShop.generateShopService' );
				}
			}
		}
		$rlt ['status'] = true;
		return $rlt;
	}

	
	/**
	 * 按服务成订单表
	 * @param int $shopId
	 * @param int $serviceId 服务： 普洗 打蜡 精洗等
	 * @param float $price
	 * @param int $positionCount 档口数
	 * @param int $serviceTime 服务时间
	 * @param int $serviceTimeRest 休息时间
	 * @param int $carGroupId 车型分组：轿车 小SUV 中大型SUV等
	 * @param int $bias 时间便宜量：0 1 2 今明后
	 */
	private function _genOrderTempByServiceAndBias($shopId, $serviceId, $price,  $positionCount, $serviceTime, $serviceTimeRest, $carGroupId, $bias) {
		
		$shop = $this->with('washShopServices')->findByPk ( $shopId );
		
		$startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $shop ['ws_open_time'] );
		$startTime = $startTime->getTimestamp ();
	
		$endTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $shop ['ws_close_time'] );
		$endTime = $endTime->getTimestamp ();
	
		$orderTime = $startTime;
		$orderTimeEnd = $orderTime + $serviceTime * 60;
	
		$orderState = OrderTemp::STATE_READY;
	
		$order = new OrderTemp ();
		while ( $orderTimeEnd <= $endTime ) {
// 			$order = new OrderTemp ();
			$order->isNewRecord = TRUE;
			$order ['ot_wash_shop_id'] = $shop ['id'];
			$order ['ot_date_time'] = date ( 'H:i:00', $orderTime );
			$order ['ot_date_time_end'] = date ( 'H:i:00', $orderTimeEnd );
				
			$order['ot_value'] = $price;
			$order['ot_value_discount'] = 1;
				
			$order ['ot_user_id'] = 0; // 默认值，没有实际意义
			$order ['ot_type'] = $serviceId;

			$order ['ot_state'] = $orderState;
			$order ['ot_position'] = $positionCount;
			$order ['ot_bias'] = $bias;
			if ($order->save ()) {
			} else {
				Yii::log ( CJSON::encode ( $order ), 'warning', 'washshop.order._generateOrderTempTable' );
			}
				
			$orderTime = $orderTimeEnd +$serviceTimeRest * 60;
			$orderTimeEnd = $orderTime + $serviceTime * 60;
		}
	}
	
	
	public function genOrderTempTable($shopId, $bias){
		
		$rlt = UTool::iniFuncRlt();
		$shop = $this->with('washShopServices')->findByPk ( $shopId );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '00001';
			return $rlt;
		}
		
		$orderCount = OrderTemp::model ()->countByAttributes ( array (
				'ot_wash_shop_id' => $shopId,
				'ot_bias' => $bias
		) );
		if (isset ( $orderCount ) && $orderCount > 0) {
			$rlt ['msg'] = '00021';
			$rlt ['data'] = CJSON::encode ( $orderCount );
			return $rlt;
		}
		
		
		
		
		
	}
	
	
	
	/**
	 * 生成洗车行订单
	 *
	 * @param int $shopId        	
	 * @param int $bias        	
	 * @return string boolean
	 */
	public function generateOrderTempTable($shopId, $bias) {
		$rlt = UTool::iniFuncRlt ();
		$shop = $this->findByPk ( $shopId );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '00001';
			return $rlt;
		}
		
		$orderCount = OrderTemp::model ()->countByAttributes ( array (
				'ot_wash_shop_id' => $shopId,
				'ot_bias' => $bias 
		) );
		if (isset ( $orderCount ) && $orderCount > 0) {
			$rlt ['msg'] = '00021';
			$rlt ['data'] = CJSON::encode ( $orderCount );
			return $rlt;
		}
		
		// 洗车档口
		for($i = 0; $i < $shop ['ws_num']; $i ++) {
			$services = $shop->washShopServices;
			foreach ( $services as $key => $value ) {
				$this->_generateOrderTempTable ( $shop, $i + 1, $value, $bias );
			}
		}
		Yii::log ( 'washshop"' . $shopId . "增加临时表成功", 'info', 'mngr.washshop.order.generateOrderTempTable' );
		$rlt ['status'] = true;
		return $rlt;
	}
	
	/**
	 * 按洗车位生成订单表
	 *
	 * @param $shop 车行对象        	
	 * @param number $position
	 *        	洗车档口
	 * @param number $interval
	 *        	服务间隔
	 * @param number $serviceType
	 *        	服务类型对象
	 * @param number $bias
	 *        	与当前日期偏移量
	 * @return array
	 */
	private function _generateOrderTempTable($shop, $position, $shopService, $bias) {
		$startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $shop ['ws_open_time'] );
		$startTime = $startTime->getTimestamp ();
		
		$endTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $shop ['ws_close_time'] );
		$endTime = $endTime->getTimestamp ();
		
		$orderTime = $startTime;
		// Yii::log(CJSON::encode($orderUser),'warning','system.washshop.order._generateOrderTempTable.staff');
		// $serviceTime = $shopService->wssSt ['st_time'];
		$serviceTime = $shopService ['wss_service_time'];
		$orderTimeEnd = $orderTime + $serviceTime * 60;
		
		$orderState = 1;
		
		while ( $orderTimeEnd <= $endTime ) {
			$order = new OrderTemp ();
			$order ['ot_wash_shop_id'] = $shop ['id'];
			$order ['ot_date_time'] = date ( 'H:i:00', $orderTime );
			$order ['ot_date_time_end'] = date ( 'H:i:00', $orderTimeEnd );
			
			$order ['ot_value'] = $shopService ['wss_value'];
			// $order ['ot_value2'] = $shopService ['wss_value2'];
			$order ['ot_value1_discount'] = 1;
			$order ['ot_value2_discount'] = 1;
			
			$order ['ot_user_id'] = 0; // 默认值，没有实际意义
			$order ['ot_type'] = $shopService ['wss_st_id'];
			$order ['ot_state'] = $orderState;
			$order ['ot_position'] = $position;
			$order ['ot_bias'] = $bias;
			
			if ($order->save ()) {
			} else {
				Yii::log ( CJSON::encode ( $order ), 'warning', 'washshop.order._generateOrderTempTable' );
			}
			
			$orderTime = $orderTimeEnd + $shopService ['wss_service_time_rest'] * 60;
			$orderTimeEnd = $orderTime + $serviceTime * 60;
		}
	}
	
	/**
	 *
	 * @param int $num        	
	 * @param int $cityId        	
	 * @return array
	 */
	public function getTopWSs($num, $cityId) {
		$criteria = new CDbCriteria ();
		// $criteria->select = 's_name, s_sex, s_age, s_wash_shop_id, id, s_user_id';
		$criteria->order = 'ws_score DESC,id DESC';
		$criteria->addCondition ( 'ws_state=1' );
		$criteria->addCondition ( 'ws_city_id=:cid' );
		$criteria->params [':cid'] = $cityId;
		// $criteria->addCondition('s_state=1');
		$criteria->limit = $num;
		
		$items = $this->findAll ( $criteria );
		return $items;
	}
	public function getAreaCode($provinceId, $cityId, $areaId) {
		
		// @$provinceId = $_COOKIE['provinceId'];
		// @$cityId = $_COOKIE['cityId'];
		// @$areaId=$_COOKIE['areaId'];
		$area_code = '';
		if (isset ( $provinceId )) {
			if ($provinceId > 0) {
				// $area_code .= sprintf('%02d',$provinceId);
				$area_code .= $provinceId . '-';
			} else {
				$area_code .= '-';
			}
		}
		if (isset ( $cityId )) {
			if ($cityId) {
				$area_code .= $cityId . '-';
				// $area_code .= sprintf('%02d',$cityId);
			} else {
				$area_code .= '-';
			}
		}
		if (isset ( $areaId )) {
			
			if ($areaId > 0) {
				$area_code .= $areaId;
				// $area_code .= sprintf('%02d',$cityId);
			} else {
				$area_code .= '%';
			}
		} else {
			$area_code .= '---';
		}
		
		return $area_code;
	}
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'ws_no' => '加盟号',
				'ws_name' => '车行名称',
				'ws_score' => '车行评分',
				'ws_address' => '车行地址',
				'ws_boss_id' => '店主',
				'ws_area_code' => '车行位置',
				'ws_state' => '车行状态',
				'ws_num' => '洗车位个数',
				'ws_exp' => '车行经验值',
				'ws_rest' => '每次洗车休息间隔(分钟)',
				'ws_desc' => '车行描述' 
		);
	}
	// public function getUnitTimeNum($shopId, $time) {
	// $shop = $this->findByPk ( $shopId );
	// $timeZoneId = $shop ['ws_time_zone_id'];
	// if (empty ( $shop ) || empty ( $timeZoneId ))
	// return 0;
	
	// $timeZone = TimeZone::model ()->findByPk ( $timeZoneId );
	// if (empty ( $timeZone ))
	// return 0;
	
	// $interval = $timeZone ['tz_interval'];
	// if (empty ( $interval ) || $interval == 0)
	// return 0;
	
	// return floor ( $time / $interval );
	// }
	
	// public function getWashShopFeature($shopId){
	// return $this->findByPk($shopId)->washShopFeatures
	
	// }
	
	/**
	 * 返回车行可以服务档口，考虑员工因数
	 *
	 * @param int $washShopId        	
	 * @return int 车行可用档口数
	 */
	public function getStaffServiceCount($washShopId) {
		$shop = $this->findByPk ( $washShopId );
		// 洗车行员工数
		$staffCount = Staff::model ()->count ( array (
				'condition' => 's_wash_shop_id =:shop_id AND s_state>0',
				'params' => array (
						':shop_id' => $washShopId 
				) 
		) );
		
		// 2人可以服务一个洗车位
		$staffServiceCount = floor ( $staffCount / 2 );
		// 人手够则已可用档口为准，人手不够则已人为准
		$activeServiceCount = $staffServiceCount >= $shop ['ws_num'] ? $shop ['ws_num'] : $staffServiceCount;
		return $activeServiceCount;
	}
	
	/**
	 * 计算指定车行一天可用洗车位数（单位时间下,同时考虑可用员工数）
	 *
	 * @param int $shopID
	 *        	车行id
	 * @param int $intervalNum
	 *        	标准服务单元
	 * @param bool $allDay
	 *        	是否全天洗车位数，否则为截止到当前时间洗车位数
	 * @param bool $available
	 *        	是否排除以预定车位
	 * @return array 可用洗车位（基本服务时间）
	 */
	public function getServiceCount($shopID, $intervalNum = 1, $allDay = True, $available = FALSE, $bias = 0) {
		$rlt = UTool::iniFuncRlt ();
		$rlt ['data'] = 0;
		$shop = $this->findByPk ( $shopID );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '指定车行信息不纯在';
			return $rlt;
		}
		
		$restCount = 0;
		// Yii::log(CJSON::encode($rlt),'error','washshop.serviceCount');
		for($i = 0; $i < $shop ['ws_num']; $i ++) {
			$t = $this->getAvailableTime ( $shopID, $intervalNum, $bias, ! $available, $i + 1 );
			// Yii::log(CJSON::encode($t),'error','washshop.serviceCount'.$i);
			if ($t ['status']) {
				$restCount += count ( $t ['data'] );
			}
		}
		
		$rlt ['status'] = true;
		// $rlt ['msg'] = '获取可用服务数量成功';
		$rlt ['data'] = $restCount;
		// Yii::log(CJSON::encode($rlt),'error','washshop.serviceCount');
		return $rlt;
		
		// $timeZone = $shop->wsTimeZone;
		
		// $interval = $timeZone ['tz_interval'];
		// if ($interval <= 0) {
		// $rlt ['msg'] = '车行标准服务单元用时设置错误';
		// return $rlt;
		// }
		
		// // $start_time = new DateTime ( $timeZone ['tz_start'] );
		// // $start_time = $start_time->getTimestamp ();
		// $start_time = strtotime(date('Y-m-d ').$timeZone['tz_start']);
		// // // 2人可以服务一个洗车位
		// // $staffServiceCount = floor ( $staffCount / 2 );
		// // // 人手够则已可用档口为准，人手不够则已人为准
		// // $times = $staffServiceCount >= $shop ['ws_num'] ? $shop ['ws_num'] : $staffServiceCount;
		
		// $activeServiceCount = $this->getStaffServiceCount ( $shopID );
		
		// // $stop_time = new DateTime ( $timeZone ['tz_stop'] );
		// // $stop_time = $stop_time->getTimestamp ();
		// $stop_time = strtotime(date('Y-m-d ').$timeZone['tz_stop']);
		
		// // 车行全天可用车位数
		// $totalCount = floor ( ($stop_time - $start_time) / 60 / ($interval+$shop['ws_rest']) ) * $activeServiceCount;
		
		// $elapseCount = 0;
		// if (! $allDay && time () > $start_time) {
		// // $current_time = time ();
		// $elapseCount = floor ( (time() - $start_time) / 60 / ($interval+$shop['ws_rest']) ) * $activeServiceCount;
		// }
		
		// $userOrderCount = 0;
		// $bossOrderCount = 0;
		// if ($available) {
		
		// $rlt = OrderHistory::model()->getOrderStatistics($shopID, date('Y-m-d H:i:s'), date('Y-m-d 23:59:59'));
		// if ($rlt['status']) {
		// $userOrderCount=$rlt['data']['totalServiceNum'];
		// $bossOrderCount= $rlt['data']['totalCountBoss'];
		// // return $washShopItem['ws_count'] - $rlt['data']['totalServiceNum'] - $rlt['data']['totalCountBoss'];
		// }
		
		// // $timeZone = $shop->wsTimeZone;
		
		// // // $now = date('Y-m-d 00:00:00');
		// // // 查看预订订单历史中已经预定洗车位数量
		// // // 检索条件包括：订单状态、订单时间、订单所属车行
		
		// // $userOrderList = OrderHistory::model ()->findAll ( array (
		// // 'condition' => 'oh_wash_shop_id=:wash_shop_id
		// // AND oh_state>0 AND oh_date_time > :order_date_time
		// // AND oh_date_time < :order_date_time_end',
		// // 'params' => array (
		// // ':wash_shop_id' => $shopID,
		// // ':order_date_time' => date ( 'Y-m-d 00:00:00' ) ,
		// // ':order_date_time_end'=>date ( 'Y-m-d 23:59:59' )
		// // )
		// // ) );
		
		// // foreach ( $userOrderList as $key => $value ) {
		// // $userOrderCount += $value ['oh_service_num'];
		// // }
		
		// // // return $user_order_count;
		// // $bossOrderList = BossOrderHistory::model ()->findAll ( array (
		// // 'condition' => 'boh_wash_shop_id=:wash_shop_id
		// // AND boh_state>0 AND boh_date_time > :order_date_time
		// // AND boh_date_time < :order_date_time_end',
		// // 'params' => array (
		// // ':wash_shop_id' => $shopID,
		// // ':order_date_time' => date ( 'Y-m-d 00:00:00' ) ,
		// // ':order_date_time_end'=>date ( 'Y-m-d 23:59:59' )
		// // )
		// // ) );
		
		// // foreach ( $bossOrderList as $key => $value ) {
		// // $bossOrderCount += $value ['boh_service_num'];
		// // }
		// }
		
		// // 返回车行可用洗车位
		
		// $temp = $totalCount - $elapseCount - $userOrderCount - $bossOrderCount;
		
		// $rlt ['status'] = true;
		// // $rlt ['msg'] = '获取可用服务数量成功';
		// $rlt ['data'] = $temp > 0 ? $temp : 0;
		// return $rlt;
	}
	
	/**
	 * 根据位置编码检索总洗车位
	 *
	 * @param string $placeCode
	 *        	'01____':根据省份检索 '__01__'根据城市检索 '__0102'根据城市城区检索
	 * @return array 总洗车位数目
	 */
	public function getTotalParkingCount($placeCode) {
		$rlt = UTool::iniFuncRlt ();
		$washShopItems = $this->findAll ( array (
				'condition' => 'ws_area_code LIKE :condition',
				'params' => array (
						':condition' => "$placeCode" 
				) 
		) );
		
		$totalCount = 0;
		
		foreach ( $washShopItems as $item ) {
			$totalCount += $item ['ws_count'];
		}
		$rlt ['data'] = $totalCount;
		$rlt ['status'] = true;
		return $rlt;
	}
	
	// /**
	// * 根据车行id 时间段序号返回该时间段服务时间
	// *
	// * @param int $shopId
	// * @param int $index
	// * @param int $serviceIntervalNum
	// * @param int $bias
	// * @return array
	// */
	// public function getServiceTimeByIndex($shopId, $timeIndex, $serviceIntervalNum, $bias) {
	// $rlt = UTool::iniFuncRlt ();
	// $shop = $this->findByPk ( $shopId );
	// if (! isset ( $shop )) {
	// $rlt ['msg'] = '00001';
	// return $rlt;
	// }
	
	// $timeZone = $shop->wsTimeZone;
	// // 构造开始营业时间
	// // $start_time =new DateTime(date('Y-m-d ',strtotime('+1 days')).$time_zone['tz_start']);
	// $startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $timeZone ['tz_start'] );
	// $startTime = $startTime->getTimestamp ();
	
	// // 检车间隔合法性
	// $interval = $timeZone ['tz_interval'];
	// if (! isset ( $interval ) || $interval <= 0) {
	// $rlt ['msg'] = '00002';
	// return $rlt;
	// }
	
	// $begin = $startTime + $timeIndex * $interval * 60;
	// $end = $begin + $serviceIntervalNum * $interval * 60;
	// // $end = $startTime + ($timeIndex + $serviceIntervalNum) * $interval * 60;
	
	// // 设置结果数据默认值
	// $resultData = array (
	// 'begin' => date ( 'Y-m-d H:i:00', $begin ),
	// 'end' => date ( 'Y-m-d H:i:00', $end )
	// );
	// $rlt ['status'] = true;
	// $rlt ['data'] = $resultData;
	// return $rlt;
	// }
	
	/**
	 * 根据车行id，时间段信息返回可用员工
	 *
	 * @param int $shopId        	
	 * @param int $index
	 *        	时间段序号
	 * @param int $serviceIntervalNum
	 *        	间隔
	 * @param int $bias        	
	 * @return array
	 */
	public function getAvailableStaff($shopId, $index, $serviceIntervalNum, $bias = 0) {
		$rlt = UTool::iniFuncRlt ();
		// $rltGetServiceTimeByIndex = $this->getServiceTimeByIndex ( $shopId, $index, $serviceIntervalNum, $bias );
		$rltGetOrderTime = Order::getOrderTime ( $shopId, $index, $serviceIntervalNum, $bias );
		
		if (! $rltGetOrderTime ['status']) {
			return $rltGetOrderTime;
		}
		$shop = $this->findByPk ( $shopId );
		
		// 用户订单
		$criteria = new CDbCriteria ();
		$criteria->condition = "((oh_date_time <= :order_date_time_begin
					AND oh_date_time_end >= :order_date_time_end)
				OR (oh_date_time >= :order_date_time_begin
					AND oh_date_time_end <= :order_date_time_end)
				OR (oh_date_time >= :order_date_time_begin
					AND oh_date_time <= :order_date_time_end)
				OR (oh_date_time_end >= :order_date_time_begin
					AND oh_date_time_end <= :order_date_time_end))";
		$criteria->addCondition ( 'oh_wash_shop_id=:wash_shop_id' );
		$criteria->addCondition ( 'oh_state>0', 'AND' );
		$criteria->params [':order_date_time_begin'] = $rltGetOrderTime ['data'] ['begin'];
		$criteria->params [':order_date_time_end'] = $rltGetOrderTime ['data'] ['end'];
		$criteria->params [':wash_shop_id'] = $shopId;
		$orders = OrderHistory::model ()->findAll ( $criteria );
		
		$staffUsed = array ();
		foreach ( $orders as $i => $value ) {
			array_push ( $staffUsed, $value ['oh_staff_id1'], $value ['oh_staff_id2'] );
		}
		
		// 检查员工病事假
		$criteria1 = new CDbCriteria ();
		$criteria1->condition = "((se_date_time <= :se_date_time_begin
					AND se_date_time_end >= :se_date_time_end)
				OR (se_date_time >= :se_date_time_begin
					AND se_date_time_end <= :se_date_time_end)
				OR (se_date_time >= :se_date_time_begin
					AND se_date_time <= :se_date_time_end)
				OR (se_date_time_end >= :se_date_time_begin
					AND se_date_time_end <= :se_date_time_end))";
		$criteria1->addCondition ( 'se_wash_shop_id=:wash_shop_id' );
		$criteria1->params [':se_date_time_begin'] = $rltGetOrderTime ['data'] ['begin'];
		$criteria1->params [':se_date_time_end'] = $rltGetOrderTime ['data'] ['end'];
		$criteria1->params [':wash_shop_id'] = $shopId;
		$event = StaffEvent::model ()->findAll ( $criteria1 );
		
		foreach ( $event as $i => $value ) {
			array_push ( $staffUsed, $value ['se_staff_id'] );
		}
		
		$rltGetStaffs = Staff::model ()->getStaffs ( $shopId, true );
		if (! isset ( $rltGetStaffs ['status'] )) {
			return $rltGetStaffs;
		}
		$staffs = $rltGetStaffs ['data'];
		
		$rltData = array ();
		foreach ( $staffs as $i => $staff ) {
			// $temp = array ();
			// $temp = $staff;
			
			if (! in_array ( $staff ['id'], $staffUsed )) {
				// $temp ['available'] = true;
				array_push ( $rltData, $staff ['id'] );
			} else {
				// $temp ['available'] = false;
			}
			// array_push ( $rltData, $temp );
			// $rltData[$i]=$temp;
		}
		
		$rlt ['data'] = $rltData;
		$rlt ['status'] = true;
		
		return $rlt;
	}
	
	/**
	 * 返回车行可用洗车位数目
	 *
	 * @param int $shopId
	 *        	车行id
	 * @return number 车行可用洗车位
	 */
	public function getAvailableParkingCount($shopId) {
		// return $this->count('ws_no=4');
		// $washShopItem = $this->find ( 'ws_no=1' );
		$washShopItem = $this->findByPk ( $shopId );
		// return $wash_shop_item;
		
		// 如果车行id没有匹配项，则可用洗车位为0
		if (empty ( $washShopItem ))
			return 0;
			
			// 如果车行状态不正常，则直接返回0
		if ($washShopItem ['ws_state'] != WashShop::SHOP_STATE_NORM)
			return 0;
		
		$rlt = OrderHistory::model ()->getOrderStatistics ( $shopId, date ( 'Y-m-d 00:01' ), date ( 'Y-m-d 23:59:59' ) );
		if (! $rlt ['status']) {
			return 0;
		}
		// return $boss_order_count;
		// 总数减去已经预定洗车位数量
		return $washShopItem ['ws_count'] - $rlt ['data'] ['totalServiceNum'] - $rlt ['data'] ['totalCountBoss'];
	}
	
	/**
	 * 根据车行，时间段，服务类型，偏移量计算车行服务时间
	 *
	 * @param int $shopId
	 *        	车行id
	 * @param int $timeIndex
	 *        	时间段序号
	 * @param number $serviceTypeId
	 *        	服务类别编号
	 * @param number $bias
	 *        	与当天便宜量
	 * @return string
	 */
	public function getServiceTime($shopId, $timeIndex, $serviceIntervalNum = 1, $bias = 0, $position = 1) {
		$rlt = UTool::iniFuncRlt ();
		// 时间段排序实际上应该从0开始
		// $timeIndex -= 1;
		
		$rltGetServiceTimeByIndex = Order::getOrderTime ( $shopId, $timeIndex, $serviceIntervalNum, $bias );
		if (! $rltGetServiceTimeByIndex ['status']) {
			return $rltGetServiceTimeByIndex;
		}
		
		// 查询车行服务时间
		$washShop = $this->findByPk ( $shopId );
		
		$timeZone = $washShop->wsTimeZone;
		
		// 设置结果数据默认值
		$resultData = array (
				'begin' => $rltGetServiceTimeByIndex ['data'] ['begin'],
				'end' => $rltGetServiceTimeByIndex ['data'] ['end'],
				'available' => true,
				'bossOrdered' => false,
				'userOrdered' => false 
		);
		// ;
		
		// 检查老板预定信息表
		$bossOrderCount = BossOrderHistory::model ()->count ( array (
				'condition' => 'boh_wash_shop_id=:wash_shop_id
				AND boh_state>0 AND ((boh_date_time <= :order_date_time_begin
					AND boh_date_time_end >= :order_date_time_end) 
				OR (boh_date_time >= :order_date_time_begin
					AND boh_date_time_end <= :order_date_time_end)
				OR (boh_date_time >= :order_date_time_begin
					AND boh_date_time <= :order_date_time_end)
				OR (boh_date_time_end >= :order_date_time_begin
					AND boh_date_time_end <= :order_date_time_end))
				AND boh_position = :position',
				'params' => array (
						':wash_shop_id' => $shopId,
						':order_date_time_begin' => $rltGetServiceTimeByIndex ['data'] ['begin'],
						':order_date_time_end' => $rltGetServiceTimeByIndex ['data'] ['end'],
						':position' => $position 
				) 
		) );
		// 是否老板自己预定
		$resultData ['bossOrdered'] = $bossOrderCount >= 1 ? true : false;
		
		// 返回1天内可用时间段
		// 构造开始营业时间
		// $start_time =new DateTime(date('Y-m-d ',strtotime('+1 days')).$time_zone['tz_start']);
		// $startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $timeZone ['tz_start'] );
		// $startTime = $startTime->getTimestamp ();
		// $currentTime = time ();
		
		// $interval = $timeZone ['tz_interval'];
		
		// $begin = $startTime + ($timeIndex-1) * $interval * 60;
		// $end = $begin + $serviceIntervalNum * $interval * 60 + $washShop['ws_rest']*60;
		
		$begin = strtotime ( $rltGetServiceTimeByIndex ['data'] ['begin'] );
		$end = strtotime ( $rltGetServiceTimeByIndex ['data'] ['nextBegin'] );
		
		// 如果当前时间大于开始时间，则该时间段不可用
		// 老板自己预定，则该时间段不可用
		if ($begin < time () || $resultData ['bossOrdered']) {
			$resultData ['available'] = false;
			$rlt ['status'] = true;
			$rlt ['msg'] = '获取服务时间成功';
			$rlt ['data'] = $resultData;
			return $rlt;
		}
		
		// 构造停止时间
		$stopTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $timeZone ['tz_stop'] );
		$stopTime = $stopTime->getTimestamp ();
		$stopTime += $washShop ['ws_rest'] * 60;
		// $userOrderCount=0;
		// $userOrderCountCurrentPosition=0;
		// // $bossOrderCount=0;
		
		if ($end > $stopTime) {
			$resultData ['end'] = date ( 'Y-m-d H:i:00', $stopTime - $washShop ['ws_rest'] * 60 );
			$resultData ['available'] = false;
			
			$rlt ['status'] = true;
			$rlt ['msg'] = '获取服务时间成功';
			$rlt ['data'] = $resultData;
			return $rlt;
		}
		
		$criteria = new CDbCriteria ();
		
		// $now = date('Y-m-d 00:00:00');
		// 查看预订订单历史中已经预定洗车位数量
		// 检索条件包括：订单状态、订单时间、订单所属车行
		$userOrderCountCurrentPosition = OrderHistory::model ()->count ( array (
				'condition' => '((oh_date_time <= :order_date_time_begin
					AND oh_date_time_end >= :order_date_time_end) 
				OR (oh_date_time >= :order_date_time_begin
					AND oh_date_time_end <= :order_date_time_end)
				OR (oh_date_time >= :order_date_time_begin
					AND oh_date_time <= :order_date_time_end)
				OR (oh_date_time_end >= :order_date_time_begin
					AND oh_date_time_end <= :order_date_time_end))
				AND oh_wash_shop_id=:wash_shop_id
				AND	oh_state>0 
				AND oh_position = :position',
				'params' => array (
						':wash_shop_id' => $shopId,
						':order_date_time_begin' => date ( 'Y-m-d H:i:00', $begin ),
						':order_date_time_end' => date ( 'Y-m-d H:i:00', $end ),
						':position' => $position 
				) 
		) );
		
		// Yii::log(date('Y-m-d H:i:00', $begin),'error','orders.time.*');
		// Yii::log($userOrderCountCurrentPosition,'error','orders.time.*');
		$resultData ['userOrdered'] = $userOrderCountCurrentPosition >= 1 ? true : false;
		
		if ($userOrderCountCurrentPosition >= 1) {
			$resultData ['available'] = false;
			// 是否老板自己预定
			
			$rlt ['status'] = true;
			$rlt ['msg'] = '获取服务时间成功';
			$rlt ['data'] = $resultData;
			return $rlt;
		}
		// OR (oh_date_time >= :order_date_time_begin
		// AND oh_date_time_end <= :order_date_time_end)
		// OR (oh_date_time >= :order_date_time_begin
		// AND oh_date_time_end >= :order_date_time_end)
		// OR (oh_date_time <= :order_date_time_begin
		// AND oh_date_time_end <= :order_date_time_end)
		
		// 根据员工数与已经存在订单数判断时间段是否可用
		// $userOrderCount = OrderHistory::model ()->count ( array (
		// 'condition' => '((oh_date_time <= :order_date_time_begin
		// AND oh_date_time_end >= :order_date_time_end)
		// OR (oh_date_time >= :order_date_time_begin
		// AND oh_date_time_end <= :order_date_time_end)
		// OR (oh_date_time >= :order_date_time_begin
		// AND oh_date_time <= :order_date_time_end)
		// OR (oh_date_time_end >= :order_date_time_begin
		// AND oh_date_time_end <= :order_date_time_end))
		// AND oh_wash_shop_id=:wash_shop_id
		// AND oh_state>0 ',
		// 'params' => array (
		// ':wash_shop_id' => $shopId,
		// ':order_date_time_begin' => date ( 'Y-m-d H:i:00', $begin ),
		// ':order_date_time_end' => date ( 'Y-m-d H:i:00', $end )
		// )
		// ) );
		
		// if ($userOrderCount >= $this->getStaffServiceCount ( $shopId )) {
		// $resultData ['available'] = false;
		// // $resultData ['userOrdered'] = false;
		// $rlt ['status'] = true;
		// $rlt ['msg'] = '获取服务时间成功,';
		// $rlt ['data'] = $resultData;
		// return $rlt;
		// }
		
		// 根据可用员工数判断该时间段是否可用
		$staffs = $this->getAvailableStaff ( $shopId, $timeIndex, $serviceIntervalNum, $bias );
		if ($staffs ['data']) {
			$staffs = $staffs ['data'];
			$staffCount = count ( $staffs );
			if (floor ( $staffCount / 2 ) < 1) {
				$resultData ['available'] = false;
				// $resultData ['userOrdered'] = false;
				$rlt ['status'] = true;
				$rlt ['msg'] = '获取服务时间成功,';
				$rlt ['data'] = $resultData;
				return $rlt;
			}
		}
		
		$rlt ['status'] = true;
		$rlt ['msg'] = '获取服务时间成功,';
		$rlt ['data'] = $resultData;
		return $rlt;
		
		// if ($userOrderCountCurrentPosition >=1
		// || $bossOrderCount >=1
		// || $userOrderCount >= $this->getStaffServiceCount($shopId)
		// ) {
		// $resultData ['available'] = false;
		// }
		
		// if (($userOrderCount + $bossOrderCount) >= 1)
		// $result ['available'] = false;
		
		// return $resultData;
	}
	
	// public function getAvailableStaff($shopId, $inmeIndex, $bias){
	
	// $rlt= UTool::iniFuncRlt();
	// $shop = $this->findByPk($shopId);
	// if (!isset($shop)) {
	// Yii::log('getAvailableStaff,指定车行信息不存在','trace','debug.shop.staff');
	// $rlt['msg'] = '00001';
	// return $rlt;
	// }
	// $orders = $shop->orderHistories;
	
	// $staffs = Staff::model()->findByAttributes(array(
	// 's_wash_shop_id'=>$shopId,
	// ));
	
	// }
	
	/**
	 * 返回时间段是否可用
	 *
	 * @param unknown $shop_id        	
	 * @param number $service_type_id        	
	 * @param unknown $time_index        	
	 */
	public function isTimeAvailable($shopId, $time_index, $service_type_id = 1) {
		$bossOrderCount = BossOrderHistory::model ()->count ( array (
				'condition' => 'boh_wash_shop_id=:wash_shop_id
				AND boh_state>0 AND boh_date_time >= :order_date_time_begin
				AND boh_date_time < :order_date_time_end
				AND boh_position = :position',
				'params' => array (
						':wash_shop_id' => $shopId,
						':order_date_time_begin' => date ( 'Y-m-d H:i:00', $begin ),
						':order_date_time_end' => date ( 'Y-m-d H:i:00', $end ),
						':position' => $position 
				) 
		) );
	}
	
	/**
	 * 根据车行id返回车行特色服务
	 *
	 * @param int $washShopId        	
	 * @return string json
	 */
	function getWashShopFeatures($washShopId) {
		$rlt = UTool::iniFuncRlt ();
		$shop = WashShop::model ()->findByPk ( $washShopId );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '指定车行信息不存在';
			return $rlt;
		}
		
		$rlt ['data'] = $shop->washShopFeatures;
		$rlt ['status'] = true;
		return $rlt;
	}
	
	/**
	 * 根据车行id获取车行信息
	 *
	 * @param int $washshopId        	
	 * @return string
	 */
	public function getWashShopInfo($washshopId) {
		// $rlt = WashShop::model()->findByPk(1 )->attributes;
		$rlt = UTool::iniFuncRlt ();
		$shop = WashShop::model ()->findByPk ( $washshopId );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '指定车行信息不存在';
			return $rlt;
		}
		$rlt ['data'] = $shop->attributes;
		$rlt ['status'] = true;
		// $shopFeatures = WashShop::model()->findByPk(1)->washShopFeatures;
		
		// foreach ($shopFeatures as $name=>$value){
		// $rlt['shop_features'][$name] = $value->attributes;
		// }
		
		return $rlt;
	}
	
	/**
	 * 根据车行id，服务类型返回可用时间段
	 *
	 * @param int $shopId
	 *        	车行id
	 * @param int $serviceIntervalNum
	 *        	标准服务单元用时数
	 * @param int $bias
	 *        	与当天偏移 0-6返回当天到后6天
	 * @param bool $showAllState
	 *        	是否返回全天状态，否则只返回现在到营业时间结束时间段可以洗车位
	 * @param int $position
	 *        	洗车档口位置
	 * @return array [state,msg,data]可用时间段
	 */
	public function getAvailableTime($shopId, $serviceIntervalNum = 1, $bias = 0, $showAllState = FALSE, $position = 1) {
		// 设置返回值初始值
		$rlt = UTool::iniFuncRlt ();
		
		$washShop = $this->findByPk ( $shopId );
		if (! isset ( $washShop )) {
			$rlt ['msg'] = '00001';
			return $rlt;
		}
		
		// 如果档口位置超出车行位置数，则直接返回空
		if ($position > $washShop ['ws_num']) {
			$rlt ['msg'] = '00007';
			return $rlt;
		}
		
		// 查询车行服务时间
		$timeZone = $washShop->wsTimeZone;
		
		// 返回1天内可用时间段
		// 构造开始营业时间
		// $start_time =new DateTime(date('Y-m-d ',strtotime('+1 days')).$time_zone['tz_start']);
		$startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $timeZone ['tz_start'] );
		$startTime = $startTime->getTimestamp ();
		// 检车间隔合法性
		$interval = $timeZone ['tz_interval'];
		if (! isset ( $interval ) || $interval <= 0) {
			$rlt ['msg'] = '00002';
			return $rlt;
		}
		
		// 构造停止营业时间
		$stopTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $timeZone ['tz_stop'] );
		$stopTime = $stopTime->getTimestamp ();
		
		// 计算一个档口营业单元数
		$count = ($stopTime - $startTime) / (60 * $interval);
		
		Yii::log ( $count, 'error', 'order.washshop.count' );
		// $count = $washShop ['ws_count'];
		// $count = $count / $washShop['ws_num'];
		// $count = $count / $serviceIntervalNum;
		
		$timeList = array ();
		
		$preTime = date ( 'H:i', $startTime );
		
		for($i = 1; $i <= $count; $i ++) {
			
			$serviceTimeRlt = $this->getServiceTime ( $shopId, $i, $serviceIntervalNum, $bias, $position );
			if ($serviceTimeRlt ['status']) {
				// 如果方法成功执行则继续如下处理
				$serviceTime = $serviceTimeRlt ['data'];
				Yii::log ( CJSON::encode ( $serviceTime ), 'error', 'order.time.state' );
				$timeBegin = new DateTime ( $serviceTime ['begin'] );
				$timeEnd = new DateTime ( $serviceTime ['end'] );
				if ($timeEnd->getTimestamp () > $stopTime || $timeBegin->getTimestamp () > $stopTime) {
					Yii::log ( date ( 'Y-m-d H:i:s', $timeEnd->getTimestamp () ), 'error', 'order.time.available' );
					break;
				}
				// if (true || $timeBegin->getTimestamp () > time ()) {
				$preTime = date ( 'Y-m-d H:i', $timeBegin->getTimestamp () );
				$params = date ( 'H:i', $timeEnd->getTimestamp () );
				
				if (! $showAllState && $serviceTime ['available']) {
					// 如下只返回可用时间段信息
					$timeList [$i] = array (
							'timeIndex' => $i,
							'timeStr' => "$preTime-$params",
							'available' => $serviceTime ['available'],
							'bossOrdered' => $serviceTime ['bossOrdered'],
							'userOrdered' => $serviceTime ['userOrdered'] 
					);
					
					// $i = $i + ($serviceIntervalNum - 1);
				} elseif ($showAllState) {
					// 如下返回全天信息，不管可用不可用
					$timeList [$i] = array (
							'timeIndex' => $i,
							'timeStr' => "$preTime-$params",
							'available' => $serviceTime ['available'],
							'bossOrdered' => $serviceTime ['bossOrdered'],
							'userOrdered' => $serviceTime ['userOrdered'] 
					);
					
					// $i = $i + ($serviceIntervalNum - 1);
				}
				// }
			}
			
			$i = $i + ($serviceIntervalNum - 1);
			// $params = date('H:i',$startTime+$i*$interval*60);
			// $timeList[$i]=array('timeStr'=>"$preTime-$params", 'available'=>true, 'timeDetail'=>$this->getServiceTime($shop_id, $i*$serviceIntervalNum-1, $service_type_id));
			// $preTime = $params;
		}
		
		$rlt ['status'] = true;
		$rlt ['msg'] = '返回时间段信息成功';
		$rlt ['data'] = $timeList;
		
		Yii::log ( CJSON::encode ( $timeList ), 'error', 'order.time.list' );
		return $rlt;
	}
	
	/**
	 * 新插入车行时自动编号
	 *
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave() {
		if (parent::beforeSave ()) {
			if ($this->isNewRecord) {
				$lastItem = $this->findAll ( array (
						// 'condition'=>'a_city_no='.$this->a_city_no,
						'order' => 'ws_no DESC',
						'limit' => 1 
				) );
				
				if (! empty ( $lastItem ))
					
					$this->ws_no = $lastItem [0] ['ws_no'] + 1;
				else
					$this->ws_no = 1;
			}
			
			return true;
		} else
			return false;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 *         based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id, true );
		$criteria->compare ( 'ws_no', $this->ws_no );
		$criteria->compare ( 'ws_name', $this->ws_name, true );
		$criteria->compare ( 'ws_score', $this->ws_score );
		$criteria->compare ( 'ws_address', $this->ws_address, true );
		$criteria->compare ( 'ws_boss_id', $this->ws_boss_id, true );
		$criteria->compare ( 'ws_state', $this->ws_state );
		$criteria->compare ( 'ws_num', $this->ws_num );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className
	 *        	active record class name.
	 * @return WashShop the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
