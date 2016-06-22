<?php

/**
 * This is the model class for table "{{Province}}".
 *
 * The followings are the available columns in table '{{Province}}':
 * @property integer $id
 * @property integer $p_no
 * @property string $p_name
 * @property string $p_spell
 */
class Province extends CActiveRecord {
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{Province}}';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'p_no, p_name, p_spell',
						'required' 
				),
				array (
						'p_no',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'p_name',
						'length',
						'max' => 20 
				),
				array (
						'p_spell',
						'length',
						'max' => 100 
				),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'id, p_no, p_name, p_spell',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array ();
	}
	
	/**
	 * 根据省份名称检索省份信息
	 * 
	 * @param string $provinceName 
	 * @return array       	
	 */
	public function getProvinceInfo($provinceName) {
		$rlt = UTool::iniFuncRlt ();
		$province = $this->find ( array (
				'condition' => 'p_name LIKE :provinceName',
				'params' => array (
						':provinceName' => "$provinceName%" 
				) 
		) );
		if (! isset ( $province )) {
			$rlt ['msg'] = '00013';
			return $rlt;
		}
		$rlt ['data'] = $province;
		$rlt  = true;
		return $rlt;
	}
	
	/**
	 * 根据省份id检索省份信息
	 * @param int $provinceId
	 * @return string
	 */
	public function getProvinceInfoById($provinceId){
		$rlt=UTool::iniFuncRlt();
		$province = $this->findByPk($provinceId);
		if (! isset ( $province )) {
			$rlt ['msg'] = '00013';
			return $rlt;
		}
		$rlt ['data'] = $province;
		$rlt  = true;
		return $rlt;
	}
	
	/**
	 * 
	 * @param string $available 默认true
	 * @param string $orderByState 默认true
	 * @return multitype:static
	 */
	public function getProvinceList($available=TRUE,$orderByState=TRUE){
		$criteria = new CDbCriteria ();
		if ($available === TRUE){
			$criteria->addCondition ( 'p_state>=1' );
		}else {
			$criteria->addCondition ( 'p_state>=0' );
		}
		
		if ($orderByState){
			$criteria->order = 'p_state DESC, p_spell ASC';
		} else {
			$criteria->order = 'p_spell ASC';
		}
		$provinceListmodel = Province::model ()->findAll ( $criteria );
		return $provinceListmodel;
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'p_no' => 'P No',
				'p_name' => 'P Name',
				'p_spell' => 'P Spell' 
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
	 *         based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id );
		$criteria->compare ( 'p_no', $this->p_no );
		$criteria->compare ( 'p_name', $this->p_name, true );
		$criteria->compare ( 'p_spell', $this->p_spell, true );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className
	 *        	active record class name.
	 * @return Province the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
