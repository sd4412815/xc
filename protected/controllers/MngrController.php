<?php

class MngrController extends Controller
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
	public $layout='admin_mngr';

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
				array (
						'allow',
						'actions' => array (
								'profile','si','sit','st','sti','shopList','Orderlist',
						),
						'roles' => array (
								'administrator'
						)
					
				),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','shopAdd',
						'shopCheck','shopReport','shopCheck','shopOnline',
				'shopUpdate',
						'UpdateFromTemp','stItems','stItemsRemove','stItemsAdd','card','wsInfo','wsP','ShopServiceList'),
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
	
	
	public function actionWsP($id){
		$model = $this->loadModel($id);
		$this->layout = 'main_map';
		$this->render('wsP',array('model'=>$model));
		
	}
	
	
	/**
	 * 更新车行信息
	 * @param int $id
	 */
	public function actionWsInfo($id){
		
		$model = $this->loadModel($id);
		$this->layout='admin_mngr';
		if (!Yii::app()->request->isAjaxRequest) {
// 			Yii::app ()->end ();
		}
		$user = User::model()->findByPk($model['ws_boss_id']);
		$boss = Boss::model()->findByAttributes(array('b_user_id'=>$model['ws_boss_id']));
		$this->render('wsInfo',array('model'=>$model,'boss'=>$boss,'user'=>$user,'editable'=>''));
		
		
	}
	
	public function actionShopServiceList(){
		
		$this->layout='admin_mngr';
// 		if (!Yii::app()->request->isAjaxRequest) {
// 			Yii::app()->end();
// 		}
	
		$model = new ShopPay();
		
	
		$criteria = new CDbCriteria();
		$criteria->order = 'sp_datetime DESC';
// 		$shopId = UTool::getShop()['id'];
// 		$criteria->addCondition('sp_shop_id = :shopId');
// 		$criteria->params[':shopId'] = $shopId;
	
		$dataProvider = new CActiveDataProvider('ShopPay',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
		
	
	
		$this->render('shopServiceList',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider),false,true);
	
	}
	

// 	public  $Layout = 'admin_mngr';
	public function actionShopUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->layout='admin_mngr';
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'ws-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['WashShop'] )) {
			$model->attributes = $_POST ['WashShop'];
			// validate user input and redirect to the previous page if valid
// 				Yii::log(CJSON::encode($_POST['WashShop']),'error','mngr.shop.update');
// 				Yii::log(CJSON::encode($model),'error','mngr.shop.update');
// 				$model['ws_desc'] = $_POST['WashShop']['ws_desc'];
			if ($model->validate () && $model->save ()){
				// 				$this->redirect ( Yii::app ()->user->returnUrl );
				$model->ws_count = $model->getServiceCount($id)['data'];
				$model->save();
				Yii::app()->user->setFlash('success','车行信息更新成功');
			}
			// 			else {
			// 				$model->scenario="loginError";
			// 			}
		
		}
		
		$this->render('shopUpdate',array('model'=>$model));
	}

	
	public function actionProfile(){
		
		$user= User::model()->findByPk(Yii::app()->user->id);
		$this->layout='admin_mngr';
		$this->render('profile',array('user'=>$user));
	
	
	}
	

	public function actionCard()
	{
	
// 		$boss = Boss::model()->findByAttributes(array(
// 				'b_user_id'=>Yii::app()->user->id,
// 		));
	
// 		$shop = $boss->washShop;
// 		$shopId = $shop['id'];
	
	
	
		$model = new CardGenHistory();
	
	
		$criteria = new CDbCriteria();
	
	
	
		$criteria->order = 'cgh_date DESC';
// 		$criteria->addCondition('cgh_shop_id=:id');
// 		$criteria->params[':id']=$shopId;
			
	
		$dataProvider = new CActiveDataProvider('CardGenHistory',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
	
		$this->layout='admin_mngr';
		$this->render('card',array('dataProvider'=>$dataProvider));
	}
	
	
	public function actionShopList(){
	
		$model = new WashShop();
		$this->layout='admin_mngr';
// 		@$startTime = $_GET['startTime'];
// 		@$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria();
// 		$criteria->order = 'ws_province_id ASC, ws_city_id ASC, ws_area_id ASC,   ws_no ASC';
// 		$criteria->addCondition('oh_user_id=:user_id');
// 		$criteria->params[':user_id']=Yii::app()->user->id;
// 		if (isset($startTime) && isset($endTime)) {
// 			$criteria->addCondition('oh_date_time>=:start');
// 			$criteria->addCondition('oh_date_time<=:end');
// 			$criteria->params[':start'] = $startTime;
// 			$criteria->params[':end']=$endTime;
// 		}
		

		$dataProvider = new CActiveDataProvider('WashShop',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		    'sort' => array (
		        'defaultOrder' => ' ws_join_date DESC',
		        'attributes' => array (
		    
		            'all' => array (
		                'asc' => 'ws_province_id ASC, ws_city_id ASC, ws_state ASC, ws_join_date ASC',
		                'desc' => 'ws_province_id DESC,ws_city_id DESC,ws_state ASC, ws_join_date DESC'
		            ),
		            'join' => array (
		                'asc' => 'ws_join_date ASC',
		                'desc' => 'ws_join_date DESC'
		            ),
		            'level' => array (
		                'asc' => 'ws_level ASC',
		                'desc' => 'ws_level DESC'
		            ),
		            'score' => array (
		                'asc' => 'ws_score ASC',
		                'desc' => 'ws_score DESC'
		            ),
		            'province' => array (
		                'asc' => 'ws_province_id ASC',
		                'desc' => 'ws_province_id DESC'
		            ),
		            'city' => array (
		                'asc' => 'ws_city_id ASC',
		                    'desc' => 'ws_city_id DESC'
		                    ),
		            'state' => array (
		                'asc' => 'ws_state ASC',
		                'desc' => 'ws_state DESC'
		            )
		        )
		    )
		));
		
		if (Yii::app()->request->isAjaxRequest) {
				
				
			$this->renderPartial('_shopList',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
		
		
		
		$this->render('shopList',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
	}
	
	public function actionAjaxShopList()
	{
		$data = array();
		
	}
	
	public function actionShopAdd(){
		$this->layout='admin_mngr';
		$this->render('shopAdd');
	
	
	}
	public function actionShopCheck(){
		$this->layout='admin_mngr';
		$this->render('shopCheck');
	
	
	}
	public function actionShopReport(){
		$this->layout='admin_mngr';
		$this->render('shopReport');
	
	
	}
	
	public function actionShopOnline(){
		$this->layout='admin_mngr';
		$this->render('shopOnline');
	
	
	}
	
	
	private   $_cityId;
	public function actionSI(){
	
		$model = new ServiceItem();
		$this->layout='admin_mngr';
		@$idProvince = $_POST['idProvince'];
		@$idCity = $_POST['idCity'];
// 		@$carType = $_GET['idCarType'];
		
		$criteria = new CDbCriteria();
		$criteria->order = 'id ASC, si_state ASC';
		
		if (isset($idCity)) {
			$_cityId = $idCity;
			$criteria->addCondition('si_city_id=:cityId');
			$criteria->params[':cityId']=$idCity;
		}else if (isset($_cityId)) {
			$criteria->addCondition('si_city_id=:cityId');
			$criteria->params[':cityId']=$_cityId;
		}
// 		$criteria->addCondition('id=4');

		@$id = $_POST['siid'];
		if (Yii::app()->request->isAjaxRequest && isset($id)) {
			$simodel = ServiceItem::model()->findByPk($id);
			
			if (isset($simodel)) {
				if (isset($_POST['sivalue'])) {
					$simodel['si_value']=$_POST['sivalue'];
				}
				if (isset($_POST['siscore'])) {
					$simodel['si_score']=$_POST['siscore'];
				}
				if (isset($_POST['sitime'])) {
					$simodel['si_time']=$_POST['sitime'];
				}
				if (isset($_POST['sistate'])) {
					$simodel['si_state']=$_POST['sistate'];
				}
				if (isset($_POST['sicity'])) {
					$simodel['si_city_id']=$_POST['sicity'];
				}
					Yii::log('dd','error','mngr.si.update');
				if ($simodel->save()){
					Yii::log('更新成功','error','mngr.si.update');
					Yii::app()->user->setFlash('siUpdateSuccess','更新服务条目信息成功');
				}
			}
		
		}
		

		$dataProvider = new CActiveDataProvider('ServiceItem',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
		
		if (Yii::app()->request->isAjaxRequest) {
				

			$this->renderPartial('_siList',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
		
		
		
		$this->render('si',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
	
	
	}
	

	public function actionUpdateFromTemp(){
	
		$model = new ServiceItem();
		$this->layout='admin_mngr';
		@$idProvince = $_POST['idProvince'];
		@$idCity = $_POST['idCity'];
		@$isReset = $_POST['reset'];
// 		$isReset = true;
		
		if (!isset($isReset)) {
			$isReset = false;
		}
		// 		@$carType = $_GET['idCarType'];
	
		$criteria = new CDbCriteria();
		$criteria->order = 'si_city_id ASC, si_order ASC, si_state ASC , id ASC';
	
		if (isset($idCity)) {
			ServiceItem::model()->UpdateFromTemplate($idCity,$isReset);
			$criteria->addCondition('si_city_id=:cityId');
			$criteria->params[':cityId']=$idCity;
		}
		else {
			ServiceItem::model()->UpdateFromTemplate($reset = $isReset);
		}
		
	
	
	
	
	
		$dataProvider = new CActiveDataProvider('ServiceItem',array(
				'pagination'=>array(
						'pageSize'=>Yii::app()->params['pageSize'],
				),
				'criteria'=>$criteria,
		));
	
		if (Yii::app()->request->isAjaxRequest) {
	
	
			$this->renderPartial('_siList',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
	
	
	
		$this->render('si',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
	
	
	}
	public function actionSIT(){
		$this->layout='admin_mngr';
		$this->render('sit');
	
	
	}
	public function actionST(){
		$this->layout='admin_mngr';
		$this->render('st');
	
	
	}
	public function actionSTI(){
		$this->layout='admin_mngr';
		$this->render('sti');
	
	
	}
	

	
	public function actionSTItems()
	{
		@$stId = $_GET['idST'];
		$stis = ServiceTypeItem::model()->findAllByAttributes(array('sti_st_id'=>$stId));

		$stItems = "";
		$arraySTItems=array();
		foreach ($stis as $key=>$sti){
			$si = ServiceItem::model()->findByPk($sti['sti_si_id']);
			$sit = ServiceItemTemplate::model()->findByPk($si['si_sit_id']);
			
			$tem  = CHtml::tag('option', array('value'=>$si['id']),CHtml::encode($sit['sit_name'].'('.$si['id'].')'),true);

			$stItems .= $tem;
			array_push($arraySTItems, $tem);
		}
		
		$sis = ServiceItem::model()->findAllByAttributes(array('si_city_id'=>ServiceType::model()->findByPk($stId)['st_city_id']));
		$siItems="";
		foreach ($sis as $key=>$si){
			$sit = ServiceItemTemplate::model()->findByPk($si['si_sit_id']);
			$tem= CHtml::tag('option', array('value'=>$si['id']),CHtml::encode($sit['sit_name'].'('.$si['id'].')'),true);
			$_tem= CHtml::tag('option', array('value'=>$sit['id']),CHtml::encode($sit['sit_name'].'('.$sit['id'].')'),true);
			if (!in_array($tem,$arraySTItems)) {
				$siItems .=$tem;
			}
		
		}
		
		
		$rlt = array(
			'stItems'=>$stItems,
			'siItems'=>$siItems,
		);
		echo CJSON::encode($rlt);
	}
	
	public function actionSTItemsRemove(){
	
		@$stItems = $_GET['stItems'];
		$ids = '';
		foreach ($stItems as $k=>$v){
			$ids .= $v.',';
		}
// 		$stItems = CJSON::decode($stItems);
// 		Yii::log(CJSON::encode($stItems),'error','st.items.remove');
// 		Yii::log($ids,'error','st.items.remove');
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition('sti_si_id', $stItems);
		$sti = ServiceTypeItem::model()->deleteAll($criteria);
		
		
		$this->actionSTItems();
	}
	
	public function actionSTItemsAdd(){
		@$stId = $_GET['idST'];
		$stItems = $_GET['siItems'];
		$ids = '';
		foreach ($stItems as $k=>$v){
			$ids .= $v.',';
			
	$c = ServiceTypeItem::model()->countByAttributes(array('sti_st_id'=>$stId, 'sti_si_id'=>$v));
	Yii::log(CJSON::encode($c),'error','sti.items.add');
		if ($c <1) {
				$sti =new  ServiceTypeItem();
			$sti['sti_st_id']=$stId;
			$sti['sti_si_id'] = $v;
			$sti->save();
		}
			
		
		}
		// 		$stItems = CJSON::decode($stItems);
		
// 		$sti = ServiceTypeItem::model()->deleteAll(array(
// 				'condition'=>'sti_si_id in (:items)',
// 				'params'=>array(
// 						':items'=>$ids,
// 				),
// 		));
		$this->actionSTItems();
	}
	

	
	
	
	public function actionOrderList(){
		
	
		$model = new OrderHistory();
	$this->layout='admin_mngr';
		@$startTime = $_GET['startTime'];
		@$endTime = $_GET['endTime'];
		$criteria = new CDbCriteria();
		$criteria->order = 'oh_date_time DESC';
		

		
// 		$criteria->condition="(oh_staff_id1 = :staff1 OR oh_staff_id2 = :staff2)";
		
// 		$shopId = Boss::model()->findByAttributes(array('b_user_id'=>Yii::app()->user->id))->washShop['id'];
		
// 		$shopId = WashShop::model()->findByAttributes(array(''))
// 		$criteria->addCondition('oh_wash_shop_id = :shopId');
		
// 		$criteria->params[':shopId'] = $shopId;
// 		$criteria->params[':staff2']=$staffId;
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
				
				
			$this->renderPartial('_orderList',array(
					'model'=>$model,
					'dataProvider'=>$dataProvider),false,true);
			Yii::app()->end();
		}
		
		
		
		$this->render('orderList',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider));
	
	
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
		$model=WashShop::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'页面不存在');
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
