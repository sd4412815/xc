<?php

/**
 * This is the model class for table "{{shop_pay}}".
 *
 * The followings are the available columns in table '{{shop_pay}}':
 * @property integer $id
 * @property integer $sp_type
 * @property string $sp_datetime
 * @property integer $sp_value
 * @property integer $sp_user_id
 * @property integer $sp_state
 * @property string $sp_remark
 * @property string $sp_shop_id
 * @property string $sp_datetime_update
 * @property integer $sp_date_long
 *
 * The followings are the available model relations:
 * @property WashShop $spShop
 */
class ShopPay extends CActiveRecord
{
	/**
	 * 体验版
	 */
	const SERVICE_LEVEL_FREE=0;
	
	/**
	 * 白银级
	 */
	const SERVICE_LEVEL_SILVER=1;
	
	/**
	 * 黄金级
	 */
	const SERVICE_LEVEL_GOLDER=2;
	
	/**
	 * 钻石级
	 */
	const SERVICE_LEVEL_DIAMOND=3;

	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_pay}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sp_type, sp_datetime, sp_value, sp_user_id, sp_state, sp_shop_id', 'required'),
			array('sp_type, sp_value, sp_user_id, sp_state, sp_date_long', 'numerical', 'integerOnly'=>true),
			array('sp_remark', 'length', 'max'=>100),
			array('sp_shop_id', 'length', 'max'=>10),
			array('sp_datetime_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sp_type, sp_datetime, sp_value, sp_user_id, sp_state, sp_remark, sp_shop_id, sp_datetime_update, sp_date_long', 'safe', 'on'=>'search'),
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
			'spShop' => array(self::BELONGS_TO, 'WashShop', 'sp_shop_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sp_type' => 'Sp Type',
			'sp_datetime' => 'Sp Datetime',
			'sp_value' => 'Sp Value',
			'sp_user_id' => 'Sp User',
			'sp_state' => 'Sp State',
			'sp_remark' => 'Sp Remark',
			'sp_shop_id' => 'Sp Shop',
			'sp_datetime_update' => 'Sp Datetime Update',
			'sp_date_long' => 'Sp Date Long',
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
		$criteria->compare('sp_type',$this->sp_type);
		$criteria->compare('sp_datetime',$this->sp_datetime,true);
		$criteria->compare('sp_value',$this->sp_value);
		$criteria->compare('sp_user_id',$this->sp_user_id);
		$criteria->compare('sp_state',$this->sp_state);
		$criteria->compare('sp_remark',$this->sp_remark,true);
		$criteria->compare('sp_shop_id',$this->sp_shop_id,true);
		$criteria->compare('sp_datetime_update',$this->sp_datetime_update,true);
		$criteria->compare('sp_date_long',$this->sp_date_long);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopPay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
