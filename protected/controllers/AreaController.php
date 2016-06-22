<?php

class AreaController extends Controller
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
				'actions'=>array('index','view','APIs','updateAreas'),
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
	 * 省市区联动用
	 */
	public function actionUpdateAreas()
	{
		$data = Area::model()->findAll('a_city_id=:idCity', array(':idCity'=>(int) $_POST['idCity']));
		$data = CHtml::listData($data,'id','a_name');
		echo "<option value=''>选择区域</option>";
		@$areaIdCookie = $_COOKIE['areaId'];
		$areaIdCookieExsit = isset($areaIdCookie);
		
// 		$areaIdCookie = $_COOKIE['areaId'];
// 		$areaIdCookie =isset($_COOKIE['cityId'])?$_COOKIE['cityId'] : false;
		foreach($data as $value=>$name){
			
			if ($areaIdCookieExsit && $areaIdCookie==$value) {
				echo CHtml::tag('option', array('value'=>$value,'selected'=>'selected'),CHtml::encode($name),true);
			}else{
				echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			}
			
		}
			
	}
	
	/**
	 * 根据城区名称检索城区信息
	 *
	 * @param string $areaName
	 * @return array
	 * @soap
	 */
	public function getAreaInfo($areaName) {
		return CJSON::encode(Area::model()->getAreaInfo($areaName));
	}
	
	/**
	 * 根据城区名称检索城区信息
	 * @param int $cityId
	 * @return string
	 * @soap
	 */
	public function getAreaInfoById($cityId){
		return CJSON::encode(Area::model()->getAreaInfoById($cityId));
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
		$model=new Area;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Area']))
		{
			$model->attributes=$_POST['Area'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * 根据城市信息查找城市
	 * @param int $cityId
	 * @return string json
	 * @soap
	 */
	public function getAreItems($cityId){
	
	
		$rlt = UTool::iniFuncRlt();
		$criteria=new CDbCriteria;
	
		$criteria->select=array('id,a_no,a_name,a_spell,a_city_id');
		$criteria->order='a_spell ASC';
		$areaItems = Area::model()->findAllByAttributes(array('c_city_id'=>$cityId),$criteria);
		$list=array();
		foreach ($areaItems as $i=>$area){
			$list[$i] = array_filter($area->attributes,'strlen');
		}
		$rlt['data'] = $list;
		$rlt['status']=true;
		$rlt['msg']='';
		return CJSON::encode($rlt);
	
	
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

		if(isset($_POST['Area']))
		{
			$model->attributes=$_POST['Area'];
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
		$dataProvider=new CActiveDataProvider('Area');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Area('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Area']))
			$model->attributes=$_GET['Area'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Area the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Area::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Area $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='area-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
