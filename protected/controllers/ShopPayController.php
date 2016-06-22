<?php

class ShopPayController extends Controller
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
				'actions'=>array('create','update','newRequestPay','AckService'),
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
	

	
	
	public function actionNewRequestPay(){
		
		
		
		
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}
		
		@$level = $_POST['level'];
		@$value = $_POST['value'];
		@$address=$_POST['address'];
		@$name=$_POST['name'];
		@$tel=$_POST['tel'];
		@$remark=$_POST['remark'];
		
		$model = new ShopPay();
		$model['sp_type']= $level;
		$model['sp_datetime']=date('Y:m:d H:i:s');
		$model['sp_value']=$value;
		$model['sp_user_id'] = Yii::app()->user->id;
		$model['sp_state']=0;
		$model['sp_remark']=$remark;
		$model['sp_shop_id']=UTool::getShop()['id'];
		$model['sp_datetime_update']=$model['sp_datetime'];
		$model['sp_name']=$name;
		$model['sp_address']=$address;
		$model['sp_tel']=$tel;
		switch ($level){
			case 0: $model['sp_date_long'] = 60;break;
			case 1: $model['sp_date_long'] = 30*8;break;
			case 2: $model['sp_date_long'] = 30*15;break;
			case 3: $model['sp_date_long'] = 30*28;break;
			default: $model['sp_date_long']=0;break;
		}
		if ($model->save()) {
			;
		}
		
		
		
		
		
	}
	
	public function actionAckService( $id,$code){
		if (Yii::app()->request->isAjaxRequest) {
			$model = ShopPay::model()->findByPk($id);
			$model['sp_state'] = $code;
			$model['sp_datetime_update'] = date('Y-m-d H:i:s');
// 			if ($code == 4) {
// 				$model['cgh_date_active'] = $model['cgh_date_state_update'];
// 			}
			// 			$model['']
			if($model->save()){
				
				if($code == 2){
					
					$shopCard = new ShopCard();
					$shopCard['sc_sn'] = 0;
					$shopCard['sc_pwd'] = UTool::randomkeys(16);
					$shopCard['sc_state']= 1;
					$shopCard['sc_date_active']='';
					$shopCard['sc_date_gen']=date('Y:m:d H:i:s');
					$shopCard['sc_price'] = $model['sp_value'];
					$shopCard['sc_shop_id'] = $model['sp_shop_id'];
					$shopCard['sc_value'] = $model['sp_date_long'];
					$shopCard['sc_date_end'] = '';
					$shopCard['sc_type']=$model['sp_type'];
					if ($shopCard->save()) {
						;
					}else{
						Yii::log(CJSON::encode($shopCard),'error','mngr.shopPayControl.ackService');
					}
// 					Cardinvite::model()->updateAll(array('ci_state'=>1),array(
// 					'condition'=>'ci_batch_no=:no AND ci_shop_id=:id',
// 					'params'=>array(':no'=>$model['id'],
// 					':id'=>$model['cgh_shop_id']),
// 					));
				}
	
			}
		}
	
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ShopPay;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopPay']))
		{
			$model->attributes=$_POST['ShopPay'];
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

		if(isset($_POST['ShopPay']))
		{
			$model->attributes=$_POST['ShopPay'];
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
		$dataProvider=new CActiveDataProvider('ShopPay');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopPay('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopPay']))
			$model->attributes=$_GET['ShopPay'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopPay the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopPay::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopPay $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-pay-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
