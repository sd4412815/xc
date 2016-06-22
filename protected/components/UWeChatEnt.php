<?php

/**
 * 对公众平台发送给公众账号的消息加解密示例代码.
 *
 * @copyright Copyright (c) 1998-2014 Tencent Inc.
 */

/**
 * 1.第三方回复加密消息给公众平台；
 * 2.第三方收到公众平台发送的消息，验证消息的安全性，并对消息进行解密。
 */
class UWeChatEnt {
	const WXENT_API = 'https://qyapi.weixin.qq.com/cgi-bin/';
	public $debug = false;
	public $msg = array ();
	
	// $_GET参数
	private $signature;
	private $timestamp;
	private $nonce;
	private $echostr;
	
	/*
	 * 企业号对应的应用名称
	 */
	public $appName;
	public $appId;
	public $agentId;
	private $m_sToken＝NULL;
	private $m_sEncodingAesKey = NULL;
	private $m_sCorpid = NULL;
	private $m_secret = NULL;
	public $token;
	
	// /**
	// * 构造函数
	// * @param $token string 公众平台上，开发者设置的token
	// * @param $encodingAesKey string 公众平台上，开发者设置的EncodingAESKey
	// * @param $Corpid string 公众平台的Corpid
	// */
	// private function UWeChatEntIniConfig($token, $encodingAesKey, $Corpid)
	// {
	// $this->m_sToken = $token;
	// $this->m_sEncodingAesKey = $encodingAesKey;
	// $this->m_sCorpid = $Corpid;
	// }
	
	/**
	 * 构造函数
	 * 
	 * @param string $appName        	
	 * @param string $nonce        	
	 * @param string $signature        	
	 * @param string $timestamp        	
	 * @param string $echostr        	
	 */
	public function UWeChatEnt($appName, $nonce = NULL, $signature = NULL, $timestamp = NULL, $echostr = NULL) {
		$this->nonce = $nonce;
		$this->signature = $signature;
		$this->timestamp = $timestamp;
		$this->echostr = $echostr;
		$this->appName = $appName;
		
		$weixinTokenModel = WeixinCtoken::model ()->findByAttributes ( array (
				'wc_app_name' => $this->appName 
		) );
		Yii::log ( CJSON::encode ( $weixinTokenModel ), CLogger::LEVEL_INFO, 'mngr.uwechatEnt.weixinTokenModel' );
		if (isset ( $weixinTokenModel )) {
			$this->m_sEncodingAesKey = $weixinTokenModel ['wc_encoding_aeskey'];
			$this->m_sCorpid = $weixinTokenModel ['wc_corp_id'];
			$this->m_sToken = $weixinTokenModel ['wc_user_token'];
			$this->agentId = $weixinTokenModel ['wc_agent_id'];
		}
	}
	
	/*
	 * 验证URL
	 * @param sMsgSignature: 签名串，对应URL参数的msg_signature
	 * @param sTimeStamp: 时间戳，对应URL参数的timestamp
	 * @param sNonce: 随机串，对应URL参数的nonce
	 * @param sEchoStr: 随机串，对应URL参数的echostr
	 * @param sReplyEchoStr: 解密之后的echostr，当return返回0时有效
	 * @return：成功0，失败返回对应的错误码
	 */
	public function VerifyURL($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr, &$sReplyEchoStr) {
		if (strlen ( $this->m_sEncodingAesKey ) != 43) {
			return ErrorCode::$IllegalAesKey;
		}
		
		$pc = new Prpcrypt ( $this->m_sEncodingAesKey );
		// verify msg_signature
		$sha1 = new SHA1 ();
		$array = $sha1->getSHA1 ( $this->m_sToken, $sTimeStamp, $sNonce, $sEchoStr );
		$ret = $array [0];
		
		if ($ret != 0) {
			return $ret;
		}
		Yii::log ( CJSON::encode($array), CLogger::LEVEL_INFO, 'mngr.uwechat.valid.1' );
		$signature = $array [1];
		if ($signature != $sMsgSignature) {
			return ErrorCode::$ValidateSignatureError;
		}
		
		$result = $pc->decrypt ( $sEchoStr, $this->m_sCorpid );
		if ($result [0] != 0) {
			return $result [0];
		}
		$sReplyEchoStr = $result [1];
		
		return ErrorCode::$OK;
	}
	
	/**
	 * 获取微信token
	 *
	 * @param string $force        	
	 * @return static|boolean
	 */
	public function getToken($appName=NULL,$force = FALSE) {
// 		$tokenModel = WeixinCtoken::model ()->findByAttributes ( array (
// 				'wc_app_name' => $this->appName 
// 		) );
		
		if (is_null($appName)) {
		    $tokenModel = WeixinCtoken::model ()->findByAttributes ( array ('wc_app_name' => $this->appName));
		}else{
		    $tokenModel = WeixinCtoken::model ()->findByAttributes ( array ('wc_app_name' => $appName));
		}
		
		if (! isset ( $tokenModel )) {
			return FALSE;
		}
		
		// 如果没有强制刷新
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
				'corpid' => $tokenModel ['wc_corp_id'],
				'corpsecret' => $tokenModel ['wc_appsecret'] 
		);
// 		$paraString = $para;
		$paraString = json_encode ( $para );
		
		$url = UWeChatEnt::WXENT_API . 'gettoken';
// 	 $rlt = UTool::requestByCurl ( $url, $paraString, TRUE, 5, false ); 
 		$rlt = UTool::doCurlGetRequest ( $url, $para ,5,TRUE);
		Yii::log ($rlt, CLogger::LEVEL_WARNING, 'mngr.uweixinEnt.getToken.getRLt' );
		
		$rlt = json_decode ( $rlt, JSON_UNESCAPED_UNICODE );
		
		if (! $rlt || isset ( $rlt ['errcode'] )) {
			return false;
		} else {
			
			$tokenModel ['wc_add_timestamp'] = time ();
			$tokenModel ['wc_token'] = $rlt ['access_token'];
			$tokenModel ['wc_expire'] = $rlt ['expires_in'];
			
			if (! $tokenModel->save ()) {
				// Yii::log ( CJSON::encode ( $tokenModel ), CLogger::LEVEL_WARNING, 'mngr.uweixinEnt.getToken.save' );
				// return false;
			}
			// else {
			// return $tokenModel ['wc_token'];
			// }
			return $tokenModel ['wc_token'];
		}
		
		return false;
	}
	
	/**
	 * 获得用户发过来的消息（消息内容和消息类型 ）
	 *
	 * @access public
	 * @return void
	 */
	public function init() {
		if (! empty ( $this->echostr )) {
			$sReplyEchoStr = NULL;
			$errCode = $this->VerifyURL ( $this->signature, $this->timestamp, $this->nonce, $this->echostr, $sReplyEchoStr );
			$this->log ( $errCode );
			if ($errCode == 0) {
				echo $sReplyEchoStr;
				// 验证URL成功，将sEchoStr返回
				Yii::app ()->end ();
			}
			Yii::app ()->end ();
		}
		
		$postStr = empty ( $GLOBALS ["HTTP_RAW_POST_DATA"] ) ? '' : $GLOBALS ["HTTP_RAW_POST_DATA"];
		
		$this->log ( $postStr );
		
		$sMsg = NULL; // 解析之后的明文
		$errCode = @$this->DecryptMsg ( $this->signature, $this->timestamp, $this->nonce, $postStr, $sMsg );
		if ($errCode == 0) {
			// 解密成功，sMsg即为xml格式的明文
			if (! empty ( $sMsg )) {
				
				$this->log ( $sMsg );
				
				$this->msg = simplexml_load_string ( $sMsg, 'SimpleXMLElement', LIBXML_NOCDATA );
			}
		} else {
			Yii::app ()->end ();
			// exit(-1);
		}
	}
	public function createMenu($menuArray) {
		$jsonMenu = json_encode ( $menuArray, JSON_UNESCAPED_UNICODE );
		$url = UWeChatEnt::WXENT_API . 'menu/create?access_token=' . $this->getToken () . '&agentid=' . $this->agentId;
		// $this->log($url);
		$r = UTool::requestByCurl ( $url, $jsonMenu, TRUE );
		// $r = UTool::https_request($url,$jsonMenu);
		// $this->log($r);
		return $r;
	}
	public function inviteUser($userId) {
		$url = UWeChatEnt::WXENT_API . 'invite/send?access_token=' . $this->getToken ();
		$data = array (
				"userid" => $userId 
		);
		$data = json_encode ( $data, JSON_UNESCAPED_UNICODE );
		$rlt = UTool::requestByCurl ( $url, $data, true );
		// $rlt = UTool::https_request($url,$data);
		// Yii::log ( $rlt, CLogger::LEVEL_INFO, 'mngr.mweixinEntC.inviteUserRlt' );
		return $rlt;
	}
	
	/**
	 * 将公众平台回复用户的消息加密打包.
	 * <ol>
	 * <li>对要发送的消息进行AES-CBC加密</li>
	 * <li>生成安全签名</li>
	 * <li>将消息密文和安全签名打包成xml格式</li>
	 * </ol>
	 *
	 * @param $replyMsg string
	 *        	公众平台待回复用户的消息，xml格式的字符串
	 * @param $timeStamp string
	 *        	时间戳，可以自己生成，也可以用URL参数的timestamp
	 * @param $nonce string
	 *        	随机串，可以自己生成，也可以用URL参数的nonce
	 * @param
	 *        	&$encryptMsg string 加密后的可以直接回复用户的密文，包括msg_signature, timestamp, nonce, encrypt的xml格式的字符串,
	 *        	当return返回0时有效
	 *        	
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function EncryptMsg($sReplyMsg, $sTimeStamp, $sNonce, &$sEncryptMsg) {
		$pc = new Prpcrypt ( $this->m_sEncodingAesKey );
		
		// 加密
		$array = $pc->encrypt ( $sReplyMsg, $this->m_sCorpid );
		$ret = $array [0];
		if ($ret != 0) {
			return $ret;
		}
		
		if ($sTimeStamp == null) {
			$sTimeStamp = time ();
		}
		$encrypt = $array [1];
		
		// 生成安全签名
		$sha1 = new SHA1 ();
		$array = $sha1->getSHA1 ( $this->m_sToken, $sTimeStamp, $sNonce, $encrypt );
		$ret = $array [0];
		if ($ret != 0) {
			return $ret;
		}
		$signature = $array [1];
		
		// 生成发送的xml
		$xmlparse = new XMLParse ();
		$sEncryptMsg = $xmlparse->generate ( $encrypt, $signature, $sTimeStamp, $sNonce );
		return ErrorCode::$OK;
	}
	
	/**
	 * 检验消息的真实性，并且获取解密后的明文.
	 * <ol>
	 * <li>利用收到的密文生成安全签名，进行签名验证</li>
	 * <li>若验证通过，则提取xml中的加密消息</li>
	 * <li>对消息进行解密</li>
	 * </ol>
	 *
	 * @param $msgSignature string
	 *        	签名串，对应URL参数的msg_signature
	 * @param $timestamp string
	 *        	时间戳 对应URL参数的timestamp
	 * @param $nonce string
	 *        	随机串，对应URL参数的nonce
	 * @param $postData string
	 *        	密文，对应POST请求的数据
	 * @param
	 *        	&$msg string 解密后的原文，当return返回0时有效
	 *        	
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function DecryptMsg($sMsgSignature, $sTimeStamp = null, $sNonce, $sPostData, &$sMsg) {
		if (strlen ( $this->m_sEncodingAesKey ) != 43) {
			return ErrorCode::$IllegalAesKey;
		}
		
		$pc = new Prpcrypt ( $this->m_sEncodingAesKey );
		
		// 提取密文
		$xmlparse = new XMLParse ();
		$array = $xmlparse->extract ( $sPostData );
		$ret = $array [0];
		
		if ($ret != 0) {
			return $ret;
		}
		
		if ($sTimeStamp == null) {
			$sTimeStamp = time ();
		}
		
		$encrypt = $array [1];
		$touser_name = $array [2];
		
		// 验证安全签名
		$sha1 = new SHA1 ();
		$array = $sha1->getSHA1 ( $this->m_sToken, $sTimeStamp, $sNonce, $encrypt );
		$ret = $array [0];
		
		if ($ret != 0) {
			return $ret;
		}
		
		$signature = $array [1];
		if ($signature != $sMsgSignature) {
			return ErrorCode::$ValidateSignatureError;
		}
		
		$result = $pc->decrypt ( $encrypt, $this->m_sCorpid );
		if ($result [0] != 0) {
			return $result [0];
		}
		$sMsg = $result [1];
		
		return ErrorCode::$OK;
	}
	
	/**
	 * 回复文本消息
	 *
	 * @param string $text        	
	 * @access public
	 * @return void
	 */
	public function makeJsonText($text = '') {
		$fromUserName = ( string ) ($this->msg->FromUserName);
		$agentId = ( int ) ($this->msg->AgentID);
		$content = array (
				'touser' => $fromUserName,
				'msgtype' => 'text',
				'agentid' => $agentId,
				'text' => array (
						'content' => $text 
				),
				'safe' => '0' 
		);
		return $content;
	}
	
	/**
	 * 发送消息，静态方法
	 * 
	 * @param strng $appName        	
	 * @param array $msgContent        	
	 *
	 */
	
	/**
	 *
	 * @param unknown $appName        	
	 * @param unknown $msgContent        	
	 * @return Ambigous <boolean, mixed>
	 */
	public function sendMsg( $msgContent) {
		$url = UWeChatEnt::WXENT_API . 'message/send?access_token=' . $this->getToken ();
		$content = json_encode ( $msgContent, JSON_UNESCAPED_UNICODE );
		$rlt = UTool::requestByCurl ( $url, $content, TRUE, 5, TRUE );
		return $rlt;
		// $rlt = UTool::https_request($url,$content);
	}
	
	/**
	 * 发送消息
	 * 
	 * @param array $content        	
	 */
	public function reply($content) {
		$url = UWeChatEnt::WXENT_API . 'message/send?access_token=' . $this->getToken ();
	    $this->log('url '.$url);
		$content = json_encode ( $content, JSON_UNESCAPED_UNICODE );
	    $this->log('99'.$content);
		$rlt = UTool::requestByCurl ( $url, $content, TRUE );
		//$rlt = UTool::doCurlGetRequest ( $url, $para ,5,TRUE);
		Yii::log('77',CLogger::LEVEL_INFO,'mngr.mweixinEnt.order');
		// $rlt = UTool::https_request($url,$content);
		 $this->log('999 '.$rlt);
		return $rlt;
	}
	
	/**
	 * log
	 *
	 * @access private
	 * @return void
	 */
	private function log($log) {
		if ($this->debug) {
			Yii::log ( $log, CLogger::LEVEL_INFO, 'mngr.uwechatEnt.postStr' );
			// Yii::log(CJSON::encode($log),CLogger::LEVEL_INFO,'mngr.uwechat');
			// file_put_contents(Yii::getPathOfAlias('application').'/runtime/weixin_log.txt', var_export($log, true)."\n\r", FILE_APPEND);
		}
	}
	
	
	
	/*
	 *  OAuth2验证
	 * @param string code
	 * @param int userid
	 * yuan
	 */
	public function getUserId($appName,$code){
	    if (empty($code)) {
	        return 'code为空';
	    }
	    $token=UWeChatEnt::getToken($appName);
	    if (empty($token)) {
	        return 'token无效';
	    }
	    $url = UWeChatEnt::WXENT_API . 'user/getuserinfo?access_token='.$token.'&code='.$code;
	    $rlt = UTool::requestByCurl ( $url,'', TRUE, 5, false );
	    $id=json_decode($rlt)->UserId;
	    return $id;
	     
	}
	
	
}

