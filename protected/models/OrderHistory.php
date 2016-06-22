<?php

/**
 * This is the model class for table "{{Order_History}}".
 *
 * The followings are the available columns in table '{{Order_History}}':
 * @property string $id
 * @property string $oh_no
 * @property string $oh_wash_shop_id
 * @property integer $oh_user_ack
 * @property integer $oh_boss_ack
 * @property integer $oh_staff_ack
 * @property string $oh_order_date_time
 * @property string $oh_date_time
 * @property integer $oh_value
 * @property integer $oh_state
 * @property string $oh_user_id
 * @property integer $oh_service_num
 * @property integer $oh_type
 * @property integer $oh_position
 * @property string $oh_staff_id1
 * @property string $oh_staff_id2
 *
 * The followings are the available model relations:
 * @property WashShop $ohWashShop
 * @property User $ohUser
 * @property StaffOrderHistory[] $staffOrderHistories
 */
class OrderHistory extends CActiveRecord {
	
	// 订单总价值
	public $totalValue;
	// 订单总数
	public $totalCount;
	// 订单占用标准洗车位数
	public $totalServiceNum;
	private static $_orderServiceItems;
	/**
	 * 订单预约中
	 */
	const ORDER_STATE_ORDER = 1;
	/**
	 * 订单成功完成
	 */
	const ORDER_STATE_SUCCESS = 2;
	/**
	 * 订单取消
	 */
	const ORDER_STATE_CANCEL = 0;
	/*
	 * 订单过期
	 */
	const ORDER_STATE_OVERDUE = - 1;
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{Order_History}}';
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
						'oh_no, oh_wash_shop_id, oh_order_date_time, oh_date_time, oh_value,  oh_user_id',
						'required' 
				),
				array (
						'oh_user_ack, oh_boss_ack, oh_staff_ack, oh_value, oh_state',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'oh_no',
						'length',
						'max' => 20 
				),
				array (
						'oh_wash_shop_id, oh_user_id',
						'length',
						'max' => 10 
				),
				// array (
				// 'oh_value_src',
				// 'length',
				// 'max' => 50
				// ),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'id, oh_no, oh_wash_shop_id, oh_user_ack, oh_boss_ack, oh_staff_ack, oh_order_date_time, oh_date_time, oh_value, oh_state, oh_user_id',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function orderAck($id) {
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'ohWashShop' => array (
						self::BELONGS_TO,
						'WashShop',
						'oh_wash_shop_id' 
				),
				'ohUser' => array (
						self::BELONGS_TO,
						'User',
						'oh_user_id' 
				),
				'staffOrderHistories' => array (
						self::HAS_MANY,
						'StaffOrderHistory',
						'soh_order_history_id' 
				),
				'comments' => array (
						self::HAS_MANY,
						'OrderComments',
						'oc_order_id' 
				),
				'serviceType' => array (
						self::BELONGS_TO,
						'ServiceType',
						'oh_type' 
				) 
		// 'totalValue1'=>array(
		// self::STAT,'OrderHistory','oh_value',
		// 'select'=>'sum(oh_value)'
		// ),
				);
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'oh_no' => '订单号',
				'oh_wash_shop_id' => '洗车行ID',
				'oh_user_ack' => '用户确认',
				'oh_boss_ack' => '车行老板确认',
				'oh_staff_ack' => '洗车工确认',
				'oh_order_date_time' => '下单时间',
				'oh_date_time' => '洗车时间',
				'oh_value' => '订单预计金额',
				// 'oh_value_src' => '订单项目',
				'oh_state' => '订单状态',
				'oh_user_id' => '用户ID' 
		);
	}
	
	/**
	 * 统计用户在车行预定订单数
	 * 刘长鑫
	 * 20150831
	 * @param int $userId 用户id
	 * @param int $shopId 车行id
	 * @param string $beginTime 开始时间，默认为NULL则不过滤
	 * @param string $endTime 截止时间，默认为NULL则不过滤
	 * @param int $serviceType 服务类型，默认为NULL则不过滤
	 * @param bool $isSuccess 是否成功，默认为TRUE
	 * @param bool $isCount 是否返回统计个数，默认为TRUE
	 * @return object $rlt
	 */
	public  function getOrderCountByUserFromShop($userId, $shopId, $beginTime=NULL,
			$endTime=NULL, $serviceType=NULL, $isSuccess=TRUE, $isCount=TRUE){
		$rlt = UTool::iniFuncRlt();
	
		if (!UCom::checkInt($userId) || !UCom::checkInt($shopId) ){
			$rlt['msg']="参数错误";
			return $rlt;
		}
	
		$criteria = new CDbCriteria();
		$criteria->addCondition('oh_user_id=:userId');
		$criteria->params[':userId']=$userId;
		$criteria->addCondition('oh_wash_shop_id=:shopId');
		$criteria->params[':shopId']=$shopId;
		// 		时间过滤
		$begin = UCom::checkDatetime($beginTime);
		if ($begin != FALSE){
			$criteria->addCondition('oh_date_time>=:begin');
			$criteria->params[':begin']=date('Y-m-d H:i:s',$begin);
		}
	
		$end = UCom::checkDatetime($endTime);
		if ($end != FALSE){
			$criteria->addCondition('oh_date_time_end<=:end');
			$criteria->params[':end']=date('Y-m-d H:i:s',$end);
		}
		// 		服务类型过滤
		if (UCom::checkInt($serviceType)){
			$criteria->addCondition('oh_type=:type');
			$criteria->params[':type']=$serviceType;
		}
	
		if ( $isSuccess){
			// 			成功订单
			$criteria->addCondition('oh_state=:state');
			$criteria->params[':state']= OrderHistory::ORDER_STATE_SUCCESS;
		}else {
			// 			预约和成功订单
			$criteria->addCondition('oh_state > 0');
			// 			$criteria->params[':type']=$serviceType;
		}
	
		if ($isCount){
			$orderRlt = $this->count($criteria);
		}else{
			$orderRlt = $this->findAll($criteria);
		}
		$rlt['data']=$orderRlt;
		$rlt['status']=TRUE;
		return $rlt;
	
	
	
	
	
	
	
	}
	
	/**
	 * 返回用户订单列表
	 * @param int $userId
	 * @param int $pageIndex
	 * @param int $pageSize
	 * @param string $startTime
	 * @param string $endTime
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getUserOrderList($userId, $pageIndex=0, $pageSize=8, $startTime=NULL,$endTime=NULL){
	    
	    $rlt = UTool::iniFuncRlt();
// 	    $model = new OrderHistory ();
// 	    $this->layout = 'admin_user';
// 	    @$startTime = $_GET ['startTime'];
// 	    @$endTime = $_GET ['endTime'];

	    $criteria = new CDbCriteria ();
	    $criteria->order = 'oh_date_time DESC';
	    $criteria->addCondition ( 'oh_user_id=:user_id' );
	    $criteria->params [':user_id'] = $userId;
	    
	    if (isset($startTime)){
	        $criteria->addCondition ( 'oh_date_time>=:start' );
	        $criteria->params [':start'] = date('Y-m-d H:i:s', strtotime( $startTime));
	    }
	    if (isset  ( $endTime )) {
// 	        $criteria->addCondition ( 'oh_date_time>=:start' );
	        $criteria->addCondition ( 'oh_date_time<=:end' );
// 	        $criteria->params [':start'] = $startTime;
	        $criteria->params [':end'] = date('Y-m-d H:i:s', strtotime( $endTime));
	    }
	    
	    $dataProvider = new CActiveDataProvider ( $this, array (
	        'pagination' => array (
	            'pageSize' => $pageSize,
	            'currentPage'=>$pageIndex,
	        ),
	        'criteria' => $criteria
	    ) );
	    $rlt['status']=true;
	    $rlt['msg']='查询成功';
	    $rlt['data']=$dataProvider;
	    return $rlt;
	    
	    // 		if (Yii::app ()->request->isAjaxRequest) {
	    	
	    // 			$this->renderPartial ( '_list', array (
	    // 					'model' => $model,
	    // 					'dataProvider' => $dataProvider
	    // 			), false, true );
	    // 			Yii::app ()->end ();
	    // 		}
	    
// 	    $this->render ( 'list', array (
// 	        'model' => $model,
// 	        'dataProvider' => $dataProvider
// 	    ) );
	}
	
	
	public function getOrderStateString($orderStateCode,$userAck=FALSE){
		$orderState = "";
		switch ($orderStateCode){
			case OrderHistory::ORDER_STATE_CANCEL:
				$orderState = '订单取消';
				break;
			case OrderHistory::ORDER_STATE_ORDER:
				if ($userAck==true){
					$orderState = "已确认";
				}else{
					$orderState = "预订中";
				}
				
				break;
			case OrderHistory::ORDER_STATE_SUCCESS:
				$orderState=  "订单成功";
				break;
			case OrderHistory::ORDER_STATE_OVERDUE:
				$orderState="用户违约";
				break;
			default:
				$orderState = "订单失败";
				break;
		};
		
		return $orderState;
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
		$criteria->compare ( 'oh_no', $this->oh_no, true );
		$criteria->compare ( 'oh_wash_shop_id', $this->oh_wash_shop_id, true );
		$criteria->compare ( 'oh_user_ack', $this->oh_user_ack );
		$criteria->compare ( 'oh_boss_ack', $this->oh_boss_ack );
		$criteria->compare ( 'oh_staff_ack', $this->oh_staff_ack );
		$criteria->compare ( 'oh_order_date_time', $this->oh_order_date_time, true );
		$criteria->compare ( 'oh_date_time', $this->oh_date_time, true );
		$criteria->compare ( 'oh_value', $this->oh_value );
		
		$criteria->compare ( 'oh_state', $this->oh_state );
		$criteria->compare ( 'oh_user_id', $this->oh_user_id, true );
		$criteria->compare ( 'oh_staff_id1', $this->oh_staff_id1, true );
		$criteria->compare ( 'oh_staff_id2', $this->oh_staff_id2, true );
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * 确认订单增加积分记录
	 * 
	 * @param objct $orderItem        	
	 */
	public function addScoreHistoty($orderItem, $hasComment=FALSE) {
		$sh = new ScoreHistory ();
		$sh ['sh_date_time'] = date ( 'Y-m-d H:i:s' );
		
		$sh ['sh_order_history_id'] = $orderItem ['id'];
		$sh ['sh_user_id'] = $orderItem ['oh_user_id'];
		
		if ($hasComment) {
			$sh ['sh_score'] = $orderItem ['oh_value']*2;
			$sh ['sh_desc'] = '订单确认+评论奖励[' . $orderItem ['oh_no'] . ']';
		}else{
			$sh ['sh_score'] = $orderItem ['oh_value'];
			$sh ['sh_desc'] = '订单确认奖励[' . $orderItem ['oh_no'] . ']';
		}
		
		$user = User::model()->findByPk($orderItem ['oh_user_id']);
		$user['u_score'] = $user['u_score'] +$sh ['sh_score'];
		$user->save();
// 		$criteria = new CDbCriteria();
// 		$criteria->select = 'sum(sh_score) as totalScore';
// 		$criteria->addCondition('sh_user_id=:userId');
// 		$criteria->params[':userId'] = $orderItem ['oh_user_id'];
			
// 		$rlt = ScoreHistory::model()->findBySql($criteria);
		if ($sh->save ()) {
			
			
			
			
			
// 			Yii::log ( CJSON::encode ($rlt), 'error', 'mngr.orders.score.user.add' );
		}else{
// 			Yii::log ( CJSON::encode ($rlt), 'error', 'mngr.orders.score.user.add' );
		}
// 		Yii::log ( CJSON::encode ($sh), 'error', 'mngr.orders.score.user.add' );
// 		$shStaff1 = new ScoreHistory ();
// 		$shStaff1 ['sh_date_time'] = date ( 'Y-m-d H:i:s' );
// 		$shStaff1 ['sh_score'] = $orderItem ['oh_value'];
// 		$shStaff1 ['sh_order_history_id'] = $orderItem ['id'];
// 		$shStaff1 ['sh_user_id'] = Staff::model ()->findByPk ( $orderItem ['oh_staff_id1'] )['s_user_id'];
// 		$sh ['sh_desc'] = '订单成功奖励[' . $orderItem ['oh_no'] . ']';
// 		if ($shStaff1->save ()) {
// 			Yii::log ( CJSON::encode ( $shStaff1 ), 'error', 'orders.score.staff1.add' );
// 		}
		
// 		$shStaff2 = new ScoreHistory ();
// 		$shStaff2 ['sh_date_time'] = date ( 'Y-m-d H:i:s' );
// 		$shStaff2 ['sh_score'] = $orderItem ['oh_value'];
// 		$shStaff2 ['sh_order_history_id'] = $orderItem ['id'];
// 		$shStaff2 ['sh_user_id'] = Staff::model ()->findByPk ( $orderItem ['oh_staff_id2'] )['s_user_id'];
// 		$sh ['sh_desc'] = '订单成功奖励[' . $orderItem ['oh_no'] . ']';
// 		if ($shStaff2->save ()) {
// 			Yii::log ( CJSON::encode ( $shStaff1 ), 'error', 'orders.score.staff2.add' );
// 		}
	}
	

	
	/**
	 * 确认取消订单
	 * 
	 * @param int $orderId        	
	 * @param int $type
	 *        	1确认 0取消
	 * @return array
	 */
	public function getOrderAckbyUser($orderId, $userId, $type, $score = 5, $comment = "") {
		$rlt = UTool::iniFuncRlt ();
		$orderItem = OrderHistory::model ()->findByPk ( $orderId );
		if (!isset($orderItem)){
		    $rlt['msg']='未找到有效订单';
		    return $rlt;
		}
		
		if ($type == 1) {
			if ($orderItem ['oh_user_id'] == $userId && $orderItem ['oh_state'] >= 1 && $orderItem['oh_user_ack']==0) {
				$orderItem ['oh_user_ack'] = 1;
// 				if ($orderItem ['oh_staff_ack'] == 1) {
// 					$orderItem ['oh_state'] = 2;
// 					$orderItem ['oh_boss_ack'] = 2;
// 					$hasComment = empty($comment)? false:true;

// 					self::addScoreHistoty ( $orderItem,$hasComment );
// 				}
				$hasComment = empty($comment)? false:true;
				self::addScoreHistoty ( $orderItem,$hasComment );
				
				$orderItem ['oh_score'] = $score;
				if ($orderItem->save ()) {
					if ($orderItem['oh_boss_ack'] ==1 ) {
						$countRlt = $this->getOrderStatistics($orderItem['oh_wash_shop_id'], '2014-01-01', date('Y-m-d H:i:s'),0,true);
						$currentCount = 0;
						if ($countRlt ['status']) {
							$currentCount = $countRlt ['data'] ['totalCount'];
						}
						$shop = WashShop::model()->findByPk($orderItem['oh_wash_shop_id']);	
						$shop['ws_score'] =( $shop['ws_score']*$currentCount + $orderItem['oh_score'])/($currentCount+1);
						// $shop['ws_score']=3;
						if (!$shop->save()) {
							Yii::log('更新车行评分失败,订单id'.$orderItem['id'].'-'.$shop['ws_score'],CLogger::LEVEL_WARNING,'mngr.washshop.score.update.error');
						}
					}
					
					
					if (!empty($comment)) {
						$commentItem = new OrderComments ();
						$commentItem ['oc_order_id'] = $orderId;
						$order = $this->findByPk ( $orderId );
						$commentItem ['oc_washshop_id'] = $order ['oh_wash_shop_id'];
						$commentItem ['oc_comment_user_id'] = $userId;
						$commentItem ['oc_comment_user_type'] = $type;
						$commentItem ['oc_datetime'] = date ( 'Y-m-d H:i:s' );

// 						if(empty($comment)){
// 							$comment = '默认好评';
// 						}
						
						$commentItem ['oc_comment'] = $comment;
						$commentItem->save ();
					
					}
					
					$rlt ['status'] = true;
				}
			}else{
			    if($orderItem ['oh_user_id'] != $userId){
			        $rlt['msg']='操作非法';
			    } else if (  $orderItem ['oh_state'] <=0 ){
			        $rlt['msg']='未找到有效订单';
			    } else {
			    $rlt['msg']='无需重复确认订单';
			    }
			}
		}
		if ($type == 0) {
			if ($orderItem ['oh_user_id'] == $userId && $orderItem ['oh_state'] == 1 && $orderItem['oh_user_ack']==0) {
				// $oh_no = $orderItem['oh_no'];
				// $oh_no[6]='0';
				// $orderItem['oh_no'] =$orderItem['oh_no'].UTool::randomkeys(4).Yii::app()->user->id;
				$orderItem ['oh_state'] = 0;
				if ($orderItem->save ()) {
					
				
					$smsRlt = USms::sendSmsOrderCancel($orderItem);
					
					$msg = new Message();
					$msg['m_datetime']=date('Y-m-d H:i:s');
					$msg['m_user_id'] =$userId;
					$msg['m_status']=0;
					$msg['m_level'] = 2;
					$msg['m_type']=1;
					$msg['m_content'] = $smsRlt['data'];
					if($msg->save()){
						
					}else{
// 						Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendSmsOrder');
					}
					
					$criteria = new CDbCriteria();
					$criteria->addCondition('ot_wash_shop_id=:shopId');
					$criteria->params[':shopId'] = $orderItem['oh_wash_shop_id'];
					$criteria->addCondition('ot_date_time=:beginTime');
					$criteria->params[':beginTime'] = date('H:i:00', strtotime($orderItem['oh_date_time']));
					$criteria->addCondition('ot_date_time_end=:endTime');
					$criteria->params[':endTime'] = date('H:i:00', strtotime($orderItem['oh_date_time_end']));
					
				
					$start =  strtotime($orderItem['oh_order_date_time']);
					
					$end = strtotime($orderItem['oh_date_time']);
					$start = date_create ( date('Y-m-d',$start));
					$end = date_create ( date('Y-m-d',$end));
					
					$interval = date_diff ( $start, $end );
					$bias =  $interval->format ( '%d' );
					
					
					$criteria->addCondition('ot_bias=:bias');
					$criteria->params[':bias'] =$bias;
					
					$ot = OrderTemp::model()->find($criteria);
					if (!isset($ot) || empty($ot)) {
						Yii::log(CJSON::encode($ot),CLogger::LEVEL_WARNING,'mngr.orderHistory.getOrderAckByUser.otIsEmpty');
					}else{
						Yii::log(CJSON::encode($ot),CLogger::LEVEL_WARNING,'mngr.orderHistory.getOrderAckByUser');
						$updateRlt = OrderTemp::model ()->updateOrderCancel ( $ot['id'], '0,0', $userId, $orderItem['oh_car_type'] );
						
					
					}
					
					$rlt ['status'] = true;
				} else {
					$rlt ['data'] = $orderItem;
				}
			}else{
			    
			    if ($orderItem ['oh_user_id'] != $userId){
			        $rlt['msg']='操作非法';
			    } else if (  $orderItem ['oh_state'] == 0 ){
			        $rlt['msg']='该订单已取消';
			    } else if($orderItem['oh_user_ack']!=0) {
			        $rlt['msg']='该订单已被确认，无法取消';
			    } else {
			        $rlt['msg']='未找到有效订单';
			    }
			    
			}
		}
		
		return $rlt;
	}
	
	
	
	/**
	 * 获取用户最新订单
	 * @param unknown $userId
	 * @param unknown $type
	 * @return Ambigous <multitype:, string, CActiveRecord, mixed, NULL, multitype:CActiveRecord , multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:unknown >
	 */
	public function getLatestOrder($userId, $type=NULL){
		$rlt = UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		$criteria->addCondition('oh_user_id=:userId');
		$criteria->params[':userId'] = $userId;
		$criteria->addCondition('oh_state>=1');
		if (isset($type)){
			$criteria->addCondition('oh_type=:type');
			$criteria->params[':type'] =$type;
		}
		
		$criteria->order = 'oh_date_time DESC';
// 		$this->find
		$order = $this->find($criteria);
		if ($order == NULL) {
			$rlt['msg']='未找到有效订单';
		}else{
			$rlt['status']=true;
			$rlt['data']=$order;
		}
		return $rlt;
		
	}
	
	/**
	 * 确认取消订单
	 * 
	 * @param int $orderId        	
	 * @param int $type
	 *        	1确认 0取消
	 * @return array
	 */
	public function getOrderAckbyStaff($orderId, $userId, $type = 1) {
		$rlt = UTool::iniFuncRlt ();
		$orderItem = OrderHistory::model ()->findByPk ( $orderId );
		
		if ($type == 1) {
			if (($orderItem ['oh_staff_id1'] == $userId || $orderItem ['oh_staff_id2'] == $userId) && $orderItem ['oh_state'] == 1) {
				$orderItem ['oh_staff_ack'] = 1;
				if ($orderItem ['oh_user_ack'] == 1) {
					$orderItem ['oh_state'] = 2;
					$orderItem ['oh_boss_ack'] = 2;
					self::addScoreHistoty ( $orderItem );
				}
				
				// $orderItem['oh_score']=$score;
				if ($orderItem->save ()) {
					// $commentItem =new OrderComments();
					// $commentItem['oc_order_id']=$orderId;
					// $order = $this->findByPk($orderId);
					// $commentItem['oc_washshop_id'] = $order['oh_wash_shop_id'];
					// $commentItem['oc_comment_user_id']=$userId;
					// $commentItem['oc_comment_user_type']=$type;
					// $commentItem['oc_datetime']=date('Y-m-d H:i:s');
					// $commentItem['oc_comment']=$comment;
					// $commentItem->save();
					$rlt ['status'] = true;
					$rlt ['data'] = $orderItem ['oh_state'];
				}
			}
		}
		if ($type == 0) {
			if ($orderItem ['oh_user_id'] == Yii::app ()->user->id && $orderItem ['oh_state'] == 1) {
				// $oh_no = $orderItem['oh_no'];
				// $oh_no[6]='0';
				$orderItem ['oh_no'] = $orderItem ['oh_no'] . UTool::randomkeys ( 4 ) . Yii::app ()->user->id;
				$orderItem ['oh_state'] = 0;
				if ($orderItem->save ()) {
					$rlt ['status'] = true;
				} else {
					$rlt ['data'] = $orderItem;
				}
			}
		}
		
		return $rlt;
	}
	
	/**
	 * 确认取消订单
	 * 
	 * @param int $orderId        	
	 * @param int $type
	 *        	1确认 0取消
	 * @return array
	 */
	public function getOrderAckbyBoss($orderId, $bossId, $type = 1,$ontime=0) {
		$rlt = UTool::iniFuncRlt ();

		$boss = Boss::model()->findByPk($bossId);
		
		$shop = WashShop::model ()->findByAttributes ( array (
				'ws_boss_id' =>$bossId
		) );
		$shopId = $shop['id'];
		$orderItem = OrderHistory::model ()->findByPk ( $orderId );
		
		
		if ($type == 1) {
			if (strtotime($orderItem['oh_date_time']) > time()) {
				$rlt['msg']='订单服务完成后才可以确认';
				return $rlt;
			}
			
			if ($orderItem ['oh_wash_shop_id'] == $shopId && $orderItem ['oh_state'] == 1) {
				$orderItem ['oh_boss_ack'] = 1;
// 				if ($orderItem ['oh_user_ack'] == 0) {
// 					$orderItem ['oh_user_ack'] = 2;
// 				}
// 				if ($orderItem ['oh_staff_ack'] == 0) {
// 					$orderItem ['oh_staff_ack'] = 2;
// 				}
// 				$shop['ws_score'] = $
				if ($orderItem['oh_user_ack'] ==1 ) {
					$countRlt = $this->getOrderStatistics($shopId, '2014-01-01', date('Y-m-d H:i:s'),0,true);
					$currentCount = 0;
					if ($countRlt ['status']) {
						$currentCount = $countRlt ['data'] ['totalCount'];
					}
					
					$shop['ws_score'] =( $shop['ws_score']*$currentCount + $orderItem['oh_score'])/($currentCount+1);
// $shop['ws_score']=3;
					if (!$shop->save()) {
						Yii::log('更新车行评分失败,订单id'.$orderItem['id'].'-'.$shop['ws_score'],CLogger::LEVEL_WARNING,'mngr.washshop.score.update.error');
					}
				}
				
				
				
				$orderItem ['oh_state'] = 2;
				$orderItem ['oh_user_ontime'] = $ontime;
// 				self::addScoreHistoty ( $orderItem );
				
				// if ($orderItem['oh_user_ack'] >= 1 || $orderItem['oh_staff_ack'] >= 1) {
				// $orderItem['oh_state']=2;
				// }
				// else{
				// $orderItem['oh_state']=3;
				// }
				
				if ($orderItem->save ()) {
					$rlt ['status'] = true;
					$rlt ['data'] = $orderItem ['oh_state'];
				}
			}
		}
		if ($type == 0) {
			if (strtotime($orderItem['oh_date_time']) > time()) {
				$rlt['msg']='订单未过期，不能主动取消订单';
				return $rlt;
			}
			if ($orderItem ['oh_wash_shop_id'] == $shopId && $orderItem ['oh_state'] == 1) {
				// 取消订单逻辑
				// $oh_no = $orderItem['oh_no'];
				// $oh_no[6]='0';
// 				$orderItem ['oh_no'] = $orderItem ['oh_no'] . UTool::randomkeys ( 4 ) . Yii::app ()->user->id;
				$orderItem ['oh_state'] = 0;
				if ($orderItem->save ()) {
					$rlt ['status'] = true;
				} else {
					$rlt['msg']='更新订单信息失败';
					$rlt ['data'] = $orderItem;
				}
			}
		}
		if ($type == -2) {
			if (strtotime($orderItem['oh_date_time']) > time()) {
				$rlt['msg']='订单未过期，不能提前确定车主违约';
				return $rlt;
			}
			if ($orderItem ['oh_wash_shop_id'] == $shopId && $orderItem ['oh_state'] == 1) {
			
				$orderItem ['oh_state'] = -2;
				if ($orderItem->save ()) {
					$rlt['msg'] = '更新订单信息成功';
					$rlt ['status'] = true;
				} else {
					$rlt['msg']='更新订单信息失败';
					$rlt ['data'] = $orderItem;
				}
			}
		}
		
		return $rlt;
	}
	
	/**
	 * 车主新增订单
	 *
	 * @param int $otId
	 *        	临时订单表id
	 * @param int $value
	 *        	订单钱数
	 * @param int $userId
	 *        	用户id
	 * @return array [state,msg,data]
	 */
	public function getOrderNew($otId, $cardId, $src, $ip, $mac, $userId) {
		$rlt = UTool::iniFuncRlt ();
		$ot = OrderTemp::model ()->findByPk ( $otId );
		if (! isset ( $ot )) {
			$rlt ['msg'] = '00022';
			return $rlt;
		}
		
		$order = new OrderHistory ();
		
		// 生成订单号
		$order ['oh_no'] = Order::getOrderNo ( $userId );
		$order ['oh_wash_shop_id'] = $ot ['ot_wash_shop_id'];
		$order ['oh_order_date_time'] = date ( 'Y-m-d H:i:s' );
		$order ['oh_date_time'] = date ( 'Y-m-d ', strtotime ( '+' . $ot ['ot_bias'] . ' days' ) ) . $ot ['ot_date_time'];
		$order ['oh_date_time_end'] = date ( 'Y-m-d ', strtotime ( '+' . $ot ['ot_bias'] . ' days' ) ) . $ot ['ot_date_time_end'];
		// $order ['oh_value'] = $value;
		$order ['oh_user_id'] = $ot ['ot_user_id'];
		$order ['oh_type'] = $ot ['ot_type'];
		$order ['oh_position'] = $ot ['ot_position'];
		$order ['oh_staff_id1'] = $ot ['ot_staff_id1'];
		$order ['oh_staff_id2'] = $ot ['ot_staff_id2'];
		$order ['oh_car_type'] = $ot ['ot_car_type'];
		$order ['oh_value'] = $ot ['ot_value' . $ot ['ot_car_type']];
		$order ['oh_discount'] = $ot ['ot_value' . $ot ['ot_car_type'] . '_discount'];
		$order ['oh_pay_type'] = 1;
		$order ['oh_src'] = $src;
		$order ['oh_pay_state'] = 0;
		$card = Cardinvite::model ()->findByPk ( $cardId );
		$order ['oh_value_discount'] = $card ['ci_value'];
		if ($order->save ()) {
			if (isset ( $card )) {
				$phModel = new PayHistory ();
				$phModel ['ph_oh_id'] = $order ['id'];
				$phModel ['ph_pay_src'] = $card['id'];
				$phModel ['ph_value'] = $order ['oh_value_discount'];
				$phModel ['ph_datetime'] = date ( 'Y-m-d H:i:s' );
				$phModel ['ph_ip'] = UTool::get_client_ip ();
				$phModel ['ph_mac'] = $phModel ['ph_ip'];
				$phModel ['ph_user_id'] = $userId;
				if ($phModel->save ()) {
					$card ['ci_state'] = 2;
					$card['ci_date_used']=$phModel ['ph_datetime'];
					$card->save ();
				}
			}
			
			$rlt ['status'] = true;
			$rlt ['data'] = $order;
			Yii::log ( CJSON::encode ( $rlt ), 'warning', 'OrderHistory.orderNew' );
			return $rlt;
		} else {
			$rlt ['msg'] = '00003';
			Yii::log ( CJSON::encode ( $order ), 'warning', 'OrderHistory.orderNew' );
			return $rlt;
		}
	}
	
	/**
	 * 删除订单
	 * 
	 * @param int $orderId        	
	 * @return array
	 */
	public function getOrderDelete($orderId) {
		$rlt = UTool::iniFuncRlt ();
		$orderItem = $this->findByPk ( $orderId );
		if (! isset ( $orderItem ) || $orderItem ['oh_state'] == OrderHistory::ORDER_STATE_CANCEL) {
			$rlt ['msg'] = '00004';
			return $rlt;
		}
		$orderItem ['oh_state'] = OrderHistory::ORDER_STATE_CANCEL;
		$orderItem->save ();
		Staff::model ()->getStaffsExpUpdate ( $orderItem->oh_staff_id1, $orderItem->oh_staff_id2, $this->oh_service_num, false );
		if (! $orderItem->save ()) {
			$rlt ['msg'] = '00005';
			return $rlt;
		} else {
			$rlt ['status'] = true;
			return $rlt;
		}
	}
	
	public function getUserTotalCount($userId){
		$rlt = UTool::iniFuncRlt();
		// 用户订单数
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'oh_state>=1' );
		$criteria->addCondition ( 'oh_user_id=:user_id' );
		$criteria->params [':user_id'] = $userId;
		$userOrderStat = OrderHistory::model ()->count ( $criteria );
		$rlt['status']=true;
		$rlt['data']=$userOrderStat;
		return $rlt;
	}
	
	/**
	 * 获取车行会员数
	 * @param unknown $bossId
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function getBossTotalMember($bossId){
		$rlt = UTool::iniFuncRlt();
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='未找到该老板的车行信息';
			return $rlt;
		}
		// 用户订单数
		$criteria = new CDbCriteria ();
// 		$criteria->addCondition ( 'sm_user_id' );
// 		$criteria->params [':shop_id'] = $shop['id'];
// 		$criteria->distinct = true;
// 		$criteria->group = 'oh_user_id';
		$criteria->addCondition ( 'sm_shop_id=:shop_id' );
		$criteria->params [':shop_id'] = $shop['id'];
		// 		$criteria->select = array('oh_user_id','oh_wash_shop_id');
		$bossOrderStat = ShopMember::model ()->count ( $criteria );
		$rlt['status']=true;
		$rlt['data']=$bossOrderStat;
		return $rlt;
	}
	
	
	/**
	 * 获取车行预定历史用户数
	 * @param unknown $bossId
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function getBossTotalUser($bossId){
		$rlt = UTool::iniFuncRlt();
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='未找到该老板的车行信息';
			return $rlt;
		}
		// 用户订单数
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'oh_state>=1' );
		$criteria->distinct = true;
		$criteria->group = 'oh_user_id';
		$criteria->addCondition ( 'oh_wash_shop_id=:shop_id' );
		$criteria->params [':shop_id'] = $shop['id'];
// 		$criteria->select = array('oh_user_id','oh_wash_shop_id');
		$bossOrderStat = OrderHistory::model ()->count ( $criteria );
		$rlt['status']=true;
		$rlt['data']=$bossOrderStat;
		return $rlt;
	}
	
	/**
	 * 获取车行总订单数
	 * @param unknown $bossId
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function getBossTotalCount($bossId){
		$rlt = UTool::iniFuncRlt();
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='未找到该老板的车行信息';
			return $rlt;
		}
		// 用户订单数
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'oh_state>=1' );
		$criteria->addCondition ( 'oh_wash_shop_id=:shop_id' );
		$criteria->params [':shop_id'] = $shop['id'];
		$bossOrderStat = OrderHistory::model ()->count ( $criteria );
		$rlt['status']=true;
		$rlt['data']=$bossOrderStat;
		return $rlt;
	}
	
	public function getBossUnAckCount($bossId){
		$rlt = UTool::iniFuncRlt();

		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='未找到该老板的车行信息';
			return $rlt;
		}
		// 用户订单数
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'oh_state>=1' );
		$criteria->addCondition ( 'oh_boss_ack=0' );
		$criteria->addCondition ( 'oh_wash_shop_id=:shop_id' );
		$criteria->params [':shop_id'] = $shop['id'];
		$bossOrderStat = OrderHistory::model ()->count ( $criteria );
		$rlt['status']=true;
		$rlt['data']=$bossOrderStat;
		return $rlt;
	}
	
	public function getUserUnAckCount($userId){
		$rlt = UTool::iniFuncRlt();
		// 用户订单数
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'oh_state>=1' );
		$criteria->addCondition ( 'oh_user_ack=0' );
		$criteria->addCondition ( 'oh_user_id=:user_id' );
		$criteria->params [':user_id'] = $userId;
		$userOrderStat = OrderHistory::model ()->count ( $criteria );
		$rlt['status']=true;
		$rlt['data']=$userOrderStat;
		return $rlt;
	}
	
	public function getUnAckOrdersByUserId($userId,$includeSuccess=TRUE,$limitNum=1){
		$rlt = UTool::iniFuncRlt();
		$criteria = new CDbCriteria ();
		$criteria->order = 'oh_date_time DESC';
		$criteria->addCondition ( 'oh_user_id=:user_id' );
		$criteria->params [':user_id'] = $userId;

		
		if ($includeSuccess==TRUE){
			$criteria->addCondition ( 'oh_state>=1');
		}else{
			$criteria->addCondition ( 'oh_state=1');
		}
		$criteria->addCondition ( 'oh_user_ack=0');
		$criteria->limit=$limitNum;

		$userOrderStat = OrderHistory::model ()->findAll ( $criteria );
		if ($userOrderStat === NULL){
			return $rlt;
		}

		$rlt ['status'] = true;
		$rlt ['data'] = $userOrderStat;
		return $rlt;
	}
	
	/**
	 * 根据时间获取所有车行用户订单
	 * 
	 * @param int $shopId        	
	 * @param string $beginTime        	
	 * @param string $endTime        	
	 * @param int $userId        	
	 * @return array
	 */
	public function getOrdersByUserId($userId, $beginTime, $endTime, $isCount = FALSE, $isValid = TRUE) {
		// 构造时间
		$rlt = UTool::iniFuncRlt ();
		$begin = date_parse ( $beginTime );
		$end = date_parse ( $endTime );
		if ($begin ['error_count'] > 0 || $end ['error_count'] > 0) {
			$rlt ['msg'] = '00008';
			return $rlt;
		}
		
		// 用户订单数
		$criteria = new CDbCriteria ();
		// $criteria->select = 'sum(oh_value) as totalValue,
		// count(oh_user_id) as totalCount,
		// sum(oh_service_num) as totalServiceNum';
		$criteria->order = 'oh_date_time DESC';
		$criteria->addCondition ( 'oh_user_id=:user_id' );
		
		if ($isValid) {
			$criteria->addCondition ( 'oh_state>0', 'AND' );
		}
		
		$criteria->addCondition ( 'oh_date_time >= :order_date_time_begin', 'AND' );
		$criteria->addCondition ( 'oh_date_time < :order_date_time_end', 'AND' );
		$criteria->params [':user_id'] = $userId;
		$criteria->params [':order_date_time_begin'] = date ( 'Y-m-d H:i:00', strtotime ( $beginTime ) );
		$criteria->params [':order_date_time_end'] = date ( 'Y-m-d H:i:00', strtotime ( $endTime ) );
		
		if ($isCount) {
			$userOrderStat = OrderHistory::model ()->count ( $criteria );
		} else {
			$userOrderStat = OrderHistory::model ()->findAll ( $criteria );
		}
		
		$rlt ['status'] = true;
		$rlt ['data'] = $userOrderStat;
		// Yii::log($beginTime,'error','orders.user.select');
		// Yii::log($endTime,'error','orders.user.select');
		return $rlt;
	}
	
	/**
	 * 根据时间获取所有车行用户订单
	 * 
	 * @param int $shopId        	
	 * @param string $beginTime        	
	 * @param string $endTime        	
	 * @param bool $isDESC        	
	 * @return array
	 */
	public function getOrdersByStaffId($staffId, $beginTime, $endTime, $isDESC = true, $shopId = 0, $isCount = FALSE, $isValid = TRUE) {
		// 构造时间
		$rlt = UTool::iniFuncRlt ();
		$begin = date_parse ( $beginTime );
		$end = date_parse ( $endTime );
		if ($begin ['error_count'] > 0 || $end ['error_count'] > 0) {
			$rlt ['msg'] = '00008';
			return $rlt;
		}
		
		$staff = Staff::model ()->findByPk ( $staffId );
		if (! isset ( $staff )) {
			$rlt ['msg'] = '00018';
			return $rlt;
		}
		
		// 用户订单数
		$criteria = new CDbCriteria ();
		// $criteria->select = 'sum(oh_value) as totalValue,
		// count(oh_user_id) as totalCount,
		// sum(oh_service_num) as totalServiceNum';
		
		if ($isDESC) {
			$criteria->order = 'oh_date_time DESC';
		} else {
			$criteria->order = 'oh_date_time ASC';
		}
		if ($isValid) {
			$criteria->addCondition ( 'oh_state>0', 'AND' );
		}
		$criteria->addCondition ( 'oh_staff_id1=:staff_id' );
		$criteria->addCondition ( 'oh_staff_id2=:staff_id', 'OR' );
		$criteria->addCondition ( 'oh_state>0', 'AND' );
		$criteria->addCondition ( 'oh_date_time >= :order_date_time_begin', 'AND' );
		$criteria->addCondition ( 'oh_date_time < :order_date_time_end', 'AND' );
		$criteria->params [':staff_id'] = $staffId;
		$criteria->params [':order_date_time_begin'] = date ( 'Y-m-d H:i:00', strtotime ( $beginTime ) );
		$criteria->params [':order_date_time_end'] = date ( 'Y-m-d H:i:00', strtotime ( $endTime ) );
		if ($shopId != 0) {
			$criteria->addCondition ( 'oh_wash_shop_id=:shopId' );
			$criteria->params [':shopId'] = $shopId;
		} else {
			$criteria->addCondition ( 'oh_wash_shop_id=:shopId' );
			$criteria->params [':shopId'] = $staff ['s_wash_shop_id'];
		}
		
		if ($isCount) {
			$userOrderStat = OrderHistory::model ()->count ( $criteria );
		} else {
			$userOrderStat = OrderHistory::model ()->findAll ( $criteria );
		}
		
		// $userOrderStat = OrderHistory::model ()->findAll ( $criteria );
		$rlt ['status'] = true;
		$rlt ['data'] = $userOrderStat;
		return $rlt;
	}
	
	/**
	 * 根据时间获取车行所有订单
	 * 
	 * @param int $shopId        	
	 * @param string $beginTime        	
	 * @param string $endTime        	
	 * @return array
	 */
	public function getOrdersByTime($shopId, $beginTime, $endTime) {
		// 构造时间
		$rlt = UTool::iniFuncRlt ();
		$begin = date_parse ( $beginTime );
		$end = date_parse ( $endTime );
		if ($begin ['error_count'] > 0 || $end ['error_count'] > 0) {
			$rlt ['msg'] = '00008';
			return $rlt;
		}
		
		// 用户订单数
		$criteria = new CDbCriteria ();
		// $criteria->select = 'sum(oh_value) as totalValue,
		// count(oh_user_id) as totalCount,
		// sum(oh_service_num) as totalServiceNum';
		$criteria->order = 'oh_date_time DESC';
		$criteria->addCondition ( 'oh_wash_shop_id=:wash_shop_id' );
		$criteria->addCondition ( 'oh_state>0', 'AND' );
		$criteria->addCondition ( 'oh_date_time >= :order_date_time_begin', 'AND' );
		$criteria->addCondition ( 'oh_date_time < :order_date_time_end', 'AND' );
		$criteria->params [':wash_shop_id'] = $shopId;
		$criteria->params [':order_date_time_begin'] = date ( 'Y-m-d H:i:00', strtotime ( $beginTime ) );
		$criteria->params [':order_date_time_end'] = date ( 'Y-m-d H:i:00', strtotime ( $endTime ) );
		
		$userOrderStat = OrderHistory::model ()->findAll ( $criteria );
		$rlt ['status'] = true;
		$rlt ['data'] = $userOrderStat;
		return $rlt;
	}
	
	/**
	 * 检查制定时间段内是否有预定订单
	 * @param int $shopId
	 * @param datetime $beginDatetime
 	 * @param datetime $endDatetime
	 * @param ing $position
	 * @return Ambigous <string, mixed, unknown>
	 */
	public function getOrderCount($shopId, $beginDatetime, $endDatetime, $position){
		$rlt = UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		
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
						':order_date_time_begin' => date ( 'Y-m-d H:i:00', strtotime( $beginDatetime) ),
						':order_date_time_end' => date ( 'Y-m-d H:i:00',strtotime($endDatetime)),
						':position' => $position
				)
		) );
		$rlt['status']=true;
		$rlt['data'] = $userOrderCountCurrentPosition;
		return $rlt;
	}
	
	public function getOrderStatisByCity($cid, $type, $isSuccess=TRUE) {
		// $cid = Yii::app()->session['_ucid'];
		// $cid =1;
		$criteria = new CDbCriteria ();
		if ($isSuccess){
		    $criteria->addCondition ( 'oh_state=2' );
		}else{
		    $criteria->addCondition ( 'oh_state>0' );
		}
// 		$criteria->addCondition ( 'oh_state=2' );
		$criteria->addCondition('oh_type=:type');
		$criteria->params[':type']=$type;
		$shops = WashShop::model ()->findAllByAttributes ( array (
				'ws_city_id' => $cid,
				'ws_state' => 1 
		) );
		// var_dump($shops);
		$shopIds = array ();
		foreach ( $shops as $key => $shop ) {
			$shopIds [] = $shop ['id'];
		}
		$criteria->addInCondition ( 'oh_wash_shop_id', $shopIds );
		// echo var_dump($shopIds);
		$criteria->select = 'count(id) as totalCount';
		$count = OrderHistory::model ()->find ( $criteria );
		// echo var_dump($count['totalCount']);
		return $count ['totalCount'];
	}
	
	/**
	 * 车行用户订单数统计
	 * 
	 * @param int $shopId
	 *        	车行id
	 * @param string $beginTime
	 *        	开始时间
	 * @param string $endTime
	 *        	终止时间   	
	 * @return string
	 */
	public function getOrderStatistics($shopId, $beginTime, $endTime, $orderType = 0, $isSuccess=false) {
		// 构造时间
		$rlt = UTool::iniFuncRlt ();
		
		
		$begin = date_parse ( $beginTime );
		$end = date_parse ( $endTime );
		if ($begin ['error_count'] > 0 || $end ['error_count'] > 0) {
			$rlt ['msg'] = '00008';
			return $rlt;
		}
		
		// 用户订单数
		$criteria = new CDbCriteria ();
		$criteria->select = 'sum(oh_value) as totalValue,	count(id) as totalCount,
		sum(oh_service_num) as totalServiceNum';
		
	
		if ($shopId>0){
			$criteria->addCondition ( 'oh_wash_shop_id=:wash_shop_id' );
			$criteria->params [':wash_shop_id'] = $shopId;
		}
		if ($isSuccess) {
			$criteria->addCondition ( 'oh_state>=2', 'AND' );
		}else{
			$criteria->addCondition ( 'oh_state>0', 'AND' );
		}

    $criteria->addCondition ( 'oh_date_time >= :order_date_time_begin', 'AND' );
    $criteria->params [':order_date_time_begin'] = date ( 'Y-m-d H:i:00', strtotime ( $beginTime ) );


  		$criteria->addCondition ( 'oh_date_time < :order_date_time_end', 'AND' );
		$criteria->params [':order_date_time_end'] = date ( 'Y-m-d H:i:00', strtotime ( $endTime ) );

		

		if ($orderType > 0) {
			$criteria->addCondition ( 'oh_type=:type' );
			$criteria->params [':type'] = $orderType;
		}
		
		$userOrderStat = OrderHistory::model ()->find ( $criteria );
// 		Yii::log ( CJSON::encode ( $userOrderStat->totalServiceNum ), 'error', 'orders.stat' );
		
		// 老板订单数
// 		$criteria1 = new CDbCriteria ();
// 		$criteria1->select = 'count(boh_service_num) as totalCountBoss';
		
// 		$criteria1->addCondition ( 'boh_wash_shop_id=:wash_shop_id' );
// 		$criteria1->addCondition ( 'boh_state>0', 'AND' );
// 		$criteria1->addCondition ( 'boh_date_time >= :order_date_time_begin', 'AND' );
// 		$criteria1->addCondition ( 'boh_date_time < :order_date_time_end', 'AND' );
// 		$criteria1->params [':wash_shop_id'] = $shopId;
// 		$criteria1->params [':order_date_time_begin'] = date ( 'Y-m-d H:i:00', strtotime ( $beginTime ) );
// 		$criteria1->params [':order_date_time_end'] = date ( 'Y-m-d H:i:00', strtotime ( $endTime ) );
		
// 		$bossOrderStat = BossOrderHistory::model ()->find ( $criteria1 );
		
		if (! isset ( $userOrderStat->totalCount )) {
			$userOrderStat->totalCount = 0;
		}
		if (! isset ( $userOrderStat->totalServiceNum )) {
			$userOrderStat->totalServiceNum = 0;
		}
		if (! isset ( $userOrderStat->totalValue )) {
			$userOrderStat->totalValue = 0;
		}
		
// 		if (! isset ( $bossOrderStat->totalCountBoss )) {
// 			$bossOrderStat->totalCountBoss = 0;
// 		}
		
		$rlt ['data'] = array (
				'totalCount' => $userOrderStat->totalCount,
				'totalServiceNum' => $userOrderStat->totalServiceNum,
				'totalValue' => $userOrderStat->totalValue,
// 				'totalCountBoss' => $bossOrderStat->totalCountBoss 
		);
// 		$rlt['msg']=$userOrderStat;
		$rlt ['status'] = true;
		return $rlt;
		
	}
	
	// protected function beforeSave(){
	// if (parent::beforeSave()) {
	// if ($this->oh_staff_id1 <=0 || $this->oh_staff_id2<=0) {
	// return false;
	// }
	// else {
	// return true;
	// }
	// }
	// else {
	// return false;
	// }
	// }
	protected function afterSave() {
		parent::afterSave ();
		// Yii::log(CJSON::encode($this),'trace','debug.*');
		// Yii::log(CJSON::encode(self::$_orderServiceItems),'trace','debug.*');
		
		// Yii::log($this->oh_staff_id1.';'.$this->oh_staff_id2.';'.$this->oh_date_time,'error','orders.staff.exp');
		
		// Staff::model()->getStaffsExpUpdate($this->oh_staff_id1,$this->oh_staff_id2,
		// $this->oh_service_num, true);
		// if (!$rlt) {
		// Yii::log(CJSON::encode($rlt),'error','orders.staff.exp');
		// }
		// soh = StaffOrderHistory::model()->findAllByAttributes(array(
		// 'soh_order_history_id'=>$this->id,
		// ));
		// if (condition) {
		// ;
		// }
		
		// try {
		// $soh1 = new StaffOrderHistory();
		// $soh1['soh_order_history_id']=$this->id;
		// $soh1['soh_staff_id']=$this->oh_staff_id1;
		// $soh1->save();
		
		// $soh2 = new StaffOrderHistory();
		// $soh2['soh_order_history_id']=$this->id;
		// $soh2['soh_staff_id']=$this->oh_staff_id2;
		// $soh2->save();
		// }
		// catch (Exception $e) {
		// Yii::log('订单'.$this->oh_no.'对应洗车工信息存入失败'.$e->getMessage(),'error','orders.staff.save');
		// }
		
		// $order['_orderServiceItems']
	}
	
	/**
	 * 新插入预定订单时操作
	 *
	 * @see CActiveRecord::beforeSave()
	 */
	// protected function beforeSave()
	// {
	// if (parent::beforeSave())
	// {
	// if ($this->isNewRecord)
	// {
	// $lastItem = $this->findAll(array(
	// 'condition'=>'c_province_no='.$this->c_province_no,
	// 'order'=>'c_no DESC',
	// 'limit'=>1,
	// ));
	
	// if (!empty($lastItem))
	
	// $this->c_no = $lastItem[0]['c_no']+1;
	// else
	// $this->c_no = 1;
	// }
	
	// return true;
	// }
	// else
	// return false;
	// }
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className
	 *        	active record class name.
	 * @return OrderHistory the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
