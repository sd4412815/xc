<?php

/**
 * This is the model class for table "{{area_hui}}".
 *
 * The followings are the available columns in table '{{area_hui}}':
 * @property string $id
 * @property integer $ah_city_id
 * @property integer $ah_hui_id
 * @property string $ah_start_date
 * @property string $ah_end_date
 * @property string $ah_join_date
 * @property integer $ah_state
 */
class AreaHui extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{area_hui}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ah_city_id, ah_hui_id, ah_start_date, ah_end_date, ah_join_date', 'required'),
			array('ah_city_id, ah_hui_id, ah_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ah_city_id, ah_hui_id, ah_start_date, ah_end_date, ah_join_date, ah_state', 'safe', 'on'=>'search'),
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
			'ah_city_id' => 'Ah City',
			'ah_hui_id' => 'Ah Hui',
			'ah_start_date' => 'Ah Start Date',
			'ah_end_date' => 'Ah End Date',
			'ah_join_date' => 'Ah Join Date',
			'ah_state' => 'Ah State',
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
		$criteria->compare('ah_city_id',$this->ah_city_id);
		$criteria->compare('ah_hui_id',$this->ah_hui_id);
		$criteria->compare('ah_start_date',$this->ah_start_date,true);
		$criteria->compare('ah_end_date',$this->ah_end_date,true);
		$criteria->compare('ah_join_date',$this->ah_join_date,true);
		$criteria->compare('ah_state',$this->ah_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AreaHui the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
