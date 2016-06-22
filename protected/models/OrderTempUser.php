<?php

/**
 * This is the model class for table "{{order_temp_user}}".
 *
 * The followings are the available columns in table '{{order_temp_user}}':
 * @property integer $id
 * @property string $otu_ot_id
 * @property string $otu_user_id
 *
 * The followings are the available model relations:
 * @property OrderTemp $otuOt
 * @property User $otuUser
 */
class OrderTempUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_temp_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('otu_ot_id, otu_user_id', 'required'),
			array('otu_ot_id, otu_user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, otu_ot_id, otu_user_id', 'safe', 'on'=>'search'),
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
			'otuOt' => array(self::BELONGS_TO, 'OrderTemp', 'otu_ot_id'),
			'otuUser' => array(self::BELONGS_TO, 'User', 'otu_user_id'),
			'otuStaff'=> array(self::BELONGS_TO, 'Staff', '','on'=>'t.otu_user_id = otuStaff.s_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'otu_ot_id' => 'Otu Ot',
			'otu_user_id' => 'Otu User',
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
		$criteria->compare('otu_ot_id',$this->otu_ot_id,true);
		$criteria->compare('otu_user_id',$this->otu_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderTempUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
