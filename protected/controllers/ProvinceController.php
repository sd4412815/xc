<?php

class ProvinceController extends Controller
{
	public function actions()
	{
		return array(
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
				'actions'=>array('index','view','APIs'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Province;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Province']))
		{
			$model->attributes=$_POST['Province'];
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

		if(isset($_POST['Province']))
		{
			$model->attributes=$_POST['Province'];
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
		$dataProvider=new CActiveDataProvider('Province');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * 根据省份名称检索省份信息
	 * @param string $provinceName
	 * @return string json
	 * @soap
	 */
	public function getProvinceInfo($provinceName) {
		return CJSON::encode(Province::model()->getProvinceInfo($provinceName));
	}
	/**
	 * 根据省份id检索省份信息
	 * @param int $provinceId
	 * @return string
	 */
	public function getProvinceInfoById($provinceId){
		return CJSON::encode(Province::model()->getProvinceInfoById($provinceId));
	}
	
	/**
	 * 根据省份信息
	 * @return string json
	 * @soap
	 */
	public function getProvinceAreItems(){
	
	
		$rlt = UTool::iniFuncRlt();
		$criteria=new CDbCriteria;
	
		$criteria->select=array('id,p_no,p_name,p_spell');
		$criteria->order = 'p_spell  ASC' ;//排序条件
		$areaItems = Province::model()->findAll($criteria);
		$list=array();
		foreach ($areaItems as $i=>$province){
			$list[$i] = array_filter($province->attributes,'strlen');
		}
		$rlt['data'] = $list;
		$rlt['status']=true;
		$rlt['msg']='';
		return CJSON::encode($rlt);
	
	
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Province('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Province']))
			$model->attributes=$_GET['Province'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Province the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Province::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Province $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='province-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
