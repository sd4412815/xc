<?php

/**
 * This is the model class for table "{{Staff_Order_History}}".
 *
 * The followings are the available columns in table '{{Staff_Order_History}}':
 * @property string $id
 * @property string $soh_order_history_id
 * @property string $soh_staff_id
 *
 * The followings are the available model relations:
 * @property OrderHistory $sohOrderHistory
 * @property Staff $sohStaff
 */
class StaffOrderHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Staff_Order_History}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('soh_order_history_id, soh_staff_id', 'required'),
			array('soh_order_history_id, soh_staff_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, soh_order_history_id, soh_staff_id', 'safe', 'on'=>'search'),
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
			'sohOrderHistory' => array(self::BELONGS_TO, 'OrderHistory', 'soh_order_history_id'),
			'sohStaff' => array(self::BELONGS_TO, 'Staff', 'soh_staff_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'soh_order_history_id' => 'Soh Order History',
			'soh_staff_id' => 'Soh Staff',
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
		$criteria->compare('soh_order_history_id',$this->soh_order_history_id,true);
		$criteria->compare('soh_staff_id',$this->soh_staff_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffOrderHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
