<?php

/**
 * This is the model class for table "{{user_notify}}".
 *
 * The followings are the available columns in table '{{user_notify}}':
 * @property string $id
 * @property string $un_shop_id
 * @property string $un_user_id
 * @property integer $un_type
 * @property string $un_datetime
 * @property integer $un_state
 */
class UserNotify extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_notify}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('un_shop_id, un_user_id, un_datetime', 'required'),
			array('un_type, un_state', 'numerical', 'integerOnly'=>true),
			array('un_shop_id, un_user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, un_shop_id, un_user_id, un_type, un_datetime, un_state', 'safe', 'on'=>'search'),
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
			'un_shop_id' => 'Un Shop',
			'un_user_id' => 'Un User',
			'un_type' => 'Un Type',
			'un_datetime' => 'Un Datetime',
			'un_state' => 'Un State',
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
		$criteria->compare('un_shop_id',$this->un_shop_id,true);
		$criteria->compare('un_user_id',$this->un_user_id,true);
		$criteria->compare('un_type',$this->un_type);
		$criteria->compare('un_datetime',$this->un_datetime,true);
		$criteria->compare('un_state',$this->un_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserNotify the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
