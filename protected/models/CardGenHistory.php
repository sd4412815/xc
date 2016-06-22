<?php

/**
 * This is the model class for table "{{card_gen_history}}".
 *
 * The followings are the available columns in table '{{card_gen_history}}':
 * @property integer $id
 * @property integer $cgh_type
 * @property integer $cgh_user_id
 * @property string $cgh_shop_id
 * @property string $cgh_date
 * @property integer $cgh_state
 * @property string $cgh_date_active
 * @property integer $cgh_count
 * @property double $cgh_guarantee
 * @property integer $cgh_value
 * @property string $cgh_date_state_update
 *
 * The followings are the available model relations:
 * @property WashShop $cghShop
 */
class CardGenHistory extends CActiveRecord
{
	public $totalGValue;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{card_gen_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cgh_type, cgh_user_id, cgh_shop_id, cgh_date, cgh_state,  cgh_count, cgh_guarantee, cgh_value, cgh_date_state_update', 'required'),
			array('cgh_type, cgh_user_id, cgh_state, cgh_count, cgh_value', 'numerical', 'integerOnly'=>true),
			array('cgh_guarantee', 'numerical'),
			array('cgh_shop_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cgh_type, cgh_user_id, cgh_shop_id, cgh_date, cgh_state, cgh_date_active, cgh_count, cgh_guarantee, cgh_value, cgh_date_state_update', 'safe', 'on'=>'search'),
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
			'cghShop' => array(self::BELONGS_TO, 'WashShop', 'cgh_shop_id'),
				'cghUser' => array(self::BELONGS_TO, 'User', 'cgh_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cgh_type' => 'Cgh Type',
			'cgh_user_id' => 'Cgh User',
			'cgh_shop_id' => 'Cgh Shop',
			'cgh_date' => 'Cgh Date',
			'cgh_state' => 'Cgh State',
			'cgh_date_active' => 'Cgh Date Active',
			'cgh_count' => 'Cgh Count',
			'cgh_guarantee' => 'Cgh Guarantee',
			'cgh_value' => 'Cgh Value',
			'cgh_date_state_update' => 'Cgh Date State Update',
		);
	}
	
	
	public function getGuarantee($shopId){
// 		$rlt = UTool::iniFuncRlt();
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(cgh_guarantee) as totalGValue';
		$criteria->addCondition('cgh_shop_id=:shopId');
		$criteria->params[':shopId']=$shopId;
		$totalGValue = CardGenHistory::model()->find($criteria);
		return $totalGValue->totalGValue;
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
		$criteria->compare('cgh_type',$this->cgh_type);
		$criteria->compare('cgh_user_id',$this->cgh_user_id);
		$criteria->compare('cgh_shop_id',$this->cgh_shop_id,true);
		$criteria->compare('cgh_date',$this->cgh_date,true);
		$criteria->compare('cgh_state',$this->cgh_state);
		$criteria->compare('cgh_date_active',$this->cgh_date_active,true);
		$criteria->compare('cgh_count',$this->cgh_count);
		$criteria->compare('cgh_guarantee',$this->cgh_guarantee);
		$criteria->compare('cgh_value',$this->cgh_value);
		$criteria->compare('cgh_date_state_update',$this->cgh_date_state_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CardGenHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
