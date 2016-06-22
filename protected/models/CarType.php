<?php

/**
 * This is the model class for table "{{Car_Type}}".
 *
 * The followings are the available columns in table '{{Car_Type}}':
 * @property integer $id
 * @property string $ct_name
 * @property string $ct_spell
 * @property integer $ct_car_brand_id
 *
 * The followings are the available model relations:
 * @property CarBrand $ctCarBrand
 */
class CarType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Car_Type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ct_name, ct_spell, ct_car_brand_id', 'required'),
			array('ct_car_brand_id', 'numerical', 'integerOnly'=>true),
			array('ct_name', 'length', 'max'=>20),
			array('ct_spell', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ct_name, ct_spell, ct_car_brand_id', 'safe', 'on'=>'search'),
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
			'ctCarBrand' => array(self::BELONGS_TO, 'CarBrand', 'ct_car_brand_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ct_name' => 'Ct Name',
			'ct_spell' => 'Ct Spell',
			'ct_car_brand_id' => 'Ct Car Brand',
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
		$criteria->compare('ct_name',$this->ct_name,true);
		$criteria->compare('ct_spell',$this->ct_spell,true);
		$criteria->compare('ct_car_brand_id',$this->ct_car_brand_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
