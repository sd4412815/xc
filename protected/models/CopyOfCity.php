<?php

/**
 * This is the model class for table "{{City}}".
 *
 * The followings are the available columns in table '{{City}}':
 * @property integer $id
 * @property string $c_name
 * @property string $c_spell
 * @property integer $c_province_id
 *
 * The followings are the available model relations:
 * @property Area[] $areas
 * @property Province $cProvince
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
			array('c_province_id', 'numerical', 'integerOnly'=>true),
			array('c_name', 'length', 'max'=>20),
			array('c_spell', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, c_name, c_spell, c_province_id', 'safe', 'on'=>'search'),
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
			'areas' => array(self::HAS_MANY, 'Area', 'a_city_id'),
			'cProvince' => array(self::BELONGS_TO, 'Province', 'c_province_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'c_name' => '城市名称',
			'c_spell' => '名称汉语全拼',
			'c_province_id' => '省份',
		);
	}

	
	public static function cityItems($prov_id)
	{
		$models = self::model()->findAll(array(
			'condition'=>'c_province_id=:prov_id',
				'params'=>array(':prov_id'=>$prov_id),
				'order'=>'c_spell',
				
				
		));
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
		$criteria->compare('c_name',$this->c_name,true);
		$criteria->compare('c_spell',$this->c_spell,true);
		$criteria->compare('c_province_id',$this->c_province_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
