<?php
class OrderController extends Controller {
	// public $layout='//layouts/map_main';
	// public $bais = 1;
	public function actions() {
		return array (
				'APIs' => array (
						'class' => 'CWebServiceAction' 
				) 
		);
	}
	public function actionIndex() {
		$this->render ( 'index' );
	}
	
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl'  // perform access control for CRUD operations
				);
	}
	
	/**
	 *
	 * @param unknown $shopId        	
	 * @param unknown $orderDate        	
	 * @param unknown $carIndex        	
	 * @param unknown $serviceIndex        	
	 * @return multitype:unknown
	 */
	public function tranfQuick() {
		
		// 与当前日期的偏移量
		@$idOrderDate = $_POST ['idOrderDate'];
		$orderDate = new DateTime ( $idOrderDate );
		;
		$currentDate = new DateTime ( date ( 'Y-m-d' ) );
		$interval = $orderDate->diff ( $currentDate );
		$bias = $interval->format ( '%a' );
		@$idCity = $_POST ['idCity'];
		@$idCarType = $_POST ['idCarType'];
		@$idServiceType = $_POST ['idServiceType'];
		$serviceTypeItem = ServiceType::model ()->findByPk ( $idServiceType );
		
		// $serviceTypeItem = ServiceType::model()->find(array(
		// 'condition'=>'st_city_id= :idCity AND st_type =:idType AND st_name = :serviceName',
		// 'params'=>array(
		// ':idCity'=>$idCity,
		// ':idType'=>$idCarType,
		// ':serviceName'=>trim($idServiceType)
		// ),
		// ));
		
		// $intervalNum = 1;
		// $intervalNum = $serviceTypeItem['st_interval_num'];
		
		return array (
				'interValNum' => $serviceTypeItem ['st_interval_num'],
				'bias' => $bias,
				'serviceTypeId' => $serviceTypeItem ['id'] 
		// 'd'=>var_dump($intervalNum)
				);
	}
	public function actionGetSTItems() {
		@$st_id = $_POST ['id'];
		@$carType = $_GET ['carType'];
		@$_sType = $_GET ['sType'];
		switch ($_sType) {
			case 1 :
				$sType = 1;
				break;
			case 3 :
				$sType = 3;
				break;
			case 5 :
				$sType = 5;
				break;
			default :
				$sType = 1;
		}
		
		$st_id = $sType;
		
		// Yii::log($st_id,'error','ddd');
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'sti_st_id=' . $st_id );
		$processList = ServiceTypeItem::model ()->findAll ( $criteria );
		// // Yii::log(CJSON::encode($tt),'error','_process.dataProvider1');
		// $dataProvider = new CActiveDataProvider('ServiceTypeItem',array(
		
		// 'criteria'=>$criteria,
		// ));
		// Yii::log(CJSON::encode($dataProvider),'error','_process.dataProvider');
		if (Yii::app ()->request->isAjaxRequest) {
			
			$this->renderPartial ( '_process', array (
					'sType' => $sType,
					'processList' => $processList 
			), false, false );
			Yii::app ()->end ();
		}
	}
	public function actionUpdateTimes() {
		$postParams = $this->tranfQuick ();
		// echo CJSON::encode($postParams);
		@$idWS = $_POST ['idWS'];
		$rlt = WashShop::model ()->getAvailableTime ( $idWS, $postParams ['interValNum'], $postParams ['bias'], false, 1 );
		// echo "d";
		// echo CJSON::encode($rlt['data']);
		$data = '<option value="">选择预约时间段</option>';
		if ($rlt ['status']) {
			$rlt = $rlt ['data'];
			foreach ( $rlt as $name ) {
				$data .= CHtml::tag ( 'option', array (
						'value' => $name ['timeIndex'] 
				), CHtml::encode ( $name ['timeStr'] ), true );
			}
		}
		
		echo CJSON::encode ( array (
				'dropDownTimes' => $data 
		) );
	}
	public function actionUpdateServiceType() {
		@$idCity = $_POST ['idCity'];
		@$idCarType = $_POST ['idCarType'];
		
		$serviceTypeItem = ServiceType::model ()->findAll ( array (
				'condition' => 'st_city_id= :idCity AND st_type =:idType',
				'params' => array (
						':idCity' => $idCity,
						':idType' => $idCarType 
				) 
		) );
		// $data = CHtml::listData($serviceTypeItem,'id','st_name');
		$dropDownServiceTypes = '';
		$defaultIsSet = false;
		$dropDownServiceTypeValues = '';
		foreach ( $serviceTypeItem as $name => $value ) {
			$dropDownServiceTypes .= CHtml::tag ( 'option', array (
					'value' => $value ['id'] 
			), CHtml::encode ( $value ['st_name'] . '(' . $value ['st_value'] . '元)' ), true );
			$dropDownServiceTypeValues .= CHtml::tag ( 'option', array (
					'value' => $value ['id'] 
			), CHtml::encode ( $value ['st_value'] ), true );
			
			// if (!$defaultIsSet) {
			// $dropDownServiceTypes .= CHtml::tag('option',
			// array('value'=>$value['id']),CHtml::encode($value['st_name']),true);
			// $defaultPrice = $value['st_value'];
			// }else {
			// $dropDownServiceTypes .= CHtml::tag('option',
			// array('value'=>$name['id']),CHtml::encode($name['st_name']),true);
			// }
		}
		
		if (empty ( $dropDownServiceTypes )) {
			$dropDownServiceTypes .= '<option value="1">洗车</option>';
			$dropDownServiceTypes .= '<option value="2">打蜡</option>';
			$dropDownServiceTypes .= '<option value="3">车内精洗</option>';
			$dropDownServiceTypeValues .= '<option value="20">20</option>';
			$dropDownServiceTypeValues .= '<option value="40">150</option>';
			$dropDownServiceTypeValues .= '<option value="150">150</option>';
		}
		
		// $intervalNum = 1;
		// $intervalNum = $serviceTypeItem['st_interval_num'];
		
		echo CJSON::encode ( array (
				'dropDownServiceTypes' => $dropDownServiceTypes,
				'dropDownServiceTypeValues' => $dropDownServiceTypeValues 
		) );
	}
	public function actionOrderAdd() {
		$rlt=UTool::iniFuncRlt();
		
		if (Yii::app()->user->isGuest) {
			$this->redirect(array('site/login').'?callback'.Yii::app()->request->hostInfo.Yii::app()->request->getUrl());
			Yii::app()->end();
		}
		if (Yii::app ()->request->isAjaxRequest && Yii::app ()->request->isPostRequest) {
			$cardId = Yii::app()->request->getParam('card',null);
			@$otId = $_POST ['id'];
			// @$otValue = $_POST['sValue'];
			// @$otStaffs = $_POST['staffs'];
			@$otStaffs = '0,0';
			@$carType = $_POST ['ct'];
			$staffs = split ( ',', $otStaffs );
			$timeInfo = Yii::app()->request->getParam('timeInfo');
			
// 			if(OrderTemp::model()->findByPk($otId)){
				
// 			}
			
			$updateRlt = OrderTemp::model ()->updateOrder ( $otId, $otStaffs, Yii::app ()->user->Id, $carType );
			
			if (! $updateRlt ['status']) {
// 				echo 'false';
				echo CJSON::encode($updateRlt);
				Yii::app()->end();
			}
			
			
// 			$ot = OrderTemp::model()->findByPk($otId);
			if ($timeInfo<1){
				$cardId = null;
			}
			
			$rlt = OrderHistory::model ()->getOrderNew ( $otId, $cardId, 1, Yii::app ()->request->userHostAddress, '1', yii::app ()->user->id );
			Yii::log(CJSON::encode($rlt),CLogger::LEVEL_INFO,'mngr.order.add.rlt');
			// Yii::app()->user->setFlash('orderAddRlt','Order add successfully!');
			
			if ($rlt ['status']) {
				// var_dump(UWeChatEnt::getToken(AppName::$EntOrderMngr));
				

				
				
				

				
// 				用户发订单通知
// 				如果该用户已关注微信平台，则通过微信平台发送订单通知
// 				WeixinOpenid::model()->getUserByOpenId($openId, $appServiceId);
				$userId= Yii::app()->user->id;
				
// 				查询是否有定制服务号
				$shopId = $rlt ['data']->oh_wash_shop_id;
				$appService =  WeixinCtoken::model()->findByAttributes(array(
					'wc_shop_id'=> $shopId
				));
				
				if ($appService === null){
// 					没有定制服务号，给我洗车统一服务号发送订单通知
					$appService =  WeixinCtoken::model()->findByAttributes(array(
							'wc_app_name'=> AppName::$OpenService
					));
					
					$appServiceId = $appService['id'];
					$weChat= new UWeChat(AppName::$OpenService);
				}else{
// 					有定制服务号，则给该服务号对应的车主openId发送订单通知
					$appServiceId= $appService['id'];
					$weChat= new UWeChat($appService['wc_app_name']);
				}
				
				
				$weixinUser = WeixinOpenid::model()->findByAttributes(array(
					'wo_user_id'=>$userId,
					'wo_src'=>$appServiceId
				));
				
				if (isset($weixinUser)){
// 					用户已关注服务号
					$order = $rlt['data'];
					$orderType = $order->serviceType ['st_name'];
					$orderStartTime = strtotime ( $order ['oh_date_time'] );
					$orderEndTime = strtotime ( $order ['oh_date_time_end'] );
					$orderPayValue = $order ['oh_value'] - $order ['oh_value_discount'];
					$url = Yii::app()->createUrl('order/view',array('id'=>$order['oh_no']));// "www.woxiche.com/boss/list";
					$infos = array (
							"touser" => $weixinUser['wo_open_id'],
							"template_id" => "FqDXhQpxVj6KspMTps7wc2ZQJtJQg-B6TCOAGcXD3Kg",
							"url" => $url,
							"topcolor" => "#7b68ee",
							"data" => array (
									"first" => array (
											"value" => $weixinUser['wo_open_id'],
											"color" => "#743a3a"
									),
									"service" => array (
											"value" => $orderType,
											"color" => "#743a3a"
									),
									"datetime" => array (
											"value" => date ( 'm月d日 H:00-', $orderStartTime ) . date ( 'H:20', $orderEndTime ),
											"color" => "#0000ff"
									),
									"price" => array (
											"value" => $orderPayValue,
											"color" => "#ff0000"
									),
									"remark" => array (
											"value" => "渐进生活，尽在我洗车",
											"color" => "#080000"
									)
							)
					);
					
					$weChatRlt = $weChat->sendTplMsg( $weixinUser['wo_open_id'],$infos);
					$weChatRlt = json_decode($weChatRlt,JSON_UNESCAPED_UNICODE);
					if ($weChatRlt['errcode'] == 0) {
						Yii::log(json_encode($weChatRlt,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.sentMsg.rlt');
					}else{
						$rltSendSms = USms::sendSmsOrder ( $rlt ['data'] );
						Yii::log(json_encode(json_encode($rltSendSms),JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.sentMsg.rlt');
					}

				} else {
// 					$rltSendSms = USms::sendSmsOrder ( $rlt ['data'] );
				}
				
				$order = $rlt['data'];
				
// 				查找老板对应企业号
				$weixinShopNotifyBossList = WeixinEntUser::model()->findAllByAttributes(array(
						'weu_shop_id'=>$order['oh_wash_shop_id'],
						'weu_state'=>WeixinEntUser::USER_STATUS_SUBSCRIBED,
				));
				
				foreach ($weixinShopNotifyBossList as $key=>$notifyBoss){
					$notifyBoss
					
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
// 				$fromUserName = Yii::app ()->user->Id;
// 				$agentId = 13;
// 				$content = array(
// 						'touser'=>(int)$fromUserName,
// 						'msgtype'=>'text',
// 						'agentid'=>(int)$agentId,
// 						'text'=>array(
// 								'content'=>$rltSendSms ['data']
// 						),
// 						'safe'=>'0'
// 				);
// 				UWeChatEnt::sendMsg(AppName::$EntOrderMngr, $content);
				
				$msg = new Message ();
				$msg ['m_datetime'] = date ( 'Y-m-d H:i:s' );
				$msg ['m_user_id'] = Yii::app ()->user->id;
				$msg ['m_status'] = 0;
				$msg ['m_level'] = Message::LEVEL_PRIORITY;
				$msg ['m_type'] = Message::TYPE_ORDER;
				$msg['m_src']=UTool::getRequestInfo();
				$orderItem = $rlt ['data'];
				$msg ['m_content'] = '订单编号:'.$orderItem['id'];
				if ($msg->save ()) {
				}
				
				// UTool::orderSubmitSms ( $rlt ['data'] );
				Yii::app ()->user->setFlash ( 'orderAddSuccess', $orderItem['id'] );
				$rlt['msg']='预约成功';
				$rlt['status']=true;
				echo CJSON::encode($rlt);
// 				echo 'true';
			} else {
				$rlt['msg']='预约失败，请刷新页面重试';
// 				echo 'false';
				echo CJSON::encode($rlt);
			}
		}
		
	
	}
	
	/**
	 * 根据车行id，服务时间段，服务时长，偏移量返回服务时间信息
	 *
	 * @param int $shopId        	
	 * @param int $timeIndex        	
	 * @param int $intervalNum        	
	 * @param int $bias        	
	 * @return string @soap
	 */
	public static function getOrderTime($shopId, $timeIndex, $intervalNum, $bias = 0) {
		return CJSON::encode ( Order::getOrderTime ( $shopId, $timeIndex, $intervalNum, $bias ) );
	}
	
	/**
	 * 车主新增订单
	 *
	 * @param int $timeIndex
	 *        	时间段序号
	 * @param int $washShopId
	 *        	车行id
	 * @param int $position
	 *        	车行档口
	 * @param int $serviceIntervalNum
	 *        	标准服务单元数
	 * @param int $orderValue
	 *        	订单金额
	 * @param int $orderType
	 *        	订单类型 0 表示自定义
	 * @param
	 *        	string json array $serviceItems
	 *        	订单对应小项
	 * @param int $staff1Id
	 *        	员工1
	 * @param int $staffId2
	 *        	员工2
	 * @param int $userId
	 *        	车主id
	 * @param int $bias
	 *        	偏移量
	 * @return string json array [state,msg,data]
	 *         @soap
	 */
	public function getOrderNew($timeIndex, $washShopId, $position, $serviceIntervalNum, $orderValue, $orderType, $serviceItems, $staff1Id, $staffId2, $userId = 0, $bias = 0) {
		$rlt = OrderHistory::model ()->getOrderNew ( $timeIndex, $washShopId, $position, $serviceIntervalNum, $orderValue, $orderType, CJSON::decode ( $serviceItems ), $staff1Id, $staffId2, $userId, $bias );
		return CJSON::encode ( $rlt );
	}
	
	/**
	 * 删除订单
	 *
	 * @param int $orderId        	
	 * @return string @soap
	 */
	public function getOrderDelete($orderId) {
		return CJSON::encode ( OrderHistory::model ()->getOrderDelete ( $orderId ) );
	}
	
	/**
	 * 根据车行id，服务时间计算服务用标准用时单元
	 *
	 * @param int $shopId        	
	 * @param int $orderTime        	
	 * @return string @soap
	 */
	public static function getOrderUnit($shopId, $serviceTime) {
		return CJSON::encode ( Order::getOrderUnit ( $shopId, $serviceTime ) );
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules() {
		return array (
				
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (
								'APIs',
								'updateTimes',
								'updateServiceType',
								'list',
								'map',
								'suggestList',
								'getTimelist',
								'getStaffList',
								'getProcessList',
								'GetShopCount',
								'GetCommentList',
						    'GetOrderList',
								'UserCardList',
								'ShopInfos',
								'MapSearch',
								'new',
								'getSTItems' ,
						    	'orderAdd',
								'topShop'
						),
						'users' => array (
								'*' 
						) 
				),
				
				array (
						'allow', // allow all users to perform 'index' and 'view' actions
						'actions' => array (
// 								'index',
// 								'bossNew',
// 							'orderAdd',
// 								'APIs' 
						),
						'users' => array (
								'@' 
						) 
				),
				// array('allow', // allow admin user to perform 'admin' and 'delete' actions
				// 'actions'=>array('admin','delete','index','view'),
				// 'users'=>array('admin'),
				// ),
				array (
						'deny', // deny all users
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionGetStaffList() {
		if (Yii::app ()->request->isAjaxRequest) {
			$id = $_GET ['id'];
			$model = new OrderTempUser ();
			$criteria = new CDbCriteria ();
			$criteria->addCondition ( 'otu_ot_id=:id' );
			$criteria->params [':id'] = $id;
			// $criteria->with = "otuUser";
			$criteria->with = "otuStaff";
			$criteria->alias = 't';
			$criteria->order = "t.id ASC";
			$dataProvider = new CActiveDataProvider ( 'OrderTempUser', array (
					'pagination' => array (
							'pageSize' => 80 
					),
					'criteria' => $criteria 
			) );
			$this->renderPartial ( '_staffList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	public function actionGetShopCount() {
		$id = $_GET ['id'];
		@$bias = $_GET ['bias'];
		@$sType = $_GET ['sType'];
		$shop = WashShop::model ()->findByPk ( $id );
		$queryRlt = WashShop::model ()->getBasicInfobyType ( $shop, $sType, $bias, false );
		$availableCount = 0;
		$totalCount = 0;
		if ($queryRlt ['status']) {
			$availableCount = $queryRlt ['data'] ['numAvailable'];
			$totalCount = $queryRlt ['data'] ['numTotal'];
		}
		
		echo CJSON::encode ( array (
				'availableCount' => $availableCount,
				'totalCount' => $totalCount 
		) );
	}
	
	/**
	 * 返回可用时间段信息
	 */
	public function actionGetTimelist() {
		if (Yii::app ()->request->isAjaxRequest) {
			$id = $_GET ['id'];
// 			$bias = Yii::app()->getParams('bias',0);
			$bias = Yii::app()->request->getParam('bias',0);
			$carType =Yii::app()->request->getParam('carType',1);
			$sType = Yii::app()->request->getParam('sType',1);
			$position = Yii::app()->request->getParam('position',1);
			
// 			@$bias = $_GET ['bias'];
// 			@$carType = $_GET ['carType'];
// 			@$sType = $_GET ['sType'];
// 			@$position = $_GET ['position'];
			
			$model = new OrderTemp ();
			
			$criteria = new CDbCriteria ();
			// $criteria->select = 'id, ot_date_time, ot_date_time_end, ot_value5 as ot_value, ot_state';
			if ($carType == '2') {
				$criteria->select = 'id, ot_date_time, ot_date_time_end, 
						ot_value2 as ot_value, ot_value2_discount as ot_discount, ot_state,ot_bias';
			} else {
				$criteria->select = 'id, ot_date_time, ot_date_time_end, ot_value1 as ot_value, 
						ot_value1_discount as ot_discount, ot_state,ot_bias';
			}
			
			$criteria->order = 'ot_date_time ASC, id ASC';
			$criteria->addCondition ( 'ot_wash_shop_id=:id' );
			$criteria->params [':id'] = $id;
			$criteria->addCondition ( 'ot_bias=:bias' );
			$criteria->params [':bias'] = $bias;
			$criteria->addCondition ( 'ot_type=:sType' );
			$criteria->params [':sType'] = $sType;
			$criteria->addCondition ( 'ot_position=:position' );
			$criteria->params [':position'] = $position;
			
			$dataProvider = new CActiveDataProvider ( 'OrderTemp', array (
					'pagination' => array (
							'pageSize' => 80 
					),
					'criteria' => $criteria 
			) );
			
			$timeList =$this->renderPartial ( '_timeList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), true, true );
			
			$shop=WashShop::model()->findByPk($id);
			$num=$shop['ws_num'];
			$countArr=array();$countArr['size']=$num;
			for ($i =1;$i<=$num; $i++){
			    $countArr['p'.$i]=OrderTemp::model()->getPositionCount($id,$sType, $i,$bias,TRUE);
			}
			
// 			$availableCount = OrderTemp::model()->getPositionCount($id,$sType,1, $position,$bias,TRUE);
			echo CJSON::encode(array('timeList'=>$timeList,'count'=>$countArr));
			Yii::app ()->end ();
		}
	}
	
	/**
	 * 返回可用时间段信息
	 */
	public function actionGetProcesslist() {
		if (Yii::app ()->request->isAjaxRequest) {
			
			@$carType = $_GET ['carType'];
			@$_sType = $_GET ['sType'];
			switch ($_sType) {
				case 1 :
					$sType = 1;
					break;
				case 3 :
					$sType = 3;
					break;
				case 5 :
					$sType = 5;
					break;
				default :
					$sType = 1;
			}
			
			// $model = new OrderTemp();
			
			$criteria = new CDbCriteria ();
			// $criteria->select = 'id, ot_date_time, ot_date_time_end, ot_value5 as ot_value, ot_state';
			if ($carType == '2') {
				$criteria->select = 'id, ot_date_time, ot_date_time_end,
						ot_value2 as ot_value, ot_value2_discount as ot_discount, ot_state';
			} else {
				$criteria->select = 'id, ot_date_time, ot_date_time_end, ot_value1 as ot_value,
						ot_value1_discount as ot_discount, ot_state';
			}
			
			$criteria->order = 'ot_date_time ASC, id ASC';
			$criteria->addCondition ( 'ot_wash_shop_id=' . $id );
			$criteria->addCondition ( 'ot_bias=' . $bias );
			$criteria->addCondition ( 'ot_type=' . $sType );
			$criteria->addCondition ( 'ot_position=' . $position );
			
			$dataProvider = new CActiveDataProvider ( 'OrderTemp', array (
					'pagination' => array (
							'pageSize' => 80 
					),
					'criteria' => $criteria 
			) );
			$this->renderPartial ( '_timeList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	
	
	
	
	public function actionGetCommentList() {
// 		if (Yii::app ()->request->isAjaxRequest && Yii::app ()->request->isPostRequest) {
			$shopId =Yii::app()->request->getParam('id');
			if (! isset ( $shopId )) {
				throw new CHttpException ( 404, '非法请求' );
				Yii::app ()->end ();
			}
			
			$model = new OrderComments ();
			
			$criteria = new CDbCriteria ();
			$criteria->order = 'oc_datetime DESC, oc_order_id DESC';
			
		
			$criteria->addCondition ( 'oc_washshop_id = :shopId' );
			$criteria->params [':shopId'] = $shopId;
			$criteria->addCondition ( 'oc_comment_user_type = 1' );
			
			$dataProvider = new CActiveDataProvider ( 'OrderComments', array (
					'pagination' => array (
							'pageSize' => Yii::app()->params['pageSize'] ,
							'route'=>'order/GetCommentList',
					),
					'criteria' => $criteria 
			) );
// 			Yii::app()->clientScript->registerScript('alert(3)',CClientScript::POS_READY);
			$this->renderPartial ( '_commentList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			));
			
			
// 			Yii::app ()->end ();
// 		}
	}
	
	public function actionGetOrderList() {
	    $shopId =Yii::app()->request->getParam('id');
	    if (! isset ( $shopId )) {
	        throw new CHttpException ( 404, '非法请求' );
	        Yii::app ()->end ();
	    }
	    	
	    $model = new OrderHistory ();
	    	
	    $criteria = new CDbCriteria ();
	    $criteria->order = 'id desc';
	    	
	
	    $criteria->addCondition ( 'oh_wash_shop_id = :shopId' );
	    $criteria->params [':shopId'] = $shopId;
	    $criteria->addCondition ( 'oh_state >= 2' );
	    	
	    $dataProvider = new CActiveDataProvider ( 'OrderHistory', array (
	        'pagination' => array (
	            'pageSize' => Yii::app()->params['pageSize'] ,
	            'route'=>'order/GetOrderList',
	        ),
	        'criteria' => $criteria
	    ) );
	    // 			Yii::app()->clientScript->registerScript('alert(3)',CClientScript::POS_READY);
	    $this->renderPartial ( '_orderList', array (
	        'model' => $model,
	        'dataProvider' => $dataProvider
	    ));
	    	
	    	
	    // 			Yii::app ()->end ();
	    // 		}
	}
	
	/**
	 * 获取推荐车行列表
	 */
	public function actionSuggestList() {
		if (Yii::app ()->request->isAjaxRequest) {
			@$cityId = $_GET ['cityId'];
			
			if (isset ( $cityId ) && is_numeric ( $cityId )) {
			} else {
				$cityId = 1;
			}
			
			$model = new WashShop ();
			
			$criteria = new CDbCriteria ();
			$criteria->order = 'ws_score DESC, ws_exp DESC, id ASC';
			$criteria->addCondition ( 'ws_city_id=:cid' );
			$criteria->params ['cid'] = $cityId;
			
			$dataProvider = new CActiveDataProvider ( 'WashShop', array (
					'pagination' => array (
							'pageSize' => 8 
					),
					'criteria' => $criteria 
			) );
			$this->renderPartial ( '_suggestList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	
	public function actionTopShop(){
		$this->render ( 'topShop');
	}
	
	
	public function actionList() {
		$this->layout = 'main';
		
		// 微信自动定位
		$src = Yii::app()->request->getParam('src');
		if ($src == 'weixin'){
			$code = Yii::app()->request->getParam('code');
			$appType = Yii::app()->request->getParam('appType');
			$weChat = new UWeChat($appType);
			$accessTokenRlt = $weChat->getAccessTokenFromCode($code);
				
			if ($accessTokenRlt['status']){
				$openid=  $accessTokenRlt['data']['openid'];
				$loginRlt = WeixinOpenid::model()->loginByOpenId($openid, Yii::app()->user->id);
				if ($loginRlt['status']){
				}
				$weiUser = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$openid));
				if (isset($weiUser)){
					Yii::app()->session['location'] = $weiUser['wo_location'];
				}
			}
			// 如果强制指定location，则忽略微信自动参数
			$currentLocation = Yii::app()->request->getParam('location',Yii::app()->session['location']);
		}else{
			$currentLocation = Yii::app()->request->getParam('location');
			if ($currentLocation == NULL){
				$ip = Yii::app()->request->userHostAddress;
				$address_information = Yii::app()->geoip->getCityInfoForIp($ip);
				$currentLocation = $address_information['longitude'].','.$address_information['latitude'];
			}
		}
		
		$cityId = UPlace::getCityId ();

		$criteria = new CDbCriteria();
		$criteria->addCondition('ws_city_id=:cityId');
		$criteria->params[':cityId']=$cityId;
		
		$criteria->addCondition('ws_state=1');
		$shopList = WashShop::model()->findAll($criteria);
		$currentLocation = @explode(',', $currentLocation);
		$currentLocation_lon = @$currentLocation[0];
		$currentLocation_lat = @$currentLocation[1];
		$rltList=array();
		foreach ($shopList as $key=>$shop){
			$shopLocation = @explode(',', $shop['ws_position']);
			$shopLocation_lon = @$shopLocation[0];
			$shopLocation_lat = @$shopLocation[1];
			$distance = UMap::GetShortDistance($currentLocation_lon, $currentLocation_lat, $shopLocation_lon, $shopLocation_lat);
			$rltList [] = array (
					'id' => $shop ['id'],
					'address' => $shop ['ws_address'],
					'distance' => $distance,
					'name' => $shop['ws_name'] ,
					'score'=>$shop['ws_score']
			);
		}
		$distanceArray = array ();
		$scoreArray = array ();
		foreach ( $rltList as $key => $value ) {
			$distanceArray [$key] = $value ['distance'];
			$scoreArray [$key] = $value ['score'];
		}
		
		array_multisort ( $distanceArray, SORT_ASC, $scoreArray, SORT_ASC, $rltList );

		
// 		if (isset($location)){
// // 			UMap::getLocationDistance($location,)
// 			$shopList = WashShop::model()->getShopListDistance($location,5000,0,50);
// 		}

// 		Yii::log('入口',CLogger::LEVEL_INFO,'mngr.'.$this->getId().'.'.$this->getAction()->getId());
		$cityId = UPlace::getCityId ();
// 		$cityId = 1;
// 		Yii::log($cityId,CLogger::LEVEL_INFO,'mngr.'.$this->getId().'.'.$this->getAction()->getId());
// 				$this->render('/site/index');
		$searchForm = new SearchForm ();
		$searchForm ['bias'] = 0;
		
		
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'search-form') {
			echo CActiveForm::validate ( $searchForm );
			Yii::app ()->end ();
		}
		
		$model = new WashShop ();
		$criteria = new CDbCriteria ();

		
		if (false && isset ( $_GET ['SearchForm'] )) {
			$searchForm->attributes = $_GET ['SearchForm'];
			if ($searchForm->validate ()) {
				
			
				
				// 根据关键字搜索
				$q = $searchForm ['q'];
				
				if (! empty ( $q)) {
					
					mb_internal_encoding ( 'UTF-8' );
					mb_regex_encoding ( 'UTF-8' );
					$q = mb_split ( '[\s,;、，；]', $q );
// 					$q = mb_split ( '[\s,;]', $q );
// 					$q = split('[\s,;]', $q);
					$q = array_filter ( $q );
					Yii::log ( CJSON::encode ( $q ) . count ( $q ), CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId());
					$qarray = '';
					if (count ( $q ) < 1) {
						$qarray = $searchForm ['q'];
					} else {
						
						foreach ( $q as $key => $value ) {
							if (! empty ( $value )) {
								$qarray .= trim ( $value ) . '|';
							}
						}
						if (substr ( $qarray, - 1, 1 ) == '|') {
							$qarray = substr ( $qarray, 0, - 1 );
						}
					}
// 					$qarray = $searchForm ['q'];
					Yii::log ( $qarray, CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId());
					
					$criteria->condition = "(ws_name  REGEXP BINARY :name or ws_address  REGEXP BINARY :address or ws_key_words  REGEXP BINARY :keyWord)";
					$criteria->params [':name'] = $qarray;
					$criteria->params [':address'] = $qarray;
					$criteria->params [':keyWord'] = $qarray;
					// Yii::app()->session['bias']=$searchForm['bias'];
				} // end if empty $q
				  


				
				$areas = $searchForm['areas'];
				
				if ($areas != 0){
// 					$criteria->addInCondition('t.ws_area_id', $areas);
					$criteria->addCondition('t.ws_area_id=:aid');
					$criteria->params[':aid']=$areas;
				}
// 				if (! empty ( $areas )) {
// 				if (empty($areas)) {
// 					$areas = array();
// 				}else{
// 					$areas = array_filter ( $areas );
// 				}
					
// 					if (count ( $areas ) > 0) {
// 							$criteria->addInCondition('t.ws_area_id', $areas);
// // 							$criteria->addInCondition ( 't.id', $rlt );
						
// 					}
// 				} // end if empty
				
				// 根据特征搜索
				$features = $searchForm ['features'];
				if (! empty ( $features )) {
// 					$features = split ( ',', trim ( $features ) );
					$features = array_filter ( $features );
					if (count ( $features ) > 0) {
						$rlt = WashShopFeature::model ()->getShopIds ( $features );
// 						Yii::log ( CJSON::encode($rlt), CLogger::LEVEL_INFO, 'mngr.orderC.list' );
						
							
							$criteria->addInCondition ( 't.id', $rlt );
						
					}
				} // end if empty
			} // end validator
		}
		
		$criteria->addCondition ( "ws_city_id=:cityId" );
		$criteria->params [':cityId'] = $cityId;
		$criteria->addCondition ( "ws_state=1" );
		
		$criteria->with = array (
				'washShopServices' => array (
						'select' => 'wss_value_min' 
				// 'group' => 'wss_value_min'
								) 
		);
		
// 		$criteria->together = true;
		
		// WashShop::model()->findAll($criteria);
		
		$dataProvider = new CActiveDataProvider ( 'WashShop', 

		array (
				
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 8, 
				),
				
				'sort' => array (
						'defaultOrder' => 'ws_level DESC',
						'attributes' => array (
								
								'all' => array (
										'asc' => 'ws_level ASC',
										'desc' => 'ws_level DESC' 
								),
								'value' => array (
										'asc' => 'washShopServices.wss_value_min ASC',
										'desc' => 'washShopServices.wss_value_min DESC' 
								),
								'level' => array (
										'asc' => 'ws_level ASC',
										'desc' => 'ws_level DESC' 
								),
								'score' => array (
										'asc' => 'ws_score ASC',
										'desc' => 'ws_score DESC' 
								),
								'ratio' => array (
										'asc' => 'ws_score ASC',
										'desc' => 'ws_score DESC' 
								) 
						) 
				) 
		)
		 );
		Yii::log ( CJSON::encode ( $shopList), CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId());
			
		
// 		if (Yii::app()->request->isAjaxRequest) {
// 			$this->renderPartial ( '_rltList', array (
// 		'model' => $model,
// 		'dataProvider' => $dataProvider,
// 		'searchModel' => $searchForm 
// ) );
// 			Yii::app()->end();
// 		}

		$this->render ( 'list', array (
				'model' => $model,
				'dataProvider' => $dataProvider,
				'searchModel' => $searchForm ,
				'shopList'=>$rltList,
		) );
	}
	public function actionMap() {
		$this->layout = 'main_map';
		
		$criteria = new CDbCriteria ();
		$criteria->addCondition('id=0');
		
		$dataProvider = new CActiveDataProvider ( 'WashShop',
		
				array (
		
						'criteria' => $criteria,
						'pagination' => array (
								'pageSize' => 3,
						),
		
				)
		);
		
		
// 		$this->render('/site/pages',array('view'=>'cooming'));
		$this->render ( 'map' ,array('dataProvider'=>$dataProvider));
	}
	public function actionMapSearch() {
// 		if (! Yii::app ()->request->isAjaxRequest) {
// 			Yii::app ()->end ();
// 		}
		$q= Yii::app()->request->getParam('q');

// 		@$q = $_GET ['q'];
        $pageNum = Yii::app()->request->getParam('page_index',0);
// 		@$pageNum = $_GET ['page_index'];
// 		@$province = $_GET ['povince'];
// 		@$city = $_GET ['city'];
// 		@$area = $_GET ['area'];
		$bounds = Yii::app()->request->getParam('bounds');
// 		$bounds = '123.189027,41.916092;123.676555,41.701016';
		$filter = '';

		$url = UMap::getMapUrl(UMapURLType::lbs_search_bound);
		
		$opts = array(
				'http'=>array(
						'method'=>"GET",
						'timeout'=>60,
				)
		);
		
		$context = stream_context_create($opts);
		$i=0;
		$maprlt_ini=false;
		$maprlt_ini= file_get_contents($url.'&bounds='.$bounds,false,$context);;
		if ($maprlt_ini == false) {
			$maprlt_ini = CJSON::encode(array('status'=>-1,'total'=>0,'size'=>0,'contents'=>array()));
		}

// 		do{
// 			@$maprlt_ini= file_get_contents($url.'&bounds='.$bounds,false,$context);;
// 			$i++;
// 		}
// 		while($i<4 && ($maprlt_ini==false));
// 		if($i==4){
// 			$maprlt_ini = array('status'=>0,'total'=>0,'size'=>0,'contents'=>array());
			
// 		} 

		
		
// 		echo $maprlt_ini;
		$maprlt = CJSON::decode($maprlt_ini);
		
		$ids=array();
		$shops=array();
		if ($maprlt['status']==0 && $maprlt['size']>0) {
			foreach ($maprlt['contents'] as $key=>$value){
				$ids[]=$value['washshop_id'];
// 				$shops[$value['washshop_id']]=$value;
				$shops['w'.$value['washshop_id']]=$value;
			}
		}
		
		Yii::log(CJSON::encode($shops),CLogger::LEVEL_INFO,'mngr.orderC.mapSearch'.$this->getAction()->id);

		$criteria = new CDbCriteria ();
		
		
		$criteria->addInCondition('id', $ids);
		$criteria->order = 'id ASC';
		
		$criteria->addCondition('ws_state=1');
		if($maprlt['status'] == -1){
			$criteria->addCondition('id=-1');
		}
		
		
		$rawData = WashShop::model()->findAll($criteria);
		
		// 		echo CJSON::encode($rawData);
		
		$filter_ids = array();
		// 		$filter_ids_str = '';
		foreach ($rawData as $key=>$value){
			$filter_ids[] = $value['id'];
		}

		
		$ids_intersect = array_intersect($filter_ids,$ids);

				$maprltOut = $maprlt;
				$maprltOut['contents']=array();
// 				$maprltOut['size'] -=1;
// 				$maprltOut['total'] -=1;
								$maprltOut['size'] =0;
								$maprltOut['total'] =0;
				foreach ($rawData as $key=>$value){
				    if (array_key_exists('w'.$value['id'], $shops)){
				        $maprltOut['contents'][]=$shops['w'.$value['id']];
				        $maprltOut['size']+=1;
				        $maprltOut['total'] +=1;
				    }
// 				    else {
// 				        $maprlt['contents'][]='w'.$value['id'];
// 				    }
				    
				}
				
// 				foreach ($maprlt['contents'] as $key=>$value){
// 					if ( in_array($value['washshop_id'],$ids_intersect)) {
// 						$maprltOut['contents'][] = $value;
// 					}else{
// 						$maprltOut['size'] -=1;
// 						$maprltOut['total'] -=1;
// 					}
// 				}
		
// 				$criteria->offset = Yii::app()->getParams('WashShop_page',0);
// 				$criteria->
        $dataProvider = new CArrayDataProvider($rawData,array('pagination'=>array('pageSize'=>800)));
// 		$dataProvider = new CActiveDataProvider ( 'WashShop',
		
// 				array (
		
// 						'criteria' => $criteria,
// 						'pagination' => array (
// 								'pageSize' => 5,
// 						),
// // 						'route'=>'order/GetCommentList',
		
// 				)
// 		);
		
		
		// 		$this->render('/site/pages',array('view'=>'cooming'));
		$result = $this->renderPartial ( '_mapRltList' ,array('dataProvider'=>$dataProvider),true,false);
		$html = array('map'=>$maprltOut,'rlt'=>$result);
		echo CJSON::encode($html);
// 	 $this->renderPartial ( '_mapRltList' ,array('dataProvider'=>$dataProvider),false,true);
	}
	
	/**
	 * 格式化地图用显示车行信息
	 */
	public function actionShopInfos() {
		if (! Yii::app ()->request->isAjaxRequest) {
			Yii::app ()->end ();
		}
		$shopInfos = array ();
		$shopIds = $_POST ['shop_id'];
		// array_push($shopIds, '19');
		foreach ( $shopIds as $key => $id ) {
			$infos = array ();
			$infos [0] = CJSON::encode ( WashShop::model ()->getWashShopInfo ( $id ) );
			$c = UTool::iniFuncRlt ();
			$c ['data'] = 1;
			$infos [1] = CJSON::encode ( $c );
			$shopInfos [$key] = $infos;
		}
		
		echo CJSON::encode ( $shopInfos );
	}
	public function actionUserCardList() {
		if (Yii::app ()->request->isAjaxRequest) {
			@$sid = $_POST ['id'];
			@$stype = $_POST ['sType'];
			$timeInfo = Yii::app()->request->getParam('timeInfo',1);
			$bias = Yii::app()->request->getParam('bias',0);
		
			
			$model = new Cardinvite ();
			
			// $cards = Cardinvite::model()->findAllByAttributes(array(
			// 'ci_state'=>'1',
			// 'ci_owner'=> Yii::app()->user->id,
			// 'ci_shop_id'=>$shopId,
			// ));
			
			$criteria = new CDbCriteria ();
			$criteria->select = 'id, ci_sn, ci_value, ci_type,ci_date_end';
			$criteria->order = 'ci_type ASC, id ASC';
// 			$criteria->addCondition('ci_date_card')
			if ($timeInfo < 1 || $stype==6){
				$criteria->addCondition('id=-1');
			}else{
				$criteria->addCondition ( 'ci_state=1' );
				$criteria->addCondition ( 'ci_shop_id=:shopId' );
				$criteria->params [':shopId'] = $sid;
				$criteria->addInCondition ( 'ci_type', array (
						0,
						$stype
				) );
				// $criteria->addCondition ( 'ci_type=:stype' );
				// $criteria->params [':stype'] = $stype;
				$criteria->addCondition ( 'ci_owner=:userId' );
				$criteria->params [':userId'] = Yii::app ()->user->id;
			}
			
			
			$dataProvider = new CActiveDataProvider ( 'Cardinvite', array (
					'pagination' => array (
							'pageSize' => 80 
					),
					'criteria' => $criteria 
			) );
			
			$this->renderPartial ( '_cardList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
		}
	}
	
	/**
	 * Displays a particular model.
	 *
	 * @param integer $id
	 *        	the ID of the model to be displayed
	 */
	public function actionNew($id) {
		if (Yii::app ()->user->hasFlash ( 'orderAddSuccess')) {
			$orderId = Yii::app ()->user->getFlash ( 'orderAddSuccess');
			$order = OrderHistory::model()->findByPk($orderId);
			if (isset($order)) {
				$this->render('_orderRlt',array('order'=>$order));
				Yii::app()->end();
			}else{
				throw new CHttpException('500','获取订单信息失败！');
			}
			
		}
		if (isset($_GET['bias'])) {
			$bias = $_GET['bias'];
		}else if (isset($_COOKIE['bias'])) {
			$bias = $_COOKIE['bias'];
		}else
		{
			$bias = 0;
		}
		
		
		
		if (isset($_GET['st']) && is_numeric($_GET['st'])) {
			$sType = $_GET['st'];
			$st = ServiceType::model()->findByPk($sType);
			if ($st === null){$sType = 1;}
		}else
		{
		
			$sType = 1;
		}
		
		
		$this->render ( 'new', array (
				'model' => $this->loadModel ( $id ) ,
				'bias'=>$bias,
				'sType'=>$sType,
		) );
	}
	
	public function actionOrderOk(){
		
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id
	 *        	the ID of the model to be loaded
	 * @return City the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = WashShop::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, '请求页面未找到！' );
		return $model;
	}
	public function actionBossNew() {
		$model = new OrderForm ();
		
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'bossOrderNew-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect order input data
		if (isset ( $_POST ['OrderForm'] )) {
			$model->attributes = $_POST ['OrderForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate () && $model->order ())
				$this->redirect ( Yii::app ()->user->returnUrl );
		}
		// display the login form
		$this->render ( 'bossnew', array (
				'model' => $model 
		) );
	}
	public function actionSearch() {
	}
}