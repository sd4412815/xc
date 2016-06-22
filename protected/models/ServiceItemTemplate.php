<?php

/**
 * This is the model class for table "{{service_item_template}}".
 *
 * The followings are the available columns in table '{{service_item_template}}':
 * @property string $id
 * @property string $sit_name
 * @property string $sit_desc
 * @property integer $sit_value
 * @property integer $sit_score
 * @property integer $sit_time
 * @property integer $sit_state
 *
 * The followings are the available model relations:
 * @property ServiceItem[] $serviceItems
 */
class ServiceItemTemplate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_item_template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sit_name, sit_desc, sit_value, sit_score, sit_time', 'required'),
			array('sit_value, sit_score, sit_time, sit_state', 'numerical', 'integerOnly'=>true),
			array('sit_name', 'length', 'max'=>20),
			array('sit_desc', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sit_name, sit_desc, sit_value, sit_score, sit_time, sit_state', 'safe', 'on'=>'search'),
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
			'serviceItems' => array(self::HAS_MANY, 'ServiceItem', 'si_sit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sit_name' => '条目名称',
			'sit_desc' => '条目描述',
			'sit_value' => '费用',
			'sit_score' => '积分',
			'sit_time' => '用时',
			'sit_state' => '状态',
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
		$criteria->compare('sit_name',$this->sit_name,true);
		$criteria->compare('sit_desc',$this->sit_desc,true);
		$criteria->compare('sit_value',$this->sit_value);
		$criteria->compare('sit_score',$this->sit_score);
		$criteria->compare('sit_time',$this->sit_time);
		$criteria->compare('sit_state',$this->sit_state);
		
		$criteria->order = 'id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceItemTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
