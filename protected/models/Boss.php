<?php

/**
 * This is the model class for table "{{Boss}}".
 *
 * The followings are the available columns in table '{{Boss}}':
 * @property string $id
 * @property string $b_name
//  * @property string $b_tel
 * @property string $b_pwd
 * @property string $b_nick_name
 * @property integer $b_type
 *
 * The followings are the available model relations:
 * @property WashShop[] $washShops
 * @property WashShopBoss[] $washShopBosses
 */
class Boss extends CActiveRecord {
	
	
	
	
	/**
	 * 根据老板ID查询
	 * @param int $bossID
	 * @return Ambigous <CActiveRecord, mixed, NULL, multitype:CActiveRecord , multitype:unknown Ambigous <CActiveRecord, NULL> , unknown, multitype:unknown Ambigous <unknown, NULL> , multitype:, multitype:unknown >
	 */
	public function getBossWashShopID($bossID){
		return $this["washShopId"];
// 		return WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossID))['ws_boss_id'];
	}
	
	/**
	 * 增加工作时间预约订单
	 * 
	 * @param array $indexList
	 *        	序号表
	 * @param int $bossId
	 *        	用户id
	 * @param int $washShopId
	 *        	车行id 默认值为0时系统会根据bossId自动查找对应车行信息
	 * @param int $position
	 *        	档口位置 默认值为档口1
	 * @param int $bias
	 * 			与今天时间偏移量天数
	 * @return array [state,msg,date]
	 */
	public function orderAdd($indexList, $bossId, $washShopId = 0, $position=1, $bias=0) {
		$rlt = UTool::iniFuncRlt();
		$dataRlt=array();
		try {
			if ($washShopId ==0) {
				// 查找符合要求第一条记录，这是老板应该为车行负责人即 b_type = 0
				$washShopId = $this->findByPk($bossId)->washShop['id'];
				if (!isset($washShopId)) {
					$rlt['msg']='老板对应车行信息不存在';
					return $rlt;
				}
			}
			
// 			Order::getOrderNo($timeIndex, $washShopId, $position)

// 			$order = new Order ();
			$isSuccess=true;
			
			foreach ( $indexList as $i=>$timeIndex ) {
				$bossOrderItem = new BossOrderHistory ();
				$getOrderRlt = Order::getOrderNo ( $timeIndex, $washShopId, $position, $bias );
				Yii::log(CJSON::encode($getOrderRlt),'error','orders.boss.order.add.getOrderRlt');
				if ($getOrderRlt['status']) {
// 					$serviceTime = $getOrderRlt['data'];
					$bossOrderItem->boh_no = $getOrderRlt['data'];
				}else {
					$dataRlt['index']=array(
							'index'=>$timeIndex,
							'status'=>false,
					);
					$isSuccess =false;
					$rlt['msg']=$rlt['msg'].'; '.$timeIndex.$getOrderRlt['msg'];
					continue;
						
				}
				
			
				$bossOrderItem->boh_order_date_time = date ( 'y-m-d H:i:s' );
// 				$serviceTimeRlt = Order::getOrderTime($washShopId, $timeIndex, $serviceIntervalNum);
				$serviceTimeRlt = WashShop::model ()->getServiceTime ( $washShopId, $timeIndex, $serviceIntervalNum = 1,$bias,$position );
				Yii::log(CJSON::encode($serviceTimeRlt),'error','orders.boss.order.add.getOrderRlt');
				if ($serviceTimeRlt['status']) {
					$serviceTime = $serviceTimeRlt['data'];
				}else {
					$dataRlt['index']=array(
						'index'=>$timeIndex,
						'status'=>false,	
					);
					$isSuccess =false;
					$rlt['msg']=$rlt['msg'].'; '.$timeIndex.':获取服务时间失败';
					continue;
					
				}
				$bossOrderItem->boh_date_time = $serviceTime['begin'];
				$bossOrderItem->boh_date_time_end = $serviceTime['end'];
				// $model->boh_order_date_time = date('y-m-d H:i:s');
				$bossOrderItem->boh_wash_shop_id = $washShopId;
				$bossOrderItem->boh_boss_id = $bossId;
				$bossOrderItem->boh_service_num = 1;
				$bossOrderItem->boh_position = $position;
				
				$orderCount = BossOrderHistory::model()->countByAttributes ( array (
						'boh_no' => $bossOrderItem->boh_no,
				) );
				// 订单号是否已存在
				if ($orderCount > 0) {
					Yii::log ( '订单号[' . $bossOrderItem->boh_no . ']已存在', 'info', 'orders.boss.new' );
					$rlt['msg']='00006';
					return $rlt;
				}
				if ($bossOrderItem->save ()) {
					$dataRlt['index']=array(
							'index'=>$timeIndex,
							'status'=>true,
					);

				}else {
					$dataRlt['index']=array(
							'index'=>$timeIndex,
							'status'=>false,
					);
					$isSuccess = false;
					Yii::log(CJSON::encode($bossOrderItem),'info','orders.boss.new');
					$rlt['msg']=$rlt['msg'].'; '.$timeIndex.':存入数据库失败';
			
					
				}
				
			}
			if ($isSuccess) {
				$rlt['status']=true;

			}
			
		} catch ( Exception $e ) {
			Yii::log('[00001]'.$e->getMessage(),'error','orders');
			$rlt['msg'] = $rlt['msg'].'意外失败.失败代码:00001,'.date('Y-m-d H:i:s');
		}
		$rlt['data']=$dataRlt;
		return $rlt;
	}
	
	/**
	 * 删除工作时间预约订单
	 * 
	 * @param array $indexList
	 *        	序号表
	 * @param int $bossId
	 *        	用户id
	 * @param int $washShopId
	 *        	车行id 默认值为0时系统会根据bossId自动查找对应车行信息
	 * @param int $position
	 *        	档口位置 默认值为档口1
	 * @param int $bias
	 * 			与今天时间偏移量天数
	 * @return array [state,msg,date]
	 */
	public function orderDelete($indexList, $bossId, $washShopId=0, $position=1,$bias=0) {
		
		$rlt = UTool::iniFuncRlt();
		$dataRlt=array();
		try {
			$washShopId = $this->findByPk($bossId)->washShop['id'];
			if ($washShopId ==0) {
				// 查找符合要求第一条记录，这是老板应该为车行负责人即 b_type = 0
				$washShopId = $this->findByPk($bossId)->washShop['id'];
				if (!isset($washShopId)) {
					$rlt['msg']='00001';
					return $rlt;
				}
			}
// 			$order = new Order ();
// 			$model = new BossOrderHistory ();
			$isSuccess = false;
			foreach ( $indexList as $i=>$value ) {
				
				$order_no =Order::getOrderNo ( $value, $washShopId, $position )['data'];
// 				return $order_no;
				$orderItem = BossOrderHistory::model()->findByAttributes( array (
						'boh_no' => $order_no ,
				) );

				if (!isset($orderItem)) {
					Yii::log ( '订单号[' . $order_no . ']不存在', 'info', 'orders.boss.delete' );
					$dataRlt[$i]=array(
							'status'=>false,
							'msg'=>'00004:'.$order_no,
					);
					continue;
				}
				if ( $orderItem->delete()) {
					$dataRlt[$i]=array(
							'status'=>true,
							'msg'=>'',
					);

						
				}else {
					$dataRlt[$i]=array(
							'status'=>false,
							'msg'=>'00005:'.$order_no,
					);						
						
				}
				
			}
			if ($isSuccess) {
				$rlt['status']=true;
			
			}
	
		
			
		} catch ( Exception $e ) {
			Yii::log('[00002]'.$e->getMessage(),'error','orders');
			$rlt['msg'] = $rlt['msg'].'意外失败.失败代码:00002,'.date('Y-m-d H:i:s');
		}
		$rlt['data']=$dataRlt;
		return $rlt;
	
	}
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{Boss}}';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				// array (
				// 		'b_name, b_pwd, b_nick_name',
				// 		'required' 
				// ),
				array (
						'b_type',
						'numerical',
						'integerOnly' => true 
				),
				// array (
				// 		'b_name, b_nick_name',
				// 		'length',
				// 		'max' => 20 
				// ),
				// array (
				// 		'b_pwd',
				// 		'length',
				// 		'max' => 128 
				// ),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'id, b_type',
						'safe',
						'on' => 'search' 
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
				'washShop' => array (
						self::HAS_ONE,
						'WashShop',
						'ws_boss_id' 
				),
				'washShopBosses' => array (
						self::HAS_MANY,
						'WashShopBoss',
						'b_id' 
				) 
		);
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				// 'b_name' => 'B Name',
				// 'b_pwd' => 'B Pwd',
				// 'b_nick_name' => 'B Nick Name',
				'b_type' => 'B Type' 
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
		
		$criteria->compare ( 'id', $this->id, true );
		// $criteria->compare ( 'b_name', $this->b_name, true );
		// $criteria->compare ( 'b_pwd', $this->b_pwd, true );
		// $criteria->compare ( 'b_nick_name', $this->b_nick_name, true );
		$criteria->compare ( 'b_type', $this->b_type );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * 验证密码
	 * @param unknown $password
	 * @return boolean
	 */
	public function validatePassword($password)
	{
// 		Yii::trace(CPasswordHelper::hashPassword($password),'uc.*');
		return CPasswordHelper::verifyPassword($password, $this->b_pwd);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return Boss the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
