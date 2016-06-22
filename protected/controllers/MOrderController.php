<?php
class mOrderController extends Controller {
	const LIST_DISTANCE = 1;
	const LIST_SCORE = 2;
	const LIST_PRICE = 3;
	const LIST_FAVORITE = 4;
	const LIST_MEMBER = 5;
	const LIST_ORDER = 6;
	
	public $shopName = 'shop name';
	
	// public $layout='//layouts/map_main';
	// public $bais = 1;
	public function actions() {
		return array (
				'page' => array (
						'layout' => 'main',
						'class' => 'CViewAction' 
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
				'accessControl' 
		) // perform access control for CRUD operations
;
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
		)
		// 'd'=>var_dump($intervalNum)
		;
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
		$rlt = UTool::iniFuncRlt ();
		
		if (Yii::app ()->user->isGuest) {
			$this->redirect ( array (
					'site/login' 
			) . '?callback' . Yii::app ()->request->hostInfo . Yii::app ()->request->getUrl () );
			Yii::app ()->end ();
		}
		if (Yii::app ()->request->isAjaxRequest && Yii::app ()->request->isPostRequest) {
			// @$cardId = $_POST ['card'];
			$cardId = Yii::app ()->request->getParam ( 'card', null );
			@$otId = $_POST ['id'];
			// @$otValue = $_POST['sValue'];
			// @$otStaffs = $_POST['staffs'];
			@$otStaffs = '0,0';
			@$carType = $_POST ['ct'];
			$staffs = preg_split ( ',', $otStaffs );
			$timeInfo = Yii::app ()->request->getParam ( 'timeInfo' );
			
			// if(OrderTemp::model()->findByPk($otId)){
			
			// }
			
			$updateRlt = OrderTemp::model ()->updateOrder ( $otId, $otStaffs, Yii::app ()->user->Id, $carType );
			
			if (! $updateRlt ['status']) {
				// echo 'false';
				echo CJSON::encode ( $updateRlt );
				Yii::app ()->end ();
			}
			
			// $ot = OrderTemp::model()->findByPk($otId);
			if ($timeInfo < 1) {
				$cardId = null;
			}
			
			$rlt = OrderHistory::model ()->getOrderNew ( $otId, $cardId, 1, Yii::app ()->request->userHostAddress, '1', yii::app ()->user->id );
			Yii::log ( CJSON::encode ( $rlt ), CLogger::LEVEL_INFO, 'mngr.order.add.rlt' );
			// Yii::app()->user->setFlash('orderAddRlt','Order add successfully!');
			
			if ($rlt ['status']) {
				// var_dump(UWeChatEnt::getToken(AppName::$EntOrderMngr));
				
				$rltSendSms = USms::sendSmsOrder ( $rlt ['data'] );
				
				// $fromUserName = Yii::app ()->user->Id;
				// $agentId = 13;
				// $content = array(
				// 'touser'=>(int)$fromUserName,
				// 'msgtype'=>'text',
				// 'agentid'=>(int)$agentId,
				// 'text'=>array(
				// 'content'=>$rltSendSms ['data']
				// ),
				// 'safe'=>'0'
				// );
				// UWeChatEnt::sendMsg(AppName::$EntOrderMngr, $content);
				
				$msg = new Message ();
				$msg ['m_datetime'] = date ( 'Y-m-d H:i:s' );
				$msg ['m_user_id'] = Yii::app ()->user->id;
				$msg ['m_status'] = 0;
				$msg ['m_level'] = Message::LEVEL_PRIORITY;
				$msg ['m_type'] = Message::TYPE_ORDER;
				$msg ['m_src'] = UTool::getRequestInfo ();
				$orderItem = $rlt ['data'];
				$msg ['m_content'] = $rltSendSms ['data'];
				if ($msg->save ()) {
				}
				
				// UTool::orderSubmitSms ( $rlt ['data'] );
				Yii::app ()->user->setFlash ( 'orderAddSuccess', $orderItem ['id'] );
				$rlt ['msg'] = '预约成功';
				$rlt ['status'] = true;
				echo CJSON::encode ( $rlt );
				// echo 'true';
			} else {
				$rlt ['msg'] = '预约失败，请刷新页面重试';
				// echo 'false';
				echo CJSON::encode ( $rlt );
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
								'GetCommentList',
								'AjaxTimeList',
								'AjaxPrice',
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
								'getSTItems',
								'orderAdd',
								'topShop' 
						),
						'users' => array (
								'*' 
						) 
				),
				
				array (
						'allow', // allow all users to perform 'index' and 'view' actions
						'actions' => array ()
						// 'index',
						// 'bossNew',
						// 'orderAdd',
						// 'APIs'
						,
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
			// $bias = Yii::app()->getParams('bias',0);
			$bias = Yii::app ()->request->getParam ( 'bias', 0 );
			$carType = Yii::app ()->request->getParam ( 'carType', 1 );
			$sType = Yii::app ()->request->getParam ( 'sType', 1 );
			$position = Yii::app ()->request->getParam ( 'position', 1 );
			
			// @$bias = $_GET ['bias'];
			// @$carType = $_GET ['carType'];
			// @$sType = $_GET ['sType'];
			// @$position = $_GET ['position'];
			
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
			
			$timeList = $this->renderPartial ( '_timeList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), true, true );
			
			$shop = WashShop::model ()->findByPk ( $id );
			$num = $shop ['ws_num'];
			$countArr = array ();
			$countArr ['size'] = $num;
			for($i = 1; $i <= $num; $i ++) {
				$countArr ['p' . $i] = OrderTemp::model ()->getPositionCount ( $id, $sType, $i, $bias, TRUE );
			}
			
			// $availableCount = OrderTemp::model()->getPositionCount($id,$sType,1, $position,$bias,TRUE);
			echo CJSON::encode ( array (
					'timeList' => $timeList,
					'count' => $countArr 
			) );
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
		// if (Yii::app ()->request->isAjaxRequest && Yii::app ()->request->isPostRequest) {
		$shopId = Yii::app ()->request->getParam ( 'id' );
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
						'pageSize' => Yii::app ()->params ['pageSize'],
						'route' => 'order/GetCommentList' 
				),
				'criteria' => $criteria 
		) );
		// Yii::app()->clientScript->registerScript('alert(3)',CClientScript::POS_READY);
		$this->renderPartial ( '_commentList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
		
		// Yii::app ()->end ();
		// }
	}
	public function actionGetOrderList() {
		$shopId = Yii::app ()->request->getParam ( 'id' );
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
						'pageSize' => Yii::app ()->params ['pageSize'],
						'route' => 'order/GetOrderList' 
				),
				'criteria' => $criteria 
		) );
		// Yii::app()->clientScript->registerScript('alert(3)',CClientScript::POS_READY);
		$this->renderPartial ( '_orderList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
		
		// Yii::app ()->end ();
		// }
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
	public function actionTopShop() {
		$this->render ( 'topShop' );
	}
	
	
	/**
	 * 获得车型分组代码
	 * @return multitype:Ambigous <unknown, Ambigous <unknown, NULL>>
	 */
	private function getCarGroup(){
		// 数据缓存设置
		$carGroupList = Yii::app ()->cache->get ( 'carGroupListData' );
		if ($carGroupList === false) {
			$carGroupListRlt = CarGroup::model ()->findAll ();
			$carGroupList = array ();
			foreach ( $carGroupListRlt as $key => $carGroup ) {
				$carGroupList [$carGroup ['id']] =array(
						'id'=>$carGroup['id'],
						'name'=>$carGroup['cg_name'],
						'desc'=>$carGroup['cg_desc'],
				); 
			}
			// 缓存列表数据
			Yii::app ()->cache->set ( 'carGroupListData', $carGroupList, 300 );
		}
		return $carGroupList;
	}
	
	
	private function getShopService($shopServices){
		// 				获取车行提供的服务
		$serviceList = array ();
		foreach ( $shopServices as $key => $service ) {
			if (isset ( $serviceList [$service ['wss_st_id']] )) {
				$serviceList [$service ['wss_st_id']] ['carGroupList'] [$service ['wss_car_group']] = array (
						'groupId' => $service ['wss_car_group'],
// 						'groupName' => $service->carGroup ['cg_name'],
// 						'groupDesc'=>$service->carGroup ['cg_desc'],
						'groupValue'=> $service ['wss_value']
				);
			} else {
				$serviceList [$service ['wss_st_id']] = array (
						'id' => $service ['wss_st_id'],
						'name' => $service->serviceType ['st_name'],
						// 'tag'=>$service->serviceType['st_code'],
						'carGroupList' => array ( $service ['wss_car_group']=>
								array (
										'groupId' => $service ['wss_car_group'],
// 										'groupName' => $service->carGroup ['cg_name'],
// 										'groupDesc'=>$service->carGroup ['cg_desc'],
										'groupValue'=> $service ['wss_value'],
										
								)
						),
				);
			}
		} // end shop service
		return $serviceList;
	}
	
	
	/**
	 * 根据城市id及当前位置获取车行信息信息
	 * @param int $cityId
	 * @param string $currentLocation
	 * @return multitype:multitype:unknown multitype: NULL Ambigous <string, number> Ambigous <multitype:, multitype:NULL multitype:unknown NULL multitype:multitype:unknown NULL    unknown > Ambigous <unknown, Ambigous <unknown, NULL>>
	 */
	private function getShopListWithDistance($cityId,$currentLocation,$force=FALSE){
		// 读取数据缓存设置
		$rltList = Yii::app ()->cache->get ( 'listData' . $cityId . Yii::app ()->request->userHostAddress );
		if ($rltList === false || $force) {
			// 没有缓存数据，则重新获取数据
			$criteria = new CDbCriteria ();
			$criteria->addCondition ( 'ws_city_id=:cityId' );
			$criteria->params [':cityId'] = $cityId;
				
			$criteria->with = array (
					"washShopServices.serviceType",
					"washShopServices.carGroup",
					"area",
					"favoriteCount",
					"memberCount",
					'orderCount' ,
					'latestNews',
					'commentCount'
			);
							
			$criteria->compare('ws_state', array(
					WashShop::SHOP_STATE_NORM,
					WashShop::SHOP_STATE_PAUSE,
					WashShop::SHOP_STATE_STOP_ORDER,
			));
				
			$shopList = WashShop::model ()->findAll ( $criteria );
				
			$currentLocation = explode ( ',', $currentLocation );
			if (isset($currentLocation[0])){
				$currentLocation_lon = $currentLocation [0];
			}else{
				$currentLocation_lon = 0;
			}
			
			if (isset($currentLocation[1])){
				$currentLocation_lat = $currentLocation [1];
			}else{
				$currentLocation_lat = 0;
			}

			$rltList = array ();
			foreach ( $shopList as $key => $shop ) {
// 				获取车行提供的服务
// 				$shopServices = $shop->washShopServices;
				
				$serviceList = $this->getShopService($shop->washShopServices);

				
// 				获取最新公告
				$newsContent = NULL;
				if ( !empty($shop->latestNews) ){
					$newsContent = $shop->latestNews[0]['sn_desc'];
				}
		
				$shopLocation = explode ( ',', $shop ['ws_position'] );
// 				$shopLocation_lon = @$shopLocation [0];
// 				$shopLocation_lat = @$shopLocation [1];
				$distanceValid = TRUE;
				if (isset($shopLocation[0])){
					$shopLocation_lon = $shopLocation [0];
				}else{
					$shopLocation_lon = 0;
					$distanceValid = FALSE;
				}
					
				if (isset($shopLocation[1])){
					$shopLocation_lat = $shopLocation [1];
				}else{
					$shopLocation_lat = 0;
					$distanceValid = FALSE;
				}
// 				$distanceValid=false;
				if ($distanceValid){
					$distance = UMap::GetShortDistance ( $currentLocation_lon, $currentLocation_lat, $shopLocation_lon, $shopLocation_lat );
				}else{
					$distance='9E+999';
				}
				$rltList [$shop ['id']] = array (
						'id' => $shop ['id'],
						'status'=>$shop['ws_state'],
						'address' => $shop ['ws_address'],
						'distance' => $distance,
						'name' => $shop ['ws_name'],
						'score' => $shop ['ws_score'],
						'serviceList' => $serviceList,
						'keyWords' => array_filter ( preg_split ( '[; ,]', $shop->ws_key_words ) ),
						'area' => $shop->area ['a_name'] ,
						'memberCount'=>$shop->memberCount,
						'favoriteCount'=>$shop->favoriteCount,
						'orderCount'=>$shop->orderCount,
						'latestNews'=>$newsContent,
						'commentCount'=>$shop->commentCount
		
				);
			}
			// 缓存列表数据
			Yii::app ()->cache->set ( 'listData' . $cityId . Yii::app ()->request->userHostAddress, $rltList, 120 );
			Yii::log ( 'set list  cache: '.'listData' . $cityId . Yii::app ()->request->userHostAddress . date ( 'Y-m-d H:i:s', time () ), CLogger::LEVEL_INFO, 'mngr.cache.listData' );
				
		} else{ // 获取车行列表数据
			Yii::log ( 'from list  cache: '.'listData' . $cityId . Yii::app ()->request->userHostAddress . date ( 'Y-m-d H:i:s', time () ), CLogger::LEVEL_INFO, 'mngr.cache.listData' );
		
		}
		return $rltList;
	}
	
	/**
	 * 根据搜索关键字过滤车行
	 * @param string $sQ 搜索词
	 * @param array $shopList 车行列表
	 * @return multitype:Ambigous <unknown, Ambigous <unknown, NULL>>
	 */
	private function getShopListBySearchKeywords($sQ, $shopList=NULL){
		$searchRltList=array();
		// 			根据搜索关键字过滤
		if (!empty($shopList)){
			$shopIdArray = array(0);
			foreach ($shopList as $key=>$value){
				$shopIdArray[]=$value['id'];
			}
		}
		
		
		
		
		
		
		if (! empty ( $sQ)) {
		
			$regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
			$sQ = preg_replace($regex,"",$sQ);
		
		
			$purifier = new CHtmlPurifier();
			$purifier->options = array(
					'HTML.Allowed'=>'div',
			);
		
			// 			/[\x{4e00}-\x{9fa5}]|[a-zA-Z0-9. ]+$/u
		
			$sQ = $purifier->purify($sQ);
			// 			Yii::log ( CJSON::encode ( $sQ ) . count ( $sQ ), CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId());
		
		
			mb_internal_encoding ( 'UTF-8' );
			mb_regex_encoding ( 'UTF-8' );
			$sQ = mb_preg_split ( '[\s,;、，；]', $sQ );
			// 					$q = mb_preg_split ( '[\s,;]', $q );
			// 					$q = preg_split('[\s,;]', $q);
			$sQ = array_filter ( $sQ );
			// 			Yii::log ( CJSON::encode ( $sQ ) . count ( $sQ ), CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId());
			$qarray = '';
			if (count ( $sQ ) < 1) {
				$qarray = $sQ;
			} else {
					
				foreach ( $sQ as $key => $value ) {
					if (! empty ( $value )) {
						$qarray .= trim ( $value ) . '|';
					}
				}
				if (substr ( $qarray, - 1, 1 ) == '|') {
					$qarray = substr ( $qarray, 0, - 1 );
				}
			}
			// 					$qarray = $searchForm ['q'];
			// 			Yii::log ( $qarray, CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId());
			$criteriaSQ = new CDbCriteria();
			$criteriaSQ->select = 'id';
			$criteriaSQ->condition = "(ws_name  REGEXP BINARY :name or ws_address  REGEXP BINARY :address or ws_key_words  REGEXP BINARY :keyWord)";
			$criteriaSQ->params [':name'] = $qarray;
			$criteriaSQ->params [':address'] = $qarray;
			$criteriaSQ->params [':keyWord'] = $qarray;
			if (!empty($shopList)){
				$criteriaSQ->compare('id', $shopIdArray);
			}
			
			$tempList = WashShop::model()->findAll($criteriaSQ);
			foreach ($tempList as $key => $shop){
				$searchRltList[]=$shop['id'];
			}
// 			Yii::log ( json_encode($searchRltList), CLogger::LEVEL_INFO, 'mngr.'.$this->getId().'.'.$this->getAction()->getId().'.search.rlt');
			// Yii::app()->session['bias']=$searchForm['bias'];
		} // end if empty $sQ
		
		return $searchRltList;
		
	}
	
	/**
	 * 获得服务类型代码
	 * @return multitype:Ambigous <unknown, Ambigous <unknown, NULL>>
	 */
	private function getServiceType(){
		// 数据缓存设置
		$serviceTypeList = Yii::app ()->cache->get ( 'serviceTypeListData' );
		if ($serviceTypeList === false) {
			$serviceTypeListRlt = ServiceType::model ()->findAll ();
			$serviceTypeList = array ();
			foreach ( $serviceTypeListRlt as $key => $serviceType ) {
				$serviceTypeList [$serviceType ['id']] =array(
						'id'=>'id',
						'name'=>$serviceType['st_name'],
						'desc'=>$serviceType['st_desc'],
						'code'=>$serviceType['st_code'],
				); 
			}
			// 缓存列表数据
			Yii::app ()->cache->set ( 'serviceTypeListData', $serviceTypeList, 300 );
		}
		return $serviceTypeList;
	}
	
	
	/**
	 * 对车行列表排序
	 * @param array $rltList
	 * @param int $sOrderFilter
	 * @return array
	 */
	private  function getSortShopList($rltList,$sOrderFilter){
		$distanceArray = array ();
		$scoreArray = array ();
		$priceArray = array ();
		$favoriteArray=array();
		$memberArray=array();
		$orderArray=array();
		$availableCountArray = array();
		foreach ( $rltList as $key => $value ) {
			$distanceArray [$key] = $value ['distance'];
			$scoreArray [$key] = $value ['score'];
			$priceArray[$key]=$value['valueMin'];
			$favoriteArray[$key]=$value['favoriteCount'];
			$memberArray[$key]=$value['memberCount'];
			$orderArray[$key]=$value['orderCount'];
			$availableCountArray[$key]=$value['countAvailable'];
		}
		
		if ($sOrderFilter == MOrderController::LIST_DISTANCE) {
			array_multisort ( $distanceArray, SORT_ASC, $scoreArray, SORT_DESC, $availableCountArray,SORT_DESC, $rltList );
		} else if ($sOrderFilter == MOrderController::LIST_SCORE) {
			array_multisort ( $scoreArray,SORT_DESC, $availableCountArray,SORT_DESC, $distanceArray, SORT_ASC, $rltList );
		} else if ($sOrderFilter == MOrderController::LIST_PRICE) {
			array_multisort ($priceArray,SORT_ASC,$availableCountArray,SORT_DESC, $scoreArray, SORT_DESC, $distanceArray, SORT_ASC, $rltList );
		} else if($sOrderFilter == MOrderController::LIST_FAVORITE){
			array_multisort ( $favoriteArray, SORT_DESC, $memberArray, SORT_DESC,$availableCountArray,SORT_DESC,$scoreArray, SORT_DESC,$distanceArray, SORT_ASC, $rltList );
		} else if($sOrderFilter == MOrderController::LIST_MEMBER){
			array_multisort ( $memberArray, SORT_DESC,$availableCountArray,SORT_DESC,$scoreArray, SORT_DESC, $priceArray,SORT_ASC, $distanceArray, SORT_ASC,$rltList );
		}else if($sOrderFilter == MOrderController::LIST_ORDER){
			array_multisort ( $orderArray, SORT_DESC, $scoreArray, SORT_DESC,$availableCountArray,SORT_DESC, $distanceArray, SORT_ASC,$rltList );
		} else{
				
			array_multisort ( $distanceArray, SORT_ASC, $scoreArray, SORT_DESC,$priceArray,SORT_ASC, $rltList );
		}
		
		return $rltList;
	}
	
	
	/**
	 * 获取车行基本信息
	 * @param array $rltList 车行列表
	 * @param  int $sTypeFilter 服务类型
	 * @param int $sDateFilter 日期
	 * @param int $sTimeFilter 时间
	 * @param string $sQ 搜索词
	 * @param array $searchRltList 搜索词过滤后车行
	 * @return multitype:multitype: 
	 */
	private function getShopListInfo($rltList, $sTypeFilter, $sDateFilter,$sTimeFilter,$sQ,$searchRltList){
		// 获取车行idList
		$shopIdArray = array (0);
		foreach ( $rltList as $key => $value ) {
			$typeFilterRlt = array_key_exists($sTypeFilter, $value['serviceList']);
			$searchRlt=TRUE;
			if (!empty($sQ)){
				$searchRlt = in_array( $value ['id'], $searchRltList);
			}
			// 			$searchRlt = arry
			if($typeFilterRlt && $searchRlt){
				$shopIdArray [] = $value ['id'];
			}
		
		}
		$timeZone = UWashShop::getTineZoneByType($sTimeFilter);
		
		// 获取车行价格，数量等信息
		$shopInfoList = OrderTemp::model ()->getShopInfoList ( $shopIdArray, $sTypeFilter, $timeZone['begin'],$timeZone['end'], $sDateFilter-1 );
		// 		Yii::log ( json_encode ( $shopInfoList ), CLogger::LEVEL_INFO, 'mngr.orderlist.shoplist' );
		$rltListTemp = array ();
		
		foreach ($shopInfoList as $key=>$shop){
				
			$temp = $rltList [$shop ['id']];
			// 			车行状态如果不正常，则可用车位为0
			if ($temp['status'] != WashShop::SHOP_STATE_NORM){
				$shop['countAvailable']=0;
			}
			$temp = array_slice ( $temp, 1 );
				
			$rltListTemp [] = array_merge($shop,$temp);
				
		}
		
		
		// 		foreach ( $rltList as $key => $shop ) {
		// 			$shopInfo = $shopInfoList [$shop ['id']];
		// 			$shopInfo = array_slice ( $shopInfo, 1 );
		// 			$rltListTemp [] = array_merge($shop,$shopInfo);
		// 		}
// 		$rltList = $rltListTemp;
		return $rltListTemp;
	}
	
	public function actionList() {
		$this->layout = 'main';
		
		// 微信自动定位
		$src = Yii::app ()->request->getParam ( 'src' );
		$srcType = Yii::app ()->request->getParam ( 'srcType' );
		$force = Yii::app ()->request->getParam ( 'force' );
		if ($src == 'weixin') {
			Yii::app ()->session ['src'] = 'weixin';
			Yii::app ()->session ['srcType'] = $srcType;
			$code = Yii::app ()->request->getParam ( 'code' );
			
			$weChat = new UWeChat ( $srcType );
			$appServiceId = $weChat->appServiceId;
			
			Yii::app ()->session ['appServiceId'] = $appServiceId;
			
			$accessTokenRlt = $weChat->getAccessTokenFromCode ( $code );
			
			if ($accessTokenRlt ['status']) {
				$openid = $accessTokenRlt ['data'] ['openid'];
				Yii::app ()->session ['weiOpenId'] = $accessTokenRlt ['data'] ['openid'];
				
				$loginRlt = WeixinOpenid::model ()->loginByOpenId ( $openid, $appServiceId, Yii::app ()->user->id );
				if ($loginRlt ['status']) {
					// Yii::app()->user->setFlash('weixinAutologin','您已绑定微信，自动登陆成功');
					// $this->urlRedirect();
				}
				$weiUser = WeixinOpenid::model ()->getUserByOpenId ( $openid, Yii::app ()->session ['appServiceId'] );
				// $weiUser = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$openid));
				if (isset ( $weiUser )) {
					Yii::app ()->session ['location'] = $weiUser ['wo_location'];
				}
			}
			// 如果强制指定location，则忽略微信自动参数
			$currentLocation = Yii::app ()->request->getParam ( 'location', Yii::app ()->session ['location'] );
		} else {
			$currentLocation = Yii::app ()->request->getParam ( 'location' );
			if ($currentLocation == NULL) {
				$ip = Yii::app ()->request->userHostAddress;
				$address_information = Yii::app ()->geoip->getCityInfoForIp ( $ip );
				$currentLocation = $address_information ['longitude'] . ',' . $address_information ['latitude'];
			}
		}
		
		$cityId = UPlace::getCityId ();
		
		$sTypeFilter = UCom::getCookieInt ( 'sTypeFilter', 1 );
		$sOrderFilter = UCom::getCookieInt ( 'sOrderFilter', 1 );
		$sDateFilter = UCom::getCookieInt ( 'sDateFilter', 1 );
		$sTimeFilter = UCom::getCookieInt ( 'sTimeFilter', 0 );
		
		$params = array(
				
				'sTypeFilter'=>$sTypeFilter,
		);
		
		$rltList = $this->getShopListWithDistance($cityId, $currentLocation,$force);
		Yii::log(json_encode($rltList),CLogger::LEVEL_INFO,'mngr.list.rltlist');
		
		// 			根据搜索关键字过滤
		$sQ = '';
		if (isset($_COOKIE ['sQ'])){
			$sQ = $_COOKIE ['sQ'];
		}
		$searchRltList = $this->getShopListBySearchKeywords($sQ,$rltList);
		
		$rltList = $this->getShopListInfo($rltList, $sTypeFilter, $sDateFilter, $sTimeFilter, $sQ, $searchRltList);
		Yii::log(json_encode($rltList),CLogger::LEVEL_INFO,'mngr.list.rltlist');
		
		$serviceTypeList = $this->getServiceType();
		
		// 距离、评分、价格排序
		$rltList = $this->getSortShopList($rltList, $sOrderFilter);
		
		
		$listProvider = new CArrayDataProvider ( $rltList, array (
				'id' => 'shopList',
				'sort' => array (
						'attributes' => array (
								'distance',
								'score' 
						) 
				),
				'pagination' => array (
						'pageSize' => 10 
				) 
		) );
		
// 		Yii::app ()->user->setFlash ( 'listRefresh', '列表刷新成功' );
		if (Yii::app ()->request->isAjaxRequest) {
			$this->renderPartial ( '_list', array (
					"dataProvider" => $listProvider,
					'serviceTypeList' => $serviceTypeList ,
					'params'=>$params
			), false, true );
			return;
			Yii::app ()->end ();
		}
		$this->render ( 'list', array (
				// 'model' => $model,
				'dataProvider' => $listProvider,
				// 'searchModel' => $searchForm ,
				'shopList' => $rltList,
				'serviceTypeList' => $serviceTypeList ,
				'params'=>$params
		) );
	}
	public function actionMap() {
		$this->layout = 'main_map';
		
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'id=0' );
		
		$dataProvider = new CActiveDataProvider ( 'WashShop', 

		array (
				
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 3 
				) 
		)
		 );
		
		// $this->render('/site/pages',array('view'=>'cooming'));
		$this->render ( 'map', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionMapSearch() {
		// if (! Yii::app ()->request->isAjaxRequest) {
		// Yii::app ()->end ();
		// }
		$q = Yii::app ()->request->getParam ( 'q' );
		
		// @$q = $_GET ['q'];
		$pageNum = Yii::app ()->request->getParam ( 'page_index', 0 );
		// @$pageNum = $_GET ['page_index'];
		// @$province = $_GET ['povince'];
		// @$city = $_GET ['city'];
		// @$area = $_GET ['area'];
		$bounds = Yii::app ()->request->getParam ( 'bounds' );
		// $bounds = '123.189027,41.916092;123.676555,41.701016';
		$filter = '';
		
		$url = UMap::getMapUrl ( UMapURLType::lbs_search_bound );
		
		$opts = array (
				'http' => array (
						'method' => "GET",
						'timeout' => 60 
				) 
		);
		
		$context = stream_context_create ( $opts );
		$i = 0;
		$maprlt_ini = false;
		$maprlt_ini = file_get_contents ( $url . '&bounds=' . $bounds, false, $context );
		;
		if ($maprlt_ini == false) {
			$maprlt_ini = CJSON::encode ( array (
					'status' => - 1,
					'total' => 0,
					'size' => 0,
					'contents' => array () 
			) );
		}
		
		// do{
		// @$maprlt_ini= file_get_contents($url.'&bounds='.$bounds,false,$context);;
		// $i++;
		// }
		// while($i<4 && ($maprlt_ini==false));
		// if($i==4){
		// $maprlt_ini = array('status'=>0,'total'=>0,'size'=>0,'contents'=>array());
		
		// }
		
		// echo $maprlt_ini;
		$maprlt = CJSON::decode ( $maprlt_ini );
		
		$ids = array ();
		$shops = array ();
		if ($maprlt ['status'] == 0 && $maprlt ['size'] > 0) {
			foreach ( $maprlt ['contents'] as $key => $value ) {
				$ids [] = $value ['washshop_id'];
				// $shops[$value['washshop_id']]=$value;
				$shops ['w' . $value ['washshop_id']] = $value;
			}
		}
		
		Yii::log ( CJSON::encode ( $shops ), CLogger::LEVEL_INFO, 'mngr.orderC.mapSearch' . $this->getAction ()->id );
		
		$criteria = new CDbCriteria ();
		
		$criteria->addInCondition ( 'id', $ids );
		$criteria->order = 'id ASC';
		
		$criteria->addCondition ( 'ws_state=1' );
		if ($maprlt ['status'] == - 1) {
			$criteria->addCondition ( 'id=-1' );
		}
		
		$rawData = WashShop::model ()->findAll ( $criteria );
		
		// echo CJSON::encode($rawData);
		
		$filter_ids = array ();
		// $filter_ids_str = '';
		foreach ( $rawData as $key => $value ) {
			$filter_ids [] = $value ['id'];
		}
		
		$ids_intersect = array_intersect ( $filter_ids, $ids );
		
		$maprltOut = $maprlt;
		$maprltOut ['contents'] = array ();
		// $maprltOut['size'] -=1;
		// $maprltOut['total'] -=1;
		$maprltOut ['size'] = 0;
		$maprltOut ['total'] = 0;
		foreach ( $rawData as $key => $value ) {
			if (array_key_exists ( 'w' . $value ['id'], $shops )) {
				$maprltOut ['contents'] [] = $shops ['w' . $value ['id']];
				$maprltOut ['size'] += 1;
				$maprltOut ['total'] += 1;
			}
			// else {
			// $maprlt['contents'][]='w'.$value['id'];
			// }
		}
		
		// foreach ($maprlt['contents'] as $key=>$value){
		// if ( in_array($value['washshop_id'],$ids_intersect)) {
		// $maprltOut['contents'][] = $value;
		// }else{
		// $maprltOut['size'] -=1;
		// $maprltOut['total'] -=1;
		// }
		// }
		
		// $criteria->offset = Yii::app()->getParams('WashShop_page',0);
		// $criteria->
		$dataProvider = new CArrayDataProvider ( $rawData, array (
				'pagination' => array (
						'pageSize' => 800 
				) 
		) );
		// $dataProvider = new CActiveDataProvider ( 'WashShop',
		
		// array (
		
		// 'criteria' => $criteria,
		// 'pagination' => array (
		// 'pageSize' => 5,
		// ),
		// // 'route'=>'order/GetCommentList',
		
		// )
		// );
		
		// $this->render('/site/pages',array('view'=>'cooming'));
		$result = $this->renderPartial ( '_mapRltList', array (
				'dataProvider' => $dataProvider 
		), true, false );
		$html = array (
				'map' => $maprltOut,
				'rlt' => $result 
		);
		echo CJSON::encode ( $html );
		// $this->renderPartial ( '_mapRltList' ,array('dataProvider'=>$dataProvider),false,true);
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
			$timeInfo = Yii::app ()->request->getParam ( 'timeInfo', 1 );
			$bias = Yii::app ()->request->getParam ( 'bias', 0 );
			
			$model = new Cardinvite ();
			
			// $cards = Cardinvite::model()->findAllByAttributes(array(
			// 'ci_state'=>'1',
			// 'ci_owner'=> Yii::app()->user->id,
			// 'ci_shop_id'=>$shopId,
			// ));
			
			$criteria = new CDbCriteria ();
			$criteria->select = 'id, ci_sn, ci_value, ci_type,ci_date_end';
			$criteria->order = 'ci_type ASC, id ASC';
			// $criteria->addCondition('ci_date_card')
			if ($timeInfo < 1 || $stype == 6) {
				$criteria->addCondition ( 'id=-1' );
			} else {
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
	
	
	private function updatePrice($price, $shopId, $huiId, $sType, $carType){
		

		
		$rlt= UTool::iniFuncRlt();
		$shop = WashShop::model()->with('washShopServices')->findByPk($shopId);
		
	

		if ($shop===NULL 
				|| $shop['ws_state']!=WashShop::SHOP_STATE_NORM
				|| $shop['ws_expire_date'] < date('Y-m-d')
		) {
			$rlt['msg']="车行异常";
			return $rlt;
		}
		
		// 		车型划分
		$serviceList=$this->getShopService($shop->washShopServices);
		
		Yii::log(json_encode($serviceList),CLogger::LEVEL_INFO,'mngr.price.update');
		// 		"washShopServices.serviceType",
		// 		"washShopServices.carGroup",
		
		if (isset($serviceList[$sType]) && isset($serviceList[$sType]['carGroupList'][$carType])){
			
			$priceCarGroupBase = current( $serviceList[$sType]['carGroupList'])['groupValue'];
			$priceCarGroup =  $serviceList[$sType]['carGroupList'][$carType]['groupValue'];
			
			
			$rlt['data']['uPriceIni'] = $priceCarGroup;
			
			$priceDiff = $priceCarGroup - $priceCarGroupBase;
			
			$price += $priceDiff;
		}else{
			$rlt['msg']='请选择车型';
			return $rlt;
		}
		

		

		
		
		$criteria = new CDbCriteria();
		$criteria->addCondition('sh_shop_id=:shopId');
		$criteria->params[':shopId']= $shop['id'];
		
		$criteria->compare('sh_hui_id', $huiId);
		$huiList = ShopHui::model()->with('hui')->findAll($criteria);
		
		foreach ($huiList as $key=>$value){
			$hui = $value->hui;
			switch ($hui['h_type']){
				case Hui::HUI_FUNC_TYPE_INNER_TEXT :
					
					$discountPrice = 1;
					$price += $discountPrice;
							
					break;
				
				default:break;
				
			}
			
			
		}
		
		$sTypeName = $serviceList[$sType]['name'];
// 		$rlt_data = array();
		$rlt['data']['uType']=$sTypeName;
		$rlt['data']['uPrice']=$price;
		$rlt['status']=TRUE;
		return $rlt;
		

		
	
	}
	


	public function actionAjaxPrice(){
		$rlt = UTool::iniFuncRlt();
		
		$shopId =  Yii::app()->request->getParam('id');
		$orderId = Yii::app()->request->getParam('orderId');
		$sType = UCom::getCookieInt("sType", 1);
		$sCarType = UCom::getCookieInt("sCarType", 1);
		
		if (!UCom::checkInt($orderId) || !UCom::checkInt($shopId) ){
			$rlt['data']['uType'] ='请选择时间';
			$rlt['data']['uTime'] ='';
			$rlt['data']['uPrice'] ='';
			echo json_encode($rlt);
			return ;
		}
		
		$orderTempItem = OrderTemp::model()->findByPk($orderId);
		
		if (isset($orderTempItem) && $orderTempItem['ot_wash_shop_id'] == $shopId){
			
		}else{
			$rlt['data']['uType'] ='请选择时间';
			$rlt['data']['uTime'] ='';
			$rlt['data']['uPrice'] ='';
			echo json_encode($rlt);
			return ;
		}
		
// 		$sCarType = UCom::getCookieInt("sCarType", 1);
		
		$priceRlt = $this->updatePrice($orderTempItem['ot_value'], $orderTempItem['ot_wash_shop_id'],1, $sType, $sCarType);
		
		if (!$priceRlt['status']){
			$rlt['data']['uType']=$priceRlt['msg'];
			$rlt['data']['uTime'] ='';
			$rlt['data']['uPrice'] ='';
			echo json_encode($rlt);
			return ;
			
		}else{
			$rlt['data'] = $priceRlt['data'];
		}
		

		switch ($orderTempItem['ot_bias']){
			case 0:
				$rlt['data']['uTime']='今天';
				break;
				case 1:
					$rlt['data']['uTime']='明天';
					break;
					case 2:
						$rlt['data']['uTime']='后天';
						break;
		}
		
		$rlt['data']['uTime'] .=substr($orderTempItem['ot_date_time'], 0,5);
		
		if ($orderTempItem['ot_gift'] == 1){
			$rlt['data']['uGiftStr'] = '赠送矿泉水';
		}else {
			$rlt['data']['uGiftStr'] = NULL;
		}
		
		$rlt['status']=TRUE;
		
		if ($rlt['data']['uPriceIni'] == $rlt['data']['uPrice']){
			$rlt['data']['uPriceIni'] = null;
		}
		
		echo json_encode($rlt);
	}
	
	public function actionAjaxTimeList(){
		$sType = UCom::getCookieInt("sType", 1);
		$sDate = UCom::getCookieInt("sDate", 1);
		$shopId =  Yii::app()->request->getParam('id');
		$sCarType = UCom::getCookieInt("sCarType", 1);
		
		$shop = $this->loadModel($shopId);
		
// 		车型划分
		$serviceList=$this->getShopService($shop->washShopServices);
		$sTypeCarGroup =$serviceList[$sType]['carGroupList'];
		$carGroupList = $this->getCarGroup();
		$scartypelistStr =  $this->renderPartial('_service_car_type',array(
				'selectedType'=>$sCarType,
				'sTypeCarGroup'=>$sTypeCarGroup,
				'carGroupList'=>$carGroupList),TRUE,TRUE);
		$rlt['scartypelist']=$scartypelistStr;
// 		时间段信息
		$timeList = OrderTemp::model()->getTimeInfoList($shopId, $sType, $sDate-1);
		
		$timeListStr = $this->renderPartial('_service_time_list',array(
			'selectedType'=>$sType,
			'timeList'=>$timeList
		),true,TRUE);
		
		$rlt['stimelist'] = $timeListStr;
		echo json_encode($rlt);   
	}
	
	
	public function actionRlt(){
		$this->layout="_root";
		
		$this->render('rlt');
	}
	
	
	/**
	 * Displays a particular model.
	 *
	 * @param integer $id
	 *        	the ID of the model to be displayed
	 */
	public function actionNew($id) {
		if(Yii::app()->request->isAjaxRequest){
			$sType = UCom::getCookieInt("sType", 1);
			$sDate = UCom::getCookieInt("sDate", 1);
			$sCarType = UCom::getCookieInt("sCarType", 1);
		}else{
			$sType = UCom::getCookieInt("sTypeFilter", 1);
			$sDate = UCom::getCookieInt("sDateFilter", 1);
			$sCarType = UCom::getCookieInt("sCarType", 1);
			
			setcookie('sType',$sType,0,'/');
			setcookie('sDate',$sDate,0,'/');
			setcookie('sCarType',$sCarType,0,'/');
		}		
		$selectedParams = array(
				'sType'=>$sType,
				'sDate'=>$sDate,
				'sCarType'=>$sCarType
		);
		$shop = $this->loadModel($id);
		$this->shopName = $shop['ws_name'];
		$cityId = UPlace::getCityId();
		$shopList = Yii::app ()->cache->get ( 'listData' . $cityId . Yii::app ()->request->userHostAddress );
		$shopInfo = array();
		if (isset($shopList[$id])){
			$shopInfo  = $shopList[$id];
		}else{
			$serviceList=$this->getShopService($shop->washShopServices);
	// 		获取最新公告
			$newsContent = NULL;
			if ( !empty($shop->latestNews) ){
				$newsContent = $shop->latestNews[0]['sn_desc'];
			}
		$shopInfo = array (
						'id' => $shop ['id'],
						'status'=>$shop['ws_state'],
						'address' => $shop ['ws_address'],
						'name' => $shop ['ws_name'],
						'score' => $shop ['ws_score'],
						'serviceList' => $serviceList,
						'keyWords' => array_filter ( explode( '[; ,]', $shop->ws_key_words ) ),
						'area' => $shop->area ['a_name'] ,
						'memberCount'=>$shop->memberCount,
						'favoriteCount'=>$shop->favoriteCount,
						'orderCount'=>$shop->orderCount,
						'latestNews'=>$newsContent,
						'commentCount'=>$shop->commentCount
				);
		}
		$this->layout = 'main_order';
		$serviceTypeList = $this->getServiceType();
		$timeList = OrderTemp::model()->getTimeInfoList($shop['id'], $sType, $sDate-1);
		$this->render ( 'new', array (
				'model' => $shop,
				'shop'=>$shopInfo,
				'serviceTypeList'=>$serviceTypeList,
				'carGroupList'=>$this->getCarGroup(),
				'selectedParams'=>$selectedParams,
				'timeList'=>$timeList,
		) );
	}


	public function actionOrderOk() {
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
		$model = WashShop::model ()->with (
					"washShopServices.serviceType",
					"washShopServices.carGroup",
					"area",
					"favoriteCount",
					"memberCount",
					'orderCount' ,
					'latestNews',
					'commentCount'
		)->findByPk ( $id);
		if ($model === null ||  in_array($model['ws_state'], array(WashShop::SHOP_STATE_BLACK,WashShop::SHOP_STATE_CLOSE,WashShop::SHOP_STATE_MASK)))
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