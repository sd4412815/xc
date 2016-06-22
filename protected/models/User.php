<?php

/**
 * This is the model class for table "{{User}}".
 *
 * The followings are the available columns in table '{{User}}':
 * @property integer $id
 * @property string $u_tel
 * @property string $u_pwd
 * @property string $u_name
 * @property integer $u_score
 * @property integer $u_car_brand
 * @property integer $u_car_type
 */
class User extends CActiveRecord {
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{User}}';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'u_tel, u_pwd',
						'required' 
				),
				array (
						'u_tel',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'u_member_id',
						'numerical',
						'integerOnly' => true,
						'allowEmpty' => true 
				),
				array (
						'u_nick_name',
						'match',
						'pattern' => '/[\x{4e00}-\x{9fa5}]|[a-zA-Z0-9*.]+$/u',
						'on' => 'update' 
				),
				array (
						'u_type, u_sex,u_age,u_state,u_error_count',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'u_sex',
						'in',
						'range' => array (
								0,
								1,
								2 
						) 
				),
				array (
						'u_score',
						'numerical' 
				),
				// array (
				// 'u_join_date',
				// 'date',
				// 'format' => 'yyyy-MM-dd HH:mm:ss'
				// ),
				// array (
				// 'u_join_date',
				// 'type',
				// 'datetime' ,
				// ),
				// array (
				// 'u_login_date',
				// 'date',
				// 'format' => 'yyyy-MM-dd HH:mm:ss'
				// ),
				// array (
				// 'u_login_date',
				// 'type',
				// 'datetime'
				// ),
				array (
						'u_name,u_nick_name',
						'length',
						'max' => 20 
				),
				array (
						'u_tel',
						'match',
						'pattern' => '/^1\d{10}$/' 
				),
				array (
						'u_tel',
						'length',
						'max' => 11 
				),
				array (
						'u_pwd',
						'length',
						'max' => 128 
				),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'u_tel',
						'safe',
						'on' => 'search' 
				) ,
				array (
						'u_car_brand,u_car_type',
						'safe',
						'on' => 'update'
				)
		);
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'favoriateShops' => array (
						self::HAS_MANY,
						'FavoriteShop',
						'fs_user_id' 
				),
				'messages' => array (
						self::HAS_MANY,
						'Message',
						'm_user_id' 
				),
				'favShops' => array (
						self::MANY_MANY,
						'WashShop',
						'tb_Favorite_Shop(fs_shop_id, fs_user_id)' 
				) 
		)
		;
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'u_tel' => '手机号',
				'u_pwd' => '密码',
				'u_name' => '昵称',
				'u_score' => '积分',
				'u_nick_name' => '昵称',
				'u_age' => '年龄',
				'u_sex' => '性别',
				'u_car_brand' => '车品牌',
				'u_car_type' => '车型' 
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 *         based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id );
		$criteria->compare ( 'u_tel', $this->u_tel, true );
		$criteria->compare ( 'u_pwd', $this->u_pwd, true );
		$criteria->compare ( 'u_name', $this->u_name, true );
		$criteria->compare ( 'u_score', $this->u_score );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * 验证密码
	 *
	 * @param unknown $password        	
	 * @return boolean
	 */
	public function validatePassword($password) {
		// Yii::trace(CPasswordHelper::hashPassword($password),'uc.*');
		return CPasswordHelper::verifyPassword ( $password, $this->u_pwd );
	}
	
	/**
	 * 用户注册
	 * 
	 * @param LoginForm $loginForm        	
	 * @return array
	 */
	public function reg($loginForm,$autoLogin=TRUE) {
		$rlt = UTool::iniFuncRlt ();
		$model = $loginForm;
		$user_model = new User ();
		$user_model ['u_tel'] = $model->u_tel;
		$user_model ['u_pwd'] = CPasswordHelper::hashPassword ( $model->u_pwd );
		$user_model ['u_name'] = '';
		$user_model ['u_member_id'] = '';
		$user_model ['u_score'] = 0;
		$user_model ['u_join_date'] = date ( 'Y-m-d H:i:s' );
		$user_model ['u_login_date'] = $user_model ['u_join_date'];
		$user_model ['u_type'] = 0; // 默认车主
		$user_model ['u_sex'] = 2; // 默认未知
		$user_model ['u_state'] = 0; // 默认正常
		$user_model ['u_age'] = 254; // 默认未知
		$user_model ['u_nick_name'] = '' . substr ( $model->u_tel, - 4, 4 );
		$user_model ['u_error_count'] = 0;
		
		if (! $user_model->validate ()) {
			$rlt ['msg'] .= $model->getErrors () . ';';
			// Yii::log ( '用户注册信息不符合规范',CLogger::LEVEL_INFO, 'mngr.user.reg.validate' );
		} elseif ($user_model->save ()) {
			$msg = new Message ();
			$msg ['m_content'] = '欢迎您注册我洗车，在线预约，养护爱车不用愁，省钱又省时';
			$msg ['m_datetime'] = date ( 'Y-m-d H:i:s' );
			$msg ['m_user_id'] = $user_model ['id'];
			$msg ['m_type'] = Message::TYPE_ACCOUNT;
			$msg['m_src']=UTool::getRequestInfo();
			$msg['m_level']=Message::LEVEL_NORM;
			$msg->save ();
			
			// 用户注册成功
			// 自动为用户增加车主角色
			$auth = Assignments::model ()->findByAttributes ( array (
					'itemname' => 'car_user',
					'userid' => $user_model ['id'] 
			) );
			if (! isset ( $auth )) {
				$auth = new Assignments ();
			}
			
			$auth->itemname = 'car_user';
			$auth->userid = $user_model ['id'];
			if (! $auth->save ()) {
				if (! $user_model->save ()) {
					Yii::log ( '初始化用户权限失败 userId:' . $user_model ['id'], CLogger::LEVEL_ERROR, 'mngr.user.reg.addAssignment' );
				}
				$rlt ['msg'] .= '初始化用户权限失败;';
			}
			// 自动登录
			// $lf = new LoginForm ();
			// $lf->u_tel = $user_model->u_tel;
			// $lf->u_pwd = $user_model->u_pwd;
			// // $loginForm->login()
			// $lf->setScenario('login');
			
			if ($autoLogin) {
				$loginForm->setScenario ( 'login' );
				$r= $loginForm->login();
				if ($r['status']) {
					
				} else {
					Yii::log ( '用户登录失败次数增加 userId:' . $user_model ['id'], CLogger::LEVEL_WARNING, 'mngr.user.reg.login' );
				} // end if
				
			}
			$rlt ['status'] = true;
			$rlt ['data'] = $user_model;
		
		} else {
			// 用户注册失败
			$rlt ['msg'] = '保存用户注册信息失败;';
			Yii::log ( '用户注册失败' . CJSON::encode ( $user_model ), CLogger::LEVEL_WARNING, 'mngr.user.reg.save' );
		} // end if save
		
		return $rlt;
	}
	
	
	
	
	/**
	 * 根据用户名/手机号/ID查找用户信息
	 * 
	 * @param string $loginStr        	
	 * @return NULL Ambigous mixed, NULL, multitype:CActiveRecord , multitype:unknown Ambigous <CActiveRecord, NULL> , unknown, multitype:unknown Ambigous <unknown, NULL> , multitype:, multitype:unknown >
	 */
	public function getUserByLoginName($loginStr) {
		$loginName = trim ( $loginStr );
		if ($loginName==0 || ! preg_match ( '/^\w{1,20}$/', $loginName )) {
			return null;
		}
		
		
		$criteria = new CDbCriteria ();
		if (! preg_match ( '/^1\d{10}&/', $loginName )) {
			$criteria->addCondition ( 'u_tel=:tel' );
			$criteria->params [':tel'] = $loginName;
		}
		$criteria->addCondition ( 'u_name=:name', 'OR' );
		$criteria->params [':name'] = $loginName;
		if (is_int ( ( int ) $loginName )) {
			$criteria->addCondition ( 'u_member_id=:uid', 'OR' );
			$criteria->params [':uid'] = $loginName;
		}
		
		$criteria->addCondition ( 'u_state=0', 'AND' );
		
		$user = User::model ()->find ( $criteria );
		
		return $user;
	}
	
	/**
	 *
	 * @param int $num        	
	 * @param int $cityId        	
	 * @return array
	 */
	public function getTopUsers($num, $cityId) {
		$criteria = new CDbCriteria ();
		// $criteria->select = 's_name, s_sex, s_age, s_wash_shop_id, id, s_user_id';
		$criteria->order = 'u_score  DESC';
		$criteria->condition = 'u_type=0';
		// $criteria->addCondition('s_state=1');
		$criteria->limit = $num;
		
		$items = $this->findAll ( $criteria );
		return $items;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className
	 *        	active record class name.
	 * @return User the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
