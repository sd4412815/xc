<?php

/**
 * This is the model class for table "{{Shop_Member}}".
 *
 * The followings are the available columns in table '{{Shop_Member}}':
 * @property string $id
 * @property string $sm_user_id
 * @property string $sm_shop_id
 * @property string $sm_join_time
 * @property integer $sm_src
 *
 * The followings are the available model relations:
 * @property WashShop $smShop
 * @property User $smUser
 */
class ShopMember extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Shop_Member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sm_user_id, sm_shop_id, sm_join_time', 'required'),
			array('sm_src', 'numerical', 'integerOnly'=>true),
			array('sm_user_id, sm_shop_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sm_user_id, sm_shop_id, sm_join_time, sm_src', 'safe', 'on'=>'search'),
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
			'smShop' => array(self::BELONGS_TO, 'WashShop', 'sm_shop_id'),
			'smUser' => array(self::BELONGS_TO, 'User', 'sm_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sm_user_id' => 'Sm User',
			'sm_shop_id' => 'Sm Shop',
			'sm_join_time' => 'Sm Join Time',
			'sm_src' => 'Sm Ref',
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
		$criteria->compare('sm_user_id',$this->sm_user_id,true);
		$criteria->compare('sm_shop_id',$this->sm_shop_id,true);
		$criteria->compare('sm_join_time',$this->sm_join_time,true);
		$criteria->compare('sm_src',$this->sm_src);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
