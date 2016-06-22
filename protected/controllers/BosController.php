<?php
class BossController extends Controller {
	public function actions() {
		return array (
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha' => array (
						'class' => 'CCaptchaAction',
						'backColor' => 0xFFFFFF,
						'minLength' => 4, // 最短为4位
						'maxLength' => 6 
				) // 是长为4位
,
				'APIs' => array (
						'class' => 'CWebServiceAction' 
				) 
		);
	}
	
	/**
	 * 更新工作时间状态
	 *
	 * @param array $indexList        	
	 * @return array @soap
	 */
	public function orderUpdate($indexList) {
		return Boss::model ()->orderUpdate ( $indexList );
	}
	
	/**
	 *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *      using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete' 
		) // we only allow deletion via POST request
;
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
								'login',
								'mngr',
								'APIs',
								'reg',
								'captcha',
								'reset' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'profile',
								'list',
								'staffEvent',
								'staffMngr',
								'StaffWSUpdate',
								'timeList',
								'getTimelist',
								'getStaffList',
								'OrderUpdate',
								'realTimeList',
								'getRealTimeList',
								'card',
								'CardRequest',
								'NewRequestCard',
								'Guarantee',
								'GuaranteeView',
								'News',
								'comment',
								'service',
								'serviceBuyList',
								'serviceList',
								'msgList',
								'serviceSet',
								'inviteUser' 
						),
						'roles' => array (
								'boss' 
						) 
				)
				// 'message'=>'非授权访问',
				,
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (),
						
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions' => array (
								'admin',
								'delete' 
						),
						'users' => array (
								'admin' 
						) 
				),
				array (
						'deny', // deny all users
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionCard() {
		
		// $boss = Boss::model()->findByAttributes(array(
		// 'b_user_id'=>Yii::app()->user->id,
		// ));
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		
		// $shop = $boss->washShop;
		$shopId = $shop ['id'];
		
		$model = new CardGenHistory ();
		
		$criteria = new CDbCriteria ();
		
		$criteria->order = 'cgh_date DESC';
		$criteria->addCondition ( 'cgh_shop_id=:id' );
		$criteria->params [':id'] = $shopId;
		
		$dataProvider = new CActiveDataProvider ( 'CardGenHistory', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		$this->layout = 'admin_boss';
		$this->render ( 'card', array (
				'shop' => $shop,
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * 邀请加入会员
	 * 刘长鑫
	 * 20150901
	 */
	public function actionInviteUser() {
		$this->layout = "admin_boss";
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		$model = new LoginForm ();
		$model->setScenario ( 'invite' );
		
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'invite-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		if (isset ( $_POST ['LoginForm'] ) && Yii::app ()->request->isAjaxRequest) {
			
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate ()) {


				$user = User::model()->findByAttributes(array('u_tel'=>$model['u_tel']));
				
				if (isset($user)){
					// 				如果已注册
					$member = ShopMember::model()->findByAttributes(array('sm_user_id'=>$user['id'],'sm_shop_id'=>$shop['id']));
					if (!isset($member)){
// 						已注册，未加入会员
						$member = new ShopMember ();
						$member ['sm_user_id'] = $user ['id'];
						$member ['sm_shop_id'] = $shop ['id'];
						$member ['sm_src'] = $boss ['b_user_id'];
						$member ['sm_join_time'] = date ( 'Y-m-d H:i:s' );
						if (! $member->save ()) {
							Yii::log ( CJSON::encode ( $member ), CLogger::LEVEL_WARNING, 'mngr.bossC.inviteUser' );
						}else {
							Yii::app ()->user->setFlash ( 'inviteError', '邀请成功' );
						}
						if (empty($shop['ws_short_url'])){
							$url = Yii::app()->createAbsoluteUrl('order/new',array('id'=>$shop['id']));
							$shop['ws_short_url'] = UWashShop::generateShortUrl($url)['data'];
							$shop->save();
						}
						
						$sendRlt = USms::sendInviteSmsReg ( $model ['u_tel'], $boss ['b_user_id'], $shop ['ws_name'],
								 UWashShop::getShortUrl ( $shop ['ws_short_url'] ) ,FALSE);

						$msg = '邀请成功';
						if (isset($sendRlt ['msg']) ){
							$msg .= ' ('.$sendRlt ['msg'].')' ;
						}
						Yii::app ()->user->setFlash ( 'inviteError', $msg);

					} else {
						Yii::app ()->user->setFlash ( 'inviteError', '该用户已经加入会员' );
					}
					
				} else {
					// 				如果未注册
					$model->u_pwd = substr ( $model->u_tel, - 4, 4 );
					$regRlt = User::model ()->reg ( $model, FALSE );
					if ($regRlt ['status']) {

						$member = new ShopMember ();
						$member ['sm_user_id'] = $regRlt ['data'] ['id'];
						$member ['sm_shop_id'] = $shop ['id'];
						$member ['sm_src'] = $boss ['b_user_id'];
						$member ['sm_join_time'] = date ( 'Y-m-d H:i:s' );
						if (! $member->save ()) {
							Yii::log ( CJSON::encode ( $member ), CLogger::LEVEL_WARNING, 'mngr.bossC.inviteUser' );
						}else {
							Yii::app ()->user->setFlash ( 'inviteError', '邀请成功' );
						}
						if (empty($shop['ws_short_url'])){
							$url = Yii::app()->createAbsoluteUrl('order/new',array('id'=>$shop['id']));
							$shop['ws_short_url'] = UWashShop::generateShortUrl($url)['data'];
							$shop->save();
						}
						
						
						$sendRlt = USms::sendInviteSmsReg ( $model ['u_tel'], $boss ['b_user_id'], $shop ['ws_name'], UWashShop::getShortUrl ( $shop ['ws_short_url'] ) );
						$msg = '邀请成功';
						if (isset($sendRlt ['msg']) ){
							$msg .= ' ('.$sendRlt ['msg'].')' ;
						}
						Yii::app ()->user->setFlash ( 'inviteError', $msg);
					} else {
						
						Yii::app ()->user->setFlash ( 'inviteError', $regRlt ['msg'] . '，请稍后重试' );
					}
				} // end 未注册
			} else {
				Yii::app ()->user->setFlash ( 'inviteError', '输入未通过验证' );
			} // end if validate
			
			$this->renderPartial ( '_inviteUser', array (
					'model' => $model 
			) );
			Yii::app ()->end ();
		}
		// display the login form
		$this->render ( 'inviteUser', array (
				'model' => $model ,'boss'=>$boss
		) );
	}
	public function actionServiceSet() {
		$this->layout = 'admin_boss';
		
		$model = new ShopServiceSetForm ();
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'service-set-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		if (isset ( $_POST ['ShopServiceSetForm'] )) {
			
			$model->attributes = $_POST ['ShopServiceSetForm'];
			if ($model->validate ()) {
				$setRlt = $model->save ();
				// $msg = new Message();
				// $msg['m_content']=$setRlt['msg'];
				// $msg['m_datetime']=date('Y-m-d H:i:s');
				// $msg['m_type']=Message::TYPE_SHOP;
				// $msg['m_user_id']=Yii::app()->user->id;
				// $msg['m_src']=UTool::getRequestInfo();
				// $msg['m_level']=Message::LEVEL_NORM;
				// $msg->save();
				$msg = new Message ();
				$msg ['m_content'] = '更新车行服务基准设置' . $setRlt ['msg'];
				$msg ['m_datetime'] = date ( 'Y-m-d H:i:s' );
				$msg ['m_type'] = Message::TYPE_ACCOUNT;
				$msg ['m_user_id'] = Yii::app ()->user->id;
				$msg ['m_src'] = UTool::getRequestInfo ();
				$msg ['m_level'] = Message::LEVEL_NORM;
				$msg->save ();
				
				Yii::app ()->user->setFlash ( 'serviceSetError', $setRlt ['msg'] );
			}  // end if validator
else {
				Yii::app ()->user->setFlash ( 'serviceSetError', CJSON::encode ( $model->errors ) );
			}
			
			Yii::app ()->end ( 0, true );
		}
		
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		
		$model->load ( $shop ['id'] );
		$this->render ( 'serviceSet', array (
				'shop' => $shop,
				'model' => $model 
		) );
	}
	
	/**
	 * 优惠劵申请
	 */
	public function actionCardRequest() {
		
		// $boss = Boss::model()->findByAttributes(array(
		// 'b_user_id'=>Yii::app()->user->id,
		// ));
		
		// $shop = $boss->washShop;
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		$shopId = $shop ['id'];
		
		$model = new CardGenHistory ();
		
		$this->layout = 'admin_boss';
		$this->render ( 'cardRequest', array (
				'shop' => $shop,
				'model' => $model 
		) );
	}
	public function actionNewRequestCard() {
		if (Yii::app ()->request->isAjaxRequest) 

		{
			@$shopId = $_GET ['id'];
			@$num = $_GET ['num'];
			@$value = $_GET ['value'];
			@$ctype = $_GET ['ctype'];
			@$stype = $_GET ['stype'];
			@$sDate = $_GET ['sDate'];
			@$sAddress = $_GET ['sAddress'];
			@$sContactor = $_GET ['sContactor'];
			@$sTel = $_GET ['sTel'];
			
			$genModel = new CardGenHistory ();
			$genModel ['cgh_type'] = $ctype;
			$gValue = 0;
			if ($ctype == 0) {
				$genModel ['cgh_type'] = $ctype;
				$genModel ['cgh_guarantee'] = 0;
				$gValue = 0;
			} else {
				$genModel ['cgh_type'] = $stype;
				$genModel ['cgh_guarantee'] = UTool::guaranteeRatio ( $num * $value ) * $num * $value;
				$gValue = UTool::guaranteeRatio ( $num * $value ) * $value;
				$genModel ['cgh_guarantee'] = $gValue * $num;
			}
			// $genModel['cgh_sype'] = $stype;
			$genModel ['cgh_user_id'] = Yii::app ()->user->id;
			$genModel ['cgh_shop_id'] = $shopId;
			$genModel ['cgh_date'] = date ( 'Y-m-d H:i:s' );
			$genModel ['cgh_state'] = 0;
			$genModel ['cgh_count'] = $num;
			
			$genModel ['cgh_value'] = $num * $value;
			$genModel ['cgh_date_state_update'] = $genModel ['cgh_date'];
			$genModel ['cgh_date_end'] = $sDate;
			$genModel ['cgh_address'] = $sAddress;
			$genModel ['cgh_contactor'] = $sContactor;
			$genModel ['cgh_tel'] = $sTel;
			
			if ($genModel->save ()) {
				Yii::log ( CJSON::encode ( $genModel ), 'info', 'mngr.boss.newRequestCard' );
				Cardinvite::model ()->send ( $shopId, $num, $value, $genModel ['id'], $genModel ['cgh_type'], $gValue );
				echo 'dd';
				echo CJSON::encode ( $genModel );
			} else {
				// Yii::log(CJSON::encode($genModel),'info','mngr.bosscontroller.newRequestCard');
				echo CJSON::encode ( $genModel );
			}
		}
	}
	public function actionGetRealTimeList() {
		if (Yii::app ()->request->isAjaxRequest) 

		{
			$shopId = $_GET ['id'];
			@$bias = $_GET ['bias'];
			
			$model = new OrderHistory ();
			
			$criteria = new CDbCriteria ();
			
			$criteria->order = 'oh_date_time ASC, oh_position ASC, oh_date_time_end ASC';
			$criteria->addCondition ( 'oh_wash_shop_id=:id' );
			$criteria->params [':id'] = $shopId;
			
			$criteria->addCondition ( 'oh_wash_shop_id=:id' );
			$criteria->params [':id'] = $shopId;
			$criteria->addCondition ( 'oh_state>0' );
			$criteria->addCondition ( 'oh_date_time>=:dtStart' );
			$criteria->addCondition ( 'oh_date_time<=:dtEnd' );
			if ($bias == 0 || $bias == 1 || $bias == 2) {
				$criteria->params [':dtStart'] = date ( 'Y-m-d 00:00:00', strtotime ( '+' . $bias . ' days' ) );
				$criteria->params [':dtEnd'] = date ( 'Y-m-d 23:59:00', strtotime ( '+' . $bias . ' days' ) );
			} else {
				$criteria->params [':dtStart'] = date ( 'Y-m-d 00:00:00', strtotime ( '+ 0 days' ) );
				$criteria->params [':dtEnd'] = date ( 'Y-m-d 23:59:00', strtotime ( '+ 2 days' ) );
			}
			
			$criteria->with = 'serviceType';
			// $criteria->addCondition('oh_state=:sType');
			
			$dataProvider = new CActiveDataProvider ( 'OrderHistory', array (
					'pagination' => array (
							'pageSize' => 800 
					),
					'criteria' => $criteria 
			) );
			
			$this->renderPartial ( '_realTimeList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
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
				// Yii::app ()->user->setFlash ( 'orderAddSuccess', '预定信息添加成功！' );
				// Yii::app()->user->setFlash('discountNumWarning', $rlt['msg']);
				// echo CJSON::encode($rlt);
			} else {
				Yii::app ()->user->setFlash ( 'discountNumWarning', $rlt ['msg'] );
				//
			}
			echo CJSON::encode ( $rlt );
		}
	}
	public function actionGetStaffList() {
		if (Yii::app ()->request->isAjaxRequest) {
			
			$id = $_GET ['id'];
			$model = new OrderTempUser ();
			$criteria = new CDbCriteria ();
			$criteria->addCondition ( 'otu_ot_id=' . $id );
			// $criteria->with = "otuUser";
			$criteria->with = "otuStaff";
			$dataProvider = new CActiveDataProvider ( 'OrderTempUser', array (
					'pagination' => array (
							'pageSize' => 80 
					),
					'criteria' => $criteria 
			) );
			$this->renderPartial ( '_timeListStaffList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	
	/**
	 * 增加工作时间预约订单
	 *
	 * @param string $indexList
	 *        	序号表
	 * @param int $bossId
	 *        	用户id
	 * @param int $washShopId
	 *        	车行id 默认值为0时系统会根据bossId自动查找对应车行信息
	 * @param int $position
	 *        	档口位置 默认值为档口1
	 * @param int $bias
	 *        	与今天时间偏移量天数
	 * @return string array [state,msg,date]
	 *         @soap
	 */
	public function orderAdd($indexList, $bossId, $washShopId = 0, $position = 1, $bias = 0) {
		// return CJSON::encode($indexList);
		// $rlt = Boss::model()->orderAdd($indexList, $bossId,$washShopId,$position);
		// return CJSON::encode($rlt);
		return CJSON::encode ( Boss::model ()->orderAdd ( CJSON::decode ( $indexList ), $bossId, $washShopId, $position, $bias ) );
	}
	public function actionProfile() {
		$upload = new ShopForm ();
		
		// if ( !Yii::app()->user->checkAccess('boss') ) {
		// $this->redirect(array('boss/login'));
		// Yii::app()->end();
		// }
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		$this->layout = 'admin_boss';
		if ($shop ['ws_state'] == 2) {
			
			$count = OrderTemp::model ()->countByAttributes ( array (
					'ot_wash_shop_id' => $shop ['id'] 
			) );
			
			if ($count < 1) {
				$shop->deleteOrderTempTable ( $shop ['id'], 0 );
				$shop->deleteOrderTempTable ( $shop ['id'], 1 );
				$shop->deleteOrderTempTable ( $shop ['id'], 2 );
				$shop->generateOrderTempTable ( $shop ['id'], 0 );
				$shop->generateOrderTempTable ( $shop ['id'], 1 );
				$shop->generateOrderTempTable ( $shop ['id'], 2 );
			}
			
			$_view = '_profile_wellcome';
		} else if ($shop ['ws_state'] == 1) {
			$_view = '_profile';
		} else {
			$_view = "_profile";
		}
		$this->render ( 'profile', array (
				'shop' => $shop,
				'boss' => $boss,
				'_view' => $_view 
		)
		// 'upload'=>$upload,
		 );
		
		// }else{
		// throw new CHttpException(401,'非法请求');
		// }
	}
	public function actionGuarantee() {
		$this->layout = 'admin_boss';
		$this->render ( 'guarantee', array (
				'shop' => UTool::getShop () 
		) );
	}
	public function actionGuaranteeView($id) {
		$this->layout = 'admin_boss';
		$this->render ( 'guaranteeView' );
	}
	public function actionService() {
		$this->layout = 'admin_boss';
		
		$model = new BuyServiceForm ();
		
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'buy-service-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['BuyServiceForm'] )) {
			// // 校验令牌
			// if (! UTool::checkCsrf ()) {
			// echo '错误请求';
			// Yii::app ()->end ();
			// }
			$model->attributes = $_POST ['BuyServiceForm'];
			if ($model->validate ()) {
				// $rltCheck = UTool::checkRepeatAction ( 10 );
				// if ($rltCheck ['status']) {
				// // echo CJSON::encode($rltCheck);
				// Yii::app ()->user->setFlash ( 'regError', $rltCheck ['msg'] );
				// // Yii::app()->end();
				// } else {
				$buyRlt = $model->Buy ( Yii::app ()->user->id );
				
				if ($buyRlt ['status']) {
					// $this->redirect(array('profile'));
					// $this->layout = 'admin_user';
					$this->redirect ( array (
							'boss/serviceList' 
					), true );
					// Yii::log($buyRlt['msg'],CLogger::)
					Yii::app ()->end ();
				} else {
					Yii::app ()->user->setFlash ( 'buyError', $buyRlt ['msg'] );
				}
				// }
			} // end if validator
		}
		
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		$joinStd = new JoinPriceForm ();
		$joinStd->load ( $shop ['ws_city_id'] );
		
		if ($shop ['ws_num'] > 1) {
			$shopType = 'more';
		} else {
			$shopType = 'one';
		}
		
		$this->render ( 'service', array (
				'model' => $model,
				'boss' => $boss,
				'shop' => $shop,
				'joinStd' => $joinStd,
				'shopType' => $shopType 
		) );
	}
	public function actionNews() {
		$this->layout = 'admin_boss';
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		// $this->layout = 'admin_boss';
		// Yii::app()->controller->renderText('')
		// if ($shop['ws_level']<1){
		// $this->render ( '_tipBuyService', array (
		// 'boss' => $boss,
		// 'shop' => $shop,
		// 'serviceName'=>"车行动态"
		// ) );
		// }else{
		
		// $this->render ( 'news', array (
		// 'boss' => $boss,
		// 'shop' => $shop
		// ) );
		// }
		$this->render ( 'news', array (
				'boss' => $boss,
				'shop' => $shop 
		) );
		// $this->render ( 'news', array (
		// 'shop' => UTool::getShop ()
		// ) );
	}
	public function actionComment() {
		$this->layout = 'admin_boss';
		// $this->render('comment');
		$model = new OrderComments ();
		
		// @$startTime = $_GET['startTime'];
		// @$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria ();
		$criteria->order = 'oc_order_id DESC, oc_datetime ASC';
		
		$shopId = UTool::getShop ()['id'];
		$criteria->addCondition ( 'oc_washshop_id = :shopId' );
		$criteria->params [':shopId'] = $shopId;
		$criteria->addCondition ( 'oc_comment_user_type = 1' );
		
		// if (isset($startTime) && isset($endTime)) {
		// $criteria->addCondition('oh_date_time>=:start');
		// $criteria->addCondition('oh_date_time<=:end');
		// $criteria->params[':start'] = $startTime;
		// $criteria->params[':end']=$endTime;
		// }
		
		$dataProvider = new CActiveDataProvider ( 'OrderComments', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		if (Yii::app ()->request->isAjaxRequest) {
			
			$this->renderPartial ( '_commentList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
		
		$this->render ( 'commentList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionTimeList() {
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		$this->layout = 'admin_boss';
		$this->render ( 'timeList', array (
				'boss' => $boss,
				'shop' => $shop 
		) );
	}
	public function actionRealTimeList() {
		$boss = UTool::getBoss ();
		$shop = UTool::getShop ();
		$this->layout = 'admin_boss';
		// Yii::app()->controller->renderText('')
		// if ($shop['ws_level']<1){
		// $this->render ( '_tipBuyService', array (
		// 'boss' => $boss,
		// 'shop' => $shop,
		// 'serviceName'=>"实时订单"
		// ) );
		// }else{
		
		// $this->render ( 'realTimeList', array (
		// 'boss' => $boss,
		// 'shop' => $shop
		// ) );
		// }
		$this->render ( 'realTimeList', array (
				'boss' => $boss,
				'shop' => $shop 
		) );
		
		// $this->layout='admin_boss';
		// $this->render('realTimeList');
	}
	public function actionStaffEvent() {
		$model = new StaffEvent ();
		$this->layout = 'admin_boss';
		@$startTime = $_GET ['startTime'];
		@$endTime = $_GET ['endTime'];
		$criteria = new CDbCriteria ();
		$criteria->order = 'se_date_time DESC';
		
		$criteria->condition = "se_wash_shop_id = :shopId";
		
		$shopId = Boss::model ()->findByAttributes ( array (
				'b_user_id' => Yii::app ()->user->id 
		) )->washShop ['id'];
		
		$criteria->params [':shopId'] = $shopId;
		// $criteria->params[':staff2']=$staffId;
		if (isset ( $startTime ) && isset ( $endTime )) {
			$criteria->addCondition ( 'se_date_time>=:start' );
			$criteria->addCondition ( 'se_date_time<=:end' );
			$criteria->params [':start'] = $startTime;
			$criteria->params [':end'] = $endTime;
		}
		
		$dataProvider = new CActiveDataProvider ( 'StaffEvent', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		if (Yii::app ()->request->isAjaxRequest) {
			
			$this->renderPartial ( '_eventList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
		
		$this->render ( 'eventList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionWsInfo($id) {
		// $model = WashShop::model()->findByPk($id);
		$model = UTool::getShop ();
		$this->layout = 'admin_boss';
		if (! Yii::app ()->request->isAjaxRequest) {
			// Yii::app ()->end ();
		}
		// $boss = UTool::getBoss();
		// $shop = UTool::getShop();
		$user = User::model ()->findByPk ( $model ['ws_boss_id'] );
		$boss = Boss::model ()->findByAttributes ( array (
				'b_user_id' => $model ['ws_boss_id'] 
		) );
		$this->render ( '//mngr/wsInfo', array (
				'model' => $model,
				'boss' => $boss,
				'user' => $user,
				'editable' => 'disabled' 
		) );
	}
	public function actionServiceList() {
		$model = new ShopPay ();
		$this->layout = 'admin_boss';
		
		$criteria = new CDbCriteria ();
		$criteria->order = 'sp_datetime DESC';
		$shopId = UTool::getShop ()['id'];
		$criteria->addCondition ( 'sp_shop_id = :shopId' );
		$criteria->params [':shopId'] = $shopId;
		
		$dataProvider = new CActiveDataProvider ( 'ShopPay', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		$this->render ( 'serviceList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		), false, true );
	}
	public function actionServiceBuyList() {
		if (! Yii::app ()->request->isAjaxRequest) {
			Yii::app ()->end ();
		}
		
		$model = new ShopPay ();
		$this->layout = 'admin_boss';
		
		$criteria = new CDbCriteria ();
		$criteria->order = 'sp_datetime DESC';
		$shopId = UTool::getShop ()['id'];
		$criteria->addCondition ( 'sp_shop_id = :shopId' );
		$criteria->params [':shopId'] = $shopId;
		
		$dataProvider = new CActiveDataProvider ( 'ShopPay', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		$this->renderPartial ( '_serviceBuyList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		), false, true );
	}
	public function actionMsgList() {
		$this->layout = 'admin_boss';
		$model = new Message ();
		$criteria = new CDbCriteria ();
		$criteria->order = 'm_datetime DESC';
		$criteria->addCondition ( 'm_user_id=:user_id' );
		$criteria->addCondition ( 'm_type>=0' );
		$criteria->params [':user_id'] = Yii::app ()->user->id;
		$dataProvider = new CActiveDataProvider ( 'Message', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		$this->render ( 'msgList', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionStaffWSUpdate() {
		$model = new Staff ();
		$this->layout = 'admin_boss';
		// @$startTime = $_GET['startTime'];
		// @$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria ();
		$criteria->order = 's_name ASC';
		
		$criteria->condition = "s_wash_shop_id = :shopId";
		
		$shopId = Boss::model ()->findByAttributes ( array (
				'b_user_id' => Yii::app ()->user->id 
		) )->washShop ['id'];
		
		$criteria->params [':shopId'] = $shopId;
		
		@$staffId = $_POST ['id'];
		@$shopId = $_POST ['shopId'];
		
		if (! isset ( $shopId )) {
			$shopId = 0;
		}
		$rlt = Staff::model ()->getStaffsUpdate ( array (
				$staffId 
		), $shopId );
		
		$dataProvider = new CActiveDataProvider ( 'Staff', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		if (Yii::app ()->request->isAjaxRequest) {
			
			$this->renderPartial ( '_staffMngr', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	public function actionStaffMngr() {
		$model = new Staff ();
		$this->layout = 'admin_boss';
		// @$startTime = $_GET['startTime'];
		// @$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria ();
		$criteria->order = 's_name ASC';
		
		$criteria->condition = "s_wash_shop_id = :shopId";
		
		$shopId = UTool::getShop ()['id'];
		
		// $shopId = Boss::model()->findByAttributes(array('b_user_id'=>Yii::app()->user->id))->washShop['id'];
		
		$criteria->params [':shopId'] = $shopId;
		
		@$staffId = $_POST ['id'];
		@$toShopId = $_POST ['shopId'];
		if (isset ( $staffId )) {
			
			if (! isset ( $toShopId )) {
				$toShopId = 0;
			}
			$rlt = Staff::model ()->getStaffsUpdate ( array (
					$staffId 
			), $toShopId );
		}
		
		@$staffTel = $_POST ['tel'];
		@$staffTag = $_POST ['tag'];
		if (isset ( $staffTel )) {
			$staff = Staff::model ()->findByAttributes ( array (
					's_tel' => $staffTel,
					's_wash_shop_id' => '0' 
			) );
			
			if (isset ( $staff )) {
				$staff ['s_wash_shop_id'] = $shopId;
				$staff ['s_tag'] = $staffTag;
				Yii::log ( CJSON::encode ( $staff, 'error', 'staff.update.washshop.add' ) );
				$staff->Save ();
			} else {
				echo '0';
				Yii::app ()->end ();
			}
		}
		
		$dataProvider = new CActiveDataProvider ( 'Staff', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		if (Yii::app ()->request->isAjaxRequest) {
			
			$this->renderPartial ( '_staffList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
		
		$this->render ( 'staffMngr', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * 返回可用时间段信息
	 */
	public function actionGetTimelist() {
		if (Yii::app ()->request->isAjaxRequest) {
			$id = $_GET ['id'];
			@$bias = $_GET ['bias'];
			@$carType = $_GET ['carType'];
			@$sType = $_GET ['sType'];
			@$position = $_GET ['position'];
			
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
			
			$this->renderPartial ( '_timeList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	public function actionList() {
		$model = new OrderHistory ();
		$this->layout = 'admin_boss';
		@$startTime = $_GET ['startTime'];
		@$endTime = $_GET ['endTime'];
		$criteria = new CDbCriteria ();
		$criteria->order = 'oh_date_time DESC';
		
		// $criteria->condition="(oh_staff_id1 = :staff1 OR oh_staff_id2 = :staff2)";
		$shopId = UTool::getShop ()['id'];
		// $shopId = Boss::model()->findByAttributes(array('b_user_id'=>Yii::app()->user->id))->washShop['id'];
		
		// $shopId = WashShop::model()->findByAttributes(array(''))
		$criteria->addCondition ( 'oh_wash_shop_id = :shopId' );
		
		$criteria->params [':shopId'] = $shopId;
		// $criteria->params[':staff2']=$staffId;
		if (isset ( $startTime ) && isset ( $endTime )) {
			$criteria->addCondition ( 'oh_date_time>=:start' );
			$criteria->addCondition ( 'oh_date_time<=:end' );
			$criteria->params [':start'] = $startTime;
			$criteria->params [':end'] = $endTime;
		}
		
		$dataProvider = new CActiveDataProvider ( 'OrderHistory', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		)
		// 'sort' => array (
		// 'defaultOrder' => 'oh_date_time DESC',
		// 'attributes' => array (
		 )
		
		// // 'all' => array (
		// // 'asc' => 'FIELD("oh_state","1","2","0") , oh_date_time DESC',
		// // 'desc' => 'FIELD("oh_state","2","1","") , oh_date_time ASC'
		// // ),
		// // 'oh_state' => array (
		// // 'asc' => 'FIELD("oh_state","1","2")',
		// // 'desc' => 'FIELD("oh_state","2","1")',
		// // ),
		// // 'oh_type' => array (
		// // 'asc' => 'ws_level ASC',
		// // 'desc' => 'ws_level DESC'
		// // ),
		// // 'score' => array (
		// // 'asc' => 'ws_score ASC',
		// // 'desc' => 'ws_score DESC'
		// // ),
		// // 'ratio' => array (
		// // 'asc' => 'ws_score ASC',
		// // 'desc' => 'ws_score DESC'
		// // )
		// )
		// )
		// )
		;
		
		if (Yii::app ()->request->isAjaxRequest) {
			
			$this->renderPartial ( '_list', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
		
		$this->render ( 'list', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * 根据老板id返回车行id
	 *
	 * @param int $bossId        	
	 * @return string soap
	 */
	public function getWashShopId($bossId) {
		$rlt = UTool::iniFuncRlt ();
		$shop = WashShop::model ()->findByAttributes ( array (
				'ws_boss_id' => $bossId 
		) );
		if (! isset ( $shop )) {
			$rlt ['msg'] = '00009';
			return $rlt;
		}
		$rlt ['data'] = $shop ['id'];
		$rlt ['status'] = true;
		return $rlt;
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		// UTool::setCsrfValidator ();
		if (Yii::app ()->request->isAjaxRequest || Yii::app ()->request->isPostRequest) {
		} else {
			$urls = array (
					'urlReferrer' => Yii::app ()->request->urlReferrer,
					'urlCurrent' => Yii::app ()->request->url,
					'urlReturn' => Yii::app ()->user->returnUrl
			);
			Yii::log ( CJSON::encode ( $urls ), CLogger::LEVEL_INFO, 'mngr.' . $this->getId () . '.' . $this->getAction ()->getId ()  . 'src');
			Yii::app ()->session ['urlReferer'] = Yii::app ()->request->urlReferrer;
		}
		$this->layout = 'main_simple';
		
		if (! Yii::app ()->user->isGuest) {
			if (Yii::app ()->user->checkAccess ( 'boss' )) {
				$this->redirect ( array (
						'Profile' 
				) );
				Yii::app ()->end ();
			}else{
				$this->redirect(Yii::app()->baseUrl);
			}
		}
		$model = new LoginForm ();
		$model->setScenario ( 'login' );
		
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		if (isset ( $_POST ['LoginForm'] )) {
			// // 校验令牌
			// if (! UTool::checkCsrf ()) {
			// throw new CHttpException ( 500, '请求异常，请稍后重试' );
			// Yii::app ()->end ();
			// }
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate ()) {
				$rltCheck = UTool::checkRepeatAction ( 5 );
				if ($rltCheck ['status']) {
					// echo CJSON::encode ( $rltCheck );
					Yii::app ()->user->setFlash ( 'loginError', $rltCheck ['msg'] );
					// Yii::app ()->end ();
				} else
				{
					$result = $model->login ();
					if (!$result['status']){
						Yii::app ()->user->setFlash ( 'loginError',$result['msg']);
					}else if (!Yii::app ()->user->checkAccess ( 'boss' )){
						Yii::app ()->user->setFlash ( 'loginError','不是有效的商家账号');
					}else{
						if (isset(Yii::app()->session['urlReferer'])){
							$this->redirect(Yii::app()->session['urlReferer'],TRUE);
							unset(Yii::app()->session['urlReferer']);
						}else{
							$this->redirect(Yii::app()->user->getReturnUrl(),TRUE);
						}
						Yii::app ()->end ();
					}
				}
			} else {
				Yii::app ()->user->setFlash ( 'loginError', '输入未通过验证' );
			} // end if validate
		}
		// display the login form
		$this->render ( 'login', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Displays the registration page
	 */
	public function actionReg() {
		$model = new LoginForm ();
		$model->user_type = 2;
		
		$model->setScenario ( 'reg' );
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			yii::trace ( 'validate before validation', 'uc.*' );
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate ()) {
				yii::trace ( 'validate pass', 'uc.*' );
				$user_model = new User ();
				$user_model->u_tel = $model->u_tel;
				$user_model->u_pwd = CPasswordHelper::hashPassword ( $model->u_pwd );
				$user_model->u_name = $model->u_tel;
				$user_model->u_score = 0;
				$user_model->u_join_date = date ( 'Y-m-d H:i:s' );
				$user_model->u_login_date = date ( 'Y-m-d H:i:s' );
				$user_model->u_type = $model->user_type;
				
				if ($user_model->save ()) {
					// $this->render('profile',array('model'=>$model),true);
					
					$bossModel = new Boss ();
					$bossModel->b_name = $user_model->u_name;
					$bossModel->b_nick_name = $user_model->u_name;
// 					$bossModel->b_tel = $user_model->u_tel;
					$bossModel->b_pwd = $user_model->u_pwd;
					$bossModel->b_type = 0;
					$bossModel->b_user_id = $user_model->id;
					if (! $bossModel->save ()) {
						Yii::log ( CJSON::encode ( $user_model ), 'error', 'user.boss.reg.boss' );
					}
					
					$auth = new Assignments ();
					$auth->itemname = 'boss';
					$auth->userid = $user_model->id;
					if ($auth->save ()) {
						Yii::log ( CJSON::encode ( $auth ), 'error', 'user.boss.reg.auth' );
					}
					
					$lf = new LoginForm ();
					$lf->u_tel = $user_model->u_tel;
					$lf->u_pwd = $user_model->u_pwd;
					// Yii::log(CJSON::encode($model),'error','user.*');
					$r = $model->login ();
					if ($r['status']) {
						// Yii::log(CJSON::encode($lf),'error','user.*');
						$this->redirect ( array (
								'profile' 
						) );
					}
				}
			}
		}
		// display the login form
		$this->render ( '//user/reg', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Displays the registration page
	 */
	public function actionReset() {
		$model = new LoginForm ();
		$model->user_type = 2;
		
		$model->setScenario ( 'reset' );
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			yii::trace ( 'validate before validation', 'uc.*' );
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate ()) {
				// yii::trace('validate pass','uc.*');
				$user_model = User::model ()->findByAttributes ( array (
						'u_tel' => $model->u_tel 
				) );
				
				$user_model->u_pwd = CPasswordHelper::hashPassword ( $model->u_pwd );
				
				$user_model->u_login_date = date ( 'Y-m-d H:i:s' );
				// $user_model->u_type = $model->user_type;
				
				if ($user_model->save ()) {
					// $this->render('profile',array('model'=>$model),true);
					
					$lf = new LoginForm ();
					$lf->u_tel = $user_model->u_tel;
					$lf->u_pwd = $user_model->u_pwd;
					// Yii::log(CJSON::encode($model),'error','user.*');
					$r = $model->login();
					if ($r['status']) {
						// Yii::log(CJSON::encode($lf),'error','user.*');
						$this->redirect ( array (
								'profile' 
						) );
					}
				}
			}
		}
		// display the login form
		$this->render ( '//user/reset', array (
				'model' => $model 
		) );
	}
	
	/**
	 * 删除工作时间预约订单
	 *
	 * @param string $indexList
	 *        	序号表
	 * @param int $bossId
	 *        	用户id
	 * @param int $washShopId
	 *        	车行id 默认值为0时系统会根据bossId自动查找对应车行信息
	 * @param int $position
	 *        	档口位置 默认值为档口1
	 * @param int $bias
	 *        	与今天时间偏移量天数
	 * @return string [state,msg,date]
	 *         @soap
	 */
	public function orderDelete($indexList, $bossId, $washShopId = 0, $position = 1, $bias = 0) {
		
		//
		return CJSON::encode ( Boss::model ()->orderDelete ( CJSON::decode ( $indexList ), $bossId, $washShopId, $position, $bias ) );
	}
	
	/**
	 * Displays a particular model.
	 *
	 * @param integer $id
	 *        	the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render ( 'view', array (
				'model' => $this->loadModel ( $id ) 
		) );
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Boss ();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['Boss'] )) {
			$model->attributes = $_POST ['Boss'];
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id 
				) );
		}
		
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel ( $id );
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['Boss'] )) {
			$model->attributes = $_POST ['Boss'];
			if ($model->save ())
				$this->redirect ( array (
						'view',
						'id' => $model->id 
				) );
		}
		
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		$this->loadModel ( $id )->delete ();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (! isset ( $_GET ['ajax'] ))
			$this->redirect ( isset ( $_POST ['returnUrl'] ) ? $_POST ['returnUrl'] : array (
					'admin' 
			) );
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider ( 'Boss' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionMngr() {
		$dataProvider = new CActiveDataProvider ( 'Boss' );
		$this->render ( 'mngr', array (
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Boss ( 'search' );
		$model->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['Boss'] ))
			$model->attributes = $_GET ['Boss'];
		
		$this->render ( 'admin', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id
	 *        	the ID of the model to be loaded
	 * @return Boss the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = Boss::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 *
	 * @param Boss $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'boss-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
