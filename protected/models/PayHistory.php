<?php

/**
 * This is the model class for table "{{pay_history}}".
 *
 * The followings are the available columns in table '{{pay_history}}':
 * @property integer $id
 * @property string $ph_oh_id
 * @property integer $ph_pay_src
 * @property integer $ph_value
 * @property string $ph_datetime
 * @property string $ph_ip
 * @property string $ph_mac
 * @property string $ph_user_id
 *
 * The followings are the available model relations:
 * @property OrderHistory $phOh
 * @property User $phUser
 */
class PayHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pay_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ph_oh_id, ph_pay_src, ph_value, ph_datetime, ph_ip, ph_mac, ph_user_id', 'required'),
			array('ph_pay_src, ph_value', 'numerical', 'integerOnly'=>true),
			array('ph_oh_id, ph_user_id', 'length', 'max'=>10),
			array('ph_ip', 'length', 'max'=>30),
			array('ph_mac', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ph_oh_id, ph_pay_src, ph_value, ph_datetime, ph_ip, ph_mac, ph_user_id', 'safe', 'on'=>'search'),
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
			'phOh' => array(self::BELONGS_TO, 'OrderHistory', 'ph_oh_id'),
			'phUser' => array(self::BELONGS_TO, 'User', 'ph_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ph_oh_id' => 'Ph Oh',
			'ph_pay_src' => 'Ph Pay Src',
			'ph_value' => 'Ph Value',
			'ph_datetime' => 'Ph Datetime',
			'ph_ip' => 'Ph Ip',
			'ph_mac' => 'Ph Mac',
			'ph_user_id' => 'Ph User',
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
		$criteria->compare('ph_oh_id',$this->ph_oh_id,true);
		$criteria->compare('ph_pay_src',$this->ph_pay_src);
		$criteria->compare('ph_value',$this->ph_value);
		$criteria->compare('ph_datetime',$this->ph_datetime,true);
		$criteria->compare('ph_ip',$this->ph_ip,true);
		$criteria->compare('ph_mac',$this->ph_mac,true);
		$criteria->compare('ph_user_id',$this->ph_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PayHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
