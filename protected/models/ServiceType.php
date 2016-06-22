<?php

/**
 * This is the model class for table "{{Service_Type}}".
 *
 * The followings are the available columns in table '{{Service_Type}}':
 * @property integer $id
 * @property string $st_name
 * @property string $st_desc
 * @property integer $st_value
 * @property integer $st_score
 * @property integer $st_interval_num
 * @property integer $st_time
 *
 * The followings are the available model relations:
 * @property WashShopService[] $washShopServices
 */
class ServiceType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Service_Type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('st_name, st_desc, st_value, st_score', 'required'),
			array('st_value, st_score, st_interval_num', 'numerical', 'integerOnly'=>true),
			array('st_name', 'length', 'max'=>20),
			array('st_desc', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, st_name, st_desc, st_value, st_score, st_interval_num', 'safe', 'on'=>'search'),
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
			'washShopServices' => array(self::HAS_MANY, 'WashShopService', 'wss_st_id'),
				'serviceTypeItems'=>array(
					self::MANY_MANY,
						'ServiceItem',
						'tb_service_type_item(sti_st_id,sti_si_id)',	
						'condition'=>'si_state=1',	
				),
		);
	}
	
	
	/**
	 * 根据服务类别id获取服务对应小项
	 * @param unknown $serviceTypeId
	 * @return boolean
	 */
	public function getServiceTypeItems($serviceTypeId){
		$rlt =UTool::iniFuncRlt();
		$type = ServiceType::model()->findByPk($serviceTypeId);
		if (!isset($type)) {
			$rlt['msg']='00011';
			return $rlt;
		}
		$items = $type->serviceTypeItems;
		
		$rltData = array();
		foreach ($items as $i=>$item){
			foreach ($item as $key=>$value){
				$rltData[$i][$key]=$value;
			}
// 			$rltData[$i]=$item;
			$rltData[$i]['si_name'] = $item->siSit['sit_name'];
			$rltData[$i]['si_desc']=$item->siSit['sit_desc'];
			
			
		}
		$rlt['data']=$rltData;
		$rlt['status']=true;
		return $rlt;
		
		
	}
	
	public function getAllServiceType(){
		$criteria = new CDbCriteria();
// 		$criteria->addCondition('')
		$criteria->order = 'st_flag ASC';
		$serviceList = $this->findAll($criteria);
		$rltList = array();
		foreach ($serviceList as $key=>$service){
			$rltList[] =array(
					'id'=>$service['id'],
					'name'=>$service['st_name'],
					'desc'=>$service['st_desc'],
			); 
		}
		return $rltList;
		
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'st_name' => '服务名称',
			'st_desc' => '服务描述',
			'st_value' => '消费价格',
			'st_score' => '消费积分',
			'st_interval_num' => '服务用时',
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
		$criteria->compare('st_name',$this->st_name,true);
		$criteria->compare('st_desc',$this->st_desc,true);
		$criteria->compare('st_value',$this->st_value);
		$criteria->compare('st_score',$this->st_score);
		$criteria->compare('st_interval_num',$this->st_interval_num);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
