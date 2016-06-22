<?php

/**
 * This is the model class for table "{{staff_event}}".
 *
 * The followings are the available columns in table '{{staff_event}}':
 * @property integer $id
 * @property string $se_date_time
 * @property string $se_date_time_end
 * @property integer $se_type
 * @property string $se_staff_id
 * @property string $se_user_id
 *
 * The followings are the available model relations:
 * @property Staff $seStaff
 * @property User $seUser
 */
class StaffEvent extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{staff_event}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('se_date_time, se_date_time_end, se_staff_id, se_user_id', 'required'),
			array('se_type', 'numerical', 'integerOnly'=>true),
			array('se_staff_id, se_user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, se_date_time, se_date_time_end, se_type, se_staff_id, se_user_id', 'safe', 'on'=>'search'),
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
			'seStaff' => array(self::BELONGS_TO, 'Staff', 'se_staff_id'),
			'seUser' => array(self::BELONGS_TO, 'User', 'se_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'se_date_time' => '开始时间',
			'se_date_time_end' => '结束时间',
			'se_type' => '缘由',
			'se_staff_id' => 'Se Staff',
			'se_user_id' => 'Se User',
				'se_desc'=>'备注',
		
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
		$criteria->compare('se_date_time',$this->se_date_time,true);
		$criteria->compare('se_date_time_end',$this->se_date_time_end,true);
		$criteria->compare('se_type',$this->se_type);
		$criteria->compare('se_staff_id',$this->se_staff_id,true);
		$criteria->compare('se_user_id',$this->se_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffEvent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
