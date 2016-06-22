<?php
class MWeiXinController extends Controller {
	
	/*
	 * 服务号对应的应用名称
	 */
	public $appName;
	
	/*
	 * 初始化后的UWeChat实例
	 */
	private $weChat;
	
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete' 
		); // we only allow deletion via POST request
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
						'allow', // allow all users to perform 'index'
						'actions' => array (
								'index' 
						),
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function actionIndex() {
		include_once ('emoji.php');
		$this->appName = AppName::$OpenService;
		// 初始化微信
		
		$weChat = new UWeChat ( 
				$this->appName, 
				Yii::app ()->request->getParam ( 'nonce' ),
				 Yii::app ()->request->getParam ( 'signature' ), 
				Yii::app ()->request->getParam ( 'timestamp' ),
				 Yii::app ()->request->getParam ( 'echostr' ) 
				);
		
		$weChat->debug = true;
		
		$rlt = $weChat->valid ();
		if (! $rlt) {
			Yii::app ()->end ();
		}
		$weChat->init ();
		
		// 保存到全局变量
		$this->weChat = $weChat;
// 		$weChat->log('1');
		$reply = '';
		$msgType = $weChat->msg->MsgType;
		$msgType = empty ( $msgType ) ? '' : strtolower ( $msgType );
		switch ($msgType) {
			case 'text' :
				$reply = $this->receiveText ();
				break;
			case 'image' :
				// 你要处理图文消息代码
				break;
			case 'location' :
				$reply = $this->receiveLocation ();
				$reply = $weChat->makeText ( $reply );
				break;
			case 'link' :
				// 你要处理链接消息代码
				break;
			case 'event' :
				$reply = $this->receiveEvent ();
				break;
			default :
				// 无效消息情况下的处理方式
				$reply = $this->getWelcomeMsgsWithPics ();
				break;
		}
		$weChat->reply ( $reply );
	}
	
	
	/**
	 * 更新位置信息
	 *
	 * @param UWeChat $weChat        	
	 * @param boool $autoUpload
	 *        	是否来自于自动上报位置信息
	 * @return string
	 */
	private function receiveLocation($autoUpload = FALSE) {
		$weChat = $this->weChat;
		$msg = $weChat->msg;
		$userOpenId = $msg->FromUserName;
		if ($autoUpload == TRUE) {
			$latitude = $msg->Latitude;
			$longitude = $msg->Longitude;
		} else {
			$latitude = $msg->Location_X;
			$longitude = $msg->Location_Y;
		}
		
		$weiUser = WeixinOpenid::model ()->getUserByOpenId ( $userOpenId, $weChat->appServiceId );
		
		if (! isset ( $weiUser )) {
			
			$weiUserAddRlt = WeixinOpenid::model ()->addUser ( $userOpenId, $weChat->appServiceId );
			$weiUser = WeixinOpenid::model ()->getUserByOpenId ( $userOpenId, $weChat->appServiceId );
		}
		
		if (isset ( $weiUser )) {
			$locationRlt = UMap::convertGEO ( $longitude . ',' . $latitude );
			
			if ($locationRlt->status == 0) {
				
				$longitude_x = $locationRlt->result [0]->x;
				$latitude_y = $locationRlt->result [0]->y;
				$weiUser ['wo_location'] = $longitude_x . ',' . $latitude_y;
				
				// 存储当前坐标
				Yii::app ()->session ['currLocation'] = $weiUser ['wo_location'];
				
				$userLocation = new UserLocation ();
				$userLocation ['ul_datetime'] = date ( 'Y-m-d H:i:s', time () );
				$userLocation ['ul_latitude'] = $latitude_y;
				$userLocation ['ul_longitude'] = $longitude_x;
				$userLocation ['ul_user_openid'] = $weiUser ['id'];
				$userLocation->save ();
			}
			$weiUser ['wo_update_time'] = date ( 'Y-m-d H:i:s', time () );
			$weiUser->save ();
		}
		
		return $longitude . ',' . $latitude;
	}
	
	/**
	 * 创建菜单
	 *
	 * @param UWeChat $weChat        	
	 * @return array
	 */
	private function createMenu() {
		$weChat = $this->weChat;
		$btnShopList = array (
				'type' => 'view',
				'name' => '我要洗车',
				'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mOrder/list' ), UWeChat::SCOPE_SNSAPI_BASE, NULL ) 
		);
// 		$btnShopTop = array (
// 				'type' => 'view',
// 				'name' => '一键下单',
// 				'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'morder/topShop' ), UWeChat::SCOPE_SNSAPI_BASE, NULL ) 
// 		);
		
// 		$jsonMenu [] = array (
// 				'name' => '我要洗车',
// 				'sub_button' => array (
// 						$btnShopList,
// 						$btnShopTop 
// 				) 
// 		);
		
		$jsonMenu [] = $btnShopList;
		
		$btnHui = array (
				'type' => 'click',
				'name' => emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1f389 ) ) . '喜车惠',
				'key' => 'hui' 
		);
		$jsonMenu [] = $btnHui;
		
		$btnUserOrder = array (
				'type' => 'click',
				'name' => '订单',
				'key' => 'userOrder' 
		);
		$btnUserScore = array (
				'type' => 'click',
				'name' => '积分查询',
				'key' => 'userScore' 
		);
		$btnUserFavoriate = array (
				'type' => 'click',
				'name' => '收藏列表',
				'key' => 'userFavoriate' 
		);
		$btnUserCard = array (
				'type' => 'click',
				'name' => '优惠卷',
				'key' => 'userCard' 
		);
		$btnUserMore = array (
				'type' => 'view',
				'name' => '更多',
				'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mUser/profile' ), UWeChat::SCOPE_SNSAPI_BASE, NULL ) 
		);
		
		$jsonMenu [] = array (
				'name' => '我的',
				'sub_button' => array (
						$btnUserMore,
						$btnUserScore,
						$btnUserFavoriate,
						$btnUserCard,
						$btnUserOrder 
				) 
		);
		
		$jsonMenu = array (
				'button' => $jsonMenu 
		);
		$r = $weChat->createMenu ( $jsonMenu );
		
		$r = json_decode ( $r );
		
		$rlt = UTool::iniFuncRlt ();
		if ($r->errcode == 0) {
			$rlt ['status'] = TRUE;
		}
		$rlt ['msg'] = $r->errmsg;
		$rlt ['data'] = $r->errcode;
		return $rlt;
	}
	private function getHuiWithPics() {
		$weChat = $this->weChat;
		
		$weiUser = WeixinOpenid::model ()->getUserByOpenId ( $weChat->msg->FromUserName, $weChat->appServiceId );
		$cityId = '';
		if (isset ( $weiUser )) {
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
		
		// $cityId=1;
		$huiRlt = CityHui::model ()->getHuiList ( $cityId );
		// Yii::log(CJSON::encode($huiRlt),CLogger::LEVEL_INFO,'mngr.hui.list');
		if ($huiRlt == null) {
			$output = $weChat->makeText ( '您所在城市喜车惠即将开通，请稍后重试' );
			return $output;
		}
		$output = array ();
		foreach ( $huiRlt as $key => $hui ) {
			$output ['items'] [] = array (
					'title' => $hui->hui ['h_name'],
					'description' => '',
					'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/hui/' . $hui->hui ['id'] . '/h' . $hui->hui ['id'] . '.jpg',
					'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mHui/list', array (
							'id' => $hui->hui ['id'] 
					) ), UWeChat::SCOPE_SNSAPI_BASE, null ) 
			);
		}
		
		return $weChat->makeNews ( $output );
	}
	private function getWelcomeMsgsWithPics() {
		$weChat = $this->weChat;
		$news = array ();
		$news ['items'] [] = array (
				'title' => '【新用户注册】',
				'description' => '新用户注册',
				'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg',
				'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mUser/reg' ), UWeChat::SCOPE_SNSAPI_BASE, null ) 
		);
		$news ['items'] [] = array (
				'title' => '【登录】绑定微信',
				'description' => '登录',
				'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg',
				'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mSite/login' ), UWeChat::SCOPE_SNSAPI_BASE, NULL ) 
		);
		return $weChat->makeNews ( $news );
	}
	private function getWelcomeMsgsOnlyText() {
		$weChat = $this->weChat;
		$msg = "您尚未绑定【我洗车】账号\n\n点击 ";
		$msg .= '<a href="' . $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mSite/login' ), UWeChat::SCOPE_SNSAPI_BASE, NULL ) . '"> 登陆 </a>';
		$msg .= "进行绑定.\n\n";
		$msg .= '新用户请 ';
		$msg .= '<a href="' . $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'mUser/reg' ), UWeChat::SCOPE_SNSAPI_BASE, null ) . '"> 注册 </a>';
		$msg .= ', 尊享更多专属优惠！';
		$content = $weChat->makeText ( $msg );
		// $weChat->reply($content);
		return $content;
	}
	private function receiveText() {
		$weChat = $this->weChat;
		$msg = $weChat->msg;
		$contentText = strtolower ( trim ( $msg->Content ) );
		$reply = '';
		switch ($contentText) {
			case 'updatemenu' :
				$rlt = $this->createMenu ( $weChat );
				if ($rlt ['status']) {
					$reply = $weChat->makeText ( $rlt ['msg'] );
				} else {
					$reply = $weChat->makeText ( $rlt ['data'] . ': ' . $rlt ['msg'] );
				}
				break;
			case 'whois' :
				$reply = $weChat->makeText ( $msg->FromUserName );
				break;
			case '100' :
				$orderAckRlt = $this->userAckOrder ( $weChat );
				
				if ($orderAckRlt ['status']) {
					$content = $weChat->makeText ( '订单确认成功!' );
				} else {
					$content = $weChat->makeText ( $orderAckRlt ['msg'] );
				}
				// $content = $weChat->makeText('订单确认成功!');
				break;
			default :
				$reply = $this->getWelcomeMsgsWithPics ( $weChat );
		}
		
		return $reply;
	}
	private function userFavoriate() {
		$weChat = $this->weChat;
		$weiUser = WeixinOpenid::model ()->getUserByOpenId ( $weChat->msg->FromUserName, $weChat->appServiceId );
		$userId = @$weiUser ['wo_user_id'];
		$currentLocation = $weiUser ['wo_location'];
		$shopList = FavoriteShop::model ()->getUserFavoriteListWithDistance ( $currentLocation, $userId );
		$shopCount = count ( $shopList );
		if ($shopCount < 1) {
			return $weChat->makeText ( '您还未收藏车行' );
		}
		$outList = array ();
		Yii::log ( json_encode ( $shopList ), CLogger::LEVEL_INFO, 'mngr.weixin.shop.favoriate.list' );
		foreach ( $shopList as $key => $shop ) {
			if ($key >= 9) {
				break;
			}
			Yii::log ( json_encode ( $shop, JSON_UNESCAPED_UNICODE ), CLogger::LEVEL_INFO, 'mngr.weixin.shop.favoriate.shop' );
			$distanceStr = '';
			$distance = $shop ['distance'];
			Yii::log ( json_encode ( $shop, JSON_UNESCAPED_UNICODE ), CLogger::LEVEL_INFO, 'mngr.weixin.shop.favoriate.shop' );
			if ($distance < 100) {
				$distanceStr = '<100米';
			} elseif ($distance < 1000) {
				$distanceStr = round ( $distance, 0, PHP_ROUND_HALF_UP ) . '米';
			} else {
				$distanceStr = round ( $distance / 1000, 1, PHP_ROUND_HALF_DOWN ) . '公里';
			}
			$shopTitle = '【' . $distanceStr . "】" . emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1f331 ) ) . round ( $shop ['score'], 2, PHP_ROUND_HALF_UP ) . '分' . "\n" . $shop ['name'];
			$outList ['items'] [] = array (
					'title' => $shopTitle,
					'description' => '',
					'picurl' => '',
					'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg',
					'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'order/new', array (
							'id' => $shop ['id'],
							'src' => 'weixin' 
					) ), UWeChat::SCOPE_SNSAPI_BASE, null ) 
			);
		}
		// Yii::log(json_encode($outList,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.list');
		if ($shopCount > 9) {
			$outList ['items'] [] = array (
					'title' => '更多收藏 >>',
					'description' => '',
					'picurl' => '',
					// 'picurl' => Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg',
					'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'user/favorite', array (
							'src' => 'weixin' 
					) ), UWeChat::SCOPE_SNSAPI_BASE, null ) 
			);
		}
		$outList = $weChat->makeNews ( $outList );
		// Yii::log(json_encode($outList,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.weixin.shop.favoriate.outlist');
		return $outList;
	}
	private function userAckOrder() {
		$weChat = $this->weChat;
		$rlt = UTool::iniFuncRlt ();
		// $userId = Yii::app()->user->Id;
		// if (Yii::app()->user->isGuest){
		// $weixinUser = WeixinOpenid::model()->getUserByOpenId($weChat->msg->FromUserName);
		// $userId = $weixinUser['wo_user_id'];
		// }else{
		// $userId = Yii::app()->user->Id;
		// }
		$userId = Yii::app ()->user->Id;
		Yii::log ( $userId, CLogger::LEVEL_INFO, 'mngr.weixin.order.userId' );
		$orderRlt = OrderHistory::model ()->getLatestOrder ( $userId );
		// $orderRlt = OrderHistory::model()->getLatestOrder(Yii::app()->user->Id);
		Yii::log ( CJSON::encode ( $orderRlt ), CLogger::LEVEL_INFO, 'mngr.weixin.order.latest' );
		if ($orderRlt ['status']) {
			$order = $orderRlt ['data'];
			// if ( strtotime($order['oh_date_time_end']) < time()
			// || $order['oh_user_ack'] == 0){
			$rlt = OrderHistory::model ()->getOrderAckbyUser ( $order ['id'], Yii::app ()->user->Id, 1 );
			Yii::log ( json_encode ( $rlt ), CLogger::LEVEL_INFO, 'mngr.weixin.order.ack' );
			// return $rlt;
			// }
		}
		
		return $rlt;
	}
	
	/**
	 * 收到事件
	 *
	 * @param UWeChat $weChat        	
	 * @return string
	 */
	private function receiveEvent() {
		$weChat = $this->weChat;
		$msg = $weChat->msg;
		$event = strtolower ( $msg->Event );
		$content = '';
		
		switch ($event) {
			case 'subscribe' :
				// 订阅事件
				$openId = $msg->FromUserName;
				$weiUserAddRlt = WeixinOpenid::model ()->addUser ( $openId, $weChat->appServiceId );
				if ($weiUserAddRlt ['status']) {
					$content = $this->getWelcomeMsgsWithPics ( $weChat );
				} else {
					$content = $this->getWelcomeMsgsWithPics ( $weChat );
				}
				
				break;
			case 'unsubscribe' :
				$content = '';
				break;
			case 'location' :
				// Yii::log('111',CLogger::LEVEL_INFO,'mngr.weixin.location');
				$content = $this->receiveLocation ( $weChat, TRUE );
				// $content = $weChat->makeText(null);
				$content = NULL;
				
				break;
			case 'view' :
				$content = $msg->FromUserName . ';' . $msg->EventKey;
				$content = $weChat->makeText ( $content );
				Yii::log ( $content, CLogger::LEVEL_INFO, 'mngr.weixin.view.url' );
				break;
			case 'click' :
				$loginStatus = $this->checkLogin ();
				if ($loginStatus ['status'] == FALSE) {
					$content = $this->getWelcomeMsgsOnlyText ( $weChat );
					return $content;
				}
				switch (strtolower ( $msg->EventKey )) {
					case "introduce" :
						// $content = $weChat->getUserInfo ( $msg->FromUserName );
						// $content = $content ['nickname'] . "\n" . $content ['city'] . "\n" . $content ['province'] . "\n" . date ( 'Y-m-d H:i:s', $content ["subscribe_time"] );
						$content = $weChat->makeText ( '单击' );
						
						break;
					case 'userorder' :
						$content = $this->userOrder ( $weChat );
						
						break;
					case 'userscore' :
						
						$user = User::model ()->findByPk ( Yii::app ()->user->Id );
						$content = "当前积分：";
						$content .= emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1f331 ) ) . $user ['u_score'];
						$content = $weChat->makeText ( $content );
						
						break;
					case 'userfavoriate' :
						$content = $this->userFavoriate ( $weChat );
						Yii::log ( $content, CLogger::LEVEL_INFO, 'mngr.userfavoriate' );
						// $content = $this->getWelcomeMsgsWithPics($weChat);
						break;
					
					case 'hui' :
						$content = $this->getHuiWithPics ( $weChat );
						break;
					default :
						// $content = @'收到事件' . $obj->Event.$obj->EventKey;
						// $content = $weChat->makeText ($content.'<a href="www.woxiche.com/site/login">登陆</a> ' );
						$loginStatus = $this->checkLogin ( $weChat );
						if ($loginStatus ['status'] == FALSE) {
							$content = $this->getWelcomeMsgsOnlyText ( $weChat );
						} else {
							// $this->sendTplMsgOrderNew($weChat);
							$content = $weChat->makeText ( '自动登陆成功' );
						}
						break;
				}
				;
				break;
			
			default :
				$content = @'收到事件' . $msg->Event . $msg->EventKey;
				$content = $weChat->makeText ( $content . '<a href="www.woxiche.com/site/login">登陆</a>  ' );
				// $content = $this->getWelcomeMsgs($weChat);
				// $content = $this->createLoginText();
				// $weChat->makeText($content);
				break;
		}
		
		// $result = $this->transmitText ( $obj, $content );
		return $content;
	}
	private function userOrder() {
		$weChat = $this->weChat;
		$userId = Yii::app ()->user->Id;
		$orderRlt = OrderHistory::model ()->getLatestOrder ( $userId );
		if ($orderRlt ['status']) {
			$order = $orderRlt ['data'];
			$list = array ();
			$orderType = $order->serviceType ['st_name'];
			$orderTime = date ( 'm月d日 H:i', strtotime ( $order ['oh_date_time'] ) ) . '-' . date ( 'H:i', strtotime ( $order ['oh_date_time_end'] ) );
			$shop = $order->ohWashShop;
			// $shopPic = Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/shops/'.$shop[id].'/shop'.$shop[id].'.jpg';
			$shopPic = Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/22/shop22.jpg';
			$orderPayValue = $order ['oh_value'] - $order ['oh_value_discount'];
			$orderInfo = '';
			
			$orderInfo .= "【到店支付】" . emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1F4B0 ) ) . $orderPayValue . "元\n";
			$orderInfo .= '【车行名称】' . $shop ['ws_name'] . "\n";
			$orderInfo .= '【车行地址】' . $shop ['ws_address'] . "\n";
			
			$orderStateIcon = '';
			switch ($order ['oh_state']) {
				case OrderHistory::ORDER_STATE_CANCEL :
					$orderStateIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x2716 ) );
					break;
				case OrderHistory::ORDER_STATE_SUCCESS :
					$orderStateIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x2705 ) );
					break;
				case OrderHistory::ORDER_STATE_ORDER :
					if ($order ['oh_user_ack'] == 1) {
						$orderStateIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1f44c ) );
					} else {
						$orderStateIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x2757 ) );
					}
					
					break;
				case OrderHistory::ORDER_STATE_OVERDUE :
					$orderStateIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1F6ab ) );
					break;
				default :
					$orderStateIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x274c ) );
					break;
			}
			$orderInfo .= "【订单状态】" . $orderStateIcon . OrderHistory::model ()->getOrderStateString ( $order ['oh_state'], $order ['oh_user_ack'] ) . "\n\n";
			
			$orderInfo .= "更多功能，请输入下列数字代码\n\n";
			// $text = preg_replace("#///u([0-9a-f]+)#ie","iconv('UCS-2','UTF-8', pack('H4', '//1'))",'ue488');
			// $emojiData = emoji_
			// include('emoji.php');
			// emoji_get_name('first quarter moon with face');
			$listIcon = emoji_softbank_to_unified ( UWeChat::utf8_bytes ( 0x1f539 ) );
			$orderInfo .= $listIcon . "100   确认订单\n";
			$orderInfo .= $listIcon . "101   取消订单\n";
			$orderInfo .= $listIcon . "1000   确认全部订单\n";
			
			$list ['items'] [] = array (
					'title' => "" . $orderStateIcon . "【" . $orderType . "】" . $orderTime,
					// 'title'=>'d',
					'description' => $orderInfo,
					'picurl' => $shopPic,
					'url' => $weChat->getUrl ( Yii::app ()->createAbsoluteUrl ( 'user/list' ), UWeChat::SCOPE_SNSAPI_BASE, null ) 
			);
			$content = $weChat->makeNews ( $list );
		} else {
			$content = $weChat->makeText ( '未找到有效订单，欢迎预订' );
		}
		
		return $content;
	}
	private function checkLogin() {
		$weChat = $this->weChat;
		$rlt = UTool::iniFuncRlt ();
		$autoLoginRlt = WeixinOpenid::model ()->loginByOpenId ( $weChat->msg->FromUserName, $weChat->appServiceId,$weChat->appName );
		if ($autoLoginRlt ['status'] == FALSE) {
			$rlt ['msg'] = $this->getWelcomeMsgsOnlyText ( );
		} else {
			$rlt ['status'] = TRUE;
		}
		return $rlt;
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