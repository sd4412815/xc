<?php

class OrderHistoryController extends Controller
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionOrderView($id)
	{
		$this->layout='admin_main';

		$this->render('orderView',array(
				'model'=>$this->loadModel($id),
		));
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrderHistory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'访问页面不存在');
		return $model;
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
				'actions'=>array('create','update','APIs','orderAckbyUser','orderAckbyUserOk','orderAckbyUserCancel',
						'OrderAckbyStaff','OrderAckbyBoss','OrderView',),
				'users'=>array('@'),
			),
			array('allow','actions'=>array('OrderAckbyBossCancel','OrderAckbyBossOk'),'roles' => array (
								'boss' 
						) ),
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
		$model=new OrderHistory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrderHistory']))
		{
			$model->attributes=$_POST['OrderHistory'];
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

		if(isset($_POST['OrderHistory']))
		{
			$model->attributes=$_POST['OrderHistory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
public function actionOrderAckbyBossCancel(){
	
		$model = new CommentForm();

	
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'comment-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	
		// collect user input data
		if (isset ( $_POST ['CommentForm'] )) {
			// 校验令牌
			// 			if (! UTool::checkCsrf ()) {
			// 				throw new CHttpException('500','错误请求')；
			// 				Yii::app ()->end ();
			// 			}
			$model->attributes = $_POST ['CommentForm'];
	
			if ($model->validate ()) {
				// 				$rltCheck = UTool::checkRepeatAction ( 10 );
				$rlt = UTool::iniFuncRlt();
	
				
				$ackrlt = OrderHistory::model()->getOrderAckbyBoss($model['id'],Yii::app()->user->id,-2,0);
				if($ackrlt['status'])
				{
					Yii::app ()->user->setFlash ( 'commentError',$ackrlt['msg'] );
					$ackrlt['status']=true;
				} else {
					$ackrlt['status']=false;
					Yii::app ()->user->setFlash ( 'commentError', $ackrlt['msg']);
						
	
				}
				// 					$this->refresh();
				echo CJSON::encode($ackrlt);
				Yii::app()->end();
	
			} // end if validator
		}else{
			Yii::app ()->user->setFlash ( 'commentError', '订单取消失败!');
		} // end isset
	
	echo CJSON::encode($rlt);
	
	
	}
	
	
	public function actionOrderAckbyUserCancel(){
	
		$model = new CommentForm();

	
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'comment-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	
		// collect user input data
		if (isset ( $_POST ['CommentForm'] )) {
			// 校验令牌
			// 			if (! UTool::checkCsrf ()) {
			// 				throw new CHttpException('500','错误请求')；
			// 				Yii::app ()->end ();
			// 			}
			$model->attributes = $_POST ['CommentForm'];
	
			if ($model->validate ()) {
				// 				$rltCheck = UTool::checkRepeatAction ( 10 );
				$rlt = UTool::iniFuncRlt();
	
				
				$rlt = OrderHistory::model()->getOrderAckbyUser($model['id'],Yii::app()->user->id,0,5,'');
				if($rlt['status'])
				{
					Yii::app ()->user->setFlash ( 'commentError','订单取消成功' );
					$rlt['status']=true;
				} else {
					$rlt['status']=false;
					Yii::app ()->user->setFlash ( 'commentError', '订单取消失败!');
						
	
				}
				// 					$this->refresh();
				echo CJSON::encode($rlt);
	
			} // end if validator
		}else{
			Yii::app ()->user->setFlash ( 'commentError', '订单取消失败!');
		} // end isset
	
	
	
	}
	
	public function actionOrderAckbyUserOk(){
		
// 		$this->layout = 'main';
		
		$model = new CommentForm();
				$model ->setScenario('ack');
		
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'comment-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
		
		// collect user input data
		if (isset ( $_POST ['CommentForm'] )) {
			// 校验令牌
			// 			if (! UTool::checkCsrf ()) {
			// 				throw new CHttpException('500','错误请求')；
			// 				Yii::app ()->end ();
			// 			}
			$model->attributes = $_POST ['CommentForm'];

			if ($model->validate ()) {
// 				$rltCheck = UTool::checkRepeatAction ( 10 );
					$rlt = UTool::iniFuncRlt();
						
					$purifier = new CHtmlPurifier();
					$model['comment'] = $purifier->purify($model['comment']);
					$rlt = OrderHistory::model()->getOrderAckbyUser($model['id'],Yii::app()->user->id,1,$model['score'],$model['comment']);
					if($rlt['status'])
					{
						Yii::app ()->user->setFlash ( 'commentError','订单确认成功' );
						$rlt['status']=true;
					} else {
						$rlt['status']=false;
							Yii::app ()->user->setFlash ( 'commentError', $rlt['msg']);
					
		
					}
// 					$this->refresh();
					echo CJSON::encode($rlt);
				
				} // end if validator
			}else{
				Yii::app ()->user->setFlash ( 'commentError', CJSON::encode( $model->errors) );
			} // end isset
// 		}
// 		$cs = Yii::app()->getClientScript();
// // 		$cs  
// 		$cs->registerScript('update', "$.fn.yiiListView.update(
// 	        			                'ajaxOrderList'
// 	        			            );");
// 		// 显示登录表单
// 		$this->render ( 'sendMessage', array (
// 				'model' => $model
// 		) );
		
		
// 		@$orderId = $_POST['id'];
// 		@$type = $_POST['type'];
// 		@$score=$_POST['score'];
// 		@$comment=$_POST['comment'];
// // 		@$userId = $_POST['userId'];
// // 		if (!isset($userId)) {
// 			$userId = Yii::app()->user->id;
// // 		}
		
// 		$rlt = OrderHistory::model()->getOrderAckbyUser($orderId,$userId,$type,$score,$comment);
	
		
// 		echo CJSON::encode($rlt);
		
		
	}
	
	public function actionOrderAckbyBossOk(){
	
		// 		$this->layout = 'main';
	
		$model = new CommentForm();
		$model ->setScenario('bossack');
	
		// if it is ajax validation request
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'comment-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	
		// collect user input data
		if (isset ( $_POST ['CommentForm'] )) {
			// 校验令牌
			// 			if (! UTool::checkCsrf ()) {
			// 				throw new CHttpException('500','错误请求')；
			// 				Yii::app ()->end ();
			// 			}
			$model->attributes = $_POST ['CommentForm'];
	
			if ($model->validate ()) {
				// 				$rltCheck = UTool::checkRepeatAction ( 10 );
				$rlt = UTool::iniFuncRlt();
	
			
				$rlt = OrderHistory::model()->getOrderAckbyBoss($model['id'],Yii::app()->user->id,1,$model['ontime']);
				if($rlt['status'])
				{
					Yii::app ()->user->setFlash ( 'commentError','订单确认成功' );
					$rlt['status']=true;
				} else {
					$rlt['status']=false;
					Yii::app ()->user->setFlash ( 'commentError', '订单确认失败!');
						
	
				}
				// 					$this->refresh();
				echo CJSON::encode($rlt);
	
			} // end if validator
		}else{
			Yii::app ()->user->setFlash ( 'commentError', CJSON::encode( $model->errors) );
		} // end isset
		
	
	
	}
	
	public function actionOrderAckbyStaff(){
	
		@$orderId = $_POST['id'];
// 		@$type = $_POST['type'];

// 		@$userId = $_POST['staffId'];
// 		if (!isset($userId)) {
			$userId = Staff::model()->findByAttributes(array(
				's_user_id'=>Yii::app()->user->id,
			))['id']; 
// 		}
	
		$rlt = OrderHistory::model()->getOrderAckbyStaff($orderId,$userId);
	
	
		echo CJSON::encode($rlt);
	
	
	}
	
	
	public function actionOrderAckbyBoss(){
	
		@$orderId = $_POST['id'];
// 		@$userId = $_POST['userId'];
// 		@$type = $_POST['type'];
// 		@$score=$_POST['score'];
// 		@$comment=$_POST['comment'];

		$boss = Boss::model()->findByAttributes(array(
				'b_user_id'=>Yii::app()->user->id,
		));
		
		$rlt = OrderHistory::model()->getOrderAckbyBoss($orderId,$boss['id']);
	
	
		echo CJSON::encode($rlt);
	
	
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
		$dataProvider=new CActiveDataProvider('OrderHistory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * 根据时间获取员工所有用户订单
	 * @param int $shopId
	 * @param string $beginTime
	 * @param string $endTime
	 * @param bool $isDESC
	 * @param bool $isShopOnly
	 * @return string
	 * @soap
	 */
	public function getOrdersByStaffId($staffId, $beginTime, $endTime, $isDESC=true, $shopId=0){
		return CJSON::encode(OrderHistory::model()->getOrdersByStaffId($staffId, $beginTime, $endTime,$isDESC,$shopId));
	}
	
	/**
	 * 根据时间获取车行所有订单
	 * @param int $shopId
	 * @param string $beginTime
	 * @param string $endTime
	 * @return string
	 * @soap
	 */
	public function getOrdersByTime($shopId, $beginTime, $endTime){
		return CJSON::encode(OrderHistory::model()->getOrdersByTime($shopId, $beginTime, $endTime));
	}
	
	/**
	 * 根据时间获取所有车行用户订单
	 * @param int $shopId
	 * @param string $beginTime
	 * @param string $endTime
	 * @param int $userId
	 * @return string
	 * @soap
	 */
	public function getOrdersByUserId($userId, $beginTime, $endTime){
		return CJSON::encode(OrderHistory::model()->getOrdersByStaffId($userId, $beginTime, $endTime));
	}

	/**
	 * 车行用户订单数统计
	 * @param int $shopId 车行id
	 * @param string $beginTime 开始时间
	 * @param string $endTime 终止时间
	 * @return string
	 * @soap
	 */
	public function getOrderStatistics($shopId, $beginTime, $endTime, $position = 0) {
		return CJSON::encode(OrderHistory::model()->getOrderStatistics($shopId, $beginTime, $endTime,$position));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrderHistory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrderHistory']))
			$model->attributes=$_GET['OrderHistory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



	/**
	 * Performs the AJAX validation.
	 * @param OrderHistory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-history-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
