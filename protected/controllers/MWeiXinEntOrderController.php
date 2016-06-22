<?php
class MWeiXinEntOrderController extends Controller {
	
	/*
	 * 企业号应用对应的应用名称
	 */
	public $appName;
	
	/*
	 * 初始化后的UWeChatEnt实例
	 */
	private $weChatEnt;
	

	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete' 
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
								'index' 
						),
						'users' => array (
								'*' 
						) 
				),
		);

	}
	
	

	public function actionIndex() {
		Yii::log('1',CLogger::LEVEL_INFO,'mngr.mweixinEnt.order');
		 $this->appName = AppName::$EntOrderMngr;
		include_once('emoji.php');
		
		$weChatEnt = new UWeChatEnt (
				$this->appName, 
				Yii::app()->request->getParam('nonce'),
				Yii::app()->request->getParam('msg_signature'),
				Yii::app()->request->getParam('timestamp'),
				Yii::app()->request->getParam('echostr',NULL)
		);
		$weChatEnt->debug=TRUE;

		Yii::log('1',CLogger::LEVEL_INFO,'mngr.mweixinEnt.order');
		$weChatEnt->init();
		$this->weChatEnt = $weChatEnt;
		
		$reply= '';
		$msg = $weChatEnt->msg;
		
		
		
		
		$msgType =(string) ($msg->MsgType);
		
		Yii::log($msgType,CLogger::LEVEL_INFO,'mngr.mweixinEnt.order.type');
		
		$msgType=empty($msgType) ? '' : strtolower($msgType);
		

		switch ($msgType){
			
			case 'text':
				$content = $this->receiveText();
				break;
			case 'event':
				$content = $this->receiveEvent (  );
				break;
			default:
				
			break;
		}
		
		$weChatEnt->reply($content);

	}
	
	
	private function receiveText() {
		$weChatEnt = $this->weChatEnt;
		$msgContent = ( string ) ($weChatEnt->msg->Content);
		$msgContent = trim ( $msgContent );
		
		switch (strtolower ( $msgContent )) {
			case 'updatemenu' :
				$content = $this->createMenu ( $weChatEnt );
				break;
			case '1':
// 				这里很多case 就是除了不同的输入，当然事件也是一样 就行公众号一样
				$content = '你输入了文本'.$msgContent;
				break;
			default :
				
				$content = "回复序号查看相关内容： \n\n";
				$content .= "[1]  今日订单\n";
				$content .= "[2]  待确定订单\n";
				$content .= "[3]  本月订单\n";
				$content .= "[4]  本年订单\n";
				
				break;
		}
		$content = $weChatEnt->makeJsonText ( $content );
		return $content;
	}

		
	private function getOrderToday(){
		$weChatEnt = $this->weChatEnt;

		$orderListRlt = OrderHistory::model()->getOrdersByTime(22, date('Y-m-d 00:00:00',time()), date('Y-m-d 23:59:59',time()));

		$content = '暂无订单';
		if ($orderListRlt['status']){
			$orderList = $orderListRlt['data'];
			if (!empty($orderList)){
				$content = date('m月d日').'预约订单：'."\n\n";
				foreach ($orderList as $key=>$order){
// 					$content .= "[".$key."]\n";
					$content .="[".date('H:i', strtotime($order['oh_date_time']));
					$content .= "-";
					$content .=date('H:i', strtotime($order['oh_date_time_end']))."]";

					$content .= "   待付".emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1F4B0)).($order['oh_value']-$order['oh_value_discount']);
					$carType = substr(Yii::app()->params['carType'][$order['oh_car_type']], 4,4);
					$content .= " (".$carType.")";
					$content .="\n";
				
				}
			}
			
		}
		return $content;
	}	
		
	private function createMenu() {
		$weChatEnt = $this->weChatEnt;
		$btnOrderToday=array('type'=>'click',
				'name'=>'今日订单',
				'key'=>'orderToday'
		);
		$jsonMenu[]=$btnOrderToday;
		
		$btnOrderUnAck=array('type'=>'click',
				'name'=>emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1f4cc)).'待确认',
				'key'=>'orderUnAck'
		);
		$jsonMenu[]=$btnOrderUnAck;
		
		
		$btnOrderMonth=array('type'=>'click',
				'name'=>'本月订单',
				'key'=>'orderMonth'
		);
		$btnOrderYear=array('type'=>'click',
				'name'=>'本年订单',
				'key'=>'orderYear'
		);
			
		$jsonMenu[]=array(
				'name'=>'统计',
				'sub_button'=>array(
						$btnOrderYear,
						$btnOrderMonth
						
				)
		);
	
		$jsonMenu = array('button' => $jsonMenu );
	

				$jsonMenu = json_encode($jsonMenu,JSON_UNESCAPED_UNICODE);
		$r = $weChatEnt->createMenu($jsonMenu);
		
// 		$jsonMenu = json_encode($jsonMenu,JSON_UNESCAPED_UNICODE);
	
// // 		Yii::log($jsonMenu,CLogger::LEVEL_INFO,'mngr.mWeiXinC.createMenu');
	
// 		$url = UWeChatEnt::WXENT_API . 'menu/create?access_token=' . $weChatEntObj->getToken ();
// 		$r = UTool::https_request($url,$jsonMenu);
// 		// 		$r = UTool::curlPost ( $url, $jsonMenu );
		return $r;
	
	}
	
	

	
	/**
	 * 更新位置信息
	 * @param unknown $weChat
	 * @return string
	 */
	private function receiveLocation($autoUpload=FALSE){
		$weChatEnt = $this->weChatEnt;
		
		$msg = $weChatEnt->msg;
		$userId =(string) ($msg->FromUserName);
		if ($autoUpload==TRUE){
			$latitude = $msg->Latitude;
			$longitude = $msg-> Longitude;
		}else{
			$latitude = $msg->Location_X;
			$longitude = $msg-> Location_Y;
		}
// 		$weiUser = WeixinOpenid::model()->findByAttributes(array('wo_open_id'=>$userOpenId));
		$weiUser = WeixinOpenid::model()->getUserByOpenId($userOpenId);
		if (isset($weiUser)){
			$locationRlt = UMap::convertGEO($longitude.','.$latitude);
// 			Yii::log(json_encode($locationRlt),CLogger::LEVEL_INFO,'mngr.mweixin.location');
			if ($locationRlt->status == 0){
// 				Yii::log('5',CLogger::LEVEL_INFO,'mngr.mweixin.location');
				$longitude_x = $locationRlt->result[0]->x;
				$latitude_y = $locationRlt->result[0]->y;
				$weiUser['wo_location']=$longitude_x.','.$latitude_y;
				Yii::app()->session['currLocation']=$weiUser['wo_location'];
				
				$userLocation = new UserLocation();
				$userLocation['ul_datetime']=date('Y-m-d H:i:s',time());
				$userLocation['ul_latitude']=$latitude_y;
				$userLocation['ul_longitude']=$longitude_x;
				$userLocation['ul_user_openid'] = $weiUser['id'];
				$userLocation->save();
				
				
			}
			$weiUser['wo_update_time']=date('Y-m-d H:i:s',time());
			$weiUser->save();
			
			
			
			
		}else{
// 			Yii::log('4',CLogger::LEVEL_INFO,'mngr.mweixin.location');
// 			$t='2';
		}

		return $longitude.','.$latitude.$msg->FromUserName.':'.$t.":".$weiUser->id;
		
		
		
		
		
	} 
	
	
	
	

	
	

	
	
	
	
	
	
	private function receiveEvent() {
		$weChatEnt = $this->weChatEnt;

		$content = '';
		$msg = $weChatEnt->msg;
		$event = (string)($msg->Event);
		
		
		switch (strtolower($event) ) {
			case 'subscribe' :
				$openId = $obj->FromUserName;
				$weiUserAddRlt = WeixinOpenid::model()->addUser($openId);
				if ($weiUserAddRlt['status']){
					$content = $this->getWelcomeMsgsWithPics($weChat);
				}else{
					$content = $weChat->makeText(null);
				}
				
				
				break;
			case 'unsubscribe' :
				$content = '';
				break;
			case 'location':
// 				Yii::log('111',CLogger::LEVEL_INFO,'mngr.weixin.location');
// 				$content = $this->receiveLocation($weChat,TRUE);
// 				$content = $weChat->makeText('ff');
				$content=NULL;
				
				break;
			case 'view':
// 				$content =  $obj->FromUserName.';'.$obj->EventKey;
// 				$content = $weChat->makeText($content);
// 				Yii::log($content,CLogger::LEVEL_INFO,'mngr.weixin.view.url');
				break;
			case 'click' :
// 				$loginStatus = $this->checkLogin($weChat);
// 				if ($loginStatus['status'] == FALSE){
// 					$content = $this->getWelcomeMsgsOnlyText($weChat);
// 					return $content;
// 				}
				$eventKey =(string) ($msg->EventKey);
				switch (strtolower($eventKey)) {
					case "ordertoday" :
// 						$content = $weChatEnt->makeJsonText("今日订单");
						$content = $this->getOrderToday();
						$content = $weChatEnt->makeJsonText($content);
						break;
					case 'orderunack':
						$content = $weChatEnt->makeJsonText("待确认订单");
						
						break;
					case 'ordermonth':

							$content = $weChatEnt->makeJsonText("本月订单");

						break;
					case 'orderyear':
							$content = $weChatEnt->makeJsonText("本年订单");
						break;
						
					case 'hui':
						$content = $this->getHuiWithPics($weChat);
						break;
					default :
// 						$content = @'收到事件' . $obj->Event.$obj->EventKey;
// 				$content = $weChat->makeText ($content.'<a href="www.woxiche.com/site/login">登陆</a>  ' );
						$loginStatus = $this->checkLogin($weChat);
						if ($loginStatus['status'] == FALSE){
							$content = $this->getWelcomeMsgsOnlyText($weChat);
						}else {
// 							$this->sendTplMsgOrderNew($weChat);
							$content = $weChat->makeText('自动登陆成功');
						}
						break;
				}
				;
				break;
			
			default :
// 				$content = @'收到事件' . $obj->Event.$obj->EventKey;
// 				$content = $weChat->makeText ($content.'<a href="www.woxiche.com/site/login">登陆</a>  ' );
$content = 'unknow';
// 				$content = $this->getWelcomeMsgs($weChat);
// 				$content = $this->createLoginText();
// 				$weChat->makeText($content);
				break;
		}
		
		// $result = $this->transmitText ( $obj, $content );
		return $content;
	}
	
	
	
	


	
	
	
	
	
	// Uncomment the following methods and override them if needed
	/*
	 * public function filters() { // return the filter configuration for this controller, e.g.: return array( 'inlineFilterName', array( 'class'=>'path.to.FilterClass', 'propertyName'=>'propertyValue', ), ); } public function actions() { // return external action classes, e.g.: return array( 'action1'=>'path.to.ActionClass', 'action2'=>array( 'class'=>'path.to.AnotherActionClass', 'propertyName'=>'propertyValue', ), ); }
	 */
}