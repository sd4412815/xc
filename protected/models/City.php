<?php

/**
 * This is the model class for table "{{City}}".
 *
 * The followings are the available columns in table '{{City}}':
 * @property integer $id
 * @property integer $c_no
 * @property string $c_name
 * @property string $c_spell
 * @property integer $c_province_id
 */
class City extends CActiveRecord
{
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{City}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_name, c_spell, c_province_id', 'required'),
			array('c_no, c_province_id', 'numerical', 'integerOnly'=>true),
			array('c_name', 'length', 'max'=>20),
			array('c_spell', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, c_no, c_name, c_spell, c_province_id', 'safe', 'on'=>'search'),
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
				'province' => array (
						self::BELONGS_TO,
						'Province',
						'c_province_id'
				),
				'serviceTypes'=>array(
					self::HAS_MANY,
						'ServiceType',
						'st_city_id',	
						'order'=>'id ASC',
				),
	
		);
	}
	
	/**
	 * 
	 * @param string $provinceId
	 * @param string $available 默认true
	 * @param string $orderByState 默认true
	 * @return multitype:static
	 */
	public function getCityList($provinceId=NULL,$available=TRUE, $orderByState=TRUE){
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'c_state>=0' );
		if ($available===TRUE){
			$criteria->addCondition ( 'c_state>=1' );
		}else{
			$criteria->addCondition ( 'c_state>=0' );
		}
		if ($orderByState){
			$criteria->order = 'c_state DESC, c_spell ASC';
		} else {
			$criteria->order = 'c_spell ASC';
		}
		if (isset($provinceId)){
			$criteria->addCondition('c_province_id=:pid');
			$criteria->params[':pid']=$provinceId;
		}
		$cityListmodel = City::model ()->findAll ( $criteria );
		return $cityListmodel;
	}
	
	
	public function getCityByPinyin($cityPinyin){
		$criteria = new CDbCriteria();
		$criteria->addSearchCondition('c_spell', strtolower($cityPinyin));
		return City::model()->find($criteria);
	}
	
	/**
	 * 根据城市名称检索城市信息
	 *
	 * @param string $cityName
	 * @return array
	 */
	public function getCityInfo($cityName) {
		$rlt = UTool::iniFuncRlt ();
		$city = $this->find ( array (
				'condition' => 'c_name LIKE :cityName',
				'params' => array (
						':cityName' => "$cityName%"
				)
		) );
		if (! isset ( $city )) {
			$rlt ['msg'] = '00014';
			return $rlt;
		}

		$rlt ['data'] = $city;
		$rlt ['status'] = true;
		return $rlt;
	}
	
	/**
	 * 根据城市id检索城市信息
	 * @param int $cityId
	 * @return string
	 */
	public function getCityInfoById($cityId){
		$rlt=UTool::iniFuncRlt();
		$city = $this->findByPk($cityId);
		if (! isset ( $city )) {
			$rlt ['msg'] = '00014';
			return $rlt;
		}
		
		$rlt ['data'] = $city;
		$rlt ['status'] = true;
		return $rlt;
	}
	
	/**
	 * 根据城市信息获取服务类型
	 * @param int $cityId
// 	 * @param int $type 1车 2大车 0不限
	 * @return string
	 */
	public function getServiceTypes($cityId){
		$rlt=UTool::iniFuncRlt();
		
		$city = $this->findByPk($cityId);
		if(!isset($city)){
			$rlt['msg']='00010';
			return $rlt;
		}
		
		$serviceTypeItems=$city->serviceTypes;
		
		
		
		$rltData=array();
		foreach ($serviceTypeItems as $i=>$typeItem){
			$rltData[$i]=$list[$i] = array_filter($typeItem->attributes,'strlen');
		}
		$rlt['data']=$rltData;
		$rlt['status']=true;
		return $rlt;
	}
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'c_no' => 'C No',
			'c_name' => '城市名称',
			'c_spell' => '汉语拼音',
			'c_province_id' => '所属省份',
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
		$criteria->compare('c_no',$this->c_no);
		$criteria->compare('c_name',$this->c_name,true);
		$criteria->compare('c_spell',$this->c_spell,true);
		$criteria->compare('c_province_id',$this->c_province_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	/**
	 * 新插入城市时自动计算城市编号
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$lastItem =  $this->findAll(array(
					'condition'=>'c_province_id='.$this->c_province_id,
						'order'=>'c_no DESC',
						'limit'=>1,
				));
				
				if (!empty($lastItem))
						
					$this->c_no = $lastItem[0]['c_no']+1;
				else 
					$this->c_no = 1;
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
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
