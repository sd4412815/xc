<?php
class SiteController extends Controller {
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array (
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha' => array (
						'class' => 'CCaptchaAction',
						'backColor' => 0xFFFFFF 
				),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page' => array (
						'layout'=>'main',
						'class' => 'CViewAction' 
				) 
		);
	}
	public $layout = 'main_simple';
	
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
								'reg',
								'login',
								'sendMessage',
								'logout',
								'error',
								'about',
								'topList',
								'help',
								'joinus',
								'jobs',
								'StaffList',
								'sms',
								'smsreset',
								'page' ,
								'index',
								'setCity'
								

						),
						'users' => array (
								'*' 
						) 
				),
				
				array (
						'allow', // allow all users to perform 'index' and 'view' actions
						'actions' => array (
								'msgList',
// 								'index',
								'yii',
								'contact',
						
								'yii',
								'APIs', 
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
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
// 		$this->layout = 'main';
		// 默认城市id=1
		// @$cityId = $_GET['cityId'];
		// if (!(isset($cityId) && is_numeric($cityId))) {
		// $cityId=1;
		// }
		// setcookie('cid',$cityId);
		
		// @$sDate = $_GET['sDate'];
		
		// if (!isset($sDate) || !strtotime($sDate)) {
		// $sDate = date('Y-m-d');
		// }
		
		// @$q=$_GET['q'];
		
		// $orderDate = new DateTime($sDate);
		// $currentDate = new DateTime(date('Y-m-d'));
		// $interval = $orderDate->diff($currentDate);
		// $bias = $interval->format('%a');
		// if (isset($bias) && is_numeric($bias)) {
		// setcookie('bias',$bias);
		// }else {
		// $bias = 0;
		// }
		
		// $model = new WashShop();
		// $criteria = new CDbCriteria();
		// $criteria->order = 'ws_score DESC, ws_exp DESC, id ASC';
		
		// if (isset($q)) {
		
		// $criteria->condition = '(ws_name LIKE :name or ws_address LIKE :address or ws_key_words LIKE :keyWord)';
		// $criteria->params[':name']='%'.$q.'%';
		// $criteria->params[':address']='%'.$q.'%';
		// $criteria->params[':keyWord']='%'.$q.'%';
		
		// }
		// $criteria->addCondition('ws_city_id=:cityId');
		// $criteria->params[':cityId']=$cityId;
		
		// $dataProvider = new CActiveDataProvider('WashShop',array(
		// 'pagination'=>array(
		// 'pageSize'=>8,
		// ),
		// 'criteria'=>$criteria,
		// ));
		
		// if (Yii::app()->request->isAjaxRequest ) {
		// $this->renderPartial('_rltList',array(
		// 'model'=>$model,
		// 'bias'=>$bias,
		// 'dataProvider'=>$dataProvider),false,true);
		// Yii::app()->end();
		// }
		$detect = new Mobile_Detect;
		// call methods
		// $detect->isMobile();
		// $detect->isTablet();
		// $detect->isIphone();
		$target = Yii::app()->request->getParam('device');
		$view  = 'index';
		if ($target == 'pc'){
			
		}else
			if ($detect->isTablet() || $target == 'mobile'){
			$view = '//mSite/index';
		} else
			if ($detect->isMobile() || $target=='mobile'){
			$view = '//mSite/index';
		}else{
		
		}
		$this->layout=  "main";
		$view = '//mSite/index';
		$this->render ( $view );
	}
	
	public function actionSetCity(){
		
		$this->render("setCity");
	}
	
	
	public function actionSmsreset(){
	
		$send_code = Yii::app ()->request->getPost ( 'send_code' );
		
		$mobile = Yii::app()->session['resetUserTel'];
		$sendRlt = USms::sendSmsReg($mobile, $send_code);
		echo CJSON::encode($sendRlt);
	}
	
	/**
	 * 发送短信验证码
	 */
	public function actionSms() {
// 		$rlt = UTool::iniFuncRlt ();
		$mobile = Yii::app ()->request->getPost ( 'tel' );
		$send_code = Yii::app ()->request->getPost ( 'send_code' );
		
		$sendRlt = USms::sendSmsReg($mobile, $send_code);
		
		echo CJSON::encode($sendRlt);
		
// 		$isTel = preg_match('/^1\d{10}$/', $mobile);
// 		$isSession = preg_match('/^r\d{6}$/', $mobile);
// 		$isValide = $isTel || $isSession;
// 		if (!Yii::app ()->request->isPostRequest 
// 			||  empty ( Yii::app ()->session ['send_code'] )
// 			|| !$isValide) {
// 			$rlt ['msg'] = '非法请求';
// 			echo CJSON::encode ( $rlt );
// 			Yii::app ()->end ();
// 		}
		
// 		if($isSession){
// 			$mobile = Yii::app()->session['resetUserTel'];
// 		}		
		
		
// 		$checkRlt = UTool::checkRepeatAction(10);
// 		if ($checkRlt['status']) {
// 			$rlt = $checkRlt;
// 			$rlt['status'] = false;
// 			echo CJSON::encode($rlt);
// 			return ;
// 		}
		
		
// 		$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";

		
// 		$mobile_code = UTool::randomkeys ( 6 );
// 		if (! preg_match ( '/^1\d{10}$/', $mobile )) {
// 			$rlt ['msg'] = '手机号码格式不正确';
// 			echo CJSON::encode ( $rlt );
// 			Yii::app ()->end ();
// 		}
		
// 		if (empty ( Yii::app ()->session ['send_code'] ) or $send_code != Yii::app ()->session ['send_code']) {
// 			// 防用户恶意请求
// 			$rlt ['msg'] = '请求超时，请刷新页面后重试';
// 			echo CJSON::encode ( $rlt );
// 			Yii::app ()->end ();
// 		}
		
// 		$post_data = "account=cf_xiche&password=" . md5 ( 'xc.2015' ) . "&mobile=" . $mobile . "&content=" . rawurlencode ( "您的验证码是：" . $mobile_code . "。请不要把验证码泄露给其他人。如非本人操作，可不用理会！" );
// 		// $post_data = "account=cf_xiche&password=123456&mobile=".$mobile."&content=".rawurlencode("您的验证码是：4290。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
// 		// 密码可以使用明文密码或使用32位MD5加密
		
// 		$sendRlt = UTool::curlPost ( $target, $post_data );
		
// 		$gets = UTool::xml_to_array ( $sendRlt );
// 		if ($gets ['SubmitResult'] ['code'] == 2) {
// 			Yii::app ()->session ['mobile'] = $mobile;
// 			Yii::app ()->session ['mobile_code'] = $mobile_code;
// 			$rlt ['status'] = true;
// 			$rlt ['msg'] = '验证码已发送';
// 		} else {
// // 			$rlt ['msg'] = $gets ['SubmitResult'] ['msg'];
// 			$rlt ['msg'] ='短信验证服务器忙，请稍后再试'.$gets ['SubmitResult'] ['code'];
// 		}
// 		echo CJSON::encode ( $rlt );
	}
	public function actionAPIs() {
		$this->render ( 'APIs' );
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app ()->errorHandler->error) {
			if (Yii::app ()->request->isAjaxRequest)
				// $this->renderText($error ['message']);
				echo $error ['message'];
			else
// 				$this->layout = 'main_blank';
// 			$this->render ( 'error', $error );
			echo json_encode($error);
			
		}
		// $this->layout ="dd";
		// $this->render ( 'error', $error );
	}
	
	public function actionMsgList(){
		
		$this->layout = 'admin_user';
		$model = new Message();
		$criteria = new CDbCriteria ();
		$criteria->order = 'm_datetime DESC';
		$criteria->addCondition ( 'm_user_id=:user_id' );
		$criteria->params [':user_id'] = Yii::app ()->user->id;
		$criteria->addCondition('m_type>=0');
		$dataProvider = new CActiveDataProvider ( 'Message', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'],
				),
				'criteria' => $criteria,
		) );
		$this->render('msgList',array (
				'model' => $model,
				'dataProvider' => $dataProvider, 
		) );
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if (isset ( $_POST ['ContactForm'] )) {
			$model->attributes = $_POST ['ContactForm'];
			if ($model->validate ()) {
				$name = '=?UTF-8?B?' . base64_encode ( $model->name ) . '?=';
				$subject = '=?UTF-8?B?' . base64_encode ( $model->subject ) . '?=';
				$headers = "From: $name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-Type: text/plain; charset=UTF-8";
				
				mail ( Yii::app ()->params ['adminEmail'], $subject, $model->body, $headers );
				Yii::app ()->user->setFlash ( 'contact', 'Thank you for contacting us. We will respond to you as soon as possible.' );
				$this->refresh ();
			}
		}
		$this->render ( 'contact', array (
				'model' => $model 
		) );
	}
	public function actionAbout() {
		$this->layout = 'main_blank';
		$this->render ( 'about' );
	}
	
	public function actionSendMessage(){
		$this->layout = 'main';
		
		$model = new OpenMessage();

		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'msg-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['OpenMessage'] )) {
			// 校验令牌
// 			if (! UTool::checkCsrf ()) {
// 				throw new CHttpException('500','错误请求')；
// 				Yii::app ()->end ();
// 			}
			$model->attributes = $_POST ['OpenMessage'];
			$model['om_datetime']=date('Y-m-d H:m:s');
			$model['om_status'] = 0;
			if ($model->validate ()) {
				$rltCheck = UTool::checkRepeatAction ( 10 );
				if ($rltCheck ['status']) {
					// echo CJSON::encode($rltCheck);
					Yii::app ()->user->setFlash ( 'msgError', $rltCheck ['msg'] );
					// Yii::app()->end();
				} else {
					
					$purifier = new CHtmlPurifier();
					$model['om_content'] = $purifier->purify($model['om_content']);
					if($model->save())
					{
						Yii::app ()->user->setFlash ( 'msgError','我们收到您的留言，会尽快处理' );
					} else {
						if(empty($model['om_content'])){
							Yii::app ()->user->setFlash ( 'msgError', '留言内容违规');
						}else{
							Yii::app ()->user->setFlash ( 'msgError', '留言失败，请稍后重试!');
						}
						
					}
					$this->refresh(true);
				}
			}else{
				Yii::app ()->user->setFlash ( 'msgError', CJSON::encode( $model->errors) );
			} // end if validator
		}
		// 显示登录表单
		$this->render ( 'sendMessage', array (
				'model' => $model
		) );
		

	}
	
	public function actionHelp() {
		$this->render ( 'help' );
	}
	public function actionJoinus() {
		$model = new JoinForm ();
// 		$model['cid']=UPlace::getCityId();
// 		$model['aid']=0;
// 		$model['pid'] = City::model()->findByPk($model['cid'])->province['id'];

		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'join-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['JoinForm'] )) {
			// 校验令牌
			if (! UTool::checkCsrf ()) {
				echo '错误请求';
				Yii::app ()->end ();
			}
			$model->attributes = $_POST ['JoinForm'];
			if ($model->validate ()) {
				$rltCheck = UTool::checkRepeatAction ( 10 );
				if ($rltCheck ['status']) {
					// echo CJSON::encode($rltCheck);
					Yii::app ()->user->setFlash ( 'joinError', $rltCheck ['msg'] );
					// Yii::app()->end();
				} else {
					$joinRlt = $model->join();

					if ($joinRlt ['status']) {


						Yii::app ()->user->setFlash ( 'joinError', '您已成功提交加盟申请，请耐心等待审核。' );

						$this->refresh(true);
					} else {
						Yii::app ()->user->setFlash ( 'joinError', $regRlt ['msg'] . '，请稍后重试' );
					}
				}
			} // end if validator
		}
		// 显示登录表单
		$this->layout = 'main';
		$this->render ( 'joinus', array (
				'model' => $model
		) );
	
	}
	public function actionJobs() {
		$this->render ( 'jobs' );
	}
	public function actionStaffList() {
		if (Yii::app ()->request->isAjaxRequest) {
			@$q = $_GET ['q'];
			@$cityId = $_GET ['cid'];
			
			if (isset ( $cityId ) && is_numeric ( $cityId )) {
			} else {
				$cityId = 1;
			}
			
			$model = new Staff ();
			
			$criteria = new CDbCriteria ();
			$criteria->order = 's_apply_date DESC, s_join_date DESC, id ASC';
			$criteria->addCondition ( 's_city_id=:cid' );
			$criteria->params ['cid'] = $cityId;
			
			$dataProvider = new CActiveDataProvider ( 'Staff', array (
					'pagination' => array (
							'pageSize' => 8 
					),
					'criteria' => $criteria 
			) );
			$this->renderPartial ( '_jobList', array (
					'model' => $model,
					'dataProvider' => $dataProvider 
			), false, true );
			Yii::app ()->end ();
		}
	}
	public function actionTopList() {
		$this->render ( 'topList' );
	}
	
	
	private function urlRedirect(){
		
		
		if (isset(Yii::app()->session['urlReferer'])){
			$this->redirect(Yii::app()->session['urlReferer'],TRUE);
			unset(Yii::app()->session['urlReferer']);
		}else{
			$this->redirect(Yii::app()->user->getReturnUrl(),TRUE);
		}
			
		Yii::app ()->end ();
	}
	
	/**
	 * 微信登录
	 */
	private function weixinLogin(){
			$code = Yii::app()->request->getParam('code');
			
			$accessTokenRlt = UWeChat::getAccessTokenFromCode($code);
// 			Yii::log($accessTokenRlt,CLogger::LEVEL_INFO,'mngr.wechat.access_token');
			$accessTokenRlt = json_decode($accessTokenRlt);
			if (!isset($accessTokenRlt->errcode)){
				$accessToken = $accessTokenRlt->access_token;
				$openId = $accessTokenRlt->openid;
				$unionid = $accessTokenRlt->unionid;
				$userid = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$openId))['wo_user_id'];
// 				Yii::log(Yii::app()->user->isGuest,CLogger::LEVEL_INFO,'mngr.Yii::app()->user->isGuest');
				if (Yii::app()->user->isGuest || Yii::app()->user->id!=$userid){
					
					$loginRlt = WeixinOpenid::model()->loginByOpenId($openId);
					Yii::log(json_encode($loginRlt),CLogger::LEVEL_INFO,'mngr.wechat.loginrlt');
					if ($loginRlt['status']){
						
						$this->urlRedirect();
					} // !if
					
				}else{
					$this->urlRedirect();
				}

				 // !if
			} // !if
	}
	
	
	
	
	
	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		
		

		if (Yii::app ()->request->isAjaxRequest || Yii::app ()->request->isPostRequest) {
		} else {
			$urls = array (
					'urlReferrer' => Yii::app ()->request->urlReferrer,
					'urlCurrent' => Yii::app ()->request->url,
					'urlReturn' => Yii::app ()->user->returnUrl
			);
			Yii::log (Yii::app()->request->hostInfo.yii::app()->request->getUrl(), CLogger::LEVEL_INFO, 'mngr.' . $this->getId () . '.' . $this->getAction ()->getId ()  . '.src');
			Yii::app ()->session ['urlReferer'] = Yii::app ()->request->urlReferrer;
			$src = Yii::app()->request->getParam('src');
			$appType = Yii::app()->request->getParam('appType');
			if ($src == 'weixin'){
				Yii::app()->session['src']='weixin';
				Yii::app()->session['appType']=$appType;
				$code = Yii::app()->request->getParam('code');
				
				$weChat = new UWeChat($appType);
				$appServiceId = $weChat->appServiceId;
				
				Yii::app()->session['appServiceId']=$appServiceId;
				
				$accessTokenRlt =$weChat->getAccessTokenFromCode($code);
				
				if ($accessTokenRlt['status']){
					$openid=  $accessTokenRlt['data']['openid'];
					Yii::app()->session['weiOpenId']=$accessTokenRlt['data']['openid'];
					$loginRlt = WeixinOpenid::model()->loginByOpenId($openid,$appServiceId, Yii::app()->user->id);
					if ($loginRlt['status']){
// 						if ($loginRlt['data']==WeixinOpenid::LOGIN_FIRST){
// 							Yii::app()->user->setFlash('weixinAutologin','您已绑定微信，自动登陆成功');
// 						}
						
						
						
						Yii::app()->user->setFlash('weixinAutologin','您已绑定微信，自动登陆成功');
						$this->urlRedirect();
					}
					
				}
			}
// 			$state = Yii::app()->request->getParam('state');
// 			$state = json_decode($state);
// 			if ($state->src == 'weixin'){
// // 				Yii::log ('weixin.login', CLogger::LEVEL_INFO, 'mngr.' . $this->getId () . '.' . $this->getAction ()->getId ()  . '.src');
// 				Yii::app ()->session ['src'] ='weixin';
// 				$this->weixinLogin();
// 			}
		}
// 		UTool::setCsrfValidator ();
		$model = new LoginForm ();
		$model->setScenario('login');
		
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		if (isset ( $_POST ['LoginForm'] )) {
			// 校验令牌
// 			if (! UTool::checkCsrf ()) {
// // 				echo '非法请求';
// 				throw new CHttpException(500,'非法请求');
// 				Yii::app ()->end ();
// 			}
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate ()) {
				$rltCheck = UTool::checkRepeatAction ( 1 );
				if ($rltCheck ['status']) {
// 					echo CJSON::encode ( $rltCheck );
					Yii::app ()->user->setFlash ( 'loginError', $rltCheck['msg'] );
// 					Yii::app ()->end ();
				}else{
					$rlt = $model->login ();
					if ($rlt['status']) {
						if (Yii::app()->session['src'] == 'weixin'){
							$openid = Yii::app()->session['weiOpenId'];
// 							$weiUser = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$openid));
							$weiUser = WeixinOpenid::model()->getUserByOpenId($openid, Yii::app()->session['appServiceId']);
							if (isset($weiUser)){
								$weiUser['wo_user_id']=Yii::app()->user->id;
								$weiUser->save();
							}
						}
						unset(Yii::app()->session['src'] );
						unset(Yii::app()->session['weiOpenId'] );
						unset(Yii::app()->session['weiOpenId'] );
						unset(Yii::app()->session['appType'] );
						$this->urlRedirect();
					} else {
							Yii::app ()->user->setFlash ( 'loginError', $rlt['msg'] );
					}
					
				} // end if
					
				
			} else{
			Yii::app ()->user->setFlash ( 'loginError','输入未通过验证' );
		}// end if validate
		}

		// display the login form
		$this->render ( 'login', array (
				'model' => $model ,
		) );
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app ()->user->logout ();
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
// 		UTool::clearCsrf ();
		$this->redirect ( Yii::app ()->homeUrl );
	}
}