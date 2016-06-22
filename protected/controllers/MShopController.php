<?php
class MShopController extends Controller {
	
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
					return Yii::app()->user->checkAccess('REST-CREATE');
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
		$this->onRest ( 'req.get.shopList.render', function () {
			// Custom logic for this route.
			$rlt = UTool::iniFuncRlt ();
			$cityName = Yii::app ()->request->getParam ( 'cityName' );
			$page =Yii::app ()->request->getParam ( 'page' ,0);
			$pageSize =Yii::app ()->request->getParam ( 'pageSize',10 );
			$cityId = $this->_getCityId($cityName);
			$rlt = $this->getList ( $cityId,'',$page,$pageSize );
			// Should output results.
			$this->emitRest ( 'req.render.json', [ 
					$rlt 
			] );
		} );
		
		
		    $this->onRest ( 'req.get.shopInfos.render', function () {
		        // Custom logic for this route.
		        $rlt = UTool::iniFuncRlt ();
		        $shopId = Yii::app ()->request->getParam ( 'shopId' );
// 		        $page =Yii::app ()->request->getParam ( 'page' ,0);
// 		        $pageSize =Yii::app ()->request->getParam ( 'pageSize',10 );
// 		        $cityId = $this->_getCityId($cityName);
		        $rlt = WashShop::model()->getDetailInfo($shopId);
		        // Should output results.
		        $this->emitRest ( 'req.render.json', [
		            $rlt
		        ] );
		    } );
		    
		    
		        $this->onRest ( 'req.get.timeList.render', function () {
		            // Custom logic for this route.
		            $rlt = UTool::iniFuncRlt ();
		            $shopId = Yii::app ()->request->getParam ( 'shopId' );
		            $serviceType = Yii::app ()->request->getParam ( 'serviceType',1 );
		            $carType= Yii::app ()->request->getParam ( 'carType',1 );
		            $bias = Yii::app ()->request->getParam ( 'bias' ,0);
		            $position = Yii::app ()->request->getParam ( 'position' ,1);
		            
		           $rlt = OrderTemp::model()->getTimeList($shopId, $serviceType, $carType, $bias,$position);
		           
		            // 		        $page =Yii::app ()->request->getParam ( 'page' ,0);
		            // 		        $pageSize =Yii::app ()->request->getParam ( 'pageSize',10 );
		            // 		        $cityId = $this->_getCityId($cityName);
// 		            $rlt = WashShop::model()->getDetailInfo($shopId);
		            // Should output results.
		            $this->emitRest ( 'req.render.json', [
		                $rlt
		            ] );
		        } );
		        
		            $this->onRest ( 'req.get.getShopComments.render', function () {
		                // Custom logic for this route.
		                // 			$rlt = UTool::iniFuncRlt ();
		                $shopId = Yii::app ()->request->getParam ( 'sid' );
		                $page =Yii::app ()->request->getParam ( 'page' ,0);
		                $pageSize =Yii::app ()->request->getParam ( 'pageSize',10 );
		                // 			$cityId = $this->_getCityId($cityName);
		                $rlt = $this->getShopComments($shopId,$page,$pageSize);
		                // Should output results.
		                $this->emitRest ( 'req.render.json', [
		                    $rlt
		                ] );
		            } );
		    
	}
	
// 	private function 
	
	
	
	/**
	 * 获取城市id
	 * 刘长鑫
	 * 20150312
	 * @param string $cityName
	 */
	private function _getCityId($cityName){
		
		$city = City::model()->findByAttributes(array('c_name'=>$cityName));
		if (isset($city)){
			return $city['id'];
		} else {
			return 0;
		}
	}
	
	
	private function getShopComments($shopId, $pageIndex=0, $pageSize=8){
	    $rlt = UTool::iniFuncRlt();
	    $commentRlt = OrderComments::model()->getShopCommentList($shopId,$pageIndex,$pageSize)['data'];
	    
	    $rlt['data']['size']=$commentRlt->getTotalItemCount();
	    $rlt['data']['currentPageCount']=$commentRlt->getItemCount();
	    $list=$commentRlt->getData();

	    
	    foreach ($list as $key=>$value){
	        $comment = array();
	        $comment=array('datetime'=>$value['oc_datetime'],
	            'score'=>$value->Order ['oh_score'],
	            'service'=>$value->Order->serviceType['st_name'],
	            'comment'=>$value['oc_comment'],
	            'user'=>$value->User['u_nick_name'],
	        );
	        
	        $rc = OrderComments::model ()->findByAttributes ( array (
	            'oc_related_id' => $value ['id'],
	        ) );
	        if (isset($rc)){
	            $comment['bossComment']=$rc['oc_comment'];
	        }
	        $rlt['data']['data'][]=$comment;
	        
	        
	        
	        
	    }
	    $rlt['status']=true;
	    $rlt['msg']='获取评论成功';
	    return $rlt;
	    
	    
	    
	}
	
	
	/**
	 * 根据城市id获取车行列表
	 * @param int $cityId
	 * @param string $q 搜索关键字
	 * @param int $page
	 * @param int $pageSize
	 * @return multitype:multitype:string unknown Ambigous <CActiveRecord, unknown, Ambigous <CActiveRecord, NULL>> Ambigous <CActiveRecord, unknown, Ambigous <CActiveRecord, NULL>, unknown, Ambigous <unknown, NULL>, unknown>
	 */
	private function getList($cityId,$q,$page=0,$pageSize=2){
		
		$rlt = UTool::iniFuncRlt();
		
// 		$criteria = new CDbCriteria();
// 		$criteria->addCondition('ws_state=1');
// 		$searchForm = new SearchForm ();
// 		$searchForm ['bias'] = 0;

		
		$model = new WashShop ();
		$criteria = new CDbCriteria ();
		
// 		$searchForm->q=$q;
		
// 		if ($searchForm->validate ()) {
// 			;
// 		}
		
		
		
		
		$criteria->addCondition ( "ws_city_id=:cityId" );
		$criteria->params [':cityId'] = $cityId;
		$criteria->addCondition ( "ws_state=1" );
		
		$criteria->limit = $pageSize;
		$criteria->offset = $page*$pageSize;
// 		$criteria->with = array (
// 				'washShopServices' => array (
// 						'select' => 'wss_value_min'
// 						// 'group' => 'wss_value_min'
// 				)
// 		);
		
// 		$criteria->together = true;
		
		$shopList = WashShop::model()->findAll($criteria);
		
		$shopInfos = array();
		foreach ($shopList as $key=>$value){
// 			$shopServices = $value->washShopServices;/
			$stdWash = WashShopService::model()->findByAttributes(array('wss_st_id'=>1,'wss_ws_id'=>$value['id']));
		
			$shopInfos[]=array(
			'id'=>$value['id'],
			'img'=>Yii::app()->request->hostInfo. Yii::app()->baseUrl.'/images/shops/'.$value['id'].'/shop'.$value->id.'.jpg',
			'name'=>$value['ws_name'],
			'address'=>$value['ws_address'],
			'minValue'=>$stdWash['wss_value_min'],
			   'position'=>$value['ws_position'],
					
			);
		}
		$rlt['status']=true;
		$rlt['data']=$shopInfos;
		return $rlt;
		

		
		
	}
	
	
	
}