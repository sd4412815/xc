<?php

/**
 * This is the model class for table "{{order_history_item}}".
 *
 * The followings are the available columns in table '{{order_history_item}}':
 * @property string $id
 * @property string $ohi_oh_id
 * @property string $ohi_si_id
 *
 * The followings are the available model relations:
 * @property OrderHistory $ohiOh
 * @property ServiceItem $ohiSi
 */
class OrderHistoryItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_history_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ohi_oh_id, ohi_si_id', 'required'),
			array('ohi_oh_id, ohi_si_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ohi_oh_id, ohi_si_id', 'safe', 'on'=>'search'),
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
			'ohiOh' => array(self::BELONGS_TO, 'OrderHistory', 'ohi_oh_id'),
			'ohiSi' => array(self::BELONGS_TO, 'ServiceItem', 'ohi_si_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ohi_oh_id' => 'Ohi Oh',
			'ohi_si_id' => 'Ohi Si',
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
		$criteria->compare('ohi_oh_id',$this->ohi_oh_id,true);
		$criteria->compare('ohi_si_id',$this->ohi_si_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderHistoryItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
