<?php

/**
 * This is the model class for table "{{Staff}}".
 *
 * The followings are the available columns in table '{{Staff}}':
 * @property string $id
 * @property string $s_tel
 * @property string $s_pwd
 * @property string $s_name
 * @property integer $s_score
 * @property string $s_wash_shop_id
 * @property integer $s_state
 * @property integer $s_sex
 * @property integer $s_age
 * @property string $s_tag
 * @property float $s_exp
 * 
 *
 * The followings are the available model relations:
 * @property StaffOrderHistory[] $staffOrderHistories
 */
class Staff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Staff}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('s_tel, s_pwd, s_name', 'required'),
			array('s_score, s_state, s_sex, s_age', 'numerical', 'integerOnly'=>true),
			array('s_tel', 'length', 'max'=>11),
			array('s_pwd', 'length', 'max'=>128),
			array('s_name', 'length', 'max'=>20),
			array('s_wash_shop_id', 'length', 'max'=>10),
			array('s_tag', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, s_tel, s_pwd, s_name, s_score, s_wash_shop_id, s_state, s_sex, s_age, s_tag', 'safe', 'on'=>'search'),
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
			'staffOrderHistories' => array(self::HAS_MANY, 'StaffOrderHistory', 'soh_staff_id'),
			'staffUser'=>array(self::BELONGS_TO,'User','s_user_id'),
			'staffCity'=>array(self::BELONGS_TO,'City','s_city_id'),
		);
	}
	
	/**
	 * 
	 * @param int $num
	 * @param int $cityId
	 * @return array
	 */
	public function getTopStaffs($num, $cityId){
		$criteria=new CDbCriteria;
		$criteria->select = 's_tel,s_name, s_sex, s_age, s_wash_shop_id, id, s_user_id, s_exp, s_score';
		$criteria->order='s_score DESC,s_exp DESC ';
		$criteria->addCondition('s_state=1');
// 		$criteria->addCondition('s_state=1');
		$criteria->limit = $num;
		
		
		
		$staffs = $this->findAll($criteria);
		return $staffs;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			's_tel' => 'S Tel',
			's_pwd' => 'S Pwd',
			's_name' => 'S Name',
			's_score' => 'S Score',
			's_wash_shop_id' => 'S Wash Shop',
			's_state' => 'S State',
			's_sex' => 'S Sex',
			's_age' => 'S Age',
			's_tag' => 'S Tag',
		);
	}

	/**
	 * 根据车行信息返回员工列表，默认$washShopId=0返回未分配员工列表
	 * @param int $washshopId 车行Id
	 * @return array 员工列表
	 */
	public function getStaffs($washshopId=0, $isExpOrder=FALSE){
		$rlt = UTool::iniFuncRlt();
		
		$criteria=new CDbCriteria;
		
		$criteria->select=array('id,s_name,s_score,s_state,s_sex,s_age,s_tag,s_user_id,s_join_date');
		if ($isExpOrder) {
			$criteria->order='s_exp DESC, s_score DESC, s_tag ASC';
		}else 
		{
			$criteria->order='s_score DESC, s_tag ASC';
		}
		
		$staffs = $this->findAllByAttributes(array('s_wash_shop_id'=>$washshopId),$criteria);
		$list=array();
		foreach ($staffs as $i=>$staff){
			$list[$i] = array_filter($staff->attributes,'strlen');
		}
		$rlt['data'] = $list;
		$rlt['status']=true;
		$rlt['msg']='获取员工信息成功';
		return $rlt;
	}
	

	public function getStaffsExpUpdate($staff1Id, $staff2Id, $serviceIntervalNum, $isNew){
		$rlt=UTool::iniFuncRlt();
// 		Yii::log($staff1Id.';'.$staff2Id,'error','orders.staff.exp');
		$staff1 = Staff::model()->findByPk($staff1Id);
		
		if (!isset($staff1)) {
			$rlt['msg']='00018';
			return $rlt;
		}

		
		$staff1['s_exp'] = $isNew? $staff1['s_exp'] + $serviceIntervalNum :
					$staff1['s_exp'] - $serviceIntervalNum;
		if (!$staff1->save() ) {
			$rlt['msg']='00019';
			return $rlt;
// 			Yii::log('订单'.$this->oh_no.'对应洗车工信息存入失败'.$e->getMessage(),'error','orders.staff.save');
		}
		
		$staff2 = Staff::model()->findByPk($staff2Id);	
		if (!isset($staff2)) {
			$rlt['msg']='00018';
			return $rlt;
		}
		
		$staff2['s_exp'] = $isNew? $staff2['s_exp'] + $serviceIntervalNum :
									$staff2['s_exp'] - $serviceIntervalNum;

		if (!$staff2->save() ) {
			$rlt['msg']='00019';
			return $rlt;
// 			Yii::log('订单'.$this->oh_no.'对应洗车工信息存入失败'.$e->getMessage(),'error','orders.staff.save');
		}
		$rlt['status']=true;
		return $rlt;
	}
	
	/**
	 * 更新洗车工所属车行信息
	 * @param array $list 洗车工id列表
	 * @param int $washshopId 车行编号
	 * @return array [state,msg,data]
	 */
	public function getStaffsUpdate($list,$washshopId=0){
		
		$rlt = UTool::iniFuncRlt();
// 		Yii::log(CJSON::encode($rlt),'error','staff.update.washshop');
		$isSuccess=false;
		$resultData=array();
		// 一致性要保证  
		try {
			foreach ($list as $i=>$staffId){
				$staff = $this->findByPk($staffId);
				if (!isset($staff)) {
					continue;
				}
				
				if ($washshopId == 0 || $staff['s_wash_shop_id']==0){
					$staff['s_wash_shop_id'] = $washshopId;
				}else {
					$isSuccess=false;
					$resultData[$staffId]=array(
							'staffId'=>$staffId,
							'status'=>false
					);
					$rlt['msg'] = $rlt['msg'].';员工'.$staffId.'不属于该车行或者人才储备库';
					continue;
				}
// 				$staff['s_wash_shop_id'] = $washshopId;
				if ($staff->save()) {
					$resultData[$staffId] = array(
							'staffId'=>$staffId,
							'status'=>true
					);
				}else {
					$isSuccess=false;
					$resultData[$staffId]=array(
						'staffId'=>$staffId,
						'status'=>false，
					);
				}
// 				$staff->save();
			}
			$rlt['data'] = $resultData;
			$rlt['status'] = true;
// 				Yii::log(CJSON::encode($rlt),'error','staff.update.washshop');
			if ($washshopId != 0) {
				$washshop = WashShop::model()->findByPk($washshopId);
				$serviceCountRlt = $washshop->getServiceCount($washshopId,true,false);
				if ($serviceCountRlt['status']) {
						$washshop['ws_count'] = $serviceCountRlt['data'];
						
						if ($washshop->save()) {
							$rlt['status'] = true;
							$rlt['msg'] = '变更车行可以洗车位数量成功';
							return $rlt;
						}
				}
				else {
					$rlt['msg']='获取服务数量失败';
					return $rlt;
				}
				
				
			}
		
// 			return true;
		} catch (Exception $e) {
			Yii::log('[00003]'.$e->getMessage(),'error','staff');
			$rlt['msg'] = $rlt['msg'].'意外失败.失败代码:00003,'.date('Y-m-d H:i:s');
		}
		
		return $rlt;
	
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
		$criteria->compare('s_tel',$this->s_tel,true);
		$criteria->compare('s_pwd',$this->s_pwd,true);
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('s_score',$this->s_score);
		$criteria->compare('s_wash_shop_id',$this->s_wash_shop_id,true);
		$criteria->compare('s_state',$this->s_state);
		$criteria->compare('s_sex',$this->s_sex);
		$criteria->compare('s_age',$this->s_age);
		$criteria->compare('s_tag',$this->s_tag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
