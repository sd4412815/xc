<?php
class UserController extends Controller {
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array (
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha' => array (
						'class' => 'CCaptchaAction',
						'backColor' => 0xFFFFFF,
						'minLength' => 4, // 最短为4位
						'maxLength' => 6  // 是长为4位
								),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page' => array (
						'class' => 'CViewAction' 
				) 
		);
	}
	public $layout = 'main_simple';
	
	/**
	 *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *      using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/column2';
	
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete'  // we only allow deletion via POST request
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
								'reg',
								'captcha',
								'reset',
								'resetCheck',
// 								'resetPWD',
// 								'resetOK' 
						),
						'users' => array (
								'*' 
						) ,
				),
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (
								'Profile',
								'list',
								'score',
								'OrderView',
								'card',
								'favorite',
								
								'info',
								'safe' 
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
	public function actionList() {
		$model = new OrderHistory ();
		$this->layout = 'admin_user';
		@$startTime = $_GET ['startTime'];
		@$endTime = $_GET ['endTime'];
		$criteria = new CDbCriteria ();
		$criteria->order = 'oh_date_time DESC';
		$criteria->addCondition ( 'oh_user_id=:user_id' );
		$criteria->params [':user_id'] = Yii::app ()->user->id;
		if (isset ( $startTime ) && isset ( $endTime )) {
			$criteria->addCondition ( 'oh_date_time>=:start' );
			$criteria->addCondition ( 'oh_date_time<=:end' );
			$criteria->params [':start'] = $startTime;
			$criteria->params [':end'] = $endTime;
		}
		
		$dataProvider = new CActiveDataProvider ( 'OrderHistory', array (
				'pagination' => array (
						'pageSize' => 30, 
				),
				'criteria' => $criteria 
		) );
		
// 		if (Yii::app ()->request->isAjaxRequest) {
			
// 			$this->renderPartial ( '_list', array (
// 					'model' => $model,
// 					'dataProvider' => $dataProvider 
// 			), false, true );
// 			Yii::app ()->end ();
// 		}
		
		$this->render ( 'list', array (
				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
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
	public function actionFavorite() {
		$this->layout = 'admin_user';
		$this->render ( 'favorite' );
	}
	public function actionInfo() {
		$model = $this->loadModel(Yii::app()->user->id);
// 		$model = new LoginForm ();
		$model->setScenario ( 'update' );

		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'user-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['User'] )) {
			// 校验令牌
			if (false && ! UTool::checkCsrf ()) {
				throw new CHttpException(500,'错误请求');
				Yii::app ()->end ();
			}
			$model->attributes = $_POST ['User'];
			if ($model->validate ()) {
				$rltCheck = UTool::checkRepeatAction ( 0 );
				if ($rltCheck ['status']) {
					// echo CJSON::encode($rltCheck);
					Yii::app ()->user->setFlash ( 'userInfo', $rltCheck ['msg'] );
					// Yii::app()->end();
				} else {
					if ($model->save()) {
						Yii::app()->user->setState('_nickName',$model['u_nick_name']);
						$msg =new  Message();
						$msg['m_datetime']=date('Y-m-d H:i:s');
						$msg['m_user_id'] = Yii::app ()->user->id ;
						$msg['m_level']= Message::LEVEL_URGENCY;
						
						$msg['m_content']='您更新了个人资料';
						$msg['m_type']=Message::TYPE_ACCOUNT;
						$msg['m_src']=UTool::getRequestInfo();
						$msg->save();
						Yii::app ()->user->setFlash ( 'userInfo', '个人信息更新成功' );
					

					}
					 else {
						Yii::app ()->user->setFlash ( 'userInfo', '个人信息更新失败' );
					}
					$this->refresh(true);
				}
			} // end if validator
		}
		
		$this->layout = 'admin_user';
		$this->render ( 'info',array('model'=>$model) );
	
	}
	public function actionSafe() {
		$this->layout = 'admin_user';
// 		$this->render ( 'safe' );
// 		$this->redirect('user/reset');
		Yii::app()->clientScript->registerScript('ready',"
		 $('#menuUserSafe').addClass('active');
",CClientScript::POS_READY);
		$this->actionReset('重设密码');
	
		
		
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new User ();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['User'] )) {
			$model->attributes = $_POST ['User'];
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
	private function urlRedirect() {
		if (isset ( Yii::app ()->session ['urlReturn'] )) {
			// Yii::log (Yii::app()->session['urlReturn'], CLogger::LEVEL_INFO, 'mngr.' . $this->getId () . '.' . $this->getAction ()->getId () . '.src');
			$this->redirect ( Yii::app ()->session ['urlReturn'], TRUE );
		} else if (isset ( Yii::app ()->session ['urlReferer'] )) {
			$this->redirect ( Yii::app ()->session ['urlReferer'], TRUE );
			unset ( Yii::app ()->session ['urlReferer'] );
		} else {
			$this->redirect ( Yii::app ()->user->getReturnUrl (), TRUE );
		}
		Yii::app ()->end ();
	}
	/**
	 * 车主注册
	 */
	public function actionReg() {
		if (Yii::app ()->request->isAjaxRequest || Yii::app ()->request->isPostRequest) {
		} else {
			if (strcmp( Yii::app ()->request->urlReferrer,Yii::app()->createAbsoluteUrl('site/login')) ==0){
				Yii::app()->session['urlReturn'] = Yii::app()->session['urlReferer'];
				// 				Yii::log (Yii::app()->session['urlReturn'], CLogger::LEVEL_INFO, 'mngr.' . $this->getId () . '.' . $this->getAction ()->getId ()  . '.src');
			}else{
				unset(Yii::app()->session['urlReturn'] );
			}
			
			$urls = array (
					'urlReferrer' => Yii::app ()->request->urlReferrer,
					'urlCurrent' => Yii::app ()->request->url,
					'urlReturn' => Yii::app ()->user->returnUrl
			);
			Yii::log ( CJSON::encode ( $urls ), CLogger::LEVEL_INFO, 'mngr.' . $this->getId () . '.' . $this->getAction ()->getId ()  . 'src');
			Yii::app ()->session ['urlReferer'] = Yii::app ()->request->urlReferrer;
			$src = Yii::app()->request->getParam('src');
			if ($src == 'weixin'){
				Yii::app()->session['src']='weixin';
				$code = Yii::app()->request->getParam('code');
				$accessTokenRlt = UWeChat::getAccessTokenFromCode($code);
			
				if ($accessTokenRlt['status']){
					$openid=  $accessTokenRlt['data']['openid'];
					Yii::app()->session['weiOpenId']=$accessTokenRlt['data']['openid'];
					$loginRlt = WeixinOpenid::model()->loginByOpenId($openid, Yii::app()->user->id);	
					if ($loginRlt['status']){
// 						if ($loginRlt['data']==WeixinOpenid::LOGIN_FIRST){
// 							Yii::app()->user->setFlash('weixinAutologin','您已绑定微信，自动登陆成功');
// 						}
						Yii::app()->user->setFlash('weixinAutologin','您已绑定微信，自动登陆成功');
						$this->urlRedirect();
					}
				}
			}
		}
		$model = new LoginForm ();
		$model->setScenario ( 'reg' );
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
// 			// 校验令牌
// 			if (! UTool::checkCsrf ()) {
// 				echo '错误请求';
// 				Yii::app ()->end ();
// 			}
			$model->attributes = $_POST ['LoginForm'];
			if ($model->validate ()) {
// 				$rltCheck = UTool::checkRepeatAction ( 10 );
// 				if ($rltCheck ['status']) {
// 					// echo CJSON::encode($rltCheck);
// 					Yii::app ()->user->setFlash ( 'regError', $rltCheck ['msg'] );
// 					// Yii::app()->end();
// 				} else {
					$regRlt = User::model ()->reg ( $model );
					if ($regRlt ['status']) {
						if (Yii::app()->session['src'] == 'weixin'){
							$openid = Yii::app()->session['weiOpenId'];
							$weiUser = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$openid));
							if (isset($weiUser)){
								$weiUser['wo_user_id']=Yii::app()->user->id;
								$weiUser->save();
							}
						}
						unset(Yii::app()->session['mobile_code'] );
						unset(Yii::app()->session['src'] );
						unset(Yii::app()->session['weiOpenId'] );
						$this->urlRedirect();
					} else {
						Yii::app ()->user->setFlash ( 'regError', $regRlt ['msg'] . '，请稍后重试' );
					}
// 				}
			} // end if validator
		}
		// 显示登录表单
		$this->layout = 'main_simple';
		$this->render ( 'reg', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Displays the registration page
	 */
	public function actionReset($atype="找回密码") {
		
		unset(Yii::app()->session['resetStep']);
		unset(Yii::app()->session['resetUserId']);
		unset(Yii::app()->session['resetUserTel']);
		$model = new LoginForm ();
		$model->setScenario ( 'reset' );
		
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			// 校验令牌
			if (FALSE && ! UTool::checkCsrf ()) {
				throw new CHttpException ( 403, '错误请求' );
				Yii::app ()->end ();
			}
			
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate () ) {
				
				$rltCheck = UTool::checkRepeatAction ( 0 );
				if ($rltCheck ['status']) {
					// echo CJSON::encode($rltCheck);
					Yii::app ()->user->setFlash ( 'resetError', $rltCheck ['msg'] );
					// Yii::app()->end();
				} else {
					$user_model = User::model ()->getUserByLoginName ( $model->u_tel );
					
					if (! isset ( $user_model )) {
						Yii::app ()->user->setFlash ( 'resetError', '该用户不存在' );
					} else {
						Yii::app ()->session ['resetUserId'] = $user_model ['id'];
						Yii::app ()->session ['resetUserTel'] = $model ['u_tel'];
						Yii::app ()->session ['resetStep'] = 'resetCheck';
						Yii::app ()->session ['resetCheckOn'] = true;
						$model->setScenario ( 'resetCheck' );
						
						$this->render ( 'resetCheck', array (
								'model' => $model ,
								'atype'=>$atype,
						) );
						// $this->redirect(array('user/resetCheck'));
						Yii::app ()->end ();
					} // end if user_model
				} // end if checkRepeat
			} else {
				Yii::app ()->user->setFlash ( 'resetError', '输入未通过验证' );
			} // end if validation
		}
		// display the login form
		$this->render ( 'reset', array (
				'model' => $model ,
				'atype'=>$atype,
		) );
	}
	
	/**
	 * Displays the registration page
	 */
	public function actionResetCheck($atype="找回密码") {
		$step = Yii::app ()->session ['resetStep'];
		$model = new LoginForm ();
		if (! (isset ( Yii::app ()->session [$step . 'On'] ) && Yii::app ()->session [$step . 'On'])) {
			throw new CHttpException ( 403, '错误请求' );
			return;
		}
		
		if (isset ( Yii::app ()->session ['resetStep'] )) {
			$model->setScenario ( Yii::app ()->session ['resetStep'] );
		} else {
			
			$model->setScenario ( 'resetCheck' );
		}
		
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			// 校验令牌
			if (! UTool::checkCsrf () || ! isset ( Yii::app ()->session ['resetUserId'] )) {
				throw new CHttpException ( 403, '错误请求' );
				Yii::app ()->end ();
			}
			
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate ()) {
				
				$rltCheck = UTool::checkRepeatAction ( 0 );
				if ($rltCheck ['status']) {
					Yii::app ()->user->setFlash ( 'resetCheckError', $rltCheck ['msg'] );
				} else {
					
					$user_model = User::model ()->findByPk ( Yii::app ()->session ['resetUserId'] );
					if (! isset ( $user_model )) {
						Yii::app ()->user->setFlash ( 'resetCheckError', '该用户不存在' );
					} else {
						// $model->smsCode = '';
						if (Yii::app ()->session ['resetStep'] == 'resetCheck') {
							unset ( Yii::app ()->session ['resetCheckOn'] );
							Yii::app ()->session ['resetStep'] = 'resetPWD';
							Yii::app ()->session ['resetPWDOn'] = true;
							$model->setScenario ( 'resetPWD' );
							$this->render ( 'resetPWD', array (
									'model' => $model ,'atype'=>$atype,
							) );
// 							$this->refresh(true);
							Yii::app ()->end ();
						} elseif (Yii::app ()->session ['resetStep'] == 'resetPWD') {
						
							
							unset ( Yii::app ()->session ['resetPWDOn'] );
							unset ( Yii::app ()->session ['resetUserId'] );
							unset ( Yii::app ()->session ['resetUserTel'] );
							
							$user_model['u_pwd'] = CPasswordHelper::hashPassword($model->u_pwd);
							$user_model['u_error_count']=0;
							if (!$user_model->save()) {
								throw new CHttpException ( 500, '对不起，服务器修改密码失败，请稍后重试' );
								Yii::app ()->end ();
							}else{
							    $msg =new  Message();
							    $msg['m_datetime']=date('Y-m-d H:i:s');
							    $msg['m_user_id'] = Yii::app ()->session ['resetUserId'] ;
							    $msg['m_level']=Message::LEVEL_URGENCY;
							    $msg['m_content']='您在设备'.Yii::app()->request->userHostAddress.'上修改密码成功';
							    $msg['m_src']=UTool::getRequestInfo();
							    $msg['m_type']=Message::TYPE_ACCOUNT;
							}
							Yii::app ()->session ['resetStep'] = 'resetOk';
							Yii::app ()->session ['resetOkOn'] = true;
							$msg['m_type']=0;
							$msg->save();
								
							$this->render ( 'resetOk',array('atype'=>$atype) );
// 							$this->refresh(true);
							Yii::app ()->end ();
						}
					} // end if user_model
				} // end if checkRepeat
			} else {
				Yii::app ()->user->setFlash ( 'resetCheckError', '验证码未通过验证' );
			} // end if validation
		}
		// display the login form
		$this->render ( 'resetCheck', array (
				'model' => $model,
'atype'=>$atype,
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
		
		if (isset ( $_POST ['User'] )) {
			$model->attributes = $_POST ['User'];
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
		$dataProvider = new CActiveDataProvider ( 'User' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionProfile() {
		$model = $this->loadModel(Yii::app()->user->id);
		Yii::log(CJSON::encode($model),CLogger::LEVEL_INFO,'mngr.userC.profile');
		$this->layout = 'admin_user';
		$this->render ( 'profile',array('user'=>$model));
	}
	public function actionCard() {
		
		// $boss = Boss::model()->findByAttributes(array(
		// 'b_user_id'=>Yii::app()->user->id,
		// ));
		
		// $shop = $boss->washShop;
		// $shopId = $shop['id'];
		$model = new Cardinvite ();
		
		$criteria = new CDbCriteria ();
		
		$criteria->order = 'ci_date_end ASC, id ASC';
		$criteria->addCondition ( 'ci_owner=:id' );
		$criteria->params [':id'] = Yii::app ()->user->id;
		
		$dataProvider = new CActiveDataProvider ( 'Cardinvite', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
		$this->layout = 'admin_user';
		$this->render ( 'card', array (
				'dataProvider' => $dataProvider 
		) );
	}
	public function actionScore() {
		
// 		$model = new OrderHistory ();
		$this->layout = 'admin_user';

		$criteria = new CDbCriteria ();
		$criteria->order = 'sh_date_time DESC';
		$criteria->addCondition ( 'sh_user_id=:user_id' );
		$criteria->params [':user_id'] = Yii::app ()->user->id;

		
		$dataProvider = new CActiveDataProvider ( 'ScoreHistory', array (
				'pagination' => array (
						'pageSize' => Yii::app ()->params ['pageSize'] 
				),
				'criteria' => $criteria 
		) );
		
// 		if (Yii::app ()->request->isAjaxRequest) {
			
// 			$this->renderPartial ( '_score', array (
// 					'model' => $model,
// 					'dataProvider' => $dataProvider 
// 			), false, true );
// 			Yii::app ()->end ();
// 		}
		
		$this->render ( 'score', array (
// 				'model' => $model,
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new User ( 'search' );
		$model->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['User'] ))
			$model->attributes = $_GET ['User'];
		
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
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
	
		if (!is_int((int)$id) || $id<=0) {
			$model = null;
		}else{
			$model = User::model ()->findByPk ( $id );
		}
		if ($model === null)
			throw new CHttpException ( 404, '访问页面不存在');
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 *
	 * @param User $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'user-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
