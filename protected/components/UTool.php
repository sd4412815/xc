<?php
class UTool {
	public static function test() {
		echo ('dd');
	}
	
	public  static function getRequestInfo(){
	    
	    $infos = array();
	    $infos['id'] = Yii::app()->user->id;
	    $infos['ip'] =Yii::app()->request->userHostAddress;
	    $infos['host']=Yii::app()->request->userHost;
	    $infos['userAgent'] = Yii::app()->request->userAgent;
// 	    .Yii::app()->request->userHost.'-'.Yii::app()->request->userAgent,CLogger::LEVEL_INFO,'user.login.fail');
	    return CJSON::encode($infos);
	}
	
	/**
	 * Post using curl
	 *
	 * @param string $url        	
	 * @param array $curlPostFields        	
	 */
	public static function curlPost($url, $curlPostFields, $isPost = true) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_HEADER, false );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_NOBODY, true );
		curl_setopt ( $curl, CURLOPT_POST, $isPost );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $curlPostFields );
		$return_str = curl_exec ( $curl );
		curl_close ( $curl );
		return $return_str;
	}
	public static function xml_to_array($xml) {
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if (preg_match_all ( $reg, $xml, $matches )) {
			$count = count ( $matches [0] );
			for($i = 0; $i < $count; $i ++) {
				$subxml = $matches [2] [$i];
				$key = $matches [1] [$i];
				if (preg_match ( $reg, $subxml )) {
					$arr [$key] = UTool::xml_to_array ( $subxml );
				} else {
					$arr [$key] = $subxml;
				}
			}
		}
		return $arr;
	}
	
	/**
	 * 验证csrf令牌
	 * @return boolean 合法为1.不合法为零
	 */
	public static function checkCsrf() {
		$token_code = UTool::randomkeys ( 6 );
		$_oi = Yii::app ()->request->cookies ['_oi'];
		if (isset ( $_oi )) {
			$token_code = $_oi->value;
		}
		$token = Yii::app()->session ['csrfId'];
		return   CPasswordHelper::verifyPassword ( $token, $token_code );
	}
	
	/**
	 * 设置csrf令牌校验
	 */
	public static function setCsrfValidator() {
		UTool::genSessionToken ();
	}
	
	/**
	 * 清除令牌
	 */
	public static function clearCsrf() {
		if (isset ( Yii::app ()->session ['csrfId'] )) {
			unset ( Yii::app ()->session ['csrfId'] );
		}
	}
	
	/**
	 * 生成csrf令牌
	 */
	public static function genToken() {
		$token = UTool::randomkeys ( 10, '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ' );
		Yii::app ()->session ['csrfId'] = $token;
		$token_code = CPasswordHelper::hashPassword ( $token );
		$cookie = new CHttpCookie ( '_oi', $token_code );
		Yii::app ()->request->cookies ['_oi'] = $cookie;
	}
	
	public static function checkRepeatActionReset(){
		
		$rlt=UTool::iniFuncRlt();
		$session = Yii::app()->session;
		$user_id = Yii::app()->user->id;
		if (!isset($user_id) ) {
			$user_id = '0';
		}
		$sessionKey = $user_id.'_is_sending';
		$session[$sessionKey] = time();

		
		return $rlt;
	}
	
	/**
	 * 检查是否重复提交
	 * @param int $interval=10 间隔秒数
	 * @return array rlt['status']=true 表示检测到重复提交
	 */
	public static function checkRepeatAction($interval=10){
		$rlt=UTool::iniFuncRlt();
		$session = Yii::app()->session;
		$user_id = Yii::app()->user->id;
		if (!isset($user_id) ) {
			$user_id = '0';
		}
		$sessionKey = $user_id.'_is_sending';
		if(isset($session[$sessionKey])){
			$first_submit_time = $session[$sessionKey];
			$current_time      = time();
			if($current_time - $first_submit_time < $interval){
				$session[$sessionKey] = $current_time;
				$rlt['msg'] = '请不要频繁刷新';
				$rlt['status']=true;
			}else{
				unset($session[$sessionKey]);//超过限制时间，释放session";
			}
		}
		
		
		//第一次点击确认按钮时执行
		if(!isset($session[$sessionKey]) ){
			$session[$sessionKey] = time();
		}
		
		return $rlt;
	}
	
	/**
	 * 生成服务器端csrf令牌
	 */
	public static function genSessionToken() {
		if (!isset ( Yii::app ()->session ['csrfId'] )) {
			// 没有值，赋新值
			UTool::genToken ();
		} else {
			// 　　　　　　　　继续使用旧的值
		}
	}
	public static function mCheckCsrf($_oi) {
		$token_code = UTool::randomkeys ( 6 );
		// $_oi = Yii::app()->request->cookies['_oi'];
		
		if (isset ( $_oi )) {
			$token_code = $_oi;
		}
		
		// $session = new CHttpSession();
		// $token = @$session['csrfId'];
		$token = Yii::app ()->session ['csrfId'];
		if (strcmp ( $token, $token_code ) == 0) {
			return true;
		}
		// return CPasswordHelper::verifyPassword($token, $token_code);
		// if( CPasswordHelper::verifyPassword($token, $token_code)){
		// return 'true';
		// }else {
		// return 'false';
		// }
	}
	
	/**
	 * 移动终端设置Csrf校验
	 */
	public static function mSetCsrfValidator() {
		return UTool::mGenSessionToken ();
	}
	
	/**
	 * 移动终端用生产session端令牌
	 * return string
	 */
	public static function mGenSessionToken() {
		// $session = new CHttpSession ();
		$session = Yii::app ()->session;
		$token_code = '';
		if (! isset ( Yii::app ()->session ['csrfId'] )) {
			// 没有值，赋新值
			$token_code = UTool::mGenToken ();
		} else {
			// 　　　　　　　　继续使用旧的值
			// $token_code =CPasswordHelper::hashPassword ($session ['csrfId']);
			$token_code = $session ['csrfId'];
		}
		
		return $token_code;
	}
	
	/**
	 * 移动终端用生产令牌
	 * 
	 * @return string
	 */
	public static function mGenToken() {
		$token = UTool::randomkeys ( 10, '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ' );
		Yii::app ()->session ['csrfId'] = $token;
		
		// $token_code = CPasswordHelper::hashPassword ( $token );
		$token_code = $token;
		
		return $token_code;
	}
	public static function orderSubmitSms($orderItem) {
		$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
		
		@$mobile = $orderItem->ohUser ['u_tel'];
		// @$send_code = $_POST['send_code'];
		
		$mobile_code = UTool::randomkeys ( 6 );
		if (empty ( $mobile )) {
			echo '手机号码不能为空';
			return;
		}
		
		$post_data = "account=cf_xiche&password=" . md5 ( 'xc.2015' ) . "&mobile=" . $mobile . "&content=" . rawurlencode ( "恭喜您，成功预约“" . $orderItem->serviceType ['st_name'] . "”服务，请于" . date ( 'Y:m:d H:i', strtotime ( $orderItem ['oh_date_time'] ) ) . "-" . date ( 'H:i', strtotime ( $orderItem ['oh_date_time_end'] ) ) . "分准时到" . $orderItem->ohWashShop ['ws_name'] . "店，尊享专属爱车服务。渐进生活，尽在我洗车！" );
		// $post_data = "account=cf_xiche&password=123456&mobile=".$mobile."&content=".rawurlencode("您的验证码是：4290。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
		// 密码可以使用明文密码或使用32位MD5加密
		
		$rlt = UTool::curlPost ( $target, $post_data );
		
		$gets = UTool::xml_to_array ( $rlt );
		if ($gets ['SubmitResult'] ['code'] == 2) {
			$_SESSION ['mobile'] = $mobile;
			$_SESSION ['mobile_code'] = $mobile_code;
		}
		// echo $gets['SubmitResult']['msg'];
	}
	
	/**
	 * 初始化函数返回值
	 *
	 * @return array
	 */
	public static function iniFuncRlt() {
		$rlt ['status'] = false;
		$rlt ['msg'] = '';
		$rlt ['data'] = '';
		return $rlt;
	}
	public static function getweather($city, $data = 'wetherData.txt') 	// 获取天气预报内容
	{
		$urlarr = unserialize ( file_get_contents ( $data ) );
		if ($urlarr [$city]) {
			$url = $urlarr [$city];
			$text = $city;
			$lines_string = file_get_contents ( $url );
			$lines_string = explode ( "<!--day", $lines_string );
			if (! $lines_string [1]) {
				return "无法获取到该城市的天气信息!";
				exit ();
			}
			$lines_string_3 = explode ( "未来", $lines_string [3] );
			$lines_array = array (
					str_replace ( '1-->', '', $lines_string [1] ),
					str_replace ( '2-->', '', $lines_string [2] ),
					str_replace ( '3-->', '', $lines_string_3 [0] ) 
			);
			for($i = 0; $i < count ( $lines_array ); $i ++) {
				$tiqian = array (
						"℃",
						"高温",
						"低温" 
				);
				$tihou = array (
						"度",
						"",
						"" 
				);
				$nowarray = str_replace ( $tiqian, $tihou, strip_tags ( $lines_array [$i] ) );
				$datearray = explode ( "日", $nowarray );
				$wtext [$i] = trim ( $datearray [0] ) . "日"; // 获取日期
				$weather = explode ( "白天", $nowarray );
				$weather = explode ( "夜间", $weather [1] );
				$baiarr = wchangearray ( explode ( "r", $weather [0] ) ); // 白天天气
				$yearr = wchangearray ( explode ( "r", $weather [1] ) ); // 夜间天气
				if ($baiarr [0] == $yearr [0]) {
					$wtext [$i] .= $baiarr [0];
				} else {
					$wtext [$i] .= $baiarr [0] . "转" . $yearr [0];
				} // 将天气添加到返回值里
				$wtext [$i] .= $baiarr [1] . "到" . $yearr [1]; // 将气温添加到返回值里
				if ($baiarr [2] == $yearr [2]) {
					$wtext [$i] .= $baiarr [2];
				} else {
					$wtext [$i] .= str_replace ( "风", "", $baiarr [2] . "转" . $yearr [2] );
					$wtext [$i] .= "风";
				} // 将风向添加到返回值里
				if ($baiarr [3] != "微风") {
					$wtext [$i] .= $baiarr [3];
				} // 将风力添加到返回值
			}
			return $text . implode ( "", $wtext );
		} else {
			return "无法获取到该城市的天气信息!";
		}
	}
	public static function wchangearray($arr) 	// 对数组进行键值排序
	{
		foreach ( $arr as $v ) {
			if (! trim ( $v ))
				continue;
			$value [] = trim ( $v );
		}
		return $value;
	}
	public static function randomkeys($length, $pattern = '1234567890') {
		$output = '';
		// $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
		// $pattern='1234567890';
		
		$output .= $pattern {mt_rand ( 0, strlen ( $pattern ) - 1 )};
		for($a = 1; $a < $length; $a ++) {
			$output .= $pattern {mt_rand ( 0, strlen ( $pattern ) - 1 )}; // 生成php随机数
		}
		while (substr($output, 0,1) == '0'){
		    $output = UTool::randomkeys($length,$pattern);
		}
		
		
		return $output;
	}
	public static function getURLRandoms($baseUrl) {
		return Yii::app ()->createUrl ( $baseUrl . '&' . UTool::randomkeys ( mt_rand ( 4, 8 ) ) );
	}
	public static function guaranteeRatio($totalValue) {
		return 0.5;
	}
	public static function getShop() {
		
		// $boss = Boss::model()->findByAttributes(array(
		// 'b_user_id'=>Yii::app()->user->id,
		// ));
		
		// $boss = UTool::getBoss();
		$shop = WashShop::model ()->findByAttributes ( array (
				'ws_boss_id' => Yii::app ()->user->id 
		) );
		return $shop;
	}
	public static function getBoss() {
		$boss = Boss::model ()->findByAttributes ( array (
				'b_user_id' => Yii::app ()->user->id 
		) );
		return $boss;
	}
	public static function getMaskKeyWords() {
		$str = '非法,屏蔽, 太差';
		$arr = split ( '[, ;]', $str );
		return $arr;
	}
	public static function checkComment($comment) {
		$keys = UTool::getMaskKeyWords ();
		return str_replace ( $keys, '*', $comment );
	}
	public static function get_client_ip() {
		global $_SERVER;
		if (isset ( $_SERVER ["HTTP_X_FORWARDED_FOR"] )) {
			$realip = $_SERVER ["HTTP_X_FORWARDED_FOR"];
		} elseif (isset ( $_SERVER ["HTTP_CLIENT_IP"] )) {
			$realip = $_SERVER ["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER ["REMOTE_ADDR"];
		}
		return $realip;
	}
	
	/**
	 * curl实现get
	 * @param 链接 $url
	 * @param 参数array $data
	 * @param 超时 $timeout
	 * @param isJSON 是否json数据
	 * @return boolean|mixed
	 */
	public static function doCurlGetRequest($url, $data, $timeout=5,$isSSL=FALSE,$isJSON=FALSE){
		if($url == '' || $timeout <=0){
			return false;
		}
		$url = $url.'?'.http_build_query($data);
		$con = curl_init((string)$url);
		
		if ($isJSON){
			curl_setopt($con, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json; charset=utf-8',
				'Content-Length: ' . strlen($data))
			);
		}else{
			curl_setopt($con, CURLOPT_HEADER, FALSE);
		}
		
		
		curl_setopt($con, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
		if ($isSSL == TRUE){
			curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
			curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		
		
		return curl_exec($con);
		
	}
	
	
	/**
	 * curl实现get post
	 * @param string $url 链接 
	 * @param string $post_data_string  post方式时参数data null=get方式
	 * @param bool $isSSL 是否安全链接
	 * @param bool $isJSON 是否传递json类型数据
	 * @param int $timeout 超时时间
	 * @return boolean|mixed
	 */
	public static function requestByCurl($url, $post_data_string=NULL,$isSSL=FALSE, $timeout=5,$isJSON=FALSE){
		if(empty($url) || $timeout <=0){
			return false;
		}
		
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $url);
		
		if ($isJSON){
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Content-Length: ' . strlen($post_data_string))
			);
		}else{
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
		}
		
		if(!empty($post_data_string)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data_string);
		}
		
		if ($isSSL == TRUE){
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
			
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_TIMEOUT, (int)$timeout);

		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
	
	
	
	public static function https_request($url, $data=NULL, $isJSON=FALSE){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if ($isJSON){
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Content-Length: ' . strlen($data))
			);
		}else{
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
		}
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
	
	
}


