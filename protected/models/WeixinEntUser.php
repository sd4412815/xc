<?php

/**
 * This is the model class for table "{{weixin_ent_user}}".
 *
 * The followings are the available columns in table '{{weixin_ent_user}}':
 * @property string $id
 * @property string $weu_ent_id
 * @property integer $weu_shop_id
 * @property integer $weu_user_id
 * @property string $weu_open_id
 * @property string $weu_weixin_id
 * @property integer $weu_state
 * @property integer $weu_invite_date
 * @property integer $weu_update_time
 * @property string $weu_union_id
 * @property integer $wen_src
 * @property string $weu_tel
 */
class WeixinEntUser extends CActiveRecord
{
	const USER_STATUS_SUBSCRIBED = 1;
	const USER_STATUS_LOCKED = 2;
	const USER_STATUS_UN_SUBSCRIBED = 4;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{weixin_ent_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('weu_ent_id', 'required'),
			array('weu_shop_id, weu_user_id, weu_state, weu_invite_date, weu_update_time, wen_src', 'numerical', 'integerOnly'=>true),
			array('weu_ent_id', 'length', 'max'=>10),
			array('weu_open_id', 'length', 'max'=>50),
			array('weu_weixin_id, weu_union_id', 'length', 'max'=>100),
			array('weu_tel', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, weu_ent_id, weu_shop_id, weu_user_id, weu_open_id, weu_weixin_id, weu_state, weu_invite_date, weu_update_time, weu_union_id, wen_src, weu_tel', 'safe', 'on'=>'search'),
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
			'weu_ent_id' => 'Weu Ent',
			'weu_shop_id' => 'Weu Shop',
			'weu_user_id' => 'Weu User',
			'weu_open_id' => 'Weu Open',
			'weu_weixin_id' => 'Weu Weixin',
			'weu_state' => 'Weu State',
			'weu_invite_date' => 'Weu Invite Date',
			'weu_update_time' => 'Weu Update Time',
			'weu_union_id' => 'Weu Union',
			'wen_src' => 'Wen Src',
			'weu_tel' => 'Weu Tel',
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
		$criteria->compare('weu_ent_id',$this->weu_ent_id,true);
		$criteria->compare('weu_shop_id',$this->weu_shop_id);
		$criteria->compare('weu_user_id',$this->weu_user_id);
		$criteria->compare('weu_open_id',$this->weu_open_id,true);
		$criteria->compare('weu_weixin_id',$this->weu_weixin_id,true);
		$criteria->compare('weu_state',$this->weu_state);
		$criteria->compare('weu_invite_date',$this->weu_invite_date);
		$criteria->compare('weu_update_time',$this->weu_update_time);
		$criteria->compare('weu_union_id',$this->weu_union_id,true);
		$criteria->compare('wen_src',$this->wen_src);
		$criteria->compare('weu_tel',$this->weu_tel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WeixinEntUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
