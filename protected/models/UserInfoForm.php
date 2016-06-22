<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserInfo extends CFormModel {
	public $name; // 手机号
	public $member_id; // 密码
	public $sex; // 记住下次自动登录
	public $age; // 重复密码
	public $nick_name; // 图形验证码
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array (
				array (
						'u_tel',
						'required',
						'message' => '{attribute}不能为空', 
						'on'=>'reg,login,reset'
				),
				array (
						'u_pwd',
						'required',
						'message' => '{attribute}不能为空',
						'on'=>'reg,login,resetPWD',
				),
				array (
						'agree',
						'compare',
						'compareValue' => '1',
						'message' => '请您阅读并确认用户协议',
						'on' => 'reg' ,
				),
				// 注册时验证：需重复填写确认密码
				array (
						'u_pwd2',
						'required',
						'on' => 'reg,resetPWD',
						'message' => '{attribute}不能为空' 
				),
				array (
						'smsCode',
						'required',
						'on' => 'reg,resetCheck',
						'message' => '{attribute}不能为空'
				),

				// 手机号格式验证：需为 1xxxxxxxxxx
				array (
						'u_tel',
						'match',
						'pattern' => '/^1\d{10}$/',
						'message' => '{attribute}格式不正确',
						'on' => 'reg',
				),
				array (
						'u_tel',
						'length',
						'max' => 20,
						'tooLong' => '登录名错误',
						'on' => 'login,reset' ,
				),
				array (
						'u_tel',
						'match',
						'pattern' => '/^\w{1,20}$/',
						'message' => '登录名错误',
						'on' => 'login,reset',
				),
				// 手机号长度11位，保证输入长度不超限
				array (
						'u_tel',
						'length',
						'max' => 11,
						'tooLong' => '{attribute}格式不正确',
						'on' => 'reg' ,
				),
				// 检查密码格式符合要求
				array (
						'u_pwd, u_pwd2',
						'match',
						'pattern' => '/^\w{1,20}$/',
						'message' => '{attribute}只能包括数字、字母和下划线',
						'on'=>'reg,resetPWD',
						 
				),
				// 密码长度不超限
				array (
						'u_pwd, u_pwd2',
						'length',
						'max' => 20,
						'tooLong' => '{attribute}不超过20位',
						
				),
				// 注册时验证密码与确认密码一致
				array (
						'u_pwd2',
						'compare',
						'compareAttribute' => 'u_pwd',
						'on' => 'reg,resetPWD',
						'message' => '两次输入密码不一致' 
				),
				// 图形验证码
				array (
				'verifyCode',
				'captcha',
				'allowEmpty' => ! CCaptcha::checkRequirements (),
				'on' => 'reset',
				'message' => '图形验证码过期，请点击刷新'
				),
				array (
						'verifyCode',
						'required',
						'on' => 'reset',
				),
				// 注册时验证手机号码唯一
				array (
						'u_tel',
						'unique',
						'className' => 'User',
						'message' => '手机号已注册',
						'on' => 'reg', 
				),
				// 记住我
				array (
						'rememberMe',
						'boolean', 
				),
				// 登录时验证密码
// 				array (
// 						'u_pwd',
// 						'authenticate',
// 						'on' => 'login' 
// 				),
				array (
						'smsCode',
						'length',
						'min'=>6,
						'max' => 6,
						'tooLong' => '短信验证码错误',
						'tooShort' => '短信验证码错误',
						'on' => 'reg,resetCheck', 
				),
				
				array (
						'smsCode',
						'match',
						'pattern' => '/^\d{6}$/',
						'message' => '短信验证码错误',
						'on' => 'reg,resetCheck' ,
				),
				array (
						'smsCode',
						'checkSmsCode',
						'on' => 'reg,resetCheck',
						'message' => '短信验证码错误', 
				),
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'rememberMe' => '记住登录',
				'u_tel' => ($this->scenario =='reg'?'手机号':'账户'),
				'u_pwd' => '密码',
				'u_pwd2' => '确认密码',
				'verifyCode' => '图形验证码',
				'smsCode' => '短信验证码',
				'agree' => '用户协议' 
		);
	}
	public function checkSmsCode($attribute, $params) {
		if (! isset ( Yii::app ()->session ['mobile_code'] )) {
			$this->addError ( $attribute, '短信验证码错误' );
		} else if (! preg_match ( '/^\d{6}$/', $this->smsCode ) || $this->smsCode != Yii::app ()->session ['mobile_code']) {
			$this->addError ( $attribute, '短信验证码错误' );
		}
	}
	
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params) {
		if (! $this->hasErrors ()) {
			$this->_identity = new UserIdentity ( $this->u_tel, $this->u_pwd );
			
			// $isBoss = $this->scenario=="boss"?true:false;
			if ( $this->_identity->authenticate () != 0){
				$this->addError ( 'password', '手机号或密码错误.' );
			}
		}
	}
	

	
	/**
	 * Logs in the user using the given username and password in the model.
	 *
	 * @return boolean whether login is successful
	 */
	public function login() {
		if ($this->_identity === null) {
			$this->_identity = new UserIdentity ( $this->u_tel, $this->u_pwd );
			// $isBoss = $this->scenario=="boss"?true:false;
			$this->_identity->authenticate ();
		}
		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
			Yii::app ()->user->login ( $this->_identity, $duration );
			$user = User::model()->findByPk(Yii::app()->user->id);
			$user['u_login_date']=date('Y-m-d H:i:m');
			$user['u_error_count'] =0;
			if($user->save()){
				
			} 
			return true;
		} else if($this->_identity->errorCode === UserIdentity::ERROR_PASSWORD_INVALID){
			$user = User::model()->findByPk($this->_identity->id);
// 			$user['u_login_date']=date('Y-m-d H:i:m');
			$user['u_error_count'] +=1;
			if($user->save()){
			}
			return false;}
	}
}
