<?php
class CardinviteController extends Controller {
	/**
	 *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *      using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	
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
								'index',
								'view',
								'addCard' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (
								'create',
								'update' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions' => array (
								'admin',
								'delete' 
						),
						'users' => array (
								'admin' 
						) 
				),
				array (
						'deny', // deny all users
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionAddCard() {
		$rlt = UTool::iniFuncRlt ();
		if (Yii::app ()->user->isGuest) {
			$rlt ['msg'] = '请先登录';
			echo CJSON::encode ( $rlt );
			Yii::app ()->end ();
		}
		if (Yii::app ()->request->isAjaxRequest) {
			@$pwd = $_GET ['pwd'];
			$pwd = str_replace ( array (
					'_',
					'-' 
			), '', $pwd );
			$card = Cardinvite::model ()->findByAttributes ( array (
					'ci_pwd' => $pwd 
			) );
			if (isset ( $card )) {
				if ($card ['ci_owner'] != - 1) {
					$rlt['msg']='次卡已被使用';
				
				} else {
					
					$card ['ci_date_active'] = date ( 'Y-m-d H:i:s' );
					$card ['ci_owner'] = Yii::app ()->user->id;
					if ($card->save ()) {
						$rlt ['status'] = true;
						// echo 'true';
					} else {
						$rlt ['msg'] = '添加失败！';
					}
				}
			} else {
				$rlt ['msg'] = '此卡已失效或非法卡！';
				// echo '非法卡！';
			}
		}
		echo CJSON::encode ( $rlt );
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
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Cardinvite ();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['Cardinvite'] )) {
			$model->attributes = $_POST ['Cardinvite'];
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
		
		if (isset ( $_POST ['Cardinvite'] )) {
			$model->attributes = $_POST ['Cardinvite'];
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
		$dataProvider = new CActiveDataProvider ( 'Cardinvite' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Cardinvite ( 'search' );
		$model->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['Cardinvite'] ))
			$model->attributes = $_GET ['Cardinvite'];
		
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
	 * @return Cardinvite the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = Cardinvite::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * 
	 * @param Cardinvite $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'cardinvite-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
