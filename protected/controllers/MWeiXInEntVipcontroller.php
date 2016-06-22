<?php
class MWeiXinEntVipController extends Controller {
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

	public function actioninviteVip(){
		$this->layout = "main_weixin";
	    $id=55;
		//$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));
		if (!isset($id)) {
			echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
			exit;
		}
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
		$boss = Boss::model ()->findByAttributes ( array ('b_user_id' => $shop ['ws_boss_id']));
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
							$shop=(object)$shop;
							$shop->save();
						}
						
						
						$sendRlt = USms::sendInviteSmsReg ( $model ['u_tel'], $boss ['b_user_id'], $shop ['ws_name'],
								 UWashShop::getShortUrl ( $shop ['ws_short_url'] ) ,FALSE);
// 						Yii::log ( CJSON::encode ( $sendRlt ), CLogger::LEVEL_WARNING, 'mngr.bossC.inviteUser' );
						$msg = '邀请成功';
						if (isset($sendRlt ['msg']) ){
							$msg .= ' ('.$sendRlt ['msg'].')' ;
						}
						Yii::app ()->user->setFlash ( 'inviteError', $msg);
// 						if ( $sendRlt ['status']) {
// 							$msg = '邀请成功';
// 							if (isset($sendRlt ['msg']) || !empty($sendRlt ['msg'])){
// 								$msg .= '('.$sendRlt ['msg'].')' ;
// 							}
// 							Yii::app ()->user->setFlash ( 'inviteError', $msg);
// 						}
					} else {
// 						已注册，已经加入会员
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
// 						if (! $sendRlt ['status']) {
// 							$msg = '邀请成功';
// 							if (isset($sendRlt ['msg'])){
// 								$msg = $msg.'('.$sendRlt ['msg'].')' ;
// 							}
// 							Yii::app ()->user->setFlash ( 'inviteError', $msg);
// 						}
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

	public function actionMembercount(){
		$this->layout = "main_weixin";
	    $id=55;
		//$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));
		if (!isset($id)) {
			echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
			exit;
		}
	
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
		Yii::app()->session['shop']=$shop;
		$model=ShopMember::model()->findAll('sm_shop_id=:id',array(':id'=>$shop->id));
		$this->render('membercount',array(
				'dataProvider'=>$dataProvider,
				'model' =>$model,
				'shop'=>$shop,
			));

	}

	public function actionsms(){
		$userid=$_POST['userid'];
		// Yii::log ( $tel, CLogger::LEVEL_INFO, 'sms.MWeiXinEntVip.postStr' );
		// $userid="userid329,userid308";
		$useridarr=explode(',', $userid);
		// print_r($telarr);
		foreach ($useridarr as  $userid) {
			$userid=substr($userid, 6);
			$tel=User::model()->find('id=:id', array(':id' =>$userid))->u_tel;
			$content = '尊敬的车主，您已成功注册“我洗车”'.'123'.'会员'.'123'.'，默认密码手机尾号后4位，欢迎登录';
			$sms=USms::_sendSms($tel, $content);
			// Yii::log ( $sms, CLogger::LEVEL_INFO, 'sms.MWeiXinEntVip.postStr' );
		}		
	}

	public function actionExtension(){
		
	    $this->layout =  "main_weixin";
	    $id=55;
		//$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));
		if (!isset($id)) {
			echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
			exit;
		}

	    $shop = WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
	    $boss = Boss::model ()->findByAttributes ( array ('b_user_id' => $shop ['ws_boss_id']));

	    Yii::app()->session['shop']=$shop;
	    $this->render ( 'Extension');
	   
	}

}