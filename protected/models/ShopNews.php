<?php

/**
 * This is the model class for table "{{shop_news}}".
 *
 * The followings are the available columns in table '{{shop_news}}':
 * @property integer $id
 * @property string $sn_date
 * @property string $sn_date_begin
 * @property string $sn_date_end
 * @property string $sn_shop_id
 * @property string $sn_desc
 * @property string $sn_func
 * @property integer $sn_state
 *
 * The followings are the available model relations:
 * @property WashShop $snShop
 */
class ShopNews extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sn_date, sn_date_begin, sn_date_end, sn_shop_id, sn_desc', 'required'),
			array('sn_state', 'numerical', 'integerOnly'=>true),
			array('sn_shop_id', 'length', 'max'=>10),
			array('sn_desc, sn_func', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sn_date, sn_date_begin, sn_date_end, sn_shop_id, sn_desc, sn_func, sn_state', 'safe', 'on'=>'search'),
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
			'snShop' => array(self::BELONGS_TO, 'WashShop', 'sn_shop_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sn_date' => 'Sn Date',
			'sn_date_begin' => 'Sn Date Begin',
			'sn_date_end' => 'Sn Date End',
			'sn_shop_id' => 'Sn Shop',
			'sn_desc' => 'Sn Desc',
			'sn_func' => 'Sn Func',
			'sn_state' => 'Sn State',
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
		$criteria->compare('sn_date',$this->sn_date,true);
		$criteria->compare('sn_date_begin',$this->sn_date_begin,true);
		$criteria->compare('sn_date_end',$this->sn_date_end,true);
		$criteria->compare('sn_shop_id',$this->sn_shop_id,true);
		$criteria->compare('sn_desc',$this->sn_desc,true);
		$criteria->compare('sn_func',$this->sn_func,true);
		$criteria->compare('sn_state',$this->sn_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopNews the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
