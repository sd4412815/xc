<?php

/**
 * This is the model class for table "{{province_hui}}".
 *
 * The followings are the available columns in table '{{province_hui}}':
 * @property string $id
 * @property integer $ph_province_id
 * @property integer $ph_hui_id
 * @property string $ph_start_date
 * @property string $ph_end_date
 * @property string $ph_join_date
 * @property integer $ph_state
 */
class ProvinceHui extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{province_hui}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ph_province_id, ph_hui_id, ph_start_date, ph_end_date, ph_join_date', 'required'),
			array('ph_province_id, ph_hui_id, ph_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ph_province_id, ph_hui_id, ph_start_date, ph_end_date, ph_join_date, ph_state', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ph_province_id' => 'Ph Province',
			'ph_hui_id' => 'Ph Hui',
			'ph_start_date' => 'Ph Start Date',
			'ph_end_date' => 'Ph End Date',
			'ph_join_date' => 'Ph Join Date',
			'ph_state' => 'Ph State',
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
		$criteria->compare('ph_province_id',$this->ph_province_id);
		$criteria->compare('ph_hui_id',$this->ph_hui_id);
		$criteria->compare('ph_start_date',$this->ph_start_date,true);
		$criteria->compare('ph_end_date',$this->ph_end_date,true);
		$criteria->compare('ph_join_date',$this->ph_join_date,true);
		$criteria->compare('ph_state',$this->ph_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProvinceHui the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
