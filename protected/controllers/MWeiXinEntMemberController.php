<?php
class MWeiXinEntMemberController extends Controller {
	
	// const TOKEN = 'wXC.2015.?';
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
								'index' 
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
		);

	}
	public function restEvents() {
		$this->onRest ( 'post.filter.req.auth.ajax.user', function ($validation) {
			// return true;
			// if(!$validation) {
			// return false;
			// }
			switch ($this->getAction ()->getId ()) {
				case 'REST.GET' :
					return true;
				case 'REST.POST' :
					return true;
					break;
				case 'REST.UPDATE' :
					return Yii::app ()->user->checkAccess ( 'REST-UPDATE' );
					break;
				case 'REST.DELETE' :
					return Yii::app ()->user->checkAccess ( 'REST-DELETE' );
					break;
				default :
					return false;
					break;
			}
			// return ($this->getAction()->getId() == 'REST.GET');
			// return true;
		} );
	}
	var $_token = 'w111';
	

	public function actionIndex() {
// 		$appName = 'EntOrderMngr';
		include_once('emoji.php');

// 		$weixinEnt = new UWeChatEnt('EntOrder',);
		
// 		Yii::log ( '1ww', CLogger::LEVEL_INFO, 'mngr.mweixinC' );
		// 		$this->render('/user/reg');
		$weixinEnt = new UWeChatEnt (AppName::$EntMemberMngr, Yii::app()->request->getParam('nonce'),
				Yii::app()->request->getParam('msg_signature'),
				Yii::app()->request->getParam('timestamp'),
				Yii::app()->request->getParam('echostr',NULL)
		);
		$weixinEnt->debug=TRUE;
// 		$rlt = $weixinEnt->valid();
		
		
// // 		$weixin->token = $this->_token;
// // 		$weixin->debug = true;
// // 		$rlt = $weixin->valid ();
		
// 		if (! $rlt) {
// 			Yii::app ()->end ();
// 		}
		
		$weixinEnt->init();
		
// 		$content = $weixinEnt->makeJsonText("dd");
// 		$weixinEnt->reply($content);
		$reply= '';
		$msg = $weixinEnt->msg;
		$msgType =(string) ($msg->MsgType);
		$msgType=empty($msgType) ? '' : strtolower($msgType);
		
// 		$msgType='text';
		switch ($msgType){
			
			case 'text':
				$content = $this->receiveText($weixinEnt);
// 				$content = $msg->Content;
			
// 				$content = $weixinEnt->makeJsonText(trim($content));
// 				Yii::log (CJSON::encode($content), CLogger::LEVEL_INFO, 'mngr.mweixinEntC.msgContent' );
// 				$weixinEnt->reply($content);
				break;
			case 'event':
				$content = $this->receiveEvent ( $weixinEnt );
				break;
			default:
				
			break;
		}
		
		$weixinEnt->reply($content);
// 		$weixinEnt->inviteUser("sys100");
		
// 		$accessToken = $weixinEnt->getToken();
// 		Yii::log ( $weixinEnt->msg->FromUserName.$weixinEnt->msg->Content, CLogger::LEVEL_INFO, 'mngr.mweixinEntC.jsonContent' );
// 		$content = array('touser'=>'100','msgtype'=>'text','agentid'=>'13','text'=>array('content'=>'默认值'),'safe'=>'0');
// 		$content = $weixinEnt->makeJsonText('默认值');
// 		Yii::log ( json_encode($content), CLogger::LEVEL_INFO, 'mngr.mweixinEntC.jsonContent' );
// 		$weixinEnt->reply($content);
// 		Yii::log ( $accessToken, CLogger::LEVEL_INFO, 'mngr.mweixinEntC.accessToken' );
		
// 		include_once('emoji.php');
// 		Yii::log ( 'ent order 1ww'.Yii::app()->request->getHostInfo().Yii::app()->request->url, CLogger::LEVEL_INFO, 'mngr.mweixinEntC' );
// 		Yii::log ( $weixinEnt->msg->FromUserName, CLogger::LEVEL_INFO, 'mngr.mweixinEntC.fromUserName' );
		
		
// $sVerifyMsgSig = Yii::app()->request->getParam('msg_signature');
// $sVerifyTimeStamp = Yii::app()->request->getParam('timestamp');
// $sVerifyNonce = Yii::app()->request->getParam('nonce');
// $sVerifyEchoStr = Yii::app()->request->getParam('echostr');

// // 需要返回的明文
// $sEchoStr =NULL;

// $weiXinAppConfig = WeixinCtoken::model()->findByAttributes(array('wc_app_name'=>$appName));
// Yii::log ( CJSON::encode($weiXinAppConfig), CLogger::LEVEL_INFO, 'mngr.mweixinEntC.weixinAppConfig' );

// if (isset($weiXinAppConfig)){
// 	$token = $weiXinAppConfig['wc_user_token'];
// 	$encodingAesKey = $weiXinAppConfig['wc_encoding_aeskey'];
// 	$corpId = $weiXinAppConfig['wc_corp_id'];
// 	$weixinEnt = new UWeChatEnt($token, $encodingAesKey, $corpId);
// 	$errCode = $weixinEnt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
// }
// else {
// 	$errCode = ErrorCode::$ValidateCorpidError;
// }

// Yii::log ($errCode.'hhh', CLogger::LEVEL_INFO, 'mngr.mweixinEntC.code' );

// $postStr = empty ( $GLOBALS ["HTTP_RAW_POST_DATA"] ) ? '' : $GLOBALS ["HTTP_RAW_POST_DATA"];
// // $this->postString = $postStr;
// Yii::log($postStr,CLogger::LEVEL_INFO,'mngr.uwechatEnt.ini.postStr');
// // $rlt =UTool::xml_to_array($postStr);// simplexml_load_string ( $postStr );
// // $rlt = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );

// // 		Yii::log($postStr,CLogger::LEVEL_INFO,'mngr.uwechat.init.poststr');
// // if ($this->debug) {
// // 	$this->log ( $postStr );
// // }

// // 		$sReqData = "<xml><ToUserName><![CDATA[wx5823bf96d3bd56c7]]></ToUserName><Encrypt><![CDATA[RypEvHKD8QQKFhvQ6QleEB4J58tiPdvo+rtK1I9qca6aM/wvqnLSV5zEPeusUiX5L5X/0lWfrf0QADHHhGd3QczcdCUpj911L3vg3W/sYYvuJTs3TUUkSUXxaccAS0qhxchrRYt66wiSpGLYL42aM6A8dTT+6k4aSknmPj48kzJs8qLjvd4Xgpue06DOdnLxAUHzM6+kDZ+HMZfJYuR+LtwGc2hgf5gsijff0ekUNXZiqATP7PF5mZxZ3Izoun1s4zG4LUMnvw2r+KqCKIw+3IQH03v+BCA9nMELNqbSf6tiWSrXJB3LAVGUcallcrw8V2t9EL4EhzJWrQUax5wLVMNS0+rUPA3k22Ncx4XXZS9o0MBH27Bo6BpNelZpS+/uh9KsNlY6bHCmJU9p8g7m3fVKn28H3KDYA5Pl/T8Z1ptDAVe0lXdQ2YoyyH2uyPIGHBZZIs2pDBS8R07+qN+E7Q==]]></Encrypt><AgentID><![CDATA[218]]></AgentID></xml>";
// $sReqData = $postStr;
// $sMsg = "";  // 解析之后的明文
// $errCode = $weixinEnt->DecryptMsg($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $postStr, $sMsg);
// if ($errCode == 0) {
// 	// 解密成功，sMsg即为xml格式的明文
// 	// TODO: 对明文的处理
// 	// For example:
// 	$rlt = simplexml_load_string ( $sMsg, 'SimpleXMLElement', LIBXML_NOCDATA );
// 	Yii::log($sMsg,CLogger::LEVEL_INFO,'mngr.uwechatEnt.decrypt.postStr');
// 	Yii::log($rlt->FromUserName,CLogger::LEVEL_INFO,'mngr.uwechatEnt.decrypt.postStr.content');
// // 	$xml = new DOMDocument();
// // 	$xml->loadXML($sMsg);
// // 	$content = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
// // 	print("content: " . $content . "\n\n");
// 	// ...
// 	// ...
// } else {
// 	Yii::log($errCode,CLogger::LEVEL_INFO,'mngr.uwechatEnt.decrypt.postStr');
// // 	print("ERR: " . $errCode . "\n\n");
// 	//exit(-1);
// }

// if ($errCode == 0) {
// 	if (isset($sEchoStr)){
// 		echo $sEchoStr;
// 		return ;
// 		Yii::app()->end();
// 	}
// // 	$accessToken = $weixin->getToken("EntOrder");
// // 	Yii::log ($accessToken, CLogger::LEVEL_INFO, 'mngr.mweixinEntC.code' );
	
	
// 	//
// 	// 验证URL成功，将sEchoStr返回
// 	// HttpUtils.SetResponce($sEchoStr);
// } else {
// 	print("ERR: " . $errCode . "\n\n");
// }
// 		
// Yii::log('dd',CLogger::LEVEL_INFO,'mngr.mweixinent');
// // 		$this->render('/user/reg');
// 		$weixin = new UWeChatEnt ('EntOrder', Yii::app()->request->getParam('nonce'),
// 				Yii::app()->request->getParam('msg_signature'),
// 				Yii::app()->request->getParam('timestamp'),
// 				Yii::app()->request->getParam('echostr')
// 				);
		
// 		$weixin->token = $this->_token;
// 		$weixin->debug = true;
// 		$rlt = $weixin->valid ();

// 		if (! $rlt) {
// 			Yii::app ()->end ();
// 		}
		
// 		$weixin->init ();

// 		$reply = '';
// 		$msgType = empty ( $weixin->msg->MsgType ) ? '' : strtolower ( $weixin->msg->MsgType );
// 		switch ($msgType) {
// 			case 'text' :
// // 				$this->sendTplMsgOrderNew($weixin);
// // 				$reply = $this->getWelcomeMsgsWithPics($weixin);
// 				$reply = $this->receiveText($weixin);
// 				break;
// 			case 'image' :
// 				// 你要处理图文消息代码
// 				break;
// 			case 'location' :
// 				$reply = $this->receiveLocation($weixin);
// 				$reply = $weixin->makeText($reply);
// 				break;
// 			case 'link' :
// 				// 你要处理链接消息代码
// 				break;
// 			case 'event' :
// 				$reply = $this->receiveEvent ( $weixin );
// 				break;
// 			default :
// 				// 无效消息情况下的处理方式
// // 				$reply = $weixin->makeText('请稍后重试');
// 				$reply = $this->getWelcomeMsgsWithPics($weixin);
// 				break;
// 		}
		
// // 		$weixin->reply ( $reply );
// // 		$this->sendTplMsgOrderNew($weixin);
		
// 		$weixin->reply ( $reply );
	}
	
	
	private function receiveText($weixinEnt){
		
		$msgContent =(string) ($weixinEnt->msg->Content); 
		$msgContent = trim($msgContent);
// 		$content = $weixinEnt->make
// 		$loginStatus = $this->checkLogin($weChat);
// 		$obj = $weChat->msg;
// 		$content = '';
		switch (strtolower($msgContent)){
			case 'updatemenu':
				
// 					$content =$weixinEnt->createMenu() ;
					$content = $this->createMenu($weixinEnt);
// 					$weixinEnt->makeJsonText($msgContent);
// 					$content = $weChat->makeText($content);
	
					// 				$content = $weChat->createText($content);
					break;
// 					case '100':
// 						$orderAckRlt = $this->userAckOrder($weChat);
	
// 						if ($orderAckRlt['status']){
// 							$content = $weChat->makeText('订单确认成功!');
// 						}else {
// 							$content = $weChat->makeText($orderAckRlt['msg']);
// 						}
// 						// 				$content = $weChat->makeText('订单确认成功!');
// 						break;
					default:
// 						$msg = "您尚未绑定【我洗车】账号\n\n点击 ";
// 						$msg .= '<a href="'.UWeChat::getUrl(Yii::app()->createAbsoluteUrl('site/login',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE,NULL). '"> 登陆 </a>';
// 						$msg .="进行绑定.\n\n";
// 						$msg .= '新用户请 ';
// 						$msg .= '<a href="'.UWeChat::getUrl(Yii::app()->createAbsoluteUrl('user/reg',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE, null).'"> 注册 </a>';
// 						$msg .= ', 尊享更多专属优惠！';
						$content ="回复序号查看相关内容： \n\n";
						$content.= "[1]  到店车主\n";
						$content.= "[2]  招募会员\n";
						$content.= "[3]  会员统计\n";
						$content.= "[4]  活跃会员\n";
						$content.= "[5]  非活跃会员\n";
// 						$content = $msg;
// 						$content = $this->getWelcomeMsgsWithPics($weChat);
						break;
				}
// 				$content = $weixinEnt->makeJsonText($msgContent);
				$content = $weixinEnt->makeJsonText($content);
				return $content;
	
		}

		
	private function getMenuData(){
		
		return $jsonMenu;
	}	
		
	private function createMenu($wexinEntObj) {
	
		$btnUserOrdered=array('type'=>'click',
				'name'=>'到店车主',
				'key'=>'userOrdered'
		);
		$jsonMenu[]=$btnUserOrdered;
		
		$btnMemberInvite=array('type'=>'click',
				'name'=>emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1f4e2)).'招募会员',
				'key'=>'memberInvite'
		);
		$jsonMenu[]=$btnMemberInvite;
		
		
		$btnMemberStat=array('type'=>'click',
				'name'=>'会员统计',
				'key'=>'memberStat'
		);
		$btnMemberActive=array('type'=>'click',
				'name'=>'活跃会员',
				'key'=>'memberActive'
		);
		$btnMemberInActive=array('type'=>'click',
				'name'=>'非活跃会员',
				'key'=>'memberInActive'
		);
			
		$jsonMenu[]=array(
				'name'=>'我的会员',
				'sub_button'=>array(
						$btnMemberActive,
						$btnMemberInActive,
						$btnMemberStat
						
				)
		);
	
		$jsonMenu = array('button' => $jsonMenu );
	
		
		$r = $wexinEntObj->createMenu($jsonMenu);
		
// 		$jsonMenu = json_encode($jsonMenu,JSON_UNESCAPED_UNICODE);
	
// // 		Yii::log($jsonMenu,CLogger::LEVEL_INFO,'mngr.mWeiXinC.createMenu');
	
// 		$url = UWeChatEnt::WXENT_API . 'menu/create?access_token=' . $weChatEntObj->getToken ();
// 		$r = UTool::https_request($url,$jsonMenu);
// 		// 		$r = UTool::curlPost ( $url, $jsonMenu );
		return $r;
	
	}
	
	
	private function sendTplMsgOrderNew($obj, $order) {
		$openid = $obj->msg->FromUserName . '';
		
		$orderType = $order->serviceType['st_name'];
		$orderStartTime = strtotime( $order['oh_date_time']);
		$orderEndTime =strtotime( $order['oh_date_time_end']);
		$orderPayValue = $order['oh_value'] - $order['oh_value_discount'];
		$url = "www.woxiche.com/boss/list";
		$infos = array (
				"touser" => $openid,
				"template_id" => "FqDXhQpxVj6KspMTps7wc2ZQJtJQg-B6TCOAGcXD3Kg",
				"url" => $url,
				"topcolor" => "#7b68ee",
				"data" => array (
						"first" => array (
								"value" => $openid,
								"color" => "#743a3a" 
						),
						"service" => array (
								"value" => $orderType,
								"color" => "#743a3a" 
						),
						"datetime" => array (
								"value" => date ( 'm月d日 H:00-' ,$orderStartTime) . date ( 'H:20',$orderEndTime ),
								"color" => "#0000ff" 
						),
						"price" => array (
								"value" => $orderPayValue,
								"color" => "#ff0000" 
						),
						"remark" => array (
								"value" => "渐进生活，尽在我洗车",
								"color" => "#080000" 
						) 
				) 
		);
		$jsonData = CJSON::encode ( $infos );
		
		$url = UWeChat::WX_API . 'message/template/send?access_token=' . $obj->getToken ();
		$r = UTool::curlPost ( $url, $jsonData );
		// $r = $openid;
		// $r=$jsonData;
		return $r;
	}
	

	
	/**
	 * 更新位置信息
	 * @param unknown $weChat
	 * @return string
	 */
	private function receiveLocation($weChat ,$autoUpload=FALSE){
		$msg = $weChat->msg;
		$userOpenId = $msg->FromUserName;
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
// 		if ($weiUser === null){
// 			WeixinOpenid::model()->addUser($msg->FromUserName);
// 			$weiUser = WeixinOpenid::model()->getUserByOpenId($msg->FromUserName);
// 		}
// 		Yii::log(json_encode($weiUser),CLogger::LEVEL_INFO,'mngr.weixin.location');
// 		if (isset($weiUser)){
// 			$weiUser['wo_location']=$latitude.','.$longitude;
// 			$weiUser['wo_update_time']=time();
// 			$weiUser->save();
			
// 			$location = new UserLocation();
// 			$location['ul_datetime']=time();
// 			$location['ul_latitude']=$latitude;
// 			$location['ul_longitude']=$longitude;
// 			$location['ul_user_openid']=$weiUser['id'];
// 			$location->save();
// 		}
		return $longitude.','.$latitude.$msg->FromUserName.':'.$t.":".$weiUser->id;
		
		
		
		
		
	} 
	
	
	
	
	private function getHuiWithPics($weChat){
		$weiUser = WeixinOpenid::model()->getUserByOpenId($weChat->msg->FromUserName);
		$cityId = '';
		if (isset($weiUser)){
			$currentLocation = $weiUser ['wo_location'];
			if (! isset ( $currentLocation )) {
				// ip定位
				$ip = Yii::app ()->request->userHostAddress;
				$address_information = Yii::app ()->geoip->getCityInfoForIp ( $ip );
				$currentLocation = $address_information ['longitude'] . ',' . $address_information ['latitude'];
			}
			// 经纬度定位
			$currentLocation = explode ( ',', $currentLocation );
			$currentLocation_lng = @$currentLocation ['0'];
			$currentLocation_lat = @$currentLocation ['1'];
			$infoRlt = UMap::getInfoByLocation ( $currentLocation_lng . ',' . $currentLocation_lat );
			$infoRlt = json_decode ( $infoRlt, JSON_UNESCAPED_UNICODE );
			if ($infoRlt ['status'] == 0) {
				$cityName = $infoRlt ['result'] ['addressComponent'] ['city'];
				$criteria = new CDbCriteria ();
				$criteria->addSearchCondition ( 'c_name', $cityName );
				$city = City::model ()->find ( $criteria );
				$cityId = @$city ['id'];
			}
		}
		
// 		$cityId=1;
		$huiRlt = CityHui::model()->getHuiList($cityId);
// 		Yii::log(CJSON::encode($huiRlt),CLogger::LEVEL_INFO,'mngr.hui.list');
		if ($huiRlt == null){
			$output = $weChat->makeText('您所在城市喜车惠即将开通，请稍后重试');
			return $output;
		}
		$output =array();
		foreach ($huiRlt as $key=>$hui){
			$output['items'][]=array(
					'title'=>$hui->hui['h_name'],
					'description'=>'',
					'picurl'=> Yii::app()->request->hostInfo. Yii::app()->baseUrl.'/images/hui/'.$hui->hui['id'].'/h'.$hui->hui['id'].'.jpg',
					'url'=>UWeChat::getUrl(Yii::app()->createAbsoluteUrl('hui/list',array('id'=>$hui->hui['id'],'src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE, null),
			);
		}
		
		return $weChat->makeNews($output);
		
		
		
	
	}
	
	private function getWelcomeMsgsWithPics($weChat){
		$news=array();
		$news['items'][]=array(
				'title'=>'【新用户注册】',
				'description'=>'新用户注册',
				'picurl'=> Yii::app()->request->hostInfo. Yii::app()->baseUrl.'/images/shops/22/shop22.jpg',
				'url'=>UWeChat::getUrl(Yii::app()->createAbsoluteUrl('user/reg',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE, null),
		);
		$news['items'][]=array(
				'title'=>'【登录】绑定微信',
				'description'=>'登录',
				'picurl'=>  Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/shops/22/shop22.jpg',
				'url'=> UWeChat::getUrl(Yii::app()->createAbsoluteUrl('site/login',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE,NULL),
		);
		return   $weChat->makeNews($news);
	}
	
	

	private function getWelcomeMsgsOnlyText($weChat){
		
		$msg = "您尚未绑定【我洗车】账号\n\n点击 ";
		$msg .= '<a href="'.UWeChat::getUrl(Yii::app()->createAbsoluteUrl('site/login',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE,NULL). '"> 登陆 </a>';
		$msg .="进行绑定.\n\n";
		$msg .= '新用户请 ';
		$msg .= '<a href="'.UWeChat::getUrl(Yii::app()->createAbsoluteUrl('user/reg',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE, null).'"> 注册 </a>';
		$msg .= ', 尊享更多专属优惠！';
		$content = $weChat->makeText($msg);
		// 		$weChat->reply($content);
		return $content;
	}
	
	
	
	
	private function userFavoriate($weChat){
		$weiUser = WeixinOpenid::model()->getUserByOpenId($weChat->msg->FromUserName);
		$userId = @$weiUser['wo_user_id'];
		$currentLocation = $weiUser['wo_location'];
		$shopList = FavoriteShop::model()->getUserFavoriteListWithDistance($currentLocation, $userId);
		$shopCount = count($shopList);
		if ($shopCount<1){
			return $weChat->makeText('您还未收藏车行');
		}
		$outList = array();
		Yii::log(json_encode($shopList),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.list');
		foreach ( $shopList as $key => $shop ) {
			if($key>=9){break;}
			Yii::log(json_encode($shop,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.shop');
			$distanceStr = '';
			$distance = $shop['distance'];
			Yii::log(json_encode($shop,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.shop');
			if ($distance < 100) {
				$distanceStr = '<100米';
			} elseif ($distance < 1000) {
				$distanceStr = round ( $distance, 0, PHP_ROUND_HALF_UP ) . '米';
			} else {
				$distanceStr = round ( $distance / 1000, 1, PHP_ROUND_HALF_DOWN ) . '公里';
			}
			$shopTitle = '【'.$distanceStr. "】"
					.emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1f331))
					.round($shop['score'] ,2,PHP_ROUND_HALF_UP) . '分'."\n"
					.$shop['name'];
			$outList ['items'][] = array (
					'title' => $shopTitle,
					'description' => '',
					'picurl'=>'',
					'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg',
					'url' => UWeChat::getUrl ( Yii::app ()->createAbsoluteUrl ( 'order/new', array ('id'=>$shop['id'],
							'src' => 'weixin' 
					) ), UWeChat::SCOPE_SNSAPI_BASE, null )

			);
		}
// 		Yii::log(json_encode($outList,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.list');
		if ($shopCount>9){
		$outList ['items'][] = array (
				'title' => '更多收藏 >>',
				'description' => '',
				'picurl'=>'',
// 				'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg',
				'url' => UWeChat::getUrl ( Yii::app ()->createAbsoluteUrl ( 'user/favorite', array (
						'src' => 'weixin'
				) ), UWeChat::SCOPE_SNSAPI_BASE, null )
		
		);
		}
		$outList = $weChat->makeNews($outList);
// 		Yii::log(json_encode($outList,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.outlist');
		return $outList;
		
	}
	
	
	private function userAckOrder($weChat){
		$rlt = UTool::iniFuncRlt();
// 		$userId =  Yii::app()->user->Id;
// if (Yii::app()->user->isGuest){
// 	$weixinUser = WeixinOpenid::model()->getUserByOpenId($weChat->msg->FromUserName);
// 	$userId = $weixinUser['wo_user_id'];
// }else{
// 	$userId = Yii::app()->user->Id;
// }
$userId = Yii::app()->user->Id;
		Yii::log($userId,CLogger::LEVEL_INFO,'mngr.weixin.order.userId');
		$orderRlt = OrderHistory::model()->getLatestOrder($userId);
// 		$orderRlt = OrderHistory::model()->getLatestOrder(Yii::app()->user->Id);
		Yii::log(CJSON::encode($orderRlt),CLogger::LEVEL_INFO,'mngr.weixin.order.latest');
		if ($orderRlt['status']){
			$order = $orderRlt['data'];
// 			if ( strtotime($order['oh_date_time_end']) < time() 
// 					|| $order['oh_user_ack'] == 0){
				$rlt = OrderHistory::model()->getOrderAckbyUser($order['id'], Yii::app()->user->Id, 1);
				Yii::log(json_encode($rlt),CLogger::LEVEL_INFO,'mngr.weixin.order.ack');
// 				return $rlt;
// 			}
		}
		
		return $rlt;
	}
	
	
	
	private function receiveEvent($weixinEnt) {
		
		
// 		$msgContent =(string) ($weixinEnt->msg->Content);
// 		$msgContent = trim($msgContent);
// 		$obj = $weChat->msg;
		$content = '';
		$msg = $weixinEnt->msg;
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
				
// 				$weixinUser = WeixinOpenid::model()->getUserByOpenId($openId);
// 				if ($weixinUser === null){
// 					$content = $weChat->makeText('请稍后重试');
// 				}else {
						
// 					$signRlt = WeixinOpenid::model()->getWeixinOpenIdSign($weixinUser['id']);
// 					Yii::log(CJSON::encode($signRlt),CLogger::LEVEL_INFO,'mngr.weixin.user.openid');
// 					$sign=null;
// 					if ($signRlt['status']){
// 						$sign = $signRlt['data'];
// 					}
// 					$this->createMenu ( $weChat);
// 					$content = $this->getWelcomeMsgsWithPics($weChat);
// 				}
				
				break;
			case 'unsubscribe' :
				$content = '';
				break;
			case 'location':
// 				Yii::log('111',CLogger::LEVEL_INFO,'mngr.weixin.location');
				$content = $this->receiveLocation($weChat,TRUE);
// 				$content = $weChat->makeText('ff');
				$content=NULL;
				
				break;
			case 'view':
				$content =  $obj->FromUserName.';'.$obj->EventKey;
				$content = $weChat->makeText($content);
				Yii::log($content,CLogger::LEVEL_INFO,'mngr.weixin.view.url');
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
						$content = $weixinEnt->makeJsonText("今日订单");
				
						break;
					case 'orderunack':
						$content = $weixinEnt->makeJsonText("待确认订单");
						
						break;
					case 'ordermonth':

							$content = $weixinEnt->makeJsonText("本月订单");

						break;
					case 'orderyear':
							$content = $weixinEnt->makeJsonText("本年订单");
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
				$content = @'收到事件' . $obj->Event.$obj->EventKey;
				$content = $weChat->makeText ($content.'<a href="www.woxiche.com/site/login">登陆</a>  ' );
// 				$content = $this->getWelcomeMsgs($weChat);
// 				$content = $this->createLoginText();
// 				$weChat->makeText($content);
				break;
		}
		
		// $result = $this->transmitText ( $obj, $content );
		return $content;
	}
	
	private function userOrder($weChat){
		$userId = Yii::app()->user->Id;
		$orderRlt = OrderHistory::model()->getLatestOrder($userId);
		if ($orderRlt['status']) {
			$order = $orderRlt['data'];
			$list = array();
			$orderType = $order->serviceType['st_name'];
			$orderTime =date('m月d日 H:i',strtotime($order['oh_date_time'])).'-'.
					date('H:i',strtotime($order['oh_date_time_end']));
			$shop = $order->ohWashShop;
			// 							$shopPic = Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/shops/'.$shop[id].'/shop'.$shop[id].'.jpg';
			$shopPic= Yii::app()->request->hostInfo. Yii::app()->baseUrl.'/images/shops/22/shop22.jpg';
			$orderPayValue = $order['oh_value']-$order['oh_value_discount'];
			$orderInfo='';
				
			$orderInfo .= "【到店支付】".emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1F4B0)). $orderPayValue."元\n";
			$orderInfo .= '【车行名称】'.$shop['ws_name']."\n";
			$orderInfo .= '【车行地址】'.$shop['ws_address']."\n";
		
			$orderStateIcon = '';
			switch ($order['oh_state']){
				case OrderHistory::ORDER_STATE_CANCEL:
					$orderStateIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x2716));
					break;
				case OrderHistory::ORDER_STATE_SUCCESS:
					$orderStateIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x2705));
					break;
				case OrderHistory::ORDER_STATE_ORDER:
					if ($order['oh_user_ack'] == 1){
						$orderStateIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1f44c));
					}else{
						$orderStateIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x2757));
					}
					
					break;
				case OrderHistory::ORDER_STATE_OVERDUE:
					$orderStateIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1F6ab));
					break;
				default:
					$orderStateIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x274c));
					break;
						
			}
			$orderInfo .= "【订单状态】".$orderStateIcon.OrderHistory::model()->getOrderStateString($order['oh_state'],$order['oh_user_ack'])."\n\n";
				
			$orderInfo .= "更多功能，请输入下列数字代码\n\n";
			// 							$text = preg_replace("#///u([0-9a-f]+)#ie","iconv('UCS-2','UTF-8', pack('H4', '//1'))",'ue488');
			// 							$emojiData = emoji_
			// 							include('emoji.php');
			// 							emoji_get_name('first quarter moon with face');
			$listIcon = emoji_softbank_to_unified( UWeChat::utf8_bytes(0x1f539));
			$orderInfo .= $listIcon. "100   确认订单\n";
			$orderInfo .= $listIcon."101   取消订单\n";
			$orderInfo .= $listIcon. "1000   确认全部订单\n";
		
			$list['items'][]=array(
					'title'=>"".$orderStateIcon."【".$orderType."】".$orderTime,
					// 									'title'=>'d',
					'description'=>$orderInfo,
					'picurl'=>$shopPic,
					'url'=>UWeChat::getUrl(Yii::app()->createAbsoluteUrl('user/list',array('src'=>'weixin')), UWeChat::SCOPE_SNSAPI_BASE, null),
			);
			$content = $weChat->makeNews($list);
		}else{
			$content = $weChat->makeText('未找到有效订单，欢迎预订');
		}
		
		return $content;
	}
	
	
	
	private function checkLogin($weChat){
		$rlt = UTool::iniFuncRlt();
		$autoLoginRlt = WeixinOpenid::model()->loginByOpenId($weChat->msg->FromUserName);
		if ($autoLoginRlt['status'] == FALSE) {
			$rlt['msg']=$this->getWelcomeMsgsOnlyText($weChat);
		}else {
			$rlt['status']=TRUE;
		}
		return $rlt;
	}

	
	
	public function actionLogout() {
	}
	
	private function saveUserInfo($userInfo) {
		$rlt = UTool::iniFuncRlt ();
		$openIdModel = WeixinOpenid::model ()->findByAttributes ( array (
				'wo_open_id' => $userInfo ['openid'] 
		) );
		
		if (! isset ( $openIdModel )) {
			$openIdModel = new WeixinOpenid ();
			$openIdModel ['wo_open_id'] = $userInfo ['openid'];
			if (! $openIdModel->save ()) {
				Yii::log ( CJSON::encode ( $openIdModel ), CLogger::LEVEL_WARNING, 'mngr.mweixinC.saveUserInfo.saveModel' );
				$rlt ['msg'] = '保存用户信息失败';
				return $rlt;
			}
			$rlt ['status'] = true;
			return $rlt;
		} 

		else {
			
			$openIdModel ['wo_sub_datetime'] = $userInfo ['subscribe_time'];
			$openIdModel ['wo_nickname'] = $userInfo ['nickname'];
			$openIdModel ['wo_city'] = $userInfo ['city'];
			$openIdModel ['wo_province'] = $userInfo ['province'];
			if (! $openIdModel->save ()) {
				Yii::log ( CJSON::encode ( $openIdModel ), CLogger::LEVEL_WARNING, 'mngr.mweixinC.saveUserInfo.saveModel' );
				$rlt ['msg'] = '保存用户信息失败';
				return $rlt;
			}
			$rlt ['status'] = true;
			return $rlt;
		}
		
		return $rlt;
	}
	
	// Uncomment the following methods and override them if needed
	/*
	 * public function filters() { // return the filter configuration for this controller, e.g.: return array( 'inlineFilterName', array( 'class'=>'path.to.FilterClass', 'propertyName'=>'propertyValue', ), ); } public function actions() { // return external action classes, e.g.: return array( 'action1'=>'path.to.ActionClass', 'action2'=>array( 'class'=>'path.to.AnotherActionClass', 'propertyName'=>'propertyValue', ), ); }
	 */
}