<?php

/**
 * This is the model class for table "{{Wash_Shop_Service}}".
 *
 * The followings are the available columns in table '{{Wash_Shop_Service}}':
 * @property integer $id
 * @property string $wss_ws_id
 * @property integer $wss_st_id
 *
 * The followings are the available model relations:
 * @property WashShop $wssWs
 * @property ServiceType $wssSt
 */
class WashShopService extends CActiveRecord
{
	
	const SHOP_SERVICE_ACTIVE = 1;
	const SHOP_SERVICE_DEACTIVE = 0;
	const SHOP_SERVICE_READY = -1;

	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Wash_Shop_Service}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wss_ws_id, wss_st_id', 'required'),
			array('wss_st_id', 'numerical', 'integerOnly'=>true),
			array('wss_ws_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wss_ws_id, wss_st_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'wssWs' => array(self::BELONGS_TO, 'WashShop', 'wss_ws_id'),//拟废除
			'wssSt' => array(self::BELONGS_TO, 'ServiceType', 'wss_st_id'), //拟废除
			'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'wss_st_id'),
			'carGroup'=>array(self::BELONGS_TO, 'CarGroup', 'wss_car_group'),
			'shop' => array(self::BELONGS_TO, 'WashShop', 'wss_ws_id'),
			'CarOil' => array(self::BELONGS_TO, 'CarOil', 'wss_oil_id'),
		);
	}

	/**
	 * 根据车行id 获取车行可用服务
	 * @param int $shopId
	 * @param string $available
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public function getServices ( $shopId, $available=FALSE){
		
		$rlt = UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		$criteria->addCondition('wss_ws_id=:shopId');
		$criteria->params[':shopId']=$shopId;
	
		if ($available){
			$criteria->addCondition('wss_state=1');
		}else{
			$criteria->addCondition('wss_state>=0');
		}
	
		$criteria->alias = 'prefix';
		$criteria->with='wssSt';
		$criteria->order = 'wssSt.st_flag ASC';
		$rlt['status']=true;
		$rlt['data']=$this->findAll($criteria);
		return $rlt;
// 		return $services;
	
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wss_ws_id' => '车行名称',
			'wss_st_id' => '服务名称',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('wss_ws_id',$this->wss_ws_id,true);
		$criteria->compare('wss_st_id',$this->wss_st_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WashShopService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * 更新车行服务
	 * @param int $id
	 * @param array $services
	 */
	public function updateShopServices($id, $services){
		$shopServices = WashShopService::model()->findAllByAttributes(array('wss_ws_id'=>$id));
		$sss = array();
		foreach ($shopServices as $service){
			array_push($sss, $service['wss_st_id']);
		}
		
		$delete=true;
		$shop = UTool::getShop();
		if (isset($shop) && $shop['id'] == $id) {
			$delete = false;
		}
		// 删除不存在的
		foreach ($shopServices as $key=>$s){
			if(!in_array($s['wss_st_id'], $services)){
				
				if($delete){
					$s->delete();
				}
				else{
					$s['wss_state'] = 0;
					if ($s->save()) {
						;
					}
				}
			}
		}
		// 增加没有的
		foreach ($services as $s){
			
			$st=ServiceType::model()->findByPk($s);
			if (!in_array($s, $sss)) {
				$model = new WashShopService();
			
				$model['wss_ws_id']=$id;
				$model['wss_st_id']=$s;
				$model['wss_state']=1;
				$model['wss_value']=$st['st_value'];
//				$model['wss_value2']=$st['st_value2'];
				$model['wss_service_time']=$st['st_time'];
				$model['wss_service_time_rest']=$st['st_time_rest'];
//				$model['wss_value_min']=$st['st_value'];
				
				if ($model->save()) {
					;
				}
			}else {
				$model = WashShopService::model()->findByAttributes(array('wss_ws_id'=>$id,'wss_st_id'=>$s));
				$model['wss_state']=1;
			$model['wss_value']=$st['st_value'];
//				$model['wss_value2']=$st['st_value2'];
				$model['wss_service_time']=$st['st_time'];
				$model['wss_service_time_rest']=$st['st_time_rest'];
				if($model->save()){}
			}
		}
		
		
	}
	
	
	
}
