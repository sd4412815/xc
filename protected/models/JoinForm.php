<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class JoinForm extends CFormModel {
	public $address; // 地址
	public $name; // 店名
	public $contactor; // 联系人
	public $tel; // 电话
	public $verifyCode; // 图形验证码
	public $smsCode; // 短信验证码
	public  $pid;
	public $cid;
	public $aid;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array (

				array (
						'pid,cid,aid',
						'numerical',
						'integerOnly'=>true,
				),
				array (
						'pid',
						'compare',
						'compareValue'=>'0',
						'operator'=>'>',
						'message'=>'请选择省份',
				
				),
				array (
						'cid',
						'compare',
						'compareValue'=>'0',
						'operator'=>'>',
						'message'=>'请选择城市',
				
				),
				array (
						'aid',
						'compare',
						'compareValue'=>'0',
						'operator'=>'>',
						'message'=>'请选择区域',
				
				),
				array (
						'tel,contactor,address,name,smsCode',
						'required',
						'message' => '{attribute}不能为空',
				),
				// 手机号格式验证：需为 1xxxxxxxxxx
				array (
						'tel',
						'match',
						'pattern' => '/^1\d{10}$/',
						'message' => '{attribute}格式不正确',
				),
				// 手机号长度11位，保证输入长度不超限
				array (
						'tel',
						'length',
						'max' => 11,
						'min'=>11,
						'tooShort' => '{attribute}格式不正确',
						'tooLong' => '{attribute}格式不正确',
				),
				// 注册时验证手机号码唯一
// 				array (
// 						'tel',
// 						'unique',
// 						'className' => 'User',
// 						'message' => '手机号已注册',
// 				),
				array (
						'tel',
						'checkTel',
						'message' => '手机号已被占用，请更换手机号',
				),

				array (
						'smsCode',
						'length',
						'min'=>6,
						'max' => 6,
						'tooLong' => '短信验证码错误',
						'tooShort' => '短信验证码错误',
				),
				
				array (
						'smsCode',
						'match',
						'pattern' => '/^\d{6}$/',
						'message' => '短信验证码错误',
				),
				array (
						'smsCode',
						'checkSmsCode',
						'message' => '短信验证码错误', 
				),

		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'address' => '地址',
				'tel' => '手机号',
				'name' => '店名',
				'contactor' => '联系人',
				'verifyCode' => '图形验证码',
				'smsCode' => '短信验证码',
// 				'agree' => '用户协议' 
		);
	}
	public function checkSmsCode($attribute, $params) {
		if (! isset ( Yii::app ()->session ['mobile_code'] )) {
			$this->addError ( $attribute, '短信验证码错误' );
		} else if (! preg_match ( '/^\d{6}$/', $this->smsCode ) || $this->smsCode != Yii::app ()->session ['mobile_code']) {
			$this->addError ( $attribute, '短信验证码错误' );
		}
	}
	
	public function checkTel($attribute, $params) {
		
		$tempUser = User::model ()->findByAttributes ( array (
				'u_tel' =>$this->tel,
		) );
		if (WashShop::model ()->countByAttributes ( array (
				'ws_boss_id' => $tempUser ['id']
		) ) > 0) {
			$this->addError ( $attribute, '该手机号已经被占用，请更换手机号' );
		}
	}
	
	public function join()
	{
		$rlt = UTool::iniFuncRlt();
			$idp = $this->pid;
			$idc = $this->cid;
			$ida = $this->aid;
			$name = $this->name;
			$contator = $this->contactor;
			$tel =$this->tel;;
			$address =$this->address;
				
			$tempUser = User::model ()->findByAttributes ( array (
					'u_tel' => $tel
			) );
			if (! isset ( $tempUser )) {
				$user = new User ();
				$user ['u_tel'] = $tel;
				$user ['u_name'] = '';
				$user ['u_nick_name'] = substr($tel,-4,4);
				$user ['u_score'] = 0;
				$user ['u_join_date'] = date ( 'Y:m:d H:i:s' );
				$user ['u_login_date'] = $user ['u_join_date'];
				$user ['u_type'] = 2;
				$user ['u_sex'] = 2;
				$user ['u_age'] = 999;
				$user ['u_state'] = 0;
				$user['u_member_id']=0;
				$user ['u_pwd'] = CPasswordHelper::hashPassword ( $tel );
				if ($user->save ()) {
					$user_id = $user ['id'];
					$boss = new Boss ();
					$boss ['b_real_name'] = $name;
					$boss ['b_type'] = 0;
// 					$boss ['b_name'] = $name;
// 					$boss ['b_tel'] = $tel;
// 					$boss ['b_pwd'] = $user ['u_pwd'];
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
// 				$boss ['b_name'] = $name;
// 				$boss ['b_tel'] = $tel;
// 				$boss ['b_pwd'] = $tempUser ['u_pwd'];
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
			
				$rlt['status']=true;
			} else {
				$rlt['msg']='保存申请信息失败，请稍后重试';
// 				echo '申请失败！';
				
			}
			return $rlt;
	
	}
	

	

	
	

}
