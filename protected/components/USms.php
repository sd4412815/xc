<?php
class USms{
	
	/**
	 * 发送短信验证码
	 * @param string $mobile
	 * @param string $content
	 * @return Ambigous <string, multitype:>
	 */
	private static function sendSms($mobile, $post_send_code, $real_send_code, $content){
		$send_code = $post_send_code;
		$mobile_code = $real_send_code;
		
		$rlt = UTool::iniFuncRlt();
		
// 		$checkRlt = USms::check($mobile, $send_code);
// 		if (!$checkRlt['status'] ) {
// 			return $checkRlt;
// 		}
		
		$sendRlt = USms::_sendSms($mobile, $content);
		if ( $sendRlt['status'] ) {
			Yii::app ()->session ['mobile'] = $mobile;
			Yii::app ()->session ['mobile_code'] = $mobile_code;
			$rlt = $sendRlt;	
		}else {
			$rlt = $sendRlt;
		}
		
		return $rlt;
		
	}
	
	/**
	 * 发送短信验证码
	 * @param string $mobile
	 * @param string $content
	 * @return Ambigous <string, multitype:>
	 */
	private static function _sendSms($mobile, $content){
		Yii::log($content,CLogger::LEVEL_INFO,'mngr.sms.msg.'.$mobile);
		$rlt = UTool::iniFuncRlt();
		
		if (YII_DEBUG){
			Yii::app ()->session ['mobile_code'] = '222222';
			$rlt['state']=true;
			$rlt['msg']='调试，未真实发送短信';
			return $rlt;
		}
		$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
		$post_data = "account=cf_xiche&password=" . md5 ( 'xc.2015' ) . "&mobile=" . $mobile . "&content=" . rawurlencode ( $content );
		// $post_data = "account=cf_xiche&password=123456&mobile=".$mobile."&content=".rawurlencode("您的验证码是：4290。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
		// 密码可以使用明文密码或使用32位MD5加密
	
		$sendRlt = UTool::curlPost ( $target, $post_data );
		$gets = UTool::xml_to_array ( $sendRlt );
		if ($gets ['SubmitResult'] ['code'] == 2) {
			$rlt ['status'] = true;
			$rlt ['msg'] = '验证码已发送';
		} else {
			// 			$rlt ['msg'] = $gets ['SubmitResult'] ['msg'];
			$rlt ['msg'] ='短信验证服务器忙，请稍后再试'.$gets ['SubmitResult'] ['code'].$mobile;
				
		}
		Yii::log(json_encode($gets,JSON_UNESCAPED_UNICODE),CLogger::LEVEL_INFO,'mngr.sms.rlt.'.$mobile);
		$rlt['status']=true;
	
		return $rlt;
	
	}
	
	/**
	 * 检查发送验证码前
	 * @param string $mobile
	 * @param string $send_code
	 * @return string|Ambigous <string, boolean>
	 */
	public static function check($mobile, $send_code){
		$rlt = UTool::iniFuncRlt ();
		$isTel = preg_match('/^1\d{10}$/', $mobile);
// 		$isSession = preg_match('/^r\d{6}$/', $mobile);
// 		$isValide = $isTel ;
		if (!Yii::app ()->request->isPostRequest
		||  empty ( Yii::app ()->session ['send_code'] )
		|| !$isTel) {
			$rlt ['msg'] = '请输入有效手机号！';
			return  $rlt ;
		}
		
// 		// 充值密码时使用
// 		if($isSession){
// 			$mobile = Yii::app()->session['resetUserTel'];
// 		}
		
		
// 		$checkRlt = UTool::checkRepeatAction(10);
// 		if ($checkRlt['status']) {
// 			$rlt = $checkRlt;
// 			$rlt['status'] = false;
// 			return $rlt;
				
// 		}
		
		
		if (! preg_match ( '/^1\d{10}$/', $mobile )) {
			$rlt ['msg'] = '手机号码格式不正确';
			return  $rlt ;
		}
		
		if (empty ( Yii::app ()->session ['send_code'] ) or $send_code != Yii::app ()->session ['send_code']) {
			// 防用户恶意请求
			$rlt ['msg'] = '请求超时，请刷新页面后重试';
			return  $rlt ;
		}
		
		$rlt['status']=true;
		return $rlt;
	}
	
	
	public static  function  sendInviteSmsReg($mobile,$bossId, $shopName, $shortUrl, $isNewReg=TRUE){
		$rlt = UTool::iniFuncRlt();
// 		$shopName = '';
// 		$shortUrl = '';
// $shopName = substr($shopName, 0,8).'...';
// $shortUrl = '';
if ($isNewReg){
$content = '尊敬的车主，您已成功注册“我洗车”'.$shopName.'会员'.$shortUrl.'，默认密码手机尾号后4位，欢迎登录';
}else{
	$content = '尊敬的车主，您已成功加入“我洗车”'.$shopName.'会员'.$shortUrl.'，欢迎登录';
}
// 		$content =  '尊敬的车主，您已成为“我洗车”'.$shopName.'会员'.$shortUrl.'，用户名本手机号，密码手机尾号后4位，欢迎登录';
// 		$content = '尊敬的车主：您好！“我洗车”'.$shopName.'店成功邀请您加入会员，用户名为本手机号，默认密码为手机尾号后4位。即刻登录，优惠多多，更多惊喜等着您！详情点击'.$shortUrl;
// 		$content = '您好，'.$content.'。本短信由系统自动发送，请不要回复。';
		$sendRlt = USms::_sendSms($mobile, $content);
// 		$sendRlt = USms::sendSmsReg($mobile, 'ddd');
		
		$msg = new Message();
		$msg['m_datetime']=date('Y-m-d H:i:s');
		$msg['m_user_id'] = $bossId;
		$msg['m_status']=0;
		$msg['m_level'] = Message::LEVEL_NORM;
		$msg['m_type']=Message::TYPE_ACCOUNT;
		$msg['m_src']=UTool::getRequestInfo();
		$msg['m_content'] = $content;
		if($msg->save()){
			// 			Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendSmsOrder');
		}else{
			Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendInviteSmsReg');
		}
		return $sendRlt;
		
	}
	
	/**
	 * 注册手机验证码
	 * @param string $mobile
	 * @param string $send_code
	 * @return Ambigous <string, multitype:>
	 */
	public static function  sendSmsReg($mobile,$send_code){
		$rlt = UTool::iniFuncRlt ();
		
		$mobile_code = UTool::randomkeys ( 6 );
		
		$content = '您的验证码是 ：'.$mobile_code.'。请不要把验证码泄露给其他人，如非本人操作，请忽略本短信。';
		$sendRlt =  USms::sendSms($mobile, $send_code, $mobile_code, $content);
		if ($sendRlt['status']) {
			$rlt['status']=true;
			$rlt ['msg'] = '验证码已发送';
			$rlt['data']=$mobile_code;
		} else {
			$rlt  =$sendRlt;
		}
		
		return $rlt;

	}
	
	

	
	/**
	 * 订单成功给用户发送短信
	 * @param unknown $orderItem
	 * @return Ambigous
	 */
	public static function sendSmsOrderForUser($orderItem){
		$user = User::model()->findByPk($orderItem['oh_user_id']);
		$mobile =$user ['u_tel'];
		$shop =$orderItem-> ohWashShop;
		$bossUser = User::model()->findByPk($shop['ws_boss_id']);
		$content = '恭喜您，成功预定“'.$orderItem->serviceType ['st_name'].'”服务，预约时间'
				.date ( 'n月j日 H:i', strtotime ( $orderItem ['oh_date_time'] ) ).'-'
				.date ( 'H:i分', strtotime ( $orderItem ['oh_date_time_end'] ) ).'，支付金额'
				.($orderItem ['oh_value']-$orderItem ['oh_value_discount']).'元，请准时到'
				.$shop['ws_name'].'，尊享专属爱车服务。地址：'
				.$shop['ws_address'].'，联系电话'
				.$bossUser['u_tel'].'。车位保留5分钟，若行程有变，请提前取消订单。渐近生活，尽在我洗车！';
		$sendRlt = USms::_sendSms($mobile, $content);
		$sendRlt['data'] = $content;
		return $sendRlt;
		
	}
	
	
	public static function getSmsMsgOrderForBoss($orderItem){
		$user = User::model()->findByPk($orderItem['oh_user_id']);
		$bossContent = '您好！您有一个新订单，“'
				.$user['u_nick_name'].'”预约了“'
						.$orderItem->serviceType ['st_name'].'”服务，预约时间'
								.date ( 'n月j日 H:i', strtotime ( $orderItem ['oh_date_time'] ) ).'-'
										.date ( 'H:i分', strtotime ( $orderItem ['oh_date_time_end'] ) ).'，支付金额'
												.($orderItem ['oh_value']-$orderItem ['oh_value_discount']).'元，请做好服务准备。渐近生活，尽在我洗车！';
		return $bossContent;
	}
	
	public static function sendSmsOrderForBoss($bossContent,$bossTel){
		
		$bossSendRlt = USms::_sendSms($bossTel, $bossContent);
		
	}
	
	
	/**
	 * 新增订单短信
	 * @param OrderHistory $orderItem
	 * @return Ambigous <string, multitype:>
	 */
	public static function  sendSmsOrder($orderItem,$tel=NULL){
// 		$rlt = UTool::iniFuncRlt ();
		if ($tel===null){
			
		}
		$shop =$orderItem-> ohWashShop;
		$boss = Boss::model()->findByAttributes(array('b_user_id'=>$shop['ws_boss_id']));
		$btel = $boss['b_tel'];
		$content = '恭喜您，成功预定“'.$orderItem->serviceType ['st_name'].'”服务，预约时间'
				.date ( 'n月j日 H:i', strtotime ( $orderItem ['oh_date_time'] ) ).'-'
				.date ( 'H:i分', strtotime ( $orderItem ['oh_date_time_end'] ) ).'，支付金额'
				.($orderItem ['oh_value']-$orderItem ['oh_value_discount']).'元，请准时到'
				.$shop['ws_name'].'，尊享专属爱车服务。地址：'
				.$shop['ws_address'].'，联系电话'
				.$btel.'。车位保留5分钟，若行程有变，请提前取消订单。渐近生活，尽在我洗车！';
		
		
		$user = User::model()->findByPk($orderItem['oh_user_id']);
		$mobile =$user ['u_tel'];
		$sendRlt = USms::_sendSms($mobile, $content);
		
		$bossContent = '您好！您有一个新订单，“'
				.$user['u_nick_name'].'”预约了“'
				.$orderItem->serviceType ['st_name'].'”服务，预约时间'
				.date ( 'n月j日 H:i', strtotime ( $orderItem ['oh_date_time'] ) ).'-'
				.date ( 'H:i分', strtotime ( $orderItem ['oh_date_time_end'] ) ).'，支付金额'
				.($orderItem ['oh_value']-$orderItem ['oh_value_discount']).'元，请做好服务准备。渐近生活，尽在我洗车！';
		$bossSendRlt = USms::_sendSms($btel, $bossContent);
		$msg = new Message();
		$msg['m_datetime']=date('Y-m-d H:i:s');
		$msg['m_user_id'] = $boss['b_user_id'];
		$msg['m_status']=0;
		$msg['m_level'] = Message::LEVEL_URGENCY;
		$msg['m_type']=Message::TYPE_ORDER;
		$msg['m_src']=UTool::getRequestInfo();
		$msg['m_content'] = $bossContent;
		if($msg->save()){
// 			Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendSmsOrder');
		}else{
			Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendSmsOrder');
		}
// 		if ($sendRlt['status']) {
			
// 			$rlt = $sendRlt;
// 			$rlt['status']=true;
// 			$rlt['data']=$content;
// 		} else {
// 			$rlt  =$sendRlt;
// 		}
		
		$sendRlt['data'] = $content;
		

	
		return $sendRlt;
	
	}
	
	/**
	 * 取消订单短信
	 * @param OrderHistory $orderItem
	 * @return Ambigous <string, multitype:>
	 */
	public static function  sendSmsOrderCancel($orderItem){
		// 		$rlt = UTool::iniFuncRlt ();
	
		$shop =$orderItem-> ohWashShop;
		$boss = Boss::model()->findByAttributes(array('b_user_id'=>$shop['ws_boss_id']));
		$btel = $boss['b_tel'];
		$content = '您好！订单编号['
				.$orderItem['oh_no'].']已取消，预约时间'
				.date ( 'n月j日 H:i', strtotime ( $orderItem ['oh_date_time'] ) ).'-'
				.date ( 'H:i分', strtotime ( $orderItem ['oh_date_time_end'] ) ).'。渐近生活，尽在我洗车！';
	
		$mobile = User::model()->findByPk($orderItem['oh_user_id'])['u_tel'];
// 		$sendRlt = USms::_sendSms($mobile, $content);
	
		
		$bossSendRlt = USms::_sendSms($btel, $content);
		$msg = new Message();
		$msg['m_datetime']=date('Y-m-d H:i:s');
		$msg['m_user_id'] = $boss['b_user_id'];
		$msg['m_status']=0;
		$msg['m_level'] = 2;
		$msg['m_type']=1;
		$msg['m_content'] = $content;
		if($msg->save()){
			// 			Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendSmsOrder');
		}else{
			Yii::log(CJSON::encode($msg),CLogger::LEVEL_INFO,'mngr.usms.sendSmsOrder');
		}
		$sendRlt['data'] = $content;
		return $sendRlt;
	
	}
	
	
	
	
	
	
}

?>