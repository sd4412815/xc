<?php

/**
 * This is the model class for table "{{hui}}".
 *
 * The followings are the available columns in table '{{hui}}':
 * @property string $id
 * @property string $h_name
 * @property string $h_desc
 * @property string $h_content
 * @property string $h_start_date
 * @property string $h_end_date
 * @property string $h_func_content
 * @property integer $h_func_type
 * @property double $h_price
 * @property string $h_join_date
 * @property integer $h_state
 * @property integer $h_create_user
 * @property integer $h_type
 */
class Hui extends CActiveRecord
{
	/**
	 * 内部语句
	 */
	const HUI_FUNC_TYPE_INNER_TEXT = 1;
	/**
	 * 外部文件
	 */
	const HUI_FUNC_TYPE_OUT_FILE = 2;
	
	
	/*
	 * 删除
	 */
	const  HUI_STATE_DELETE=-20;
	/*
	 * 过期
	 */
	const  HUI_STATE_EXPIRED=-1;
	const HUI_STATE_REG=0;
	const HUI_STATE_PROVE=1;
	const HUI_STATE_READY=2;
	const  HUI_STATE_ACTIVE=3;
	const  HUI_STATE_ONLINE=4;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hui}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('h_name, h_content, h_start_date, h_end_date, h_func_content, h_join_date, h_create_user', 'required'),
			array('h_func_type, h_state, h_create_user, h_type', 'numerical', 'integerOnly'=>true),
			array('h_price', 'numerical'),
			array('h_name, h_desc, h_func_content', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, h_name, h_desc, h_content, h_start_date, h_end_date, h_func_content, h_func_type, h_price, h_join_date, h_state, h_create_user, h_type', 'safe', 'on'=>'search'),
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
	
	public function getHuiList($cityId, $typeArray=array(Hui::HUI_STATE_ONLINE),$limit=8) {
		$criteria = new CDbCriteria ();
		
// 		$criteria->addInCondition('id', )
		$city = City::model()->findByPk($cityId);
		if ($city == NULL){
			return NULL;
		}
		$huiList = $city['c_shop_activities'];
		
		
		
		$criteria->addInCondition ( 'h_state', $typeArray );
		$criteria->order = 'h_end_date ASC';
		$criteria->limit = $limit;
		return Hui::model ()->findAll ( $criteria );
	}
	
	

	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'h_name' => 'H Name',
			'h_desc' => 'H Desc',
			'h_content' => 'H Content',
			'h_start_date' => 'H Start Date',
			'h_end_date' => 'H End Date',
			'h_func_content' => 'H Func Content',
			'h_func_type' => 'H Func Type',
			'h_price' => 'H Price',
			'h_join_date' => 'H Join Date',
			'h_state' => 'H State',
			'h_create_user' => 'H Create User',
			'h_type' => 'H Type',
		);
	}
	
	
	public function getTopHui($count=5,$state=0){
		$criteria = new CDbCriteria();
		$criteria->addCondition('h_state=:state');
		$criteria->params[':state']=$state;
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
		$criteria->compare('h_name',$this->h_name,true);
		$criteria->compare('h_desc',$this->h_desc,true);
		$criteria->compare('h_content',$this->h_content,true);
		$criteria->compare('h_start_date',$this->h_start_date,true);
		$criteria->compare('h_end_date',$this->h_end_date,true);
		$criteria->compare('h_func_content',$this->h_func_content,true);
		$criteria->compare('h_func_type',$this->h_func_type);
		$criteria->compare('h_price',$this->h_price);
		$criteria->compare('h_join_date',$this->h_join_date,true);
		$criteria->compare('h_state',$this->h_state);
		$criteria->compare('h_create_user',$this->h_create_user);
		$criteria->compare('h_type',$this->h_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hui the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
