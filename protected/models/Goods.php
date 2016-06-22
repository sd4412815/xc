<?php

/**
 * This is the model class for table "{{goods}}".
 *
 * The followings are the available columns in table '{{goods}}':
 * @property string $id
 * @property string $g_name
 * @property string $g_desc
 * @property string $g_content
 * @property string $g_join_date
 * @property string $g_start_date
 * @property string $g_end_date
 * @property string $g_func_content
 * @property integer $g_func_type
 * @property double $g_price
 * @property string $g_owner_id
 * @property integer $g_state
 * @property integer $g_type
 */
class Goods extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('g_name, g_content, g_join_date, g_start_date, g_end_date, g_func_content, g_owner_id', 'required'),
			array('g_func_type, g_state, g_type', 'numerical', 'integerOnly'=>true),
			array('g_price', 'numerical'),
			array('g_name, g_desc, g_func_content', 'length', 'max'=>255),
			array('g_owner_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, g_name, g_desc, g_content, g_join_date, g_start_date, g_end_date, g_func_content, g_func_type, g_price, g_owner_id, g_state, g_type', 'safe', 'on'=>'search'),
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
			'g_name' => 'G Name',
			'g_desc' => 'G Desc',
			'g_content' => 'G Content',
			'g_join_date' => 'G Join Date',
			'g_start_date' => 'G Start Date',
			'g_end_date' => 'G End Date',
			'g_func_content' => 'G Func Content',
			'g_func_type' => 'G Func Type',
			'g_price' => 'G Price',
			'g_owner_id' => 'G Owner',
			'g_state' => 'G State',
			'g_type' => 'G Type',
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
		$criteria->compare('g_name',$this->g_name,true);
		$criteria->compare('g_desc',$this->g_desc,true);
		$criteria->compare('g_content',$this->g_content,true);
		$criteria->compare('g_join_date',$this->g_join_date,true);
		$criteria->compare('g_start_date',$this->g_start_date,true);
		$criteria->compare('g_end_date',$this->g_end_date,true);
		$criteria->compare('g_func_content',$this->g_func_content,true);
		$criteria->compare('g_func_type',$this->g_func_type);
		$criteria->compare('g_price',$this->g_price);
		$criteria->compare('g_owner_id',$this->g_owner_id,true);
		$criteria->compare('g_state',$this->g_state);
		$criteria->compare('g_type',$this->g_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
