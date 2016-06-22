<?php

/**
 * This is the model class for table "{{shop_hui}}".
 *
 * The followings are the available columns in table '{{shop_hui}}':
 * @property string $id
 * @property string $sh_shop_id
 * @property string $sh_hui_id
 * @property integer $sh_state
 * @property string $sh_begin_date
 * @property string $sh_end_date
 * @property string $sh_join_date
 */
class ShopHui extends CActiveRecord
{
	/**
	 * 优惠自动生效
	 */
	const HUI_TYPE_AUTO = 0;
	
	/**
	 * 优惠需要手动选择
	 */
	const HUI_TYPE_ONLY = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_hui}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sh_shop_id, sh_hui_id, sh_begin_date, sh_end_date, sh_join_date', 'required'),
			array('sh_state', 'numerical', 'integerOnly'=>true),
			array('sh_shop_id, sh_hui_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sh_shop_id, sh_hui_id, sh_state, sh_begin_date, sh_end_date, sh_join_date', 'safe', 'on'=>'search'),
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
				'hui'=> array(self::BELONGS_TO, 'Hui', 'sh_hui_id'),
				'shop'=> array(self::BELONGS_TO, 'WashShop', 'sh_shop_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sh_shop_id' => 'Sh Shop',
			'sh_hui_id' => 'Sh Hui',
			'sh_state' => 'Sh State',
			'sh_begin_date' => 'Sh Begin Date',
			'sh_end_date' => 'Sh End Date',
			'sh_join_date' => 'Sh Join Date',
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
		$criteria->compare('sh_shop_id',$this->sh_shop_id,true);
		$criteria->compare('sh_hui_id',$this->sh_hui_id,true);
		$criteria->compare('sh_state',$this->sh_state);
		$criteria->compare('sh_begin_date',$this->sh_begin_date,true);
		$criteria->compare('sh_end_date',$this->sh_end_date,true);
		$criteria->compare('sh_join_date',$this->sh_join_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public function getShopListByHuiId($huiId, $typeArray= array(Hui::HUI_STATE_ONLINE),$endTime = NULL, $limit=null){
		$criteria = new CDbCriteria();
// 		$criteria->addInCondition('sh_', $values)
		$criteria->addCondition('sh_hui_id=:huiId');
		$criteria->params[':huiId']=$huiId;
// 		$criteria->addCondition('sh_state = :hui');
		$criteria->addInCondition('sh_state', $typeArray);
		
		if (!empty($endTime)){
			$criteria->addCondition('sh_end_date>:endDate');
			$criteria->params[':endDate']=$endTime;
		}
		
		return $this->findAll($criteria);
	
	
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopHui the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
