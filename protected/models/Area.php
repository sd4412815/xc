<?php

/**
 * This is the model class for table "{{Area}}".
 *
 * The followings are the available columns in table '{{Area}}':
 * @property integer $id
 * @property integer $a_no
 * @property string $a_name
 * @property string $a_spell
 * @property integer $a_city_id
 */
class Area extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Area}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('a_name, a_spell, a_city_id', 'required'),
			array('a_no, a_city_id', 'numerical', 'integerOnly'=>true),
			array('a_name', 'length', 'max'=>20),
			array('a_spell', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, a_no, a_name, a_spell, a_city_id', 'safe', 'on'=>'search'),
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
				'city' => array (
						self::BELONGS_TO,
						'City',
						'a_city_id'
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
			'a_no' => 'A No',
			'a_name' => '城区名称',
			'a_spell' => '汉语拼音',
			'a_city_id' => 'A City id',
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
		$criteria->compare('a_no',$this->a_no);
		$criteria->compare('a_name',$this->a_name,true);
		$criteria->compare('a_spell',$this->a_spell,true);
		$criteria->compare('a_city_id',$this->a_city_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	/**
	 * 新插入城区时自动计算城区编号
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$lastItem =  $this->findAll(array(
						'condition'=>'a_city_id='.$this->a_city_id,
						'order'=>'a_no DESC',
						'limit'=>1,
				));
	
				if (!empty($lastItem))
	
					$this->a_no = $lastItem[0]['a_no']+1;
				else
					$this->a_no = 1;
			}
				
			return true;
		}
		else
			return false;
	}
	
	/**
	 * 根据城区名称检索城区信息
	 *
	 * @param string $areaName
	 * @return array
	 */
	public function getAreaInfo($areaName) {
		$rlt = UTool::iniFuncRlt ();
		$area = $this->find ( array (
				'condition' => 'a_name LIKE :areaName',
				'params' => array (
						':areaName' => "$areaName%"
				)
		) );
		if (! isset ( $area )) {
			$rlt ['msg'] = '00015';
			return $rlt;
		}
		$rlt ['data'] = $area;
		$rlt ['status'] = true;
		return $rlt;
	}
	
	/**
	 * 根据城区名称检索城区信息
	 * @param int $cityId
	 * @return string
	 */
	public function getAreaInfoById($cityId){
		$rlt=UTool::iniFuncRlt();
		$area=$this->findByPk($cityId);
		if (! isset ( $area )) {
			$rlt ['msg'] = '00015';
			return $rlt;
		}
		$rlt ['data'] = $area;
		$rlt ['status'] = true;
		return $rlt;
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Area the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
