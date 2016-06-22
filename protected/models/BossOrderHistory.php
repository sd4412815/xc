<?php

/**
 * This is the model class for table "{{Boss_Order_History}}".
 *
 * The followings are the available columns in table '{{Boss_Order_History}}':
 * @property string $id
 * @property string $boh_no
 * @property string $boh_wash_shop_id
 * @property string $boh_order_date_time
 * @property string $boh_date_time
 * @property integer $boh_state
 * @property string $boh_boss_id
 *
 * The followings are the available model relations:
 * @property Boss $bohBoss
 * @property WashShop $bohWashShop
 */
class BossOrderHistory extends CActiveRecord
{
	// 老板订单数
	public $totalCountBoss;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Boss_Order_History}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('boh_no, boh_wash_shop_id, boh_order_date_time, boh_date_time, boh_boss_id', 'required'),
			array('boh_state', 'numerical', 'integerOnly'=>true),
			array('boh_no', 'length', 'max'=>20),
			array('boh_wash_shop_id, boh_boss_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, boh_no, boh_wash_shop_id, boh_order_date_time, boh_date_time, boh_state, boh_boss_id', 'safe', 'on'=>'search'),
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
			'bohBoss' => array(self::BELONGS_TO, 'Boss', 'boh_boss_id'),
			'bohWashShop' => array(self::BELONGS_TO, 'WashShop', 'boh_wash_shop_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'boh_no' => 'Boh No',
			'boh_wash_shop_id' => 'Boh Wash Shop',
			'boh_order_date_time' => 'Boh Order Date Time',
			'boh_date_time' => 'Boh Date Time',
			'boh_state' => 'Boh State',
			'boh_boss_id' => 'Boh Boss',
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
		$criteria->compare('boh_no',$this->boh_no,true);
		$criteria->compare('boh_wash_shop_id',$this->boh_wash_shop_id,true);
		$criteria->compare('boh_order_date_time',$this->boh_order_date_time,true);
		$criteria->compare('boh_date_time',$this->boh_date_time,true);
		$criteria->compare('boh_state',$this->boh_state);
		$criteria->compare('boh_boss_id',$this->boh_boss_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

// 	protected function beforeSave(){
// 				if (parent::beforeSave()){
// 					$orderCount = $this->countByAttributes(array(
// 							'boh_no'=>$this->boh_no,
// 					));
// 					if ($orderCount >0) {
// 						return false;
// 					}
// 				}
// 				else {
// 					true;
// 				}
	
	
	
	
	
// 	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BossOrderHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
