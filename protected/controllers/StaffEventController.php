<?php

class StaffEventController extends Controller
{
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','add'),
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

	public function actionAdd()
	{
		$model = new StaffEvent();
		@$etype = $_POST['etype'];
		@$edesc = $_POST['edesc'];
		@$start = $_POST['startTime'];
		@$end = $_POST['endTime'];
		@$staffId= $_POST['estaff'];
		

		

		// collect user input data
		if (isset ($etype) && isset($edesc) && isset($start) && isset($end)) {
			// 			$model->attributes = $_POST ['StaffEvent'];
			$model->se_type = $etype;
			$model->se_desc = $edesc;
			$model->se_date_time = date('Y-m-d H:i:s',strtotime($start));
			$model->se_date_time_end = date('Y-m-d H:i:s',strtotime($end));
			
			if (!isset($staffId)){
				$staff = Staff::model()->findByAttributes(array('s_user_id'=>Yii::app()->user->id));
				
			}else {
				$staff = Staff::model()->findByPk($staffId);
				
			}
			
			$model->se_staff_id = $staff['id'];
			$model->se_wash_shop_id = $staff['s_wash_shop_id'];
			$model->se_user_id = Yii::app()->user->id;
			// validate user input and redirect to the previous page if valid
			if ($model->validate () && $model->save ()){
				// 				$this->redirect ( Yii::app ()->user->returnUrl );
		
			}
			Yii::log(CJSON::encode($model),'error','staff.event.add');
		
		
		}
		// 		Yii::log(CJSON::encode($_POST),'error','staff.event.add');
	}
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new StaffEvent;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StaffEvent']))
		{
			$model->attributes=$_POST['StaffEvent'];
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

		if(isset($_POST['StaffEvent']))
		{
			$model->attributes=$_POST['StaffEvent'];
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StaffEvent');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StaffEvent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StaffEvent']))
			$model->attributes=$_GET['StaffEvent'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StaffEvent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StaffEvent::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StaffEvent $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
