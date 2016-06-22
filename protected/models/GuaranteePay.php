<?php

/**
 * This is the model class for table "{{guarantee_pay}}".
 *
 * The followings are the available columns in table '{{guarantee_pay}}':
 * @property integer $id
 * @property integer $gp_value
 * @property string $gp_date
 * @property string $gp_ip
 * @property string $gp_mac
 * @property string $gp_user_id
 * @property string $gp_shop_id
 * @property string $gp_remark
 * @property integer $gp_state
 *
 * The followings are the available model relations:
 * @property WashShop $gpShop
 * @property User $gpUser
 */
class GuaranteePay extends CActiveRecord
{
	public $gValueRequest;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{guarantee_pay}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gp_date, gp_ip, gp_mac, gp_user_id, gp_shop_id, gp_state', 'required'),
			array('gp_value, gp_state', 'numerical', 'integerOnly'=>true),
			array('gp_ip, gp_mac', 'length', 'max'=>20),
			array('gp_user_id, gp_shop_id', 'length', 'max'=>10),
			array('gp_remark', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gp_value, gp_date, gp_ip, gp_mac, gp_user_id, gp_shop_id, gp_remark, gp_state', 'safe', 'on'=>'search'),
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
			'gpShop' => array(self::BELONGS_TO, 'WashShop', 'gp_shop_id'),
			'gpUser' => array(self::BELONGS_TO, 'User', 'gp_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'gp_value' => 'Gp Value',
			'gp_date' => 'Gp Date',
			'gp_ip' => 'Gp Ip',
			'gp_mac' => 'Gp Mac',
			'gp_user_id' => 'Gp User',
			'gp_shop_id' => 'Gp Shop',
			'gp_remark' => 'Gp Remark',
			'gp_state' => 'Gp State',
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
		$criteria->compare('gp_value',$this->gp_value);
		$criteria->compare('gp_date',$this->gp_date,true);
		$criteria->compare('gp_ip',$this->gp_ip,true);
		$criteria->compare('gp_mac',$this->gp_mac,true);
		$criteria->compare('gp_user_id',$this->gp_user_id,true);
		$criteria->compare('gp_shop_id',$this->gp_shop_id,true);
		$criteria->compare('gp_remark',$this->gp_remark,true);
		$criteria->compare('gp_state',$this->gp_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GuaranteePay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
