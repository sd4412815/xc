<?php

class CityController extends Controller
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
	public $layout='main';

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
				'actions'=>array('index','view','APIs','updateCities','UpdateJoinForm','choose'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','joinStd'),
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
	 * 根据城市id获取加盟费设置表单
	 * @param int $cid
	 * @throws CHttpException
	 */
	public function actionUpdateJoinForm($cid){
	    $model = new JoinPriceForm();
	        $rlt = $model->load($cid);
	        $model = $rlt['data'];
	    $this->renderPartial('_joinStdForm',array('model'=>$model),false,true);
	}
	
	/**
	 * 修改城市加盟信息
	 * @param int $id 城市id
	 * @throws CHttpException
	 */
	public function actionJoinStd()
	{ 
// 	    Yii::app ()->user->setFlash ( 'joinError','dd');
// 	    $id=1;
	    $this->layout = 'admin_mngr';
	    $model = new JoinPriceForm();
// 	    $model->cid = $id;
	    

	    if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'join-price-form') {
	        echo CActiveForm::validate ( $model );
	        Yii::app ()->end ();
	    }
	    
	    // collect user input data
	    if (isset ( $_POST ['JoinPriceForm'] )) {
	        $model->attributes = $_POST ['JoinPriceForm'];
	        if ($model->validate ()) {

	            $joinSetRlt = $model->save();
	            Yii::app ()->user->setFlash ( 'joinError', $joinSetRlt ['msg']);
	        } // end if validator
	       
	        $this->renderPartial('_joinStdForm',array('model'=>$model),false,true);
	        Yii::app ()->end ();
	    }

// // 	    if()
	    $rlt = $model->load(1);
// 	    if (!$rlt['status']){
// 	        $model->pid = 1;
// 	        $model->cid = 1;
// 	        $rlt = $model->load(1);
// // 	        throw new CHttpException('404','');
// // 	    }else{
	        
// // 	    }
	    $model = $rlt['data'];
// 	    $model->pid = 1;
	    $model->cid = 1;
	    $this->render('joinStd',array('model'=>$model));
	    
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
	
	public function actionChoose()
	{
		$this->layout = 'main_simple';
		$this->render('choose');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new City;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['City']))
		{
			$model->attributes=$_POST['City'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 根据城市名称检索城市信息
	 *
	 * @param string $cityName
	 * @return string json
	 * @soap
	 */
	public function getCityInfo($cityName) {
		return CJSON::encode(City::model()->getCityInfo($cityName));
	}
	
	/**
	 * 根据城市id检索城市信息
	 * @param int $cityId
	 * @return string
	 * @soap
	 */
	public function getCityInfoById($cityId){
		return CJSON::encode(City::model()->getCityInfoById($cityId));
	}
	
	/**
	 * 根据城市信息获取服务类型
	 * @param int $cityId
	 * @param int $type 1车 2大车 0不限
	 * @return string
	 * @soap
	 */
	public function getServiceTypes($cityId){
		return CJSON::encode(City::model()->getServiceTypes($cityId));
	}
	
	/**
	 * 根据省份信息查找城市
	 * @param int $provinceId
	 * @return string json
	 * @soap
	 */
	public function getCityItems($provinceId){

	
	$rlt = UTool::iniFuncRlt();
	$criteria=new CDbCriteria;
	
	$criteria->select=array('id,c_no,c_name,c_spell,c_province_id');
	$criteria->order='c_spell ASC';
	$cityItems = City::model()->findAllByAttributes(array('c_province_id'=>$provinceId),$criteria);
	$list=array();
	foreach ($cityItems as $i=>$city){
		$list[$i] = array_filter($city->attributes,'strlen');
	}
	$rlt['data'] = $list;
	$rlt['status']=true;
	$rlt['msg']='';
	return CJSON::encode($rlt);
	
	
	}
	

	

	/**
	 * 省市区联动用
	 */
	public function actionUpdateCities()
	{
		//Cities
		$data = City::model()->findAll('c_province_id=:idProvince', array(':idProvince'=>(int) $_POST['idProvince']));
		$data = CHtml::listData($data,'id','c_name');
		$dropDownCities = "<option value=''>选择城市</option>";
		
		@$cityIdCookie = $_COOKIE['cityId'];
		$cityIdCookieExsit = isset($cityIdCookie);
// 		$cityIdCookie =isset($_COOKIE['cityId'])?$_COOKIE['cityId'] : false;
		
		
		$needUpdateArea=false;
		foreach($data as $value=>$name){
			
			if ($cityIdCookieExsit && $cityIdCookie==$value) {
				$dropDownCities .= CHtml::tag('option', array('value'=>$value,'selected'=>'selected'),CHtml::encode($name),true);
				$needUpdateArea=true;
			}else 
			{
				$dropDownCities .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			}
			
			
		}
		//District
		if ($needUpdateArea) {
		$data1 = Area::model()->findAll('a_city_id=:idCity', array(':idCity'=>$cityIdCookie));
		$data1 = CHtml::listData($data1,'id','a_name');
		$dropDownAreas ="<option value=''>选择区域</option>";
		@$areaIdCookie = $_COOKIE['areaId'];
		$areaIdCookieExsit = isset($areaIdCookie);
		
		foreach($data1 as $value1=>$name1){
			
			if ($areaIdCookieExsit && $areaIdCookie==$value1) {
				$dropDownAreas.= CHtml::tag('option', array('value'=>$value1,'selected'=>'selected'),CHtml::encode($name1),true);
			}else{
				$dropDownAreas.= CHtml::tag('option', array('value'=>$value1),CHtml::encode($name1),true);
			}
			
		}
		}else {
			$dropDownAreas = "<option value='null'>选择区域</option>";
		}
		
		
		
	
		// return data (JSON formatted)
		echo CJSON::encode(array(
				'dropDownCities'=>$dropDownCities,
				'dropDownAreas'=>$dropDownAreas
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

		if(isset($_POST['City']))
		{
			$model->attributes=$_POST['City'];
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
		$dataProvider=new CActiveDataProvider('City');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new City('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['City']))
			$model->attributes=$_GET['City'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return City the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=City::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param City $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
