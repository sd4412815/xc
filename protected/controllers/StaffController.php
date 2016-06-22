<?php

class StaffController extends Controller
{
	public function actions()
	{
		return array(
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
						'minLength'=>4,  //最短为4位
						'maxLength'=>6,   //是长为4位
				),
				'APIs'=>array(
						'class'=>'CWebServiceAction',
				),
		);
	}
	

	
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','APIs','login','reg','captcha','reset'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','profile','list','score','eventList','staffWSUpdate'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionList()
	{

	
		$model = new OrderHistory();
		$this->layout='admin_staff';
		@$startTime = $_GET['startTime'];
		@$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria();
		$criteria->order = 'oh_date_time DESC';
		

		
		$criteria->condition="(oh_staff_id1 = :staff1 OR oh_staff_id2 = :staff2)";
		
		$staffId = Staff::model()->findByAttributes(array('s_user_id'=>Yii::app()->user->id))['id'];
		
		$criteria->params[':staff1'] = $staffId;
		$criteria->params[':staff2']=$staffId;
		if (isset($startTime) && isset($endTime)) {
			$criteria->addCondition('oh_date_time>=:start');
			$criteria->addCondition('oh_date_time<=:end');
			$criteria->params[':start'] = $startTime;
			$criteria->params[':end']=$endTime;
		}
		

		$dataProvider = new CActiveDataProvider('OrderHistory',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
		
		if (Yii::app()->request->isAjaxRequest) {
				
				
			$this->renderPartial('_list',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
		
		
		
		$this->render('list',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
		
	}
	
	
	public function actionEventList()
	{
	
	
		$model = new StaffEvent();
		$this->layout='admin_staff';

		
		@$startTime = $_GET['startTime'];
		@$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria();
		$criteria->order = 'se_date_time DESC';
		$criteria->condition="se_user_id = :userId";
		$criteria->params[':userId'] = Yii::app()->user->id;
		if (isset($startTime) && isset($endTime)) {
			$criteria->addCondition('se_date_time>=:start');
			$criteria->addCondition('se_date_time<=:end');
			$criteria->params[':start'] = $startTime;
			$criteria->params[':end']=$endTime;
		}
	
	
		$dataProvider = new CActiveDataProvider('StaffEvent',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
	
		if (Yii::app()->request->isAjaxRequest) {
	
	
			$this->renderPartial('_eventlist',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
	
	
	
		$this->render('eventList',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
	
	}
	
	public function actionScore()
	{
	
		
	$model = new OrderHistory();
		$this->layout='admin_staff';
		@$startTime = $_GET['startTime'];
		@$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria();
		$criteria->order = 'sh_date_time DESC';
		$criteria->addCondition('sh_user_id=:user_id');
		$criteria->params[':user_id']=Yii::app()->user->id;
		if (isset($startTime) && isset($endTime)) {
			$criteria->addCondition('sh_date_time>=:start');
			$criteria->addCondition('sh_date_time<=:end');
			$criteria->params[':start'] = $startTime;
			$criteria->params[':end']=$endTime;
		}
		

		$dataProvider = new CActiveDataProvider('ScoreHistory',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
		
		if (Yii::app()->request->isAjaxRequest) {
				
				
			$this->renderPartial('_score',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
		
		
		
		$this->render('score',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
	}
	
	/**
	 * 更新洗车工所属车行信息
	 * @param array $list 洗车工id列表
	 * @param int $washshopId 车行编号
	 * @return string [state,msg,data]
	 * @soap
	 */
	public function getStaffsUpdate($list,$washshopId){
		$updateRlt = Staff::model()->getStaffsUpdate($list, $washshopId);
		
	return CJSON::encode($updateRlt);
	}
	
	public function actionStaffWSUpdate(){
		
		@$staffId = $_POST['id'];
		@$shopId = $_POST['shopId'];
		
		if (!isset($shopId)) {
			$shopId = 0;
		}
	 $rlt = Staff::model()->getStaffsUpdate(array($staffId),$shopId);
// 		Yii::log(CJSON::encode($rlt),'error','staff.update.washshop');
	 echo  CJSON::encode($rlt);
		
	}
	
	/**
	 * 根据车行信息返回员工列表，默认$washShopId=0返回未分配员工列表
	 * @param int $washshopId 车行Id
	 * @return string 员工列表
	 * @soap
	 */
	public function getStaffs($washshopId=0){
		return CJSON::encode(Staff::model()->getStaffs($washshopId));	
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Staff;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionProfile(){
		$this->layout='admin_staff';
		$this->render('profile');
	
	
	}
	
	/**
	 * Displays the registration page
	 */
	public function actionReg()
	{
	
	
	
		$model=new LoginForm;
		$model->user_type = 1;
	
		$model->setScenario('reg');
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			yii::trace('validate before validation','uc.*');
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				yii::trace('validate pass','uc.*');
				$user_model=new User;
				$user_model->u_tel = $model->u_tel;
				$user_model->u_pwd = CPasswordHelper::hashPassword($model->u_pwd);
				$user_model->u_name=$model->u_tel;
				$user_model->u_score = 0;
				$user_model->u_join_date = date('Y-m-d H:i:s');
				$user_model->u_login_date = date('Y-m-d H:i:s');
				$user_model->u_type = $model->user_type;
	
				if ($user_model->save()){
					// 					$this->render('profile',array('model'=>$model),true);
	
					$staffModel = new Staff();
					$staffModel->s_name = $user_model->u_name;
// 					$bossModel->b_nick_name = $user_model->u_name;
					$staffModel->s_tel = $user_model->u_tel;
					$staffModel->s_pwd = $user_model->u_pwd;
// 					$bossModel->b_type = 0;
					$staffModel->s_user_id = $user_model->id;
					if(!$staffModel->save()){
						Yii::log(CJSON::encode($user_model),'error','user.staff.reg.staff');
					}
						
					$auth = new Assignments();
					$auth->itemname = 'staff';
					$auth->userid  = $user_model->id;
					if($auth->save()){
						Yii::log(CJSON::encode($auth),'error','user.staff.reg.auth');
					}
						
						
						
						
					$lf = new LoginForm();
					$lf->u_tel = $user_model->u_tel;
					$lf->u_pwd = $user_model->u_pwd;
					// 					Yii::log(CJSON::encode($model),'error','user.*');
					if ($model->login()) {
						Yii::log(CJSON::encode($lf),'error','user.*');
						$this->redirect(array('profile'));
					}
	
				}
			}
	
		}
		// display the login form
		$this->render('//user/reg',array('model'=>$model));
	}
	
	

	/**
	 * Displays the registration page
	 */
	public function actionReset()
	{
	
	
	
		$model=new LoginForm;
		$model->user_type = 1;
	
		$model->setScenario('reset');
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			yii::trace('validate before validation','uc.*');
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				// 				yii::trace('validate pass','uc.*');
				$user_model = User::model()->findByAttributes(array(
						'u_tel'=>$model->u_tel,
				));
	
	
				$user_model->u_pwd = CPasswordHelper::hashPassword($model->u_pwd);
					
				$user_model->u_login_date = date('Y-m-d H:i:s');
				// 				$user_model->u_type = $model->user_type;
	
				if ($user_model->save()){
					// 					$this->render('profile',array('model'=>$model),true);
	
					$lf = new LoginForm();
					$lf->u_tel = $user_model->u_tel;
					$lf->u_pwd = $user_model->u_pwd;
					// 					Yii::log(CJSON::encode($model),'error','user.*');
					if ($model->login()) {
						// 						Yii::log(CJSON::encode($lf),'error','user.*');
						$this->redirect(array('profile'));
					}
	
	
	
	
	
	
	
				}
			}
	
		}
		// display the login form
		$this->render('//user/reset',array('model'=>$model));
	}
	
	
	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$model = new LoginForm ();
		$model->user_type = 1;
		// 		$model->setScenario('boss');
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'login-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	
		// collect user input data
		if (isset ( $_POST ['LoginForm'] )) {
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate () && $model->login ())
				$this->redirect ( Yii::app ()->createUrl('staff/profile') );
		}
		// display the login form
		$this->render ( '//site/login', array (
				'model' => $model
		) );
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Staff');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Staff('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Staff']))
			$model->attributes=$_GET['Staff'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Staff the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Staff::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Staff $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
