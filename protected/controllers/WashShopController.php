<?php
class WashShopController extends Controller {
	public function actions() {
		return array (
				'APIs' => array (
						'class' => 'CWebServiceAction' 
				) 
		);
	}
	
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
								'APIs',
								'updateWSs',
								'updateCarCount',
								'UpdateWSInfos',
								'new' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array (
								'create',
								'update',
								'updatePosition',
								'Oper',
								'online', 
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
	public function actionNew() {
		if (Yii::app ()->request->isAjaxRequest) {
			@$idp = $_POST ['idp'];
			@$idc = $_POST ['idc'];
			@$ida = $_POST ['ida'];
			@$name = $_POST ['name'];
			@$contator = $_POST ['contator'];
			@$tel = $_POST ['tel'];
			@$address = $_POST ['address'];
			
			$tempUser = User::model ()->findByAttributes ( array (
					'u_tel' => $tel 
			) );
			if (WashShop::model ()->countByAttributes ( array (
					'ws_boss_id' => $tempUser ['id'] 
			) ) > 0) {
				echo '该手机号已经被占用，请更换手机号';
				return;
			}
			$user_id = Yii::app ()->user->id;
			if (! isset ( $tempUser )) {
				$user = new User ();
				$user ['u_tel'] = $tel;
				$user ['u_name'] = $tel;
				$user ['u_nick_name'] = $tel;
				$user ['u_score'] = 0;
				$user ['u_join_date'] = date ( 'Y:m:d H:i:s' );
				$user ['u_login_date'] = $user ['u_join_date'];
				$user ['u_type'] = 2;
				$user ['u_sex'] = 2;
				$user ['u_age'] = 999;
				$user ['u_state'] = 0;
				$user ['u_pwd'] = CPasswordHelper::hashPassword ( $tel );
				if ($user->save ()) {
					$user_id = $user ['id'];
					$boss = new Boss ();
					$boss ['b_real_name'] = $name;
					$boss ['b_type'] = 0;
					$boss ['b_name'] = $name;
// 					$boss ['b_tel'] = $tel;
					$boss ['b_pwd'] = $user ['u_pwd'];
					$boss ['b_nick_name'] = $name;
					$boss ['b_user_id'] = $user_id;
					if ($boss->save ()) {
						;
					}
				} else {
					$user_id = 0;
				}
				// echo $user_id;
				// return ;
			} else {
				$user_id = $tempUser ['id'];
				$boss = new Boss ();
				$boss ['b_real_name'] = $name;
				$boss ['b_type'] = 0;
				$boss ['b_name'] = $name;
// 				$boss ['b_tel'] = $tel;
				$boss ['b_pwd'] = $tempUser ['u_pwd'];
				$boss ['b_nick_name'] = $name;
				$boss ['b_user_id'] = $user_id;
				if ($boss->save ()) {
					;
				}
			}
			
			$shop = new WashShop ();
			$shop ['ws_name'] = $name;
			$shop ['ws_score'] = 0;
			$shop ['ws_address'] = $address;
			$shop ['ws_desc'] = '';
			$shop ['ws_position'] = '0,0';
			$shop ['ws_boss_id'] = $user_id;
			$shop ['ws_state'] = 0;
			$shop ['ws_rest'] = 5;
			$shop ['ws_exp'] = 0;
			$shop ['ws_key_words'] = '';
			$shop ['ws_open_time'] = '7:00';
			$shop ['ws_close_time'] = '21:00';
			$shop ['ws_province_id'] = $idp;
			$shop ['ws_city_id'] = $idc;
			$shop ['ws_area_id'] = $ida;
			$shop ['ws_join_date'] = date ( 'Y:m:d H:i:s' );
			$shop ['ws_expire_date'] = date ( 'Y:m:d 23:59:59', time () + 60 * 24 * 60 * 60 );
			$shop ['ws_intro_user_id'] = 1;
			$shop ['ws_discount_count'] = 2;
			$shop ['ws_num'] = 0;
			$shop ['ws_level'] = 0;
			$shop ['ws_date_end'] = $shop ['ws_expire_date'];
			// $shop['ws_count']=0;
			if ($shop->save ()) {
				echo 'true';
			} else {
				echo '申请失败！';
				return;
			}
		}
	}
	
	
	public function actionOnline(){
		
		$shop = UTool::getShop();
		$joinStd = new JoinPriceForm();
		$joinStd->load($shop['ws_city_id']);
		
		if ($shop['ws_state'] == 2) {
			$shop['ws_state'] =1;
			$shop['ws_score']=5;
			$shop['ws_start_date']=date('Y-m-d H:i:s');
			$shop['ws_expire_date']=$shop['ws_start_date'];
			$shop['ws_date_end']=date('Y-m-d H:i:s',strtotime('+'.$joinStd['free_date_long'].' months'));
			if($shop->save()){
// 			    $criteria = new CDbCriteria();
// 			    $criteria->addCondition('ot_wash_shop_id')
			    $count =  OrderTemp::model()->countByAttributes(array('ot_wash_shop_id'=>$shop['id']));
			    
			    if ($count<1){
			        $shop->generateOrderTempTable($shop['id'], 0);
			        					$shop->generateOrderTempTable($shop['id'], 1);
			        					$shop->generateOrderTempTable($shop['id'], 2);
			    }
// 				$shop->deleteOrderTempTable($shop['id'], 0);
// 				$shop->deleteOrderTempTable($shop['id'], 1);
// 				$shop->deleteOrderTempTable($shop['id'], 2);
// 				 
				Yii::app()->user->setFlash('onlineMsg','车行上线成功！');
				
			}else{
				Yii::app()->user->setFlash('onlineMsg','车行上线失败，请稍后重试！');

			}

		}else{
			Yii::app()->user->setFlash('onlineMsg','车行上线失败，请稍后重试！');
		}
		
		$this->redirect(array('boss/profile'));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new WashShop ();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['WashShop'] )) {
			$model->attributes = $_POST ['WashShop'];
			$model->ws_lat = 0;
			$model->ws_lng = 0;
			$model->ws_no = 1;
			
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
	public function actionUpdateWSs() {
		if (! Yii::app ()->request->isAjaxRequest) {
			Yii::app ()->end ();
		}
		@$id = $_POST ['id'];
		@$no = $_POST ['wno'];
		@$name = $_POST ['wname'];
		@$address = $_POST ['waddress'];
		@$desc = $_POST ['wdesc'];
		@$owner = $_POST ['wowner'];
		@$tel = $_POST ['wtel'];
// 		@$rest = $_POST ['wrest'];
		@$wnum = $_POST ['wnum'];
		@$wsts = $_POST ['wsts'];
		@$time = $_POST ['wtime'];
		@$sfs = $_POST ['sfs'];
		@$waccount = $_POST ['waccount'];
		@$waccountOwner = $_POST ['waccountOwner'];
// 		@$xc1 = $_POST ['xc1'];
// 		@$xc2 = $_POST ['xc2'];
// 		@$dala1 = $_POST ['dala1'];
// 		@$dala2 = $_POST ['dala2'];
// 		@$jx1 = $_POST ['jx1'];
// 		@$jx2 = $_POST ['jx2'];
		$keywords = Yii::app()->request->getParam('wkeywords');
		
		$shop = WashShop::model ()->findByPk ( $id );
		
		$shop ['ws_no'] = $no;
		$shop ['ws_name'] = $name;
		$shop ['ws_address'] = $address;
		$shop ['ws_desc'] = $desc;
// 		$shop ['ws_rest'] = $rest;
		$shop ['ws_num'] = $wnum;
		$shop ['ws_key_words'] = $keywords;
		$times = split ( '[- ]', $time );
		// Yii::log(CJSON::encode($times),'info','mngr.washshop.UpdateWSs.times s');
		// echo CJSON::encode($times);
		$shop ['ws_open_time'] = $times [0];
		// Yii::log($times[1],'info','mngr.washshop.UpdateWSs.times[1] ');
		$shop ['ws_close_time'] = $times [1];
		
		if ($shop->save ()) {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.shop s');
		} else {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.shop e');
		}
		// echo CJSON::encode($shop);
		
		$boss = Boss::model ()->findByAttributes ( array (
				'b_user_id' => $shop ['ws_boss_id'] 
		) );
		$boss ['b_real_name'] = $owner;
// 		$boss ['b_tel'] = $tel;
		$boss ['b_account'] = $waccount;
		$boss ['b_account_owner'] = $waccountOwner;
		if ($boss->save ()) {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.boss s');
		} else {
			// Yii::log(CJSON::encode($shop),'info','mngr.washshop.UpdateWSs.boss e');
		}
		
		// $services =$wsts ; // CJSON::decode($wsts);
		// echo CJSON::encode($_POST['wsts']);
		// Yii::log(CJSON::encode($services),'info','mngr.washshop.UpdateWSs.services s');
// 		$values = array (
// 				'1_1' => $xc1,
// 				'1_2' => $xc2,
// 				'3_1' => $dala1,
// 				'3_2' => $dala2,
// 				'5_1' => $jx1,
// 				'5_2' => $jx2 
// 		)
// 		;
		WashShopService::model ()->updateShopServices ( $id, $wsts);
		
		WashShopFeature::model ()->updateShopFeatures ( $id, $sfs );
		
		


		
	
	}
	public function actionUpdatePosition() {
		$rlt = UTool::iniFuncRlt ();
// 		UTool::clearCsrf();
		UTool::setCsrfValidator();
		
		$strParamErr = '页面请求参数错误';
		
		if (!Yii::app()->request->isAjaxRequest || !UTool::checkCsrf()){
			$rlt['msg'] = '页面已过期，请刷新重试';
// 			echo CJSON::encode($rlt);
// 			return ;
// 			throw new CHttpException ( 404, '页面已过期，请刷新重试' );
		}
		$id = Yii::app ()->request->getPost ( 'id' );
		if (!is_int((int)$id)) {
			throw new CHttpException ( 404, '页面请求参数错误' );
		}
		
		$p = Yii::app ()->request->getPost ( 'p' );
		Yii::log($id.'position:'.$p,CLogger::LEVEL_INFO,'mngr.updatePosition');
		$pos = split('[,\w]', $p);

		if (count($pos)<2) {
			$rlt['msg'] = '';
			throw new CHttpException ( 404, '页面请求参数错误' );
		}
		$lat =trim($pos[1]);
		$lng =	trim($pos[0]);

		if (!(is_numeric($lat) && is_numeric($lng))) {
			throw new CHttpException ( 404, '页面请求参数错误' );
		}
		

		$shop = $this->loadModel ( $id );
		$shop ['ws_position'] = $p;
		if ($shop->save ()) {
			$ak = UMap::getMapAttributes()['ak'];
			$geotable_id = UMap::getMapAttributes()['geotable_id'];
			
			$url = UMap::getMapUrl(UMapURLType::lbs_poi_list);
			$maprlt= file_get_contents($url.'&washshop_id='.$shop['id'].','.$shop['id']);
			$maprlt = CJSON::decode($maprlt);

			if ($maprlt['status']==0 && $maprlt['size']>0) {
// 				如果存在该车行数据
				$poiId = $maprlt['pois'][0]['id'];
				$url = UMap::getMapUrl(UMapURLType::lbs_poi_update);
				$params = array(
					'id'=>$poiId,
					'latitude'=>$lat,
					'longitude'=>$lng,
					'address'=>$shop['ws_address'],
					'title'=>$shop['ws_name'],
					'tags'=>$shop['ws_key_words'],
					'coord_type'=>3,
					'ak' => $ak,
					'geotable_id' => $geotable_id,
					'washshop_no'=>$shop['ws_no'],
				);
				$updateRlt = UTool::curlPost($url, $params);
				$updateRlt = CJSON::decode($updateRlt);
				if ($updateRlt['status']==0) {
					$rlt['status']=true;
					$rlt['msg']='车行LBS信息更新成功';
				}
				else {
					$rlt['msg']='更新车行lbs信息失败'.$updateRlt['message'].CJSON::encode($params);
					Yii::log('shopId:'.$shop['id'],'warning','mngr.washShop.updatePosition.updateLBS');
				}
			}else{
// 				车行不存在
				$url = UMap::getMapUrl(UMapURLType::lbs_poi_create);
				$params = array(
					'latitude'=>$lat,
					'longitude'=>$lng,
					'address'=>$shop['ws_address'],
					'title'=>$shop['ws_name'],
					'tags'=>$shop['ws_key_words'],
					'coord_type'=>3,
					'ak' => $ak,
					'geotable_id' => $geotable_id,
					'washshop_id'=>$shop['id'],
					'washshop_no'=>$shop['ws_no'],	
				);
				$createRlt = UTool::curlPost($url, $params);
				$createRlt = CJSON::decode($createRlt);
				if ($createRlt['status']==0) {
					$rlt['status']=true;
					$rlt['msg']='车行LBS信息创建成功';
				}
				else {
					$rlt['msg']='创建车行lbs信息失败'.$createRlt['message'].CJSON::encode($params);
					Yii::log('shopId:'.$shop['id'],'warning','mngr.washShop.updatePosition.createLBS');
				}
			} // end if
		}
		
		echo CJSON::encode ( $rlt );
		
		// echo $rlt['size'];
	}
	public function actionOper() {
		$rlt = UTool::iniFuncRlt();
		if (! Yii::app ()->request->isAjaxRequest) {
			Yii::app ()->end ();
		}
		
		
		@$id = $_GET ['id'];
		@$type = $_GET ['oper'];
		
		$shop = $this->loadModel ( $id );
		$shop ['ws_state'] = $type;
		if (empty($shop['ws_short_url'])){
						$url = Yii::app()->createAbsoluteUrl('order/new',array('id'=>$shop['id']));
						$shop['ws_short_url'] = UWashShop::generateShortUrl($url)['data'];
						$shop->save();
		}
		
		if ($shop->save ()) {
			
			if($shop['ws_state'] == WashShop::SHOP_STATE_PASS){
				$rlt = $shop->checkPass($shop['id']);
			}
			
			$auth = Yii::app()->authManager;
			
			
			
			if (!$auth->isAssigned('boss',$shop['ws_boss_id'])) {
				
				
				$auth->assign('boss',$shop['ws_boss_id']);
			}else{
				if ($shop['ws_state'] == -20) {
					$auth->revoke('boss',$shop['ws_boss_id']);
				}
			}
			$rlt['status']=true;
			$rlt['msg']='操作成功';
		} else {
			$rlt['msg']='操作失败';
			
		}
		
		echo CJSON::encode($rlt);
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
		
		if (isset ( $_POST ['WashShop'] )) {
			$model->attributes = $_POST ['WashShop'];
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
	 * 测试
	 * 
	 * @return int @soap
	 */
	public function getTest() {
		return 1;
	}
	
	/**
	 * 根据车行id，时间段信息返回可用员工
	 * 
	 * @param int $shopId        	
	 * @param int $index
	 *        	时间段序号
	 * @param int $serviceIntervalNum
	 *        	间隔
	 * @param int $bias        	
	 * @return string @soap
	 */
	public function getAvailableStaff($shopId, $index, $serviceIntervalNum, $bias = 0) {
		return CJSON::encode ( WashShop::model ()->getAvailableStaff ( $shopId, $index, $serviceIntervalNum, $bias ) );
	}
	
	/**
	 * 根据车行id获取车行信息
	 * 
	 * @param int $washshopId        	
	 * @return string @soap
	 */
	public function getWashShopInfo($washshopId) {
		return CJSON::encode ( WashShop::model ()->getWashShopInfo ( $washshopId ) );
	}
	
	/**
	 * 根据位置编码检索总洗车位
	 * 
	 * @param string $placeCode
	 *        	'01____':根据省份检索 '__01__'根据城市检索 '__0102'根据城市城区检索
	 * @return int 总洗车位数目
	 *         @soap
	 */
	public function getTotalParkingCount($placeCode) {
		return CJSON::encode ( WashShop::model ()->getTotalParkingCount ( $placeCode ) );
	}
	
	/**
	 * 根据车行id返回车行特色服务
	 * 
	 * @param int $washShopId        	
	 * @return string json
	 *         @soap
	 */
	function getWashShopFeatures($washShopId) {
		return CJSON::encode ( WashShop::model ()->findByPk ( $washShopId )->washShopFeatures );
	}
	
	/**
	 * 计算指定车行一天可用洗车位数（单位时间下,同时考虑可用员工数）
	 *
	 * @param int $shopID
	 *        	车行id
	 * @param bool $allDay
	 *        	是否全天洗车位数，否则为截止到当前时间洗车位数
	 * @param bool $available
	 *        	是否排除以预定车位
	 * @return string 可用洗车位（基本服务时间）
	 *         @soap
	 */
	public function getServiceCount($shopID, $allDay = True, $available = FALSE) {
		return CJSON::encode ( WashShop::model ()->getServiceCount ( $shopID, $allDay, $available ) );
	}
	
	/**
	 * 根据车行id，服务类型返回可用时间段
	 *
	 * @param int $shopId
	 *        	车行id
	 * @param int $serviceIntervalNum
	 *        	标准服务单元用时数
	 * @param int $bias
	 *        	与当天偏移 0-6返回当天到后6天
	 * @param bool $showAllState
	 *        	是否返回全天状态，否则只返回现在到营业时间结束时间段可以洗车位
	 * @param int $position
	 *        	洗车档口位置
	 * @return string [state,msg,data]可用时间段
	 *         @soap
	 */
	public function getAvailableTime($shopId, $serviceIntervalNum = 1, $bias = 0, $showAllState = FALSE, $position = 1) {
		$temp = WashShop::model ()->getAvailableTime ( $shopId, $serviceIntervalNum, $bias, $showAllState, $position );
		return CJSON::encode ( $temp );
		// return CJSON::encode(WashShop::model()->getAvailableTime($shopId, $serviceIntervalNum, $bias, $showAllState,$position));
	}
	public function actionUpdateCarCount() {
		// $yu = new SoapClient('http://202.118.21.228/index.php?r=washshop/APIs&4321');
		$shop_id = array ();
		$shop_id = $_POST ['shop_id'];
		$k = array ();
		for($i = 0; $i < count ( $shop_id ); $i ++) {
			$m = array ();
			$m [0] = $i + 1;
			$m [1] = WashShop::model ()->getServiceCount ( $i + 1 );
			// $m[1] = json_decode($yu->getServiceCount($i+1));
			$k [$i] = $m;
		}
		// echo json_encode($k);
		echo CJSON::encode ( $k );
		// echo $client->getServiceCount($shop_id);
		// echo $client->getServiceCount(1);
	}
	public function actionUpdateWSInfos() {
		@$region = $_POST ['cityName'];
		@$region = '沈阳';
		
		$ak = UMap::getMapAttributes ()['ak'];
		$tableId = UMap::getMapAttributes ()['geotable_id'];
		$url = UMap::getMapUrl ( UMapURLType::lbs_search_local );
		$url = "{$url}?ak={$ak}&geotable_id={$tableId}&region={$region}";
		$WSrlt = file_get_contents ( $url );
		// echo $url;
		$wsData = array ();
		$rlt = CJSON::decode ( $WSrlt );
		if ($rlt ['status'] != 0) {
			return $WSrlt;
		} else {
			$rltContents = $rlt ['contents'];
			foreach ( $rltContents as $key => $value ) {
				$wsId = $value ['washshop_id'];
				$shop = WashShop::model ()->findByPk ( $wsId );
				$shopAvailableCount = WashShop::model ()->getServiceCount ( $wsId, false, true );
				if ($shopAvailableCount ['status']) {
					$shopAvailableCount = $shopAvailableCount ['data'];
				} else {
					$shopAvailableCount = 0;
				}
				
				if (isset ( $shop )) {
					
					$wsData [$key] = array (
							'uid' => $value ['uid'],
							'shopId' => $wsId,
							'shopScore' => $shop ['ws_score'],
							'shopNo' => $shop ['ws_no'],
							'shopCount' => $shop ['ws_count'],
							'availableCount' => $shopAvailableCount,
							'address' => $shop ['ws_address'] 
					// 'totalCount'=>$shopTotal
										);
				} // end if
			} // end foreach
		} // end if-else
		
		echo CJSON::encode ( $wsData );
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
		$dataProvider = new CActiveDataProvider ( 'WashShop' );
		$this->render ( 'index', array (
				'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new WashShop ( 'search' );
		$model->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['WashShop'] ))
			$model->attributes = $_GET ['WashShop'];
		
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
	 * @return WashShop the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = WashShop::model ()->findByPk ( $id );
		if (! isset ( $model ))
			throw new CHttpException ( 404, '页面请求参数错误' );
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * 
	 * @param WashShop $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'wash-shop-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
}
