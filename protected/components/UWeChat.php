<?php

/**
 * WeixinCallback 
 */
class UWeChat {
	const WX_API = 'https://api.weixin.qq.com/cgi-bin/';
	const SCOPE_SNSAPI_BASE = 'snsapi_base';
	const SCOPE_SNSAPI_USERINFO = 'snsapi_userinfo';
	/*
	 * 服务号对应的应用名称
	 */
	public $appName;
	/*
	 * 服务号对应的应用标识ID
	 */
	public $appServiceId;
	
	
	
	private $userToken;
	private $appId;
	private $appSecret;
	
	// $_GET参数
	private $signature;
	private $timestamp;
	private $nonce;
	private $echostr;
	public $debug = false;
	
	/*
	 * 微信消息体
	 */
	public $msg = array ();
	public $setFlag = false;
	
	/**
	 * 构造函数
	 *
	 * @param string $appName
	 *        	服务号对应的应用名称
	 * @param string $nonce        	
	 * @param string $signature        	
	 * @param string $timestamp        	
	 * @param string $echostr        	
	 */
	public function UWeChat($appName, $nonce = NULL, $signature = NULL, $timestamp = NULL, $echostr = NULL) {
		$this->nonce = $nonce;
		$this->signature = $signature;
		$this->timestamp = $timestamp;
		$this->echostr = $echostr;
		$this->appName = $appName;
		
		$weixinTokenModel = WeixinCtoken::model ()->findByAttributes ( array (
				'wc_app_name' => $this->appName 
		) );
		
		if (isset ( $weixinTokenModel )) {
			$this->appId = $weixinTokenModel ['wc_appId'];
			$this->appSecret = $weixinTokenModel ['wc_appsecret'];
			$this->userToken = $weixinTokenModel ['wc_user_token'];
			$this->appServiceId = $weixinTokenModel['id'];
		}
	}
	
	/**
	 * 获取微信token
	 *
	 * @param bool $force
	 *        	是否强制刷新accessToken
	 * @return string accessToken 如果失败则返回 FLASE
	 */
	public function getToken($force = FALSE) {
// 		$this->log ( 'appName:' . $this->appName );
		$tokenModel = WeixinCtoken::model ()->findByAttributes ( array (
				'wc_app_name' => $this->appName 
		) );
		
		if (! isset ( $tokenModel )) {
			return FALSE;
		}
		
		// 如果没有强制刷新
		if ($force == FALSE) {
			$token = $tokenModel ['wc_token'];
			$expire = $tokenModel ['wc_expire'];
			$addTimestamp = $tokenModel ['wc_add_timestamp'];
			$current = time ();
// 			$this->log ( '3:' );
			if ($addTimestamp + $expire - 30 > $current) {
// 				$this->log ( '4:' );
				return $token;
			}
		}
		
		// 重新获取accessToken
		$para = array (
				'grant_type' => 'client_credential',
				'appid' => $this->appId,
				'secret' => $this->appSecret 
		);
		$url = UWeChat::WX_API . 'token';
		$url = $url . '?' . http_build_query ( $para );
		$rlt = UTool::requestByCurl ( $url, null, TRUE );
		$rlt = CJSON::decode ( $rlt, true );
		
		if (! $rlt || isset ( $rlt ['errcode'] )) {
			return false;
		} else {
			
			$tokenModel ['wc_add_timestamp'] = time ();
			$tokenModel ['wc_token'] = $rlt ['access_token'];
			$tokenModel ['wc_expire'] = $rlt ['expires_in'];
			if (! $tokenModel->save ()) {
// 				return false;
			} 
			return $tokenModel ['wc_token'];
		}
		
		return false;
	}
	
	/**
	 * 校验签名
	 *
	 * @return bool 如果有回显echostr，则输出后停止
	 */
	public function valid() {
		// 校验签名
		if ($this->checkSignature ()) {
			if (! empty ( $this->echostr )) {
				echo $this->echostr;
				Yii::app ()->end ();
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 获得用户发过来的消息（消息内容和消息类型 ），放在msg属性中
	 *
	 * @return void
	 */
	public function init() {
		$postStr = empty ( $GLOBALS ["HTTP_RAW_POST_DATA"] ) ? '' : $GLOBALS ["HTTP_RAW_POST_DATA"];
		$this->log ( $postStr );
		if (! empty ( $postStr )) {
			$rlt = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$this->msg = $rlt;
		}
	}
	
	/**
	 * 创建菜单
	 * @param array $menuArray
	 * @return Ambigous <boolean, mixed>
	 */
	public function createMenu($menuArray) {
		$jsonMenu = json_encode ( $menuArray, JSON_UNESCAPED_UNICODE );
		$url = UWeChat::WX_API . 'menu/create?access_token=' . $this->getToken ();
		Yii::log($jsonMenu,CLogger::LEVEL_INFO,'mngr.createMenu');
		$r = UTool::requestByCurl ( $url, $jsonMenu, TRUE );
		return $r;
	}
	
	/**
	 * makeEvent
	 *
	 * @access public
	 * @return void
	 */
	public function makeEvent() {
	}
	
	/**
	 * 发送模版消息
	 * @param string $toUser weixinOpenId
	 * @param array $msgContentArray
	 * @return Ambigous <boolean, mixed> jsonString array("errcode"=>0, "errmsg"=>"ok", "msgid"=>200228332)
	 */
	public function sendTplMsg($toUser, $msgContentArray){

		$jsonDataString = json_encode($msgContentArray,JSON_UNESCAPED_UNICODE);
		
		$url = UWeChat::WX_API . 'message/template/send?access_token=' . $this->getToken ();
		$r = UTool::requestByCurl($url,$jsonDataString,TRUE,5,TRUE);

		return $r;
		
		
	}
	
	
	private function sendTplMsgOrderNew($order) {
		$obj = $this->weChat;
		$openid = $obj->msg->FromUserName . '';
	
		$orderType = $order->serviceType ['st_name'];
		$orderStartTime = strtotime ( $order ['oh_date_time'] );
		$orderEndTime = strtotime ( $order ['oh_date_time_end'] );
		$orderPayValue = $order ['oh_value'] - $order ['oh_value_discount'];
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
								"value" => date ( 'm月d日 H:00-', $orderStartTime ) . date ( 'H:20', $orderEndTime ),
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
	 * 回复文本消息
	 *
	 * @param string $text   待显示的文本    	
	 * @return string 组织后的文本
	 */
	public function makeText($text = '') {
		$createTime = time ();
		$funcFlag = $this->setFlag ? 1 : 0;

		$textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
		$r = sprintf ( $textTpl, $text, $funcFlag );
		return $r;
	}
	
	/**
	 * 根据数组参数回复图文消息
	 *
	 * @param array $newsData        	
	 * @return string 组织后的图文消息
	 */
	public function makeNews($newsData = array()) {
		$createTime = time ();
		$funcFlag = $this->setFlag ? 1 : 0;
		$newTplHeader = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>%s</ArticleCount><Articles>";
		$newTplItem = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
		$newTplFoot = "</Articles>
            <FuncFlag>%s</FuncFlag>
            </xml>";
		$content = '';
		$itemsCount = count ( $newsData ['items'] );
		// 微信公众平台图文回复的消息一次最多10条
		$itemsCount = $itemsCount < 10 ? $itemsCount : 10;
		if ($itemsCount) {
			foreach ( $newsData ['items'] as $key => $item ) {
				if ($key <= 9) {
					$content .= sprintf ( $newTplItem, $item ['title'], $item ['description'], $item ['picurl'], $item ['url'] );
				}
			}
		}
		$header = sprintf ( $newTplHeader, $itemsCount );
		$footer = sprintf ( $newTplFoot, $funcFlag );
		return $header . $content . $footer;
	}
	
	/**
	 * 微信回复消息
	 *
	 * @param mixed $data        	
	 * @access public
	 * @return void
	 */
	public function reply($data) {
		if ($this->debug) {
			$this->log ( $data );
		}
		echo $data;
	}
	/**
	 * 输出微信emoji表情
	 *
	 * @param string $str        	
	 * @return mixed
	 */
	public static function unicode2utf8_2($str) {
		$str = '{"result_str":"' . $str . '"}'; // 组合成json格式
		$strarray = json_decode ( $str, true ); // json转换为数组，利用 JSON 对 \uXXXX 的支持来把转义符恢复为 Unicode 字符
		return $strarray ['result_str'];
	}
	public static function utf8_bytes($cp) {
		if ($cp > 0x10000) {
			// 4 bytes
			return chr ( 0xF0 | (($cp & 0x1C0000) >> 18) ) . chr ( 0x80 | (($cp & 0x3F000) >> 12) ) . chr ( 0x80 | (($cp & 0xFC0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else if ($cp > 0x800) {
			// 3 bytes
			return chr ( 0xE0 | (($cp & 0xF000) >> 12) ) . chr ( 0x80 | (($cp & 0xFC0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else if ($cp > 0x80) {
			// 2 bytes
			return chr ( 0xC0 | (($cp & 0x7C0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else {
			// 1 byte
			return chr ( $cp );
		}
	}
	
	/**
	 * 校验签名
	 *
	 * @return bool 
	 */
	private function checkSignature() {
		$tmpArr = array (
				$this->userToken,
				$this->timestamp,
				$this->nonce 
		);
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $this->signature) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getUserInfo($openId) {
		$openId = $openId . '';
		$url = UWeiXin::WX_API . 'user/info';
		$accessToken = $this->getToken ();
		$data = array (
				'access_token' => $accessToken,
				'openid' => $openId,
				'lang' => 'zh_CN' 
		);

		$url = $url . '?' . http_build_query ( $data );
		$rlt = UTool::requestByCurl ( $url );
		return CJSON::decode ( $rlt, true );
		
		// return $accessToken;
	}
	

	
	/**
	 * 返回授权连接
	 *
	 * @param string $redirectUrl        	
	 * @param string $scope        	
	 * @param string $state        	
	 * @return string
	 */
	public function getUrl($redirectUrl, $scope, $state) {
		$baseUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
		$url = $baseUrl . 'appid=' . $this->appId;
		$redirectUrl = $redirectUrl.'?src=weixin&srcType='.$this->appName;
		$redirectUrl = urlencode($redirectUrl);
		$url = $url . '&redirect_uri=' . $redirectUrl;
// 		$url = $url .'&src=weixin&appType='.$this->appName;
		$url = $url . '&response_type=code';
		$url = $url . '&scope=' . $scope;
		$url = $url . '&state=' . $state;
		$url = $url . '#wechat_redirect';
		return $url;
	}
	
	/**
	 * 通过code换取access_code
	 *
	 * @param string $code        	
	 * @return mixed
	 */
	public function getAccessTokenFromCode($code) {
		$rlt = UTool::iniFuncRlt ();
		$baseUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?';
		$url = $baseUrl . 'appid=' . $this->appId;
		$url = $url . '&secret=' . $this->appSecret;
		$url = $url . '&code=' . $code;
		$url = $url . '&grant_type=authorization_code';

		$accessTokenRlt = UTool::requestByCurl ( $url, null, true );
		$accessTokenRlt = json_decode ( $accessTokenRlt );
		if (isset ( $accessTokenRlt->errcode )) {
			$rlt ['data'] = $accessTokenRlt;
			return $rlt;
		}
		
		$accessToken = $accessTokenRlt->access_token;
		$openId = $accessTokenRlt->openid;
		if (isset ( $accessTokenRlt->unionid )) {
			$unionid = $accessTokenRlt->unionid;
		} else {
			$unionid = NULL;
		}
		$rlt ['status'] = TRUE;
		$rlt ['data'] = array (
				'openid' => $openId,
				'unionid' => $unionid 
		);
		return $rlt;
	}
	
	/**
	 * log
	 *
	 * @return void
	 */
	private function log($log) {
		if ($this->debug) {
			Yii::log ( $log, CLogger::LEVEL_INFO, 'mngr.uwechat.' . $this->appName . '.msg.log' );
		}
	}
}
