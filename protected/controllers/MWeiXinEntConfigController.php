<?php
class MWeiXinEntConfigController extends Controller {
	// const TOKEN = 'wXC.2015.?';
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				array (
						'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE' 
				) 
		);
	}

	public function beforeAction($action) {
		parent::beforeAction ( $action );
		Yii::app ()->clientScript->reset ();
		return true;
	}

	public function actions() {
		return array (
				'REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider' 
		);
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
						'allow', // allow all users to perform 'index' and 'view' actions
						'actions' => array (
								'REST.GET',
								'REST.PUT',
								'REST.POST',
								'REST.DELETE',
								'index' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (
								'update' 
						),
						'users' => array (
								'@' 
						) 
				) 
		);

	}

	public function restEvents() {
		$this->onRest ( 'post.filter.req.auth.ajax.user', function ($validation) {
			// return true;
			// if(!$validation) {
			// return false;
			// }
			switch ($this->getAction ()->getId ()) {
				case 'REST.GET' :
					return true;
				case 'REST.POST' :
					return true;
					break;
				case 'REST.UPDATE' :
					return Yii::app ()->user->checkAccess ( 'REST-UPDATE' );
					break;
				case 'REST.DELETE' :
					return Yii::app ()->user->checkAccess ( 'REST-DELETE' );
					break;
				default :
					return false;
					break;
			}
			// return ($this->getAction()->getId() == 'REST.GET');
			// return true;
		} );
	}
	var $_token = 'w111';
	

	public function actionIndex() {
	  
		include_once('emoji.php');

		$weixinEnt = new UWeChatEnt (AppName::$EntConfigMngr, Yii::app()->request->getParam('nonce'),
				Yii::app()->request->getParam('msg_signature'),
				Yii::app()->request->getParam('timestamp'),
				Yii::app()->request->getParam('echostr',NULL)
		);
		$weixinEnt->debug=TRUE;

		
		$weixinEnt->init();

		$this->
		$reply= '';
		$msg = $weixinEnt->msg;
		$msgType =(string) ($msg->MsgType);
		$msgType=empty($msgType) ? '' : strtolower($msgType);

		// $a= (string)($weChatEnt->msg->FromUserName);
		// Yii::log("$a",CLogger::LEVEL_INFO,'mngr.mweixinEnt.config.type');




		switch ($msgType){
			
			case 'text':
				$content = $this->receiveText($weixinEnt);

				break;
			case 'event':
				$content = $this->receiveEvent ( $weixinEnt );
				break;
			default:
				
			break;
		}
		
		$weixinEnt->reply($content);

	}
	

		
	private function getMenuData(){
		
		return $jsonMenu;
	}	
		
	/**
	 * 更新位置信息
	 * @param unknown $weChat
	 * @return string
	 */
	private function receiveLocation($weChat ,$autoUpload=FALSE){
		$msg = $weChat->msg;
		$userOpenId = $msg->FromUserName;
		if ($autoUpload==TRUE){
			$latitude = $msg->Latitude;
			$longitude = $msg-> Longitude;
		}else{
			$latitude = $msg->Location_X;
			$longitude = $msg-> Location_Y;
		}
// 		$weiUser = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$userOpenId));
		$weiUser = WeixinOpenid::model()->getUserByOpenId($userOpenId);
		if (isset($weiUser)){
			$locationRlt = UMap::convertGEO($longitude.','.$latitude);
// 			Yii::log(json_encode($locationRlt),CLogger::LEVEL_INFO,'mngr.mweixin.location');
			if ($locationRlt->status == 0){
// 				Yii::log('5',CLogger::LEVEL_INFO,'mngr.mweixin.location');
				$longitude_x = $locationRlt->result[0]->x;
				$latitude_y = $locationRlt->result[0]->y;
				$weiUser['wo_location']=$longitude_x.','.$latitude_y;
				Yii::app()->session['currLocation']=$weiUser['wo_location'];
				
				$userLocation = new UserLocation();
				$userLocation['ul_datetime']=date('Y-m-d H:i:s',time());
				$userLocation['ul_latitude']=$latitude_y;
				$userLocation['ul_longitude']=$longitude_x;
				$userLocation['ul_user_openid'] = $weiUser['id'];
				$userLocation->save();
				
				
			}
			$weiUser['wo_update_time']=date('Y-m-d H:i:s',time());
			$weiUser->save();
			
			
			
			
		}else{
// 			Yii::log('4',CLogger::LEVEL_INFO,'mngr.mweixin.location');
// 			$t='2';
		}
// 		if ($weiUser === null){
// 			WeixinOpenid::model()->addUser($msg->FromUserName);
// 			$weiUser = WeixinOpenid::model()->getUserByOpenId($msg->FromUserName);
// 		}
// 		Yii::log(json_encode($weiUser),CLogger::LEVEL_INFO,'mngr.weixin.location');
// 		if (isset($weiUser)){
// 			$weiUser['wo_location']=$latitude.','.$longitude;
// 			$weiUser['wo_update_time']=time();
// 			$weiUser->save();
			
// 			$location = new UserLocation();
// 			$location['ul_datetime']=time();
// 			$location['ul_latitude']=$latitude;
// 			$location['ul_longitude']=$longitude;
// 			$location['ul_user_openid']=$weiUser['id'];
// 			$location->save();
// 		}
		return $longitude.','.$latitude.$msg->FromUserName.':'.$t.":".$weiUser->id;	
	} 
	
	
	
	
	
	

	
	public function actionbasicInfo() {

		$this->layout=  "main_weixin";
		$id=55;
		Yii::app ()->user->id =$id;
		//$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));

		if (!isset($id)) {
			echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
			exit;
		}
		$user = User::model ()->findByAttributes(array('id' =>$id));
	    $shop = WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
	    $boss = Boss::model ()->findByAttributes ( array ('b_user_id' => $id) );
	    // $service=WashShopService::model()->getServices($shop->id);
	    // print_r($service);exit();
		Yii::app()->session['shop']=$shop;
		Yii::app()->session['boss']=$boss;

		$this->render ( 'wsinfo', array (
	        'model' => $shop,
	        'boss' => $boss,
	        'user' => $user,
	        'editable' => 'disabled'
	    ) );
	   
	}


	public function actionUpdateWSs() {
		if (! Yii::app ()->request->isAjaxRequest) {
			Yii::app ()->end ();
		}
		@$id = $_POST ['id'];
		@$desc = $_POST ['wdesc'];
		@$owner = $_POST ['wowner'];
		@$tel = $_POST ['wtel'];
		@$wnum = $_POST ['wnum'];
		@$wsts = $_POST ['wsts'];
		@$time[0] = $_POST ['opentime'];
		@$time[1] = $_POST ['closetime'];
		@$keywords = $_POST ['wkeywords'];	
		$shop = WashShop::model ()->findByPk ( $id );
		$shop ['ws_desc'] = $desc;
		$shop ['ws_num'] = $wnum;
		$shop ['ws_key_words'] = $keywords;
		$shop ['ws_open_time'] = $time [0];
		$shop ['ws_close_time'] = $time [1];
		 Yii::log(CJSON::encode($_POST),'info','mngr.washshop.UpdateWSs.post');
		if ($shop->save ()) {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.shop s');
		} else {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.shop e');
		}
		$boss = Boss::model ()->findByAttributes ( array (
				'b_user_id' => $shop ['ws_boss_id'] 
		) );
		$boss ['b_real_name'] = $owner;
		if ($boss->save ()) {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.boss s');
		} else {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.boss e');
		}
		WashShopService::model ()->updateShopServices ( $id, $wsts);
//		 WashShopFeature::model ()->updateShopFeatures ( $id, $sfs );
	}

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
		return $model;
	}

	private function getShopService($shopServices){
		//获取车行提供的服务
		$serviceList = array ();
		foreach ( $shopServices as $key => $service ) {
			if (isset ( $serviceList [$service ['wss_st_id']] )) {
				$serviceList [$service ['wss_st_id']] ['carGroupList'] [$service ['wss_car_group']] = array (
						'groupId' => $service ['wss_car_group'],
						'groupValue'=> $service ['wss_value'],
				);
			} else {
				$serviceList [$service ['wss_st_id']] = array (
						'id' => $service ['wss_st_id'],
						'name' => $service->serviceType ['st_name'],
						'carGroupList' => array ( $service ['wss_car_group']=>
								array (
										'groupId' => $service ['wss_car_group'],
										'groupValue'=> $service ['wss_value'],
										// 'groupname'=>$service['cg_name'],
								)
						),
				);
			}
		} // end shop service
		return $serviceList;
	}

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




	public function actionOrderUpdate() {
		if (Yii::app ()->request->isAjaxRequest && Yii::app ()->request->isPostRequest) {
			@$uType = $_POST ['ut'];
			@$otIds = $_POST ['dates'];
			@$sType = $_POST ['sType'];
			@$sValue = $_POST ['sValue'];
			// @$otStaffs = $_POST['staffs'];
			@$carType = $_POST ['carType'];
			$otStaffs = '';
			$rlt = OrderTemp::model ()->updateOrderByBoss ( $otIds, $otStaffs, $sType, $sValue, $uType, $carType );
			// Yii::app()->user->setFlash('orderAddRlt','Order add successfully!');
			if ($rlt ['status']) {
			} else {
				Yii::app ()->user->setFlash ( 'discountNumWarning', $rlt ['msg'] );
				//
			}
			echo CJSON::encode ( $rlt );
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


	public function actioncomment(){
		$id=55;
		//$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));
		Yii::app()->session[id]=$id;
		if (!isset($id)) {
			echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
			exit;
		}
	    $this->layout = 'main_weixin_blank';
	    $model = new OrderComments ();
	    
	    $criteria = new CDbCriteria ();
	    $criteria->order = 'oc_order_id DESC, oc_datetime ASC';
	    $shop= WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
	    $boss = Boss::model ()->findByAttributes ( array ('b_user_id' => $shop ['ws_boss_id']));
	    Yii::app()->session['shop']=$shop;
	    $shopId =$shop->id;

	    $criteria->addCondition ( 'oc_washshop_id = :shopId' );
	    $criteria->params [':shopId'] = $shopId;
	    $criteria->addCondition ( 'oc_comment_user_type = 1' );
	    
	    $dataProvider = new CActiveDataProvider ( 'OrderComments', array (
	        'pagination' => array (
	            'pageSize' => Yii::app ()->params ['pageSize']
	        ),
	        'criteria' => $criteria
	    ) );

	    $this->render ( 'commentList', array (
			'shop'=>$shop,
	        'model' => $model,
	        'dataProvider' => $dataProvider
	    ) );
	}
	
	public function actionnews(){
	    $this->layout = 'main_weixin';
	    $id=55;
		//$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));
		if (!isset($id)) {
			echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
			exit;
		}

	    $model=new ShopNews;
	    $shop = WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
	    $boss = Boss::model ()->findByAttributes ( array ('b_user_id' => $shop ['ws_boss_id']));
	    Yii::app()->session['shop']=$shop;
	    Yii::app()->session['boss']=$boss;
		if (!empty($_POST)) {
			$shopId = $shop['id'];
			$desc = $_POST['ShopNews']['sn_desc'];
			$model = new ShopNews();
			$model['sn_date']=date('Y-m-d H:i:s');
			$model['sn_date_begin']=date('Y-m-d H:i:s');
			$model['sn_date_end']=date('Y-m-d H:i:s');
			$model['sn_shop_id'] = $shopId;
			$model['sn_desc']=$desc;
			$model['sn_func'] = '1';
			$model['sn_state'] = 1;
			if($model->save()){
				Yii::app()->user->setFlash('shopnews','发布成功');
			}else{
				Yii::app()->user->setFlash('shopnews','发布失败');
			}
	   	}
	    
	    $news = ShopNews::model()->findAllByAttributes(array('sn_shop_id'=>$shop['id']),array('limit'=>'10','order'=>'sn_date DESC'));
	   
	    $this->render ( 'news', array (
	    	'model'=>$model,
	        'boss' => $boss,
	        'shop' => $shop,
	        'shopnews'=>$news,
	    ) );
	}


	public function actionDisUpdateComment($id,$new){
		$this->layout='main_blank';
		if ($new ==1) {//1为回复，0为修改
			$model = OrderComments::model()->findByPk($id);
			$model['oc_comment']='';
		}else {
			$model = OrderComments::model()->findByPk($id);
		}
		$this->render('disUpdateComment',array('model'=>$model,'new'=>$new));
	}


	public function actionUpdateComment($id,$new){
		$uid=Yii::app()->session['id'];
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}
		@$comment = $_POST['c'];
		
		if ($new ==1) {
			$model = new OrderComments();
			$relatedModel = OrderComments::model()->findByPk($id);
			
			$model['oc_order_id'] = $relatedModel['oc_order_id'];
			$model['oc_washshop_id'] = $relatedModel['oc_washshop_id'];
			$model['oc_comment_user_id'] = $uid;
			$model['oc_comment_user_type']=3;
			$model['oc_datetime'] = date('Y:m:d H:i:s');
			$model['oc_comment']=$comment;
			// $model['oc_comment']=UTool::checkComment($comment);
			$model['oc_related_id']=$relatedModel['id'];
			
			$model['oc_state']=1;
			if ($model->save()) {
				echo '评论回复成功!';
			}else {
				Yii::log(CJSON::encode($model),'warning','mngr.OrderComments.UpdateComment');
			}
			
		}else{
			$model  = OrderComments::model()->findByPk($id);
			$model['oc_comment'] = $comment;
			$model['oc_datetime'] = date('Y:m:d H:i:s');
			if ($model->save()) {
				echo '评论修改成功';
			}
		}
		
	}



}