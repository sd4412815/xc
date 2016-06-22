<?php

/**
 * This is the model class for table "{{weixin_openid}}".
 *
 * The followings are the available columns in table '{{weixin_openid}}':
 * @property string $id
 * @property string $wo_open_id
 * @property integer $wo_sub_datetime
 * @property integer $wo_user_id
 * @property integer $wo_city
 * @property integer $wo_province
 * @property string $wo_nickname
 */
class WeixinOpenid extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{weixin_openid}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wo_open_id', 'required'),
			array('wo_sub_datetime, wo_user_id', 'numerical', 'integerOnly'=>true),
			array('wo_open_id', 'length', 'max'=>255),
			array('wo_nickname', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wo_open_id, wo_sub_datetime, wo_user_id, wo_city, wo_province, wo_nickname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wo_open_id' => 'Wo Open',
			'wo_sub_datetime' => 'Wo Sub Datetime',
			'wo_user_id' => 'Wo User',
			'wo_city' => 'Wo City',
			'wo_province' => 'Wo Province',
			'wo_nickname' => 'Wo Nickname',
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
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('wo_open_id',$this->wo_open_id,true);
		$criteria->compare('wo_sub_datetime',$this->wo_sub_datetime);
		$criteria->compare('wo_user_id',$this->wo_user_id);
		$criteria->compare('wo_city',$this->wo_city);
		$criteria->compare('wo_province',$this->wo_province);
		$criteria->compare('wo_nickname',$this->wo_nickname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 校验微信openid
	 * @param int $wid 微信openid表id
	 * @param string $signature 签名
	 * @return string|Ambigous <string, multitype:, boolean>
	 */
	public function checkWeixinOpenId($wid, $signature){
		
		$getRlt = $this->getWeixinOpenIdSign($wid);
		
		
		if (!$getRlt['status']){
			return $getRlt;
		} 
		$tmpStr = $getRlt['data'];
		$rlt = UTool::iniFuncRlt();
		if ($tmpStr == $signature ) {
			$rlt['status']=TRUE;
			$rlt['data']=array('openid'=>$wid);
		} else {
			$rlt['msg']='校验失败';
		}
		return $rlt;
	
	}
	
	
	
	
	/**
	 * 生成微信openid签名
	 * @param int $wid
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function getWeixinOpenIdSign($wid){
		$rlt=UTool::iniFuncRlt();
		if(!UCom::checkInt($wid)){
			$rlt['msg']="参数非法";
			return $rlt;
		}
		$model = $this->findByPk($wid);
		if ($model === null){
			$rlt['msg']='参数非法';
		}
		
		$tmpArr = array (
				$wid,
				$model['wo_open_id'],
				$model['wo_sub_datetime']
		);
		sort ( $tmpArr,SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		 $rlt['data']=$tmpStr;
		 $rlt['status']=true;
		 return $rlt;
		
		
		
	}
	
	/**
	 * 增加新关注用户
	 * 
	 * @param string $openid
	 * @param int $appServiceId 服务号对应的应用表ID
	 * @return Ambigous <string, multitype:, boolean>
	 */
	public function addUser($openid, $appServiceId){
		$rlt = UTool::iniFuncRlt ();
		$openIdModel = $this->getUserByOpenId($openid, $appServiceId);
		if ($openIdModel === null) {
// 			新用户
			$openIdModel = new WeixinOpenid ();
			$openIdModel ['wo_open_id'] = $openid;
			$openIdModel ['wo_sub_datetime'] = time();
			$openIdModel ['wo_update_time'] = date('Y-m-d H:i:s');
			$openIdModel['wo_src']=$appServiceId;
			if (! $openIdModel->save ()) {
				Yii::log ( CJSON::encode ( $openIdModel ), CLogger::LEVEL_WARNING, 'mngr.weixin.user.add.save_failure' );
				$rlt ['msg'] = '保存用户信息失败';
				return $rlt;
			}
			$rlt ['status'] = true;
			$rlt['data']=array('wid'=>$openIdModel['id']);
		} else {
// 			老用户
			$rlt['msg']='用户已存在';
		}
		return $rlt;
	}
	
	/**
	 * 更新微信用户信息
	 * @param string $openid
	 * @param string $province
	 * @param string $city
	 * @param string $nickName
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function updateUser($openid, $province, $city, $nickName){
		$rlt = UTool::iniFuncRlt ();
		$openIdModel = $this->getUserByOpenId($openid);
		if ($openIdModel === NULL){
			$rlt['msg'] = '用户不存在';
			return $rlt;
		}

		$openIdModel ['wo_nickname'] = $nickName;
		$openIdModel ['wo_city'] =$city;
		$openIdModel ['wo_province'] = $province;
		if (! $openIdModel->save ()) {
			Yii::log ( CJSON::encode ( $openIdModel ), CLogger::LEVEL_WARNING, 'mngr.weixin.user.update.save_failure' );
			$rlt ['msg'] = '保存用户信息失败';
			return $rlt;
		}
		$rlt ['status'] = true;
		return $rlt;
	}
	
	
	private function getParamFromRequest(){
		$state = Yii::app()->request->getParam('state');
		$code = Yii::app()->request->getParam('code');
	}
	
// 	/**
// 	 * 微信登录
// 	 */
// 	public function loginFromWeixinByCode($openId, $currentUserId = NULL) {
// 		$rlt = UTool::iniFuncRlt ();
		
// 		// $accessTokenRlt = json_decode($accessTokenRlt);
// 		// if (!isset($accessTokenRlt->errcode)){
// 		// $accessToken = $accessTokenRlt->access_token;
// 		// $openId = $accessTokenRlt->openid;
// 		// $unionid = $accessTokenRlt->unionid;
// 		$weiUser = WeixinOpenid::model ()->findByAttributes ( array (
// 				'wo_open_id' => $openId 
// 		) );
// 		if ($weiUser == NULL) {
// 			return $rlt;
// 		}
// 		$userId = $weiUser ['wo_user_id'];
// 		// Yii::log(Yii::app()->user->isGuest,CLogger::LEVEL_INFO,'mngr.Yii::app()->user->isGuest');
// 		if ($currentUserId != $userId) {
// 			$loginRlt = $this->loginByOpenId ( $openId );
// 			// Yii::log(json_encode($loginRlt),CLogger::LEVEL_INFO,'mngr.wechat.loginrlt');
// 			return $loginRlt;
// 		} else {
// 			$rlt ['status'] = TRUE;
// 		}
// 		return $rlt;
// 		// }
// 		// return $rlt;
// 	}
	
	const LOGIN_FIRST=0;
	const LOGIN_ALLREDY=1;
	
	public function loginByOpenId($openId,$appServiceId, $currentUserId = -1){
		$rlt = UTool::iniFuncRlt();
		$weixinUser = $this->getUserByOpenId($openId, $appServiceId);
		if ($weixinUser === null){
			$rlt['msg']='用户不存在';
			return $rlt;
		}
		$userId = $weixinUser['wo_user_id'];
		if($currentUserId>0 && $currentUserId==$userId){
			$rlt['data']= WeixinOpenid::LOGIN_ALLREDY;
			$rlt['status']=TRUE;
			return $rlt;
		}
// 		Yii::log($userId,CLogger::LEVEL_INFO,'mngr.login.userid');
		if ($userId > 0){
			$user = User::model()->findByPk($userId);
// 			Yii::log(CJSON::encode($user),CLogger::LEVEL_INFO,'mngr.loginbyopenid');
			if (isset($user)){
				$loginform = new LoginForm();
				$loginform->u_tel = $user->u_tel;				
// 				$loginModel = new LoginForm();
// 				$loginModel->u_tel="13898800771";
				$rlt = $loginform->login(TRUE);
				if ($rlt['status']){
					$rlt['status']=TRUE;
					$rlt['data']=WeixinOpenid::LOGIN_FIRST;
				}
				return $rlt;
				
			}
			
		}
		return $rlt;
		
		
		
		
	}
	
	
	/**
	 * 查询微信用户
	 * @param string $openId
	 * @param string $appServiceId
	 * @return weixinOpenid Object
	 */
	public function getUserByOpenId($openId,$appServiceId){
		return  $this->findByAttributes(array(
				'wo_open_id'=>$openId,
				'wo_src'=>$appServiceId
		));
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WeixinOpenid the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
