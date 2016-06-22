<?php

/**
 * This is the model class for table "{{order_temp}}".
 *
 * The followings are the available columns in table '{{order_temp}}':
 * @property string $id
 * @property string $ot_wash_shop_id
 * @property string $ot_date_time
 * @property string $ot_date_time_end
 * @property integer $ot_state
 * @property integer $ot_position
 * @property string $ot_staff_id1
 * @property string $ot_staff_id2
 *
 * The followings are the available model relations:
 * @property User $otUser
 * @property WashShop $otWashShop
 */
class OrderTemp extends CActiveRecord
{
	const STATE_BOSS_DISABLED = 0;
	const STATE_READY = 1;
	const STATE_ORDERED = 2;
	const STATE_DISABLED_BY_ORDERED = 3;

	
//     public $ot_value;
    
    /*
     * 最低价格
     */
    public $ot_min_value;
    
    /*
     * 剩余车位
     */
    public $ot_count;
    
    public $ot_ordered_count; 

//     public $ot_discount;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{order_temp}}';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'ot_wash_shop_id, ot_date_time, ot_date_time_end',
                'required'
            ),
            array(
                'ot_state, ot_position',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'ot_wash_shop_id, ot_user_id',
                'length',
                'max' => 10
            ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, ot_wash_shop_id, ot_date_time, ot_date_time_end, ot_state, ot_user_id, ot_position,',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'otUser' => array(
                self::BELONGS_TO,
                'User',
                'ot_user_id'
            ),
            'otWashShop' => array(
                self::BELONGS_TO,
                'WashShop',
                'ot_wash_shop_id'
            ),
        	
        )
        ;
    }
    
    
//     function updateShopOrderTemp($shopId){
    	
    	
//     }
    
    /**
     * 按天删除临时订单表
     *
     * @param int $shopId
     * @param int $bias
     * @return string
     */
    public function deleteOrderTempTable($shopId,$serviceId, $bias) {
    	$rlt = UTool::iniFuncRlt ();
//     	$shop = WashShop::model()->findByPk ( $shopId );
//     	if ($shop === null) {
//     		$rlt ['msg'] = '车行不存在';
//     		return $rlt;
//     	}
    
    	$rlt['data'] = OrderTemp::model ()->deleteAllByAttributes ( array (
    	'ot_wash_shop_id' => $shopId,
    	'ot_type'=>$serviceId,
    	'ot_bias' => $bias
    	) );

    	$rlt['status']=TRUE;
    	return $rlt;
    }
    
    
    public function getTimeInfoList($shopId, $serviceId, $bias){
    	$rlt=UTool::iniFuncRlt();
    	
    	$timeList = $this->findAllByAttributes(array(
    			'ot_wash_shop_id'=>$shopId,
    			'ot_type'=>$serviceId,
    			'ot_bias'=>$bias,
    	));
    	
    	return $timeList;
    }
    
    
    /**
     * 车行时间段信息初始化
     * @param int $shopId
     * @return Ambigous <multitype:, boolean>
     */
    public function iniOrderTemp($shopId){
    	$rlt = UTool::iniFuncRlt();
    	$criteria = new CDbCriteria();
    	$criteria->addCondition('wss_ws_id=:shopId');
    	$criteria->params[':shopId'] = $shopId;
    	
    	$criteria->compare('wss_state', array(WashShopService::SHOP_SERVICE_ACTIVE,WashShopService::SHOP_SERVICE_DEACTIVE));
    	$criteria->group = "wss_st_id";
    	$criteria->order="wss_st_id ASC, wss_car_group ASC";
    	$shopServiceList = WashShopService::model()->findAll($criteria);
    	
    	if ($shopServiceList === null){
    		$rlt['msg']='未开通服务';
    		return 	$rlt;
    	}
    	
    	foreach ($shopServiceList as $key=>$service){
    		$this->_iniOrderTempFromService($shopId, $service['wss_st_id'], $service['wss_value'], $service['wss_count'], 
    				$service['wss_service_time'], $service['wss_service_time_rest'], 0,TRUE);
    		$this->_iniOrderTempFromService($shopId, $service['wss_st_id'], $service['wss_value'], $service['wss_count'],
    				$service['wss_service_time'], $service['wss_service_time_rest'],  1,TRUE);
    		$this->_iniOrderTempFromService($shopId, $service['wss_st_id'], $service['wss_value'], $service['wss_count'],
    				$service['wss_service_time'], $service['wss_service_time_rest'], 2,TRUE);
    	}
    	$rlt['status']=TRUE;
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
    private function _iniOrderTempFromService($shopId, $serviceId, $price,  $positionCount, $serviceTime, $serviceTimeRest, $bias,$isForce=FALSE) {
    	$rlt = UTool::iniFuncRlt();
    	$shop = WashShop::model()->findByPk ( $shopId );
    	if ($shop === null){
    		$rlt['msg']= '车行不存在';
    		return $rlt;
    	}
    	
    	if ($isForce){
    		$r = $this->deleteOrderTempTable($shopId, $serviceId, $bias);
    		Yii::log(json_encode($r),CLogger::LEVEL_INFO,'mngr.delete.*');
    	}
    	
    	$startTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $shop ['ws_open_time'] );
    	$startTime = $startTime->getTimestamp ();
    
    	$endTime = new DateTime ( date ( 'Y-m-d ', strtotime ( '+' . $bias . ' days' ) ) . $shop ['ws_close_time'] );
    	$endTime = $endTime->getTimestamp ();
    
    	$orderTime = $startTime;
    	$orderTimeEnd = $orderTime + $serviceTime * 60;
    
    	$orderState = OrderTemp::STATE_READY;
    
//     	$order = new OrderTemp ();
    	$index=0;
    	while ( $orderTimeEnd <= $endTime ) {
    		$order = new OrderTemp ();
    		$order->isNewRecord = TRUE;
    		$order ['ot_wash_shop_id'] = $shop ['id'];
    		$order ['ot_date_time'] = date ( 'H:i:00', $orderTime );
    		$order ['ot_date_time_end'] = date ( 'H:i:00', $orderTimeEnd );
    
    		$order['ot_value'] = $price;
    		$order['ot_value_discount'] = 0;
    
    		$order ['ot_user_id'] = 0; // 默认值，没有实际意义
    		$order ['ot_type'] = $serviceId;
    
    		$order ['ot_state'] = $orderState;
    		$order ['ot_position'] = $positionCount;
    		$order ['ot_bias'] = $bias;
    		$order['ot_index']=$index;
    		if ($order->save ()) {
    		} else {
    			Yii::log ( CJSON::encode ( $order ), 'warning', 'washshop.order._generateOrderTempTable' );
    		}
    
    		$orderTime = $orderTimeEnd +$serviceTimeRest * 60;
    		$orderTimeEnd = $orderTime + $serviceTime * 60;
    		$index++;
    	}
    	$rlt['status']=TRUE;
    	return $rlt;
    	
    	
    }
    
    
    /**
     * 根据车行基本信息，包括最低价格，
     * @param array $shopIdList 单个值或数组
     * @param array $serviceTypeList 单个值或数组
     * @param  time $dateTimeBegin
     * @param time $dateTimeEnd
     * @param int $bias
     * @return array
     */
    function getShopInfoList($shopIdList, $serviceTypeList, $dateTimeBegin, $dateTimeEnd,$bias=0){
    	$minValueList = $this->getShopMinValue($shopIdList, $serviceTypeList, $dateTimeBegin, $dateTimeEnd,$bias,TRUE);
    	$TotalCountList = $this->getShopCount($shopIdList, $serviceTypeList, $dateTimeBegin, $dateTimeEnd, $bias,false);
    	
    	
    	
    	$shopInfoList=array();
    	
//     	根据车行总数得到车行列表
    	foreach ($TotalCountList as $key=>$shop){
//     		$temp = $shop;
    		$temp = array(
    				'id'=>$shop['id'], 
    				'countTotal'=>$shop['count'],
    				'countOrdered'=>$shop['countOrdered'],
    				'valueMin'=>$shop['valueMin']
    		);
//     		$tempShopInfo = $minValueList[$shop['id']];
    		if (isset($minValueList[$shop['id']])){
    			$tempShopInfo = $minValueList[$shop['id']];
    		}else{
    			$tempShopInfo = $this->getShopMinValue($shop['id'], $serviceTypeList, $dateTimeBegin, $dateTimeEnd,$bias,FALSE);
    			$tempShopInfo = $tempShopInfo[$shop['id']];
    			$tempShopInfo['countAvailable']=0;
//     			  array(
//     				'id'=>$shop['id'],
//     				'countAvailable'=>0,
//     				'valueMin'=>4,
//     				'valueDiscount'=>1,
//     		);
    		}
    		
    		$tempShopInfo = array_slice($tempShopInfo, 1);
    		
    		$temp = array_merge($temp,$tempShopInfo);
    		$shopInfoList[$shop['id']]= $temp;
    	
    		
    		
//     		$rltList[$model['ot_wash_shop_id']] = array(
//     				'id'=>$model['ot_wash_shop_id'],
//     				'countAvailable'=>$model['ot_count'],
//     				'valueMin'=>$model['ot_min_value'],
//     				'valueDiscount'=>$model['ot_value_discount'],
// //     		);
    		
//     		$temp[] = $shopTotalCount;
//     		$shopInfoList[$shop['id']]= $temp;
    	
    	}
    	
//     	根据当前可用时间最小价格得到车行列表
//     	foreach ($minValueList as $key=>$shop){
// 			$temp = $shop;
// 			$shopTotalCount = @$TotalCountList[$shop['id']]['count'];
// 			$temp['countTotal'] = $shopTotalCount;
// 			$shopInfoList[$shop['id']]= $temp;

//     	}
    	
    	return $shopInfoList;
    }
    
    
    /**
     * 根据车行id数组获取车行制定时间段内指定服务最低价格
     * @param array $shopIdList 单个值或数组
     * @param array $serviceTypeList 单个值或数组
     * @param  time $dateTimeBegin
     * @param time $dateTimeEnd
     * @param int $bias
     * @return array 
     */
    function getShopMinValue($shopIdList, $serviceTypeList, $dateTimeBegin, $dateTimeEnd,$bias=0,$isAvailable=TRUE){
//     	$rltList = array();
    
    	$criteria = new CDbCriteria();
    	
    	$criteria->select = array(
    			"sum(ot_position) as ot_count",
    			"min(ot_value) as ot_min_value",
    			'sum(ot_order_count) as ot_ordered_count',
    			"ot_wash_shop_id",
    			'ot_value_discount'
    			
    	);
//     	  "count(*) as ot_count, (ot_value) as ot_min_value, ot_wash_shop_id";
    	
    	$criteria->compare('ot_wash_shop_id', $shopIdList);
    	$criteria->compare('ot_type', $serviceTypeList);

    	

    	
    

    	
    	$criteria->addCondition('ot_bias=:bias');
    	$criteria->params[':bias']=$bias;
    	
        if ($isAvailable){
    		$criteria->compare('ot_state', OrderTemp::STATE_READY);
    		
    		if ($bias ==0 && $dateTimeBegin< date('H:i',time())){
    			$dateTimeBegin = date('H:i:00',time());
    		}

    		
    		
    	}else{
    		$criteria->compare('ot_state',array(OrderTemp::STATE_READY,
    				OrderTemp::STATE_ORDERED,
    				OrderTemp::STATE_DISABLED_BY_ORDERED,
    				OrderTemp::STATE_BOSS_DISABLED
    		) );
//     		$criteria->addCondition("ot_state>=0");
    	}
    	
    	$criteria->addCondition('ot_date_time>:timeBegin');
    	$criteria->params[':timeBegin']=$dateTimeBegin;
    	$criteria->addCondition('ot_date_time_end<:timeEnd');
    	$criteria->params[':timeEnd']=$dateTimeEnd;
    	
    	$criteria->order = 'ot_wash_shop_id';
    	$criteria->group = "ot_wash_shop_id";
//     	$criteria->distinct = TRUE;
    	$shopList = $this->findAll($criteria);
    	
    	$rltList=array();
    	foreach ($shopList as $key=>$model){
    		$rltList[$model['ot_wash_shop_id']] = array(
    				'id'=>$model['ot_wash_shop_id'],
    				'countAvailable'=>$model['ot_count']-$model['ot_ordered_count'],
//     				'countOrdered'=>$model['ot_ordered_count'],
    				'valueDiscount'=>$model['ot_value_discount'],
    		);
    	}
    	
    	return $rltList;
    	
    }
    
    /**
     * 根据车行id数组获取车行制定时间段内可预约车位数
     * @param array $shopIdList 单个值或数组
     * @param array $serviceTypeList 单个值或数组
     * @param  time $dateTimeBegin
     * @param time $dateTimeEnd
     * @param int $bias
     * @param bool $isAvailable 是否剩余可预约 默认＝false
     * @return array shopId=>$minValue
     */
    function getShopCount($shopIdList, $serviceTypeList, $dateTimeBegin, $dateTimeEnd,$bias=0, $isAvailable=FALSE){
//     	$rltList = array();
    
    	$criteria = new CDbCriteria();
    	
    	$criteria->select = array(
    			'sum(ot_position) as ot_count',
    			'sum(ot_order_count) as ot_ordered_count',
    			"min(ot_value) as ot_min_value",
    			
    	 'ot_wash_shop_id'
    			
    	); 
    	
    	$criteria->compare('ot_wash_shop_id', $shopIdList);
    	
    	$criteria->compare('ot_type', $serviceTypeList);
    	    	
    	$criteria->addCondition('ot_date_time>:timeBegin');
    	$criteria->params[':timeBegin']=$dateTimeBegin;
    	
    
    	$criteria->addCondition('ot_date_time_end<:timeEnd');
    	$criteria->params[':timeEnd']=$dateTimeEnd;
    	
    	
    	$criteria->addCondition('ot_bias=:bias');
    	$criteria->params[':bias']=$bias;
    	

    	if ($isAvailable){
//     		$criteria->addCondition("ot_state=0");
    		$criteria->compare('ot_state', OrderTemp::STATE_READY);
    	}else{
    		$criteria->compare('ot_state',array(OrderTemp::STATE_READY,
    				OrderTemp::STATE_ORDERED,
    				OrderTemp::STATE_DISABLED_BY_ORDERED,
    				OrderTemp::STATE_BOSS_DISABLED
    		) );
//     		$criteria->addCondition("ot_state>=0");
    	}

    	
    	$criteria->order = 'ot_wash_shop_id';
    	$criteria->group = "ot_wash_shop_id";
//     	$criteria->distinct = TRUE;
    	$shopList = $this->findAll($criteria);
    	
    	$rltList=array();
    	foreach ($shopList as $key=>$model){
    		$rltList[$model['ot_wash_shop_id']] = array(
    				'id'=>$model['ot_wash_shop_id'],
    				'countOrdered'=>$model['ot_ordered_count'],
    				'count'=>$model['ot_count'],
    				'valueMin'=>$model['ot_min_value']);
    	}
    	
    	return $rltList;
    	
    }
    

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'ot_wash_shop_id' => 'Ot Wash Shop',
            'ot_date_time' => 'Ot Date Time',
            'ot_date_time_end' => 'Ot Date Time End',
            'ot_state' => 'Ot State',
            'ot_user_id' => 'Ot User',
            'ot_position' => 'Ot Position',
            'ot_staff_id1' => 'Ot Staff Id1',
            'ot_staff_id2' => 'Ot Staff Id2'
        );
    }

    /**
     * 根据城市id获取该城市总洗车位数
     * 刘长鑫
     * 20150308
     * 
     * @param int $cityId            
     * @return array()
     */
    public function getStatTotalCount($cityId, $bias = 0)
    {
        $rlt = UTool::iniFuncRlt();
        
        $criteria1 = new CDbCriteria();
        // $criteria1->addCondition ( 'ot_state>0' );
        $criteria1->addCondition('ot_bias=:bias');
        $criteria1->params[':bias'] = $bias;
        
        $criteria1->addInCondition('ot_wash_shop_id', WashShop::model()->getOnlineShop($cityId)['data']);
        // $criteria1->addCondition ( 'ot_date_time>:ctime' );
        // $criteria1->params ['ctime'] = date ( 'H:i' );
        $total = OrderTemp::model()->count($criteria1);
        $rlt['data'] = $total;
        $rlt['status'] = true;
        return $rlt;
    }

    /**
     * 根据城市id获取该城市总洗车位数
     * 刘长鑫
     * 20150308
     * 
     * @param int $cityId            
     * @return array()
     */
    public function getStatAvailableCount($cityId, $bias = 0)
    {
        $rlt = UTool::iniFuncRlt();
        
        $criteria1 = new CDbCriteria();
        $criteria1->addCondition('ot_state=1');
        $criteria1->addCondition('ot_bias=0');
        $criteria1->addCondition('ot_bias=:bias');
        $criteria1->params[':bias'] = $bias;
        
        $criteria1->addInCondition('ot_wash_shop_id', WashShop::model()->getOnlineShop($cityId)['data']);
        $criteria1->addCondition('ot_date_time>:ctime');
        $criteria1->params['ctime'] = date('H:i', time() + 20 * 60);
        $total = OrderTemp::model()->count($criteria1);
        $rlt['data'] = $total;
        $rlt['status'] = true;
        return $rlt;
    }

    /**
     * 返回车行可用时间段信息
     * 刘长鑫
     * 20150320
     */
    public function getTimeList($shopId, $serviceType, $carType, $bias = 0, $position = 1)
    {
        $rlt = UTool::iniFuncRlt();
        
        $id = $shopId;
        $sType = $serviceType;
        
        if (! is_numeric($shopId)) {
            $rlt['msg'] = '该车行不存在';
            return $rlt;
        }
        
        if (! is_numeric($serviceType) || ! is_numeric($carType) || ! is_numeric($bias) || ! is_numeric($position)) {
            $rlt['msg'] = '请求参数非法';
            return $rlt;
        }
        
        // $id = $_GET ['id'];
        // @$bias = $_GET ['bias'];
        // @$carType = $_GET ['carType'];
        // @$sType = $_GET ['sType'];
        // @$position = $_GET ['position'];
        
        $model = new OrderTemp();
        
        $criteria = new CDbCriteria();
        
        if ($carType == '2') {
            $criteria->select = 'id, ot_date_time, ot_date_time_end,
						ot_value2 as ot_value, ot_value2_discount as ot_discount, ot_state,ot_bias';
        } else {
            $criteria->select = 'id, ot_date_time, ot_date_time_end, ot_value1 as ot_value,
						ot_value1_discount as ot_discount, ot_state,ot_bias';
        }
        
        $criteria->order = 'ot_date_time ASC, id ASC';
        $criteria->addCondition('ot_wash_shop_id=:id');
        $criteria->params[':id'] = $id;
        $criteria->addCondition('ot_bias=:bias');
        $criteria->params[':bias'] = $bias;
        $criteria->addCondition('ot_type=:sType');
        $criteria->params[':sType'] = $sType;
        $criteria->addCondition('ot_position=:position');
        $criteria->params[':position'] = $position;
        
        $timeList = $model->findAll($criteria);
        
        $timeItems = array();
        foreach ($timeList as $key => $value) {
            $status=$value['ot_state'];
            if ($bias==0){
                if ( strtotime(date('Y-m-d ').$value['ot_date_time']) <  (time()+20*60) ){
                $status=-1;
                }
            }
            $item = array(
                'id' => $value['id'],
                'value' => $value['ot_value'],
                'date_time' => $value['ot_date_time'],
                'date_time_end' => $value['ot_date_time_end'],
                'status' =>$status,
            );
            $timeItems[] = $item;
        }
        
        $items['size'] = count($timeItems);
        $items['data']=$timeItems;
        $rlt['status'] = true;
        $rlt['data'] = $items;
        return $rlt;
        
        // $dataProvider = new CActiveDataProvider ( 'OrderTemp', array (
        // 'pagination' => array (
        // 'pageSize' => 80
        // ),
        // 'criteria' => $criteria
        // ) );
        
        // $this->renderPartial ( '_timeList', array (
        // 'model' => $model,
        // 'dataProvider' => $dataProvider
        // ), false, true );
        // Yii::app ()->end ();
    }

    /**
     * 用户新增订单时更新临时订单表
     * 
     * @param int $otId            
     * @param string $otStaffs            
     * @param int $userId            
     * @return string|Ambigous <string, boolean, multitype:>
     */
    public function updateOrder($otId, $otStaffs, $userId, $carType)
    {
        $rlt = UTool::iniFuncRlt();
        
        $ot = OrderTemp::model()->findByPk($otId);
        if (! isset($ot)) {
            $rlt['msg'] = '00022';
            return $rlt;
        }
        
        if ($ot['ot_state'] != 1) {
            $rlt['msg'] = '该时间已被占用，请刷新后选择其他时间';
            return $rlt;
        }
        $order_date_time = date('Y-m-d ', strtotime('+' . $ot['ot_bias'] . ' days')) . $ot['ot_date_time'];
        $order_date_time = strtotime($order_date_time);
        if (($order_date_time - time()) / 60 < 20) {
            $rlt['msg'] = '请提前20分钟预约';
            return $rlt;
        }
        
        @$staffs = split(',', $otStaffs);
        // Yii::log($otStaffs,'error','orderTemp.updateOrder.staffs');
        // Yii::log(var_dump($staffs),'error','orderTemp.updateOrder.staffs1');
        if (empty($otStaffs)) {
            $staffs = array();
        }
        // Yii::log($otStaffs,'error','orderTemp.updateOrder.staffs2');
        // Yii::log(CJSON::encode($staffs),'error','orderTemp.updateOrder.staffs3');
        
        // if (!isset($staffs) || count($staffs)<2) {
        // // $shop = WashShop::model()->findByPk($ot['ot_wash_shop_id']);
        // // if (!isset($shop)) {
        // // $rlt['msg']='';
        // // return $rlt;
        // // }
        
        // // $staffRlt = $shop->getStaffs($ot['ot_wash_shop_id'],true);
        // // if (!$staffRlt['status']) {
        // // return $staffRlt;
        // // }
        
        // $availableStaffs = OrderTempUser::model()->findAllByAttributes(array(
        // 'otu_ot_id'=>$otId,
        // 'otu_state'=>'1',
        // ),array(
        // 'order'=>'id ASC',
        // ));
        
        // //$availableStaffs = $staffRlt['data'];
        // foreach ($availableStaffs as $key=>$value){
        // array_push($staffs, $value['otu_user_id']);
        // }
        
        // }
        
        $ot['ot_user_id'] = $userId;
        // $ot['ot_staff_id1']=$staffs[0];
        // $ot['ot_staff_id2']=$staffs[1];
        $ot['ot_staff_id1'] = 0;
        $ot['ot_staff_id2'] = 0;
        $ot['ot_state'] = 2;
        $ot['ot_car_type'] = $carType;
        $staffs = array_slice($staffs, 0, 2);
        
        if ($ot->save()) {
            
            // OrderTemp::model()->findAll();
            $criteria = new CDbCriteria();
            $otRelations = OrderTemp::model()->findAll(array(
                'condition' => '((ot_date_time <= :order_date_time_begin
					AND ot_date_time_end >= :order_date_time_end)
				OR (ot_date_time >= :order_date_time_begin
					AND ot_date_time_end <= :order_date_time_end)
				OR (ot_date_time >= :order_date_time_begin
					AND ot_date_time <= :order_date_time_end)
				OR (ot_date_time_end >= :order_date_time_begin
					AND ot_date_time_end <= :order_date_time_end))
				AND ot_wash_shop_id=:wash_shop_id
				AND	ot_state=1
				AND ot_bias = :bias',
                'params' => array(
                    ':wash_shop_id' => $ot['ot_wash_shop_id'],
                    ':order_date_time_begin' => $ot['ot_date_time'],
                    ':order_date_time_end' => $ot['ot_date_time_end'],
                    ':bias' => $ot['ot_bias']
                )
            ));
            if (isset($otRelations)) {
                foreach ($otRelations as $key => $value) {
                    if ($value['ot_position'] == $ot['ot_position']) {
                        $value['ot_state'] = 3;
                        if (! $value->save()) {
                            Yii::log($value['id'] . 'update relation order error', 'error', 'orderTemp.updateOrder');
                        }
                    }
                    
                    $otus = OrderTempUser::model()->findAllByAttributes(array(
                        'otu_ot_id' => $value['id']
                    ));
                    
                    foreach ($otus as $key => $otuItem) {
                        if (in_array($otuItem['otu_user_id'], $staffs) && $otuItem['id'] != $otId) {
                            $otuItem['otu_state'] = 2;
                            if (! $otuItem->save()) {
                                Yii::log($otuItem['id'] . 'update relation order user error', 'error', 'orderTemp.updateOrder');
                            }
                        }
                    }
                }
            }
            
            $rlt['status'] = true;
        }
        return $rlt;
    }

    /**
     * 用户取消订单时更新临时订单表
     * 
     * @param int $otId            
     * @param string $otStaffs            
     * @param int $userId            
     * @return string|Ambigous <string, boolean, multitype:>
     */
    public function updateOrderCancel($otId, $otStaffs, $userId, $carType)
    {
        $rlt = UTool::iniFuncRlt();
        
        $ot = OrderTemp::model()->findByPk($otId);
        if (! isset($ot)) {
            $rlt['msg'] = '00022';
            return $rlt;
        }
        
        @$staffs = split(',', $otStaffs);
        // Yii::log($otStaffs,'error','orderTemp.updateOrder.staffs');
        // Yii::log(var_dump($staffs),'error','orderTemp.updateOrder.staffs1');
        if (empty($otStaffs)) {
            $staffs = array();
        }
        
        $ot['ot_user_id'] = 0;
        $ot['ot_staff_id1'] = 0;
        $ot['ot_staff_id2'] = 0;
        $ot['ot_state'] = 1;
        $ot['ot_car_type'] = 0;
        // $staffs = array_slice($staffs, 0,2);
        
        if ($ot->save()) {
            
            $criteria = new CDbCriteria();
            $otRelations = OrderTemp::model()->findAll(array(
                'condition' => '((ot_date_time <= :order_date_time_begin
					AND ot_date_time_end >= :order_date_time_end)
				OR (ot_date_time >= :order_date_time_begin
					AND ot_date_time_end <= :order_date_time_end)
				OR (ot_date_time >= :order_date_time_begin
					AND ot_date_time <= :order_date_time_end)
				OR (ot_date_time_end >= :order_date_time_begin
					AND ot_date_time_end <= :order_date_time_end))
				AND ot_wash_shop_id=:wash_shop_id
				AND	ot_state>=2
				AND ot_bias = :bias',
                'params' => array(
                    ':wash_shop_id' => $ot['ot_wash_shop_id'],
                    ':order_date_time_begin' => $ot['ot_date_time'],
                    ':order_date_time_end' => $ot['ot_date_time_end'],
                    ':bias' => $ot['ot_bias']
                )
            ));
            // Yii::log(CJSON::encode($otRelations),CLogger::LEVEL_WARNING,'mngr.orderTemp.updateOrderCancel.otRelations');
            if (isset($otRelations)) {
                foreach ($otRelations as $key => $value) {
                    if ($value['ot_position'] == $ot['ot_position']) {
                        $beginTime = date('Y-m-d ', time() + $value['ot_bias'] * 24 * 60 * 60);
                        $beginTime = date('Y-m-d H:i:00', strtotime($beginTime . $value['ot_date_time']));
                        $endTime = date('Y-m-d ', time() + $value['ot_bias'] * 24 * 60 * 60);
                        $endTime = date('Y-m-d H:i:00', strtotime($endTime . $value['ot_date_time_end']));
                        // Yii::log($beginTime,CLogger::LEVEL_WARNING,'mngr.orderTemp.updateOrderCancel.beginTime');
                        $count = OrderHistory::model()->getOrderCount($value['ot_wash_shop_id'], $beginTime, $endTime, $value['ot_position']);
                        // Yii::log($count['data'],CLogger::LEVEL_WARNING,'mngr.orderTemp.updateOrderCancel.count');
                        if ($count['data'] < 1) {
                            // Yii::log(CJSON::encode($value),CLogger::LEVEL_WARNING,'mngr.orderTemp.updateOrderCancel.'.$value['id']);
                            
                            // $value = $otRelations[$key];
                            // $value = OrderTemp::model()->findByPk($value['id']);
                            // $value->delete();
                            $value['ot_user_id'] = 0;
                            $value['ot_staff_id1'] = 0;
                            $value['ot_staff_id2'] = 0;
                            $value['ot_state'] = '1';
                            $value['ot_car_type'] = 0;
                            if ($value->save()) {
                                // Yii::log(CJSON::encode($value),CLogger::LEVEL_WARNING,'mngr.orderTemp.updateOrderCancel.'.$value['id']);
                            } else {
                                // Yii::log(CJSON::encode($value),CLogger::LEVEL_WARNING,'mngr.orderTemp.updateOrderCancel.false.'.$value['id']);
                            }
                        }
                    }
                    
                    // $otus = OrderTempUser::model()->findAllByAttributes(array('otu_ot_id'=>$value['id']));
                    
                    // foreach ($otus as $key=>$otuItem){
                    // if (in_array($otuItem['otu_user_id'], $staffs) && $otuItem['id']!=$otId) {
                    // $otuItem['otu_state']=2;
                    // if(!$otuItem->save()){
                    // Yii::log($otuItem['id'].'update relation order user error','error', 'orderTemp.updateOrder');
                    // }
                    // }
                    // }
                }
            }
            
            $rlt['status'] = true;
        }
        return $rlt;
    }

    /**
     * 更新时间段信息
     * 
     * @param string $otIds            
     * @param string $otStaffs            
     * @param int $sType            
     * @param int $sValue            
     * @param int $uType            
     * @param int $carType            
     * @return Ambigous <multitype:, string>|boolean
     */
    public function updateOrderByBoss($otIds, $otStaffs, $sType, $sValue, $uType, $carType)
    {
        $rlt = UTool::iniFuncRlt();
        $ids = explode(',', $otIds);
        if (count($ids) < 1) {
            $rlt['msg']='未选择时间段';
            return $rlt;
        }
        $shop = OrderTemp::model()->findByPk($ids[0])->otWashShop;
        // Yii::log(CJSON::encode($shop), 'info', 'mngr.orderTemp.updateOrderByBoss.shop');
//         $shopDiscountCount = $shop['ws_discount_count'];
        // 只有洗车服务限制折扣数量
        $shopDiscountCount=999;
        if ($sType==1){
            $shopDiscountCount = $shop['ws_discount_count'];
        }
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'ot_wash_shop_id=:id';
        $criteria->params[':id'] = $shop['id'];
        
        $stdValue = 30;
//         $shopService = WashShopService::model()->findByAttributes(array('wss_ws_id'=>$shop['id'], 'wss_st_id'=>$sType));
        
//         $stdValue = $shopService['wss_value'.$carType];
        if ($uType == 3) {
            $service = WashShopService::model()->findByAttributes(array(
                'wss_ws_id' => $shop['id'],
                'wss_st_id' => $sType
            ));
            $stdValue = $service['wss_value'];
        }

        // $currentCount = OrderTemp::model()->count($criteria);
        // Yii::log(CJSON::encode($currentCount),'info','mngr.orderTemp.updateOrderByBoss.currentCount');
        // $temp=0;
        $rlt['status']=true;
        foreach ($ids as $key => $id) {
            if ($uType == 1) { // 禁用选中时间段
                $item = $this->findByPk($id);
             if ($item['ot_state'] == 1 || $item['ot_state']==3){
                    $item['ot_state'] = 0;
                   if (! $item->save()){
                       $rlt['status']=false;
                       
                   }
                    
                }
                
//                 $item['ot_state'] = 0;
//                 $item->save();
            } elseif ($uType == 2) { // 启用选中时间段
                $item = $this->findByPk($id);
                if ($item['ot_state'] == 0){
                    $item['ot_state'] = 1;
                    if (! $item->save()){
                        $rlt['status']=false;
                         
                    }
//                     $item->save();
                    
                }
                
                
            } elseif ($uType == 3) { // 更新选中时间段信息
                $item = $this->findByPk($id);
                $criteria->addCondition('ot_bias=:bias');
                $criteria->params[':bias']=$item['ot_bias'];
//                 $item->save();
                // Yii::log(CJSON::encode($item), 'warning', 'mngr.orderTemp.updateOrderByBoss');
                if ($sValue >= $stdValue || OrderTemp::model()->count($criteria) < $shopDiscountCount) {
                    $item['ot_value'] = $sValue;

                    $item['ot_value_discount'] = $sValue / $stdValue;
                    if ($item->save()) {
                    } 
                    
                } else {
                    $rlt['status']=false;
                    $rlt['msg']='折扣时间段数量超出最大允许值“' . $shopDiscountCount . '”，部分折扣信息未更新，请合理分配折扣信息！';
//                     Yii::app()->user->setFlash('discountNumWarning', '折扣时间段数量超出最大允许值“' . $shopDiscountCount . '”，部分折扣信息未更新，请合理分配折扣信息！');
                }
                
                if ($item->save()) {
//                     Yii::log(CJSON::encode($item), 'warning', 'mngr.orderTemp.updateOrderByBoss1');
//                     $msg=new Message();
//                     $msg['m_content']='修改时间段';
                    
                } else {
//                     Yii::log(CJSON::encode($item), 'warning', 'mngr.orderTemp.updateOrderByBoss2');
                }
                

            } // end if utype=3
        } // end foreach
        
//         $rlt['status'] = true;/
        return $rlt;
    }
    
    /**
     * 获取当前车行车位可用数量
     * 刘长鑫
     * 20150330
     * @param int $shopId
     * @param int $serviceType
     * @param int $position
     * @param int $bias
     * @param bool $isAvailable
     * @return Ambigous <string, mixed>
     */
    public function getPositionCount($shopId,$serviceType,$position, $bias,  $isAvailable=TRUE){

        $criteria = new CDbCriteria();
        $criteria->addCondition('ot_wash_shop_id=:id');
        $criteria->params[':id']=$shopId;
        
        $criteria->addCondition('ot_type=:type');
        $criteria->params[':type']=$serviceType;
        
//         $criteria->addCondition('ot_car_type=:cartype');
//         $criteria->params[':cartype']=$carType;
        
        $criteria->addCondition('ot_position=:position');
        $criteria->params[':position']=$position;
        
        $criteria->addCondition('ot_bias=:bias');
        $criteria->params[':bias']=$bias;
        if ($bias ==0){
            
            $criteria->addCondition('ot_date_time>:time');
            $criteria->params[':time']=date('H:i:00',time()+20*60);
        }
        
        
//         $criteria->addCondition('ot_bias=:bias');
//         $criteria->params[':bias']=$bias;
        
        $criteria->addCondition('ot_state=1');
        $rlt = $this->count($criteria);
        
        return $rlt;
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria();
        
        $criteria->compare('id', $this->id, true);
        $criteria->compare('ot_wash_shop_id', $this->ot_wash_shop_id, true);
        $criteria->compare('ot_date_time', $this->ot_date_time, true);
        $criteria->compare('ot_date_time_end', $this->ot_date_time_end, true);
        
        $criteria->compare('ot_state', $this->ot_state);
        $criteria->compare('ot_user_id', $this->ot_user_id, true);
        $criteria->compare('ot_position', $this->ot_position);
        $criteria->compare('ot_staff_id1', $this->ot_staff_id1, true);
        $criteria->compare('ot_staff_id2', $this->ot_staff_id2, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * 
     * @param string $className
     *            active record class name.
     * @return OrderTemp the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
