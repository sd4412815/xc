<?php

/**
 * This is the model class for table "{{Car_Brand}}".
 *
 * The followings are the available columns in table '{{Car_Brand}}':
 * @property integer $id
 * @property string $cb_name
 * @property string $cb_spell
 *
 * The followings are the available model relations:
 * @property CarType[] $carTypes
 */
class CarBrand extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Car_Brand}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cb_name, cb_spell', 'required'),
			array('cb_name', 'length', 'max'=>20),
			array('cb_spell', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cb_name, cb_spell', 'safe', 'on'=>'search'),
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
			'carTypes' => array(self::HAS_MANY, 'CarType', 'ct_car_brand_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cb_name' => '品牌名称',
			'cb_spell' => '品牌全拼',
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
		$criteria->compare('cb_name',$this->cb_name,true);
		$criteria->compare('cb_spell',$this->cb_spell,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarBrand the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
