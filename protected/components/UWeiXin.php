<?php
/**
 * 单例模式
 * update time: 20141008
 */


class UWeiXin {
	private static $_instance;
	private static $TOKEN = "wXC.2015.?";
	const appID = 'wxc778346f1d1b51d9';
	const appsecret = 'c224006577b2693b8114f6375879e918';
	const WX_API = 'https://api.weixin.qq.com/cgi-bin/';

	private static $access_token = '';

	public function __construct() {
// 		self::$access_token = self::getToken ();
	}
	
	/**
	 * 获取微信token
	 * 
	 * @param string $force        	
	 * @return static|boolean
	 */
	public static function getToken($force = FALSE) {
		$tokenModel = WeixinCtoken::model ()->findByAttributes ( array (
				'wc_appId' => self::appID 
		) );
		if ($force == FALSE) {
			if (isset ( $tokenModel )) {
				$token = $tokenModel ['wc_token'];
				$expire = $tokenModel ['wc_expire'];
				$addTimestamp = $tokenModel ['wc_add_timestamp'];
				$current = time ();
				if ($addTimestamp + $expire - 30 > $current) {
					return $token;
				}
			}
		}
		
		$para = array (
				'grant_type' => 'client_credential',
				'appid' => UWeiXin::appID,
				'secret' => UWeiXin::appsecret 
		);
		
		$url = UWeiXin::WX_API . 'token';
		$rlt = UTool::doCurlGetRequest ( $url, $para );
		
		$rlt = CJSON::decode ( $rlt, true );
		
		if (! $rlt || isset ( $rlt ['errcode'] )) {
			return false;
			// $this->status = false;
		} else {
			if (! isset ( $tokenModel )) {
				$tokenModel = new WeixinCtoken ();
				$tokenModel ['wc_appId'] = self::appID;
			}
			$tokenModel ['wc_add_timestamp'] = time ();
			$tokenModel ['wc_token'] = $rlt ['access_token'];
			;
			$tokenModel ['wc_expire'] = $rlt ['expires_in'];
			if (! $tokenModel->save ()) {
				Yii::log ( CJSON::encode ( $tokenModel ), CLogger::LEVEL_WARNING, 'mngr.uweixin.getToken.save' );
				return false;
			} else {
				return $tokenModel ['wc_token'];
			}

		}
		
		return false;

	}
	public function valid() {
		$echoStr = $_GET ["echostr"];
		
		// valid signature , option
		if ($this->checkSignature ()) {
			return  $echoStr;
// 			exit ();
		}
	}
	public function responseMsg() {
		// get post data, May be due to the different environments
		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
		    	Yii::log(CJSON::encode($postStr),CLogger::LEVEL_INFO,'mngr.uweixin.HTTP_RAW_POST_DATA');
		// extract post data
		if (! empty ( $postStr )) {
			
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			Yii::log(CJSON::encode($postObj),CLogger::LEVEL_INFO,'mngr.uweixin.postObj');
			$RX_TYPE = trim($postObj->MsgType);
			switch ($RX_TYPE){
				case 'event':
					$result = $this->receiveEvent($postObj);
					break;
				default:
					$result = '未知消息类型'.$RX_TYPE;
			}
			return $result;
			

		} else {
			return  null;

		}
	}
	
	private function receiveEvent($obj){
		$content = '';
		switch ($obj->Event){
			case 'subscribe':
				$content = '欢迎关注www.我洗车.com';
				break;
			case 'unsubscribe':
				$content = '';
				break;
			default:
				$content = '收到事件'.$obj->Event;
		}
		
		$result = $this->transmitText($obj, $content);
		return $result;
	}
	
	private function transmitText($obj, $content){
		
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>	
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		</xml>";
		$rlt = sprintf($textTpl,$obj->FromUserName,$obj->ToUserName,time(),$content);
		return $rlt;
	}
	
	private function checkSignature() {
		$signature = $_GET ["signature"];
		$timestamp = $_GET ["timestamp"];
		$nonce = $_GET ["nonce"];
		$token = UWeiXin::$TOKEN;
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce 
		);
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
}

?>