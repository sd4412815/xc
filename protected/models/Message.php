<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property string $m_datetime
 * @property string $m_user_id
 * @property integer $m_status
 * @property integer $m_level
 * @property string $m_content
 * @property integer $m_type
 * @property integer $m_src_user_id
 *
 * The followings are the available model relations:
 * @property User $mUser
 */
class Message extends CActiveRecord
{
    const LEVEL_NORM = 0;
    const LEVEL_PRIORITY =1;
    const LEVEL_URGENCY=2;
    const LEVEL_HIGHTEST=3;
    
    const TYPE_SHOP=-2;
    const TYPE_LOGIN= -1;
    const TYPE_ACCOUNT=0;
    const  TYPE_ORDER=1;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('m_datetime, m_user_id, m_type', 'required'),
			array('m_status, m_level, m_type, m_src_user_id', 'numerical', 'integerOnly'=>true),
			array('m_user_id', 'length', 'max'=>10),
			array('m_content', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, m_datetime, m_user_id, m_status, m_level, m_content, m_type, m_src_user_id', 'safe', 'on'=>'search'),
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
			'mUser' => array(self::BELONGS_TO, 'User', 'm_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'm_datetime' => 'M Datetime',
			'm_user_id' => 'M User',
			'm_status' => 'M Status',
			'm_level' => 'M Level',
			'm_content' => 'M Content',
			'm_type' => 'M Type',
			'm_src_user_id' => 'M Src User',
		);
	}
	
	/**
	 * 根据用户id获取未读数量
	 * @param int $user_id 用户id
	 * @return number|Ambigous <string, mixed, unknown>
	 */
	public function getUnReadCount($user_id){
		if (!is_int((int)$user_id) || $user_id<0) {
			return -1;
		}
	   $criteria = new CDbCriteria();
	   $criteria->addCondition('m_user_id=:uid');
	   $criteria->params[':uid']=$user_id;
	   
	   $criteria->addCondition('m_status=0');
	   $criteria->addCondition('m_type>=0');
		return $this->count($criteria);
	}
	
	/**
	 * 根据用户id获取最新未读消息
	 * @param int $userId 用户id
	 * @param int $num 通知数量
	 * @return NULL|Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public function getLateastMessage($userId, $num, $types=NULL){
		if (!is_int((int)$userId) || !is_int((int)$num) || $userId<=0 || $num<=0) {
			return array();
		}
		$criteria = new  CDbCriteria();
		$criteria->addCondition('m_user_id=:userId');
		$criteria->params[':userId']=$userId;
		$criteria->addCondition('m_status=0');
		if (empty($types)){
		    $criteria->addCondition('m_type>=0');
		}else{
		    $criteria->addInCondition('m_type',$types);
		}
		
		
		$criteria->order = 'm_datetime DESC';
		
		return $this->findAll($criteria);
		
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
		$criteria->compare('m_datetime',$this->m_datetime,true);
		$criteria->compare('m_user_id',$this->m_user_id,true);
		$criteria->compare('m_status',$this->m_status);
		$criteria->compare('m_level',$this->m_level);
		$criteria->compare('m_content',$this->m_content,true);
		$criteria->compare('m_type',$this->m_type);
		$criteria->compare('m_src_user_id',$this->m_src_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function addOrderInfoForBoss(){
		
	}
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
