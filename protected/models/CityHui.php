<?php

/**
 * This is the model class for table "{{city_hui}}".
 *
 * The followings are the available columns in table '{{city_hui}}':
 * @property string $id
 * @property integer $ch_city_id
 * @property integer $ch_hui_id
 * @property string $ch_start_date
 * @property string $ch_end_date
 * @property string $ch_join_date
 * @property integer $ch_state
 */
class CityHui extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{city_hui}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ch_city_id, ch_hui_id, ch_start_date, ch_end_date, ch_join_date', 'required'),
			array('ch_city_id, ch_hui_id, ch_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ch_city_id, ch_hui_id, ch_start_date, ch_end_date, ch_join_date, ch_state', 'safe', 'on'=>'search'),
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
				'hui' => array (
						self::BELONGS_TO,
						'Hui',
						'ch_hui_id' 
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ch_city_id' => 'Ch City',
			'ch_hui_id' => 'Ch Hui',
			'ch_start_date' => 'Ch Start Date',
			'ch_end_date' => 'Ch End Date',
			'ch_join_date' => 'Ch Join Date',
			'ch_state' => 'Ch State',
		);
	}
	public function getHuiList($cityId, $startDate = NULL, $endDate = NULL, $typeArray = array(Hui::HUI_STATE_ONLINE), $limit = 8) {
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( 'ch_city_id=:cid' );
		$criteria->params [':cid'] = $cityId;
		
		$criteria->addInCondition ( 'ch_state', $typeArray );
		
		if (isset ( $startDate )) {
			$criteria->addCondition ( 'ch_start_date>=:startDate' );
			$criteria->params [':startDate'] = date ( 'Y-m-d H:i:s', strtotime ( $startDate ) );
		}
		
		if (isset ( $endDate )) {
			$criteria->addCondition ( 'ch_end_date<=:endDate' );
			$criteria->params [':endDate'] = date ( 'Y-m-d H:i:s', strtotime ( $endDate ) );
		} else {
			$criteria->addCondition ( 'ch_end_date>=:endDate' );
			$criteria->params [':endDate'] = date ( 'Y-m-d H:i:s', time () );
		}
		
		$criteria->with = array (
				'hui' 
		);
		$criteria->order = 'ch_end_date ASC';
		$criteria->limit = $limit;
		return $this->findAll ( $criteria );
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
		$criteria->compare('ch_city_id',$this->ch_city_id);
		$criteria->compare('ch_hui_id',$this->ch_hui_id);
		$criteria->compare('ch_start_date',$this->ch_start_date,true);
		$criteria->compare('ch_end_date',$this->ch_end_date,true);
		$criteria->compare('ch_join_date',$this->ch_join_date,true);
		$criteria->compare('ch_state',$this->ch_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CityHui the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
