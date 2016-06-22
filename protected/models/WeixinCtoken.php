<?php

/**
 * This is the model class for table "{{weixin_ctoken}}".
 *
 * The followings are the available columns in table '{{weixin_ctoken}}':
 * @property string $id
 * @property string $wc_appId
 * @property string $wc_token
 * @property integer $wc_expire
 * @property integer $wc_add_timestamp
 */
class WeixinCtoken extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{weixin_ctoken}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wc_app_name', 'required'),
			array('wc_expire, wc_add_timestamp', 'numerical', 'integerOnly'=>true),
			array('wc_appId, wc_token', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wc_appId, wc_token, wc_expire, wc_add_timestamp', 'safe', 'on'=>'search'),
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
			'wc_appId' => 'Wc App',
			'wc_token' => 'Wc Token',
			'wc_expire' => 'Wc Expire',
			'wc_add_timestamp' => 'Wc Add Timestamp',
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
		$criteria->compare('wc_appId',$this->wc_appId,true);
		$criteria->compare('wc_token',$this->wc_token,true);
		$criteria->compare('wc_expire',$this->wc_expire);
		$criteria->compare('wc_add_timestamp',$this->wc_add_timestamp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WeixinCtoken the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
