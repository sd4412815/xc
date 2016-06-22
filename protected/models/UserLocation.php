<?php

/**
 * This is the model class for table "{{user_location}}".
 *
 * The followings are the available columns in table '{{user_location}}':
 * @property string $id
 * @property string $ul_datetime
 * @property double $ul_latitude
 * @property double $ul_longitude
 * @property string $ul_user_openid
 */
class UserLocation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ul_datetime, ul_user_openid', 'required'),
// 			array('ul_latitude, ul_longitude', 'numerical'),
			array('ul_user_openid', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ul_datetime, ul_latitude, ul_longitude, ul_user_openid', 'safe', 'on'=>'search'),
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
			'ul_datetime' => 'Ul Datetime',
			'ul_latitude' => 'Ul Latitude',
			'ul_longitude' => 'Ul Longitude',
			'ul_user_openid' => 'Ul User Openid',
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
		$criteria->compare('ul_datetime',$this->ul_datetime,true);
		$criteria->compare('ul_latitude',$this->ul_latitude);
		$criteria->compare('ul_longitude',$this->ul_longitude);
		$criteria->compare('ul_user_openid',$this->ul_user_openid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserLocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
