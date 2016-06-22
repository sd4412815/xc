<?php

/**
 * This is the model class for table "{{time_conf}}".
 *
 * The followings are the available columns in table '{{time_conf}}':
 * @property string $id
 * @property string $tc_name
 * @property string $tc_desc
 * @property string $tc_configuration
 * @property string $tc_join_date
 * @property string $tc_create_user
 * @property integer $tc_state
 * @property integer $tc_type
 */
class TimeConf extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{time_conf}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tc_name, tc_configuration, tc_join_date, tc_create_user', 'required'),
			array('tc_state, tc_type', 'numerical', 'integerOnly'=>true),
			array('tc_name, tc_desc', 'length', 'max'=>255),
			array('tc_create_user', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tc_name, tc_desc, tc_configuration, tc_join_date, tc_create_user, tc_state, tc_type', 'safe', 'on'=>'search'),
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
			'tc_name' => 'Tc Name',
			'tc_desc' => 'Tc Desc',
			'tc_configuration' => 'Tc Configuration',
			'tc_join_date' => 'Tc Join Date',
			'tc_create_user' => 'Tc Create User',
			'tc_state' => 'Tc State',
			'tc_type' => 'Tc Type',
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
		$criteria->compare('tc_name',$this->tc_name,true);
		$criteria->compare('tc_desc',$this->tc_desc,true);
		$criteria->compare('tc_configuration',$this->tc_configuration,true);
		$criteria->compare('tc_join_date',$this->tc_join_date,true);
		$criteria->compare('tc_create_user',$this->tc_create_user,true);
		$criteria->compare('tc_state',$this->tc_state);
		$criteria->compare('tc_type',$this->tc_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimeConf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
