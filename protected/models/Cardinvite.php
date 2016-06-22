<?php

/**
 * This is the model class for table "{{cardinvite}}".
 *
 * The followings are the available columns in table '{{cardinvite}}':
 * @property string $id
 * @property string $ci_sn
 * @property string $ci_pwd
 * @property integer $ci_state
 * @property string $ci_date_active
 * @property string $ci_date_used
 * @property integer $ci_batch_no
 * @property string $ci_shop_id
 * @property integer $ci_owner
 * @property integer $ci_value
 *
 * The followings are the available model relations:
 * @property WashShop $ciShop
 */
class Cardinvite extends CActiveRecord
{
	public $gValueRemain;
	public $gValueRequest;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cardinvite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ci_pwd, ci_state,  ci_batch_no, ci_shop_id, ci_owner, ci_value', 'required'),
			array('ci_state, ci_batch_no, ci_owner, ci_value', 'numerical', 'integerOnly'=>true),
			array('ci_sn', 'length', 'max'=>25),
			array('ci_pwd', 'length', 'max'=>16),
			array('ci_shop_id', 'length', 'max'=>10),
			array('ci_sn, ci_pwd','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ci_sn, ci_pwd, ci_state, ci_date_active, ci_date_used, ci_batch_no, ci_shop_id, ci_owner, ci_value', 'safe', 'on'=>'search'),
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
			'ciShop' => array(self::BELONGS_TO, 'WashShop', 'ci_shop_id'),
			'ciGenHistory' => array(self::BELONGS_TO, 'CardGenHistory', 'ci_batch_no'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ci_sn' => 'Ci Sn',
			'ci_pwd' => 'Ci Pwd',
			'ci_state' => 'Ci State',
			'ci_date_active' => 'Ci Date Active',
			'ci_date_used' => 'Ci Date Used',
			'ci_batch_no' => 'Ci Batch No',
			'ci_shop_id' => 'Ci Shop',
			'ci_owner' => 'Ci Owner',
			'ci_value' => 'Ci Value',
		);
	}
	
	public function getGValueRemain($shopId){
		
		$totalGValue = CardGenHistory::model()->getGuarantee($shopId);
		
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(ci_g_value) as gValueRemain';
		$criteria->addCondition('ci_shop_id=:shopId');
		$criteria->params[':shopId']=$shopId;
		$criteria->addCondition('ci_state=2');
		$availableGValue = Cardinvite::model()->find($criteria);
		@$availableGValue =  $availableGValue-> gValueRemain;
		if (!is_numeric($availableGValue)) {
			$availableGValue = 0;
		}
		
		$criteria1 = new CDbCriteria();
		$criteria1->select = 'sum(gp_value) as gValueRequest';
		$criteria1->addCondition('gp_shop_id=:shopId');
		$criteria1->params[':shopId']=$shopId;
		$criteria1->addCondition('gp_state>=0');
		$requestGValue = GuaranteePay::model()->find($criteria1);
		@$requestGValue =  $requestGValue-> gValueRequest;
		
		if (!is_numeric($requestGValue)) {
			$requestGValue = 0;
		}
		return $availableGValue - $requestGValue;

		
	}
	
	/**
	 * 返回用户优惠卡列表
	 * 刘长鑫
	 * 20150326
	 * @param int $userId
	 * @param int $pageIndex
	 * @param int $pageSize
	 * @param string $startTime
	 * @param string $endTime
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getUserCardList($userId, $pageIndex=0, $pageSize=8, $startTime=NULL,$endTime=NULL){
	     
	    $rlt = UTool::iniFuncRlt();
	    $criteria = new CDbCriteria ();
	    $criteria->order = 'ci_date_end ASC, ci_state ASC, ci_date_begin ASC';
	    $criteria->addCondition ( 'ci_owner=:user_id' );
	    $criteria->params [':user_id'] = $userId;
	     
	    if (isset($startTime)){
	        $criteria->addCondition ( 'ci_date_begin>=:start' );
	        $criteria->params [':start'] = date('Y-m-d H:i:s', strtotime( $startTime));
	    }
	    if (isset  ( $endTime )) {
	        $criteria->addCondition ( 'ci_date_end<=:end' );
	        $criteria->params [':end'] = date('Y-m-d H:i:s', strtotime( $endTime));
	    }
	     
	    $dataProvider = new CActiveDataProvider ( $this, array (
	        'pagination' => array (
	            'pageSize' => $pageSize,
	            'currentPage'=>$pageIndex,
	        ),
	        'criteria' => $criteria
	    ) );
	    $rlt['status']=true;
	    $rlt['msg']='查询成功';
	    $rlt['data']=$dataProvider;
	    return $rlt;

	}
	
	public function addCard($uid, $pwd) {
	    $rlt = UTool::iniFuncRlt ();
	        $pwd = str_replace ( array (
	            '_',
	            '-'
	        ), '', $pwd );
	        $card = Cardinvite::model ()->findByAttributes ( array (
	            'ci_pwd' => $pwd
	        ) );
	        if (isset ( $card )) {
	            if ($card ['ci_owner'] != - 1) {
	                $rlt['msg']='次卡已被使用';
	
	            } else {
	                	
	                $card ['ci_date_active'] = date ( 'Y-m-d H:i:s' );
	                $card ['ci_owner'] =$uid;
	                if ($card->save ()) {
	                    $rlt ['status'] = true;
	                    $rlt['msg']='添加成功';
	                    $rlt['data']=$card['id'];
	                    // echo 'true';
	                } else {
	                    $rlt ['msg'] = '添加失败，请稍后再试';
	                }
	            }
	        } else {
	            $rlt ['msg'] = '此卡已失效或非法卡！';
	          
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
		$criteria->compare('ci_sn',$this->ci_sn,true);
		$criteria->compare('ci_pwd',$this->ci_pwd,true);
		$criteria->compare('ci_state',$this->ci_state);
		$criteria->compare('ci_date_active',$this->ci_date_active,true);
		$criteria->compare('ci_date_used',$this->ci_date_used,true);
		$criteria->compare('ci_batch_no',$this->ci_batch_no);
		$criteria->compare('ci_shop_id',$this->ci_shop_id,true);
		$criteria->compare('ci_owner',$this->ci_owner);
		$criteria->compare('ci_value',$this->ci_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function statisticCount($shopId, $type){
		
		$rlt = UTool::iniFuncRlt();
		
		$batchNos = array();
		$batchs = CardGenHistory::model()->findAllByAttributes(
				array('cgh_shop_id'=>$shopId,
						'cgh_type'=>$type));
		foreach ($batchs as $no){
			array_push($batchNos, $no['id']);
		}
		
		$crietia = new CDbCriteria();
		$crietia->addCondition('ci_state>0');
		$crietia->addCondition('ci_shop_id='.$shopId);
		
		$crietia->addInCondition('ci_batch_no', $batchNos);
		$totalCount = $this->count($crietia);
		
		$crietia1 = new CDbCriteria();
		$crietia1->addCondition('ci_state=2');
		$crietia1->addCondition('ci_shop_id='.$shopId);
		$crietia1->addInCondition('ci_batch_no', $batchNos);
		$usedCount = $this->count($crietia1);
		
		$rlt['status']=true;
		$rlt['data']=array('totalCount'=>$totalCount,
							'usedCount'=>$usedCount);
		return $rlt;
		
	}
	
	/**
	 * 根据老板信息获取车行所有首次优惠卡信息
	 * 刘长鑫
	 * 20150314
	 * @param int $bossId
	 * @param bool $used 是否使用
	 * @return string|Ambigous <multitype:, boolean>
	 */
	public function getBossDiscountCardCount($bossId,$used=TRUE){
		$rlt=UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		$criteria->addCondition('ci_shop_id=:shopId');
		
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='未找到该老板的车行信息';
			return $rlt;
		}
		$criteria->params[':shopId'] = $shop['id'];
		
		$batchNos = array();
		$batchs = CardGenHistory::model()->findAllByAttributes(
		    array('cgh_shop_id'=>$shop['id'],
		        'cgh_type'=>0));
		foreach ($batchs as $key=> $no){
		    array_push($batchNos, $no['id']);
		}
		$criteria->addInCondition('ci_batch_no', $batchNos);
		
		
// 		$criteria->addCondition('ci_type=0');
		$criteria->addCondition('ci_owner>0');
		if ($used){
		    $criteria->addCondition('ci_state=2');
		}
		
		$count = Cardinvite::model()->count($criteria);
		$rlt['status']=true;
		$rlt['data']=$count;
		return $rlt;
	}
	
	public function getBossOneCardCount($bossId,$type=0,$used=TRUE){
		$rlt=UTool::iniFuncRlt();
		
		
		
		$criteria = new CDbCriteria();
		$criteria->addCondition('ci_shop_id=:shopId');

		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='未找到该老板的车行信息';
			return $rlt;
		}
		$criteria->params[':shopId'] = $shop['id'];
		
		$batchNos = array();
		$cri = new CDbCriteria();
		$cri->addCondition('cgh_shop_id=:shopId');
		$cri->params[':shopId'] = $shop['id'];
		
		if($type==0){
		    $cri->addCondition('cgh_type>0');
		}else{
		    $cri->addCondition('cgh_type=:type');
		    $cri->params[':type'] = $type;
		}
		
		$batchs = CardGenHistory::model()->findAll($cri);
		foreach ($batchs as $key=> $no){
		    array_push($batchNos, $no['id']);
		}
		
		$criteria->addInCondition('ci_batch_no', $batchNos);
		
		$criteria->addCondition('ci_owner>0');
		if ($used){
		    $criteria->addCondition('ci_state=2');
		}
		
// 		$criteria->addCondition('ci_type>0');
// 		$criteria->addCondition('ci_owner>0');
		$count = Cardinvite::model()->count($criteria);
		$rlt['status']=true;
		$rlt['data']=$count;
		return $rlt;
	}
	
	public function getUserDiscountCardCount($userId){
		$rlt=UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		$criteria->addCondition('ci_owner=:userId');
		$criteria->params[':userId'] = $userId;
		$criteria->addCondition('ci_type=0');
		$criteria->addCondition('ci_state=1');
		$count = Cardinvite::model()->count($criteria);
		$rlt['status']=true;
		$rlt['data']=$count;
		return $rlt;
	}
	
	public function getUserOneCardCount($userId){
		$rlt=UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		$criteria->addCondition('ci_owner=:userId');
		$criteria->params[':userId'] = $userId;
		$criteria->addCondition('ci_type>0');
		$criteria->addCondition('ci_state=1');
		$count = Cardinvite::model()->count($criteria);
		$rlt['status']=true;
		$rlt['data']=$count;
		return $rlt;
	}
	
	/**
	 * 
	 * @param int $shopId
	 * @param int $num 数量
	 * @param int $value 金额
	 * @param int $batchNo 申请批次
	 */
	public function send($shopId, $num,$value, $batchNo, $type, $gValue){
		
		$rlt = UTool::iniFuncRlt();
		Yii::log('batchNo:'.$batchNo,'info','mngr.cardinvite.send');
		$currentCount = 0;
// 		$maxErrCount = 20;
		while ($currentCount<$num)
		{
			$model = new Cardinvite();
			$model['ci_shop_id']=$shopId;
// 			$model['ci_sn'] = '12';
			$model['ci_pwd']=UTool::randomkeys(8);
			$model['ci_state']=0;
			$model['ci_batch_no'] =$batchNo;
			$model['ci_owner']=-1;
			$model['ci_value']=$value;
			$model['ci_type']=$type;
			$model['ci_g_value'] = $gValue;
			if($model->save()){
				$currentCount++;
// 				Yii::log(CJSON::encode($genModel),'info','mngr.cardinvite.send');
			}else {
// 				Yii::log(CJSON::encode($model),'info','mngr.cardinvite.send');
			}
			
		}
		$rlt['status']=true;
		
		return $rlt;
		
		
		
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$lastItem =  $this->find(array(
// 						'condition'=>'a_city_id='.$this->a_city_id,
						'order'=>'id DESC',
						'limit'=>1,
				));
	
				if (!empty($lastItem))
	
					$this->ci_sn = $lastItem['ci_sn']+1;
				else
					$this->ci_sn = 1;
			}
	
			return true;
		}
		else
			return false;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cardinvite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
