<?php

/**
 * This is the model class for table "{{Service_Item}}".
 *
 * The followings are the available columns in table '{{Service_Item}}':
 * @property string $id
 * @property string $si_sit_id
 * @property integer $si_value
 * @property integer $si_score
 * @property integer $si_time
 * @property integer $si_city_id
 * @property integer $si_state
 *
 * The followings are the available model relations:
 * @property City $siCity
 * @property ServiceItemTemplate $siSit
 * @property ServiceTypeItem[] $serviceTypeItems
 */
class ServiceItem extends CActiveRecord
{
	public $serviceItemName;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Service_Item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('si_sit_id, si_value, si_score, si_time, si_city_id', 'required'),
			array('si_value, si_score, si_time, si_city_id, si_state', 'numerical', 'integerOnly'=>true),
			array('si_sit_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, si_sit_id, si_value, si_score, si_time, si_city_id, si_state', 'safe', 'on'=>'search'),
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
			'siCity' => array(self::BELONGS_TO, 'City', 'si_city_id'),
			'siSit' => array(self::BELONGS_TO, 'ServiceItemTemplate', 'si_sit_id'),
			'serviceTypeItems' => array(self::HAS_MANY, 'ServiceTypeItem', 'sti_si_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'si_sit_id' => 'Si Sit',
			'si_value' => 'Si Value',
			'si_score' => 'Si Score',
			'si_time' => 'Si Time',
			'si_city_id' => 'Si City',
			'si_state' => 'Si State',
		);
	}
	
	private function UpdateFromTemplateByCity($sits, $cityId, $reset=FALSE){
		foreach ($sits as $key=>$sit){
			$si = ServiceItem::model()->findByAttributes(array(
				'si_sit_id'=>$sit['id'],
					'si_city_id'=>$cityId,
			)
			);
			
			
			Yii::log(CJSON::encode($si),'error','serviceItem.update.cityid'.$cityId);
			if (isset($si)) {
				if ($reset) {
			
				$si['si_sit_id'] = $sit['id'];
				$si['si_value'] = $sit['sit_value'];
				$si['si_score'] = $sit['sit_score'];
				$si['si_time'] = $sit['sit_time'];
				$si['si_state'] = $sit['sit_state'];
				$si['si_order'] = $sit['sit_order'];
				if ($si->save()) {
					
				};
				}else {
					continue;
				}
			}else {
				$sinew = new ServiceItem();
				$sinew['si_sit_id'] = $sit['id'];
				$sinew['si_value'] = $sit['sit_value'];
				$sinew['si_score'] = $sit['sit_score'];
				$sinew['si_time'] = $sit['sit_time'];
				$sinew['si_state'] = $sit['sit_state'];
				$sinew['si_order'] = $sit['sit_order'];
				$sinew['si_city_id']=$cityId;
				if ($sinew->save()) {
					
				};
				
			}
		
		}
	}
	
	public function UpdateFromTemplate($cityId=0,$reset=false){
		Yii::log('sdf','error','serviceItem.update');
		if ($cityId==0) {
			$sits = ServiceItemTemplate::model()->findAllByAttributes(array(
'sit_state'=>'1',				
			));
			
			$citys = City::model()->findAll();
			foreach ($citys as $i=>$city){
				$this->UpdateFromTemplateByCity($sits, $city['id'], $reset);
				
			}

			
			
		}
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
		$criteria->compare('si_sit_id',$this->si_sit_id,true);
		$criteria->compare('si_value',$this->si_value);
		$criteria->compare('si_score',$this->si_score);
		$criteria->compare('si_time',$this->si_time);
		$criteria->compare('si_city_id',$this->si_city_id);
		$criteria->compare('si_state',$this->si_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 根据城市信息获取该城市可用服务小项
	 * @param int $cityId
	 * @return string
	 */
	public function getServiceItems($cityId){
		$rlt = UTool::iniFuncRlt();
		
		$items = $this->findAllByAttributes(array(
				'si_city_id'=>$cityId,
				
		),array('order'=>'id ASC',));// $type->serviceTypeItems;
		
		if (!isset($items)) {
			$rlt['msg']='00012';
			return $rlt;
		}
		
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
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
