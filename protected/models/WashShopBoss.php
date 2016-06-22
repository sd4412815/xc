<?php

/**
 * This is the model class for table "{{Wash_Shop_Boss}}".
 *
 * The followings are the available columns in table '{{Wash_Shop_Boss}}':
 * @property string $id
 * @property string $b_id
 * @property string $ws_id
 *
 * The followings are the available model relations:
 * @property Boss $b
 * @property WashShop $ws
 */
class WashShopBoss extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Wash_Shop_Boss}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('b_id, ws_id', 'required'),
			array('b_id, ws_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, b_id, ws_id', 'safe', 'on'=>'search'),
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
			'b' => array(self::BELONGS_TO, 'Boss', 'b_id'),
			'ws' => array(self::BELONGS_TO, 'WashShop', 'ws_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'b_id' => 'B',
			'ws_id' => 'Ws',
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
		$criteria->compare('b_id',$this->b_id,true);
		$criteria->compare('ws_id',$this->ws_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WashShopBoss the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
