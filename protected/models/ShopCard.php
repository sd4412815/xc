<?php

/**
 * This is the model class for table "{{shop_card}}".
 *
 * The followings are the available columns in table '{{shop_card}}':
 * @property integer $id
 * @property string $sc_sn
 * @property string $sc_pwd
 * @property integer $sc_state
 * @property string $sc_date_active
 * @property string $sc_date_gen
 * @property integer $sc_price
 * @property integer $sc_shop_id
 * @property integer $sc_value
 * @property string $sc_date_end
 * @property integer $sc_type
 */
class ShopCard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_card}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sc_sn, sc_pwd, sc_state, sc_price, sc_type', 'required'),
			array('sc_state, sc_price, sc_shop_id, sc_value, sc_type', 'numerical', 'integerOnly'=>true),
			array('sc_sn', 'length', 'max'=>25),
			array('sc_pwd', 'length', 'max'=>16),
			array('sc_date_gen, sc_date_end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sc_sn, sc_pwd, sc_state, sc_date_active, sc_date_gen, sc_price, sc_shop_id, sc_value, sc_date_end, sc_type', 'safe', 'on'=>'search'),
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
			'sc_sn' => 'Sc Sn',
			'sc_pwd' => 'Sc Pwd',
			'sc_state' => 'Sc State',
			'sc_date_active' => 'Sc Date Active',
			'sc_date_gen' => 'Sc Date Gen',
			'sc_price' => 'Sc Price',
			'sc_shop_id' => 'Sc Shop',
			'sc_value' => 'Sc Value',
			'sc_date_end' => 'Sc Date End',
			'sc_type' => 'Sc Type',
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
		$criteria->compare('sc_sn',$this->sc_sn,true);
		$criteria->compare('sc_pwd',$this->sc_pwd,true);
		$criteria->compare('sc_state',$this->sc_state);
		$criteria->compare('sc_date_active',$this->sc_date_active,true);
		$criteria->compare('sc_date_gen',$this->sc_date_gen,true);
		$criteria->compare('sc_price',$this->sc_price);
		$criteria->compare('sc_shop_id',$this->sc_shop_id);
		$criteria->compare('sc_value',$this->sc_value);
		$criteria->compare('sc_date_end',$this->sc_date_end,true);
		$criteria->compare('sc_type',$this->sc_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
