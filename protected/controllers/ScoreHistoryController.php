<?php

class ScoreHistoryController extends Controller
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
		$model=new ScoreHistory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ScoreHistory']))
		{
			$model->attributes=$_POST['ScoreHistory'];
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

		if(isset($_POST['ScoreHistory']))
		{
			$model->attributes=$_POST['ScoreHistory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
// 	/**
// 	 * 返回用户优惠卡列表
// 	 * 刘长鑫
// 	 * 20150326
// 	 * @param int $userId
// 	 * @param int $pageIndex
// 	 * @param int $pageSize
// 	 * @param string $startTime
// 	 * @param string $endTime
// 	 * @return Ambigous <multitype:, boolean>
// 	 */
// 	public function getUserCardList($userId, $pageIndex=0, $pageSize=8, $startTime=NULL,$endTime=NULL){
	
// 	    $rlt = UTool::iniFuncRlt();
// 	    $criteria = new CDbCriteria ();
// 	    $criteria->order = 'ci_date_end ASC, ci_state ASC, ci_date_begin ASC';
// 	    $criteria->addCondition ( 'ci_owner=:user_id' );
// 	    $criteria->params [':user_id'] = $userId;
	
// 	    if (isset($startTime)){
// 	        $criteria->addCondition ( 'ci_date_begin>=:start' );
// 	        $criteria->params [':start'] = date('Y-m-d H:i:s', strtotime( $startTime));
// 	    }
// 	    if (isset  ( $endTime )) {
// 	        $criteria->addCondition ( 'ci_date_end<=:end' );
// 	        $criteria->params [':end'] = date('Y-m-d H:i:s', strtotime( $endTime));
// 	    }
	
// 	    $dataProvider = new CActiveDataProvider ( $this, array (
// 	        'pagination' => array (
// 	            'pageSize' => $pageSize,
// 	            'currentPage'=>$pageIndex,
// 	        ),
// 	        'criteria' => $criteria
// 	    ) );
// 	    $rlt['status']=true;
// 	    $rlt['msg']='查询成功';
// 	    $rlt['data']=$dataProvider;
// 	    return $rlt;
	
// 	}
	

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
		$dataProvider=new CActiveDataProvider('ScoreHistory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ScoreHistory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScoreHistory']))
			$model->attributes=$_GET['ScoreHistory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ScoreHistory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ScoreHistory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ScoreHistory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='score-history-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
