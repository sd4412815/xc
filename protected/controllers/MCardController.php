<?php
class MCardController extends Controller {
	
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				array (
						'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE' 
				) 
		);
	}
	public function beforeAction($action) {
		parent::beforeAction ( $action );
		Yii::app ()->clientScript->reset ();
		return true;
	}
	public function actions() {
		return array (
				'REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider' 
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
								'REST.GET',
								'REST.PUT',
								'REST.POST',
								'REST.DELETE',
							
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (
								'update' 
						),
						'users' => array (
								'@' 
						) 
				) 
		// array('allow', // allow admin user to perform 'admin' and 'delete' actions
		// 'actions'=>array('admin','delete'),
		// 'users'=>array('admin'),
		// ),
		// array('deny', // deny all users
		// 'users'=>array('*'),
		// ),
				);
	}
	public function restEvents() {
		
		$this->onRest('post.filter.req.auth.ajax.user', function($validation) {
// 			return true;
// 			if(!$validation) {
// 				return false;
// 			}
			switch ($this->getAction()->getId()) {
				case 'REST.GET':return  true;
				case 'REST.POST':
				    return TRUE;
// 					return Yii::app()->user->checkAccess('REST-CREATE');
					break;
				case 'REST.POST':
					return Yii::app()->user->checkAccess('REST-UPDATE');
					break;
				case 'REST.DELETE':
					return Yii::app()->user->checkAccess('REST-DELETE');
					break;
				default:
					return false;
					break;
			}
// 			return ($this->getAction()->getId() == 'REST.GET');
// 			return true;
		});
		$this->onRest ( 'req.get.cardList.render', function () {
			// Custom logic for this route.
			$rlt = UTool::iniFuncRlt ();
			$userId = Yii::app ()->request->getParam ( 'uid' );
			$pageIndex =Yii::app ()->request->getParam ( 'pageIndex' ,0);
			$pageSize =Yii::app ()->request->getParam ( 'pageSize',10 );
			$startTime = Yii::app ()->request->getParam ( 'startTime',NULL );
			$endTime = Yii::app ()->request->getParam ( 'endTime',NULL );

			$rlt = $this-> getList($userId, $pageIndex, $pageSize, $startTime,$endTime);

			// Should output results.
			$this->emitRest ( 'req.render.json', [ 
					$rlt 
			] );
		} );
		
		    $this->onRest ( 'req.post.add.render', function () {
		        // Custom logic for this route.
		        $rlt = UTool::iniFuncRlt ();
		        $userId = Yii::app ()->request->getParam ( 'uid' );
		        $pwd =Yii::app ()->request->getParam ( 'pwd');
		       
		    
		        $rlt = Cardinvite::model()->addCard($userId, $pwd);
		    
		        // Should output results.
		        $this->emitRest ( 'req.render.json', [
		            $rlt
		        ] );
		    } );
		

	
		    
	}
	
// 	private function 
	
	
	
	
	/**
	 * 根据用户id获取优惠卷列表
	 * @param int $userId
	 * @param string $q 搜索关键字
	 * @param int $page
	 * @param int $pageSize
	 * @return multitype:multitype:string unknown Ambigous <CActiveRecord, unknown, Ambigous <CActiveRecord, NULL>> Ambigous <CActiveRecord, unknown, Ambigous <CActiveRecord, NULL>, unknown, Ambigous <unknown, NULL>, unknown>
	 */
	private function getList($userId, $pageIndex, $pageSize, $startTime,$endTime){
		
		$rlt = UTool::iniFuncRlt();
		$cardListRlt = Cardinvite::model()->getUserCardList($userId, $pageIndex, $pageSize, $startTime,$endTime);
		$cardList=array();
		$totalCard=0;
		$currentPageCount=0;
		
		
		if ($cardListRlt['status']){
		    $list=$cardListRlt['data']->getData();
		    $totalCard=$cardListRlt['data']->getTotalItemCount();
		    $currentPageCount = $cardListRlt['data']->getItemCount();
		 
		    foreach ($list as $key=>$value){
		        $shop = $value->ciShop; 
// 		        $type= $value->serviceType;
                $genBatch=$value->ciGenHistory;
		        $cardList[]=array('id'=>$value['id'],
		            'no'=>$value['ci_sn'],
		            'shopId'=>$shop['id'],
		            'shopName'=>$shop['ws_name'],
		        'status'=>$value['ci_state'] ,   
		            'value'=>$value['ci_value'] ,
		            'type'=>$genBatch['cgh_type'],
		        
		        
		        );
		    }
		}
		
		$rlt['status']=true;
		$rlt['data']['size']=$totalCard;
		$rlt['data']['currentPageCount']=$currentPageCount;
		$rlt['data']['data']=$cardList;
		$rlt['msg']='查询成功';
		
		return $rlt;

		
		
	}
	
	
	
}