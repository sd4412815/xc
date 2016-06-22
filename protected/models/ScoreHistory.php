<?php

/**
 * This is the model class for table "{{Score_History}}".
 *
 * The followings are the available columns in table '{{Score_History}}':
 * @property integer $id
 * @property string $sh_date_time
 * @property integer $sh_score
 * @property string $sh_order_history_id
 * @property string $sh_user_id
 *
 * The followings are the available model relations:
 * @property User $shUser
 */
class ScoreHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Score_History}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sh_date_time, sh_score, sh_user_id', 'required'),
			array('sh_score', 'numerical', 'integerOnly'=>true),
			array('sh_order_history_id, sh_user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sh_date_time, sh_score, sh_order_history_id, sh_user_id', 'safe', 'on'=>'search'),
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
			'shUser' => array(self::BELONGS_TO, 'User', 'sh_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sh_date_time' => 'Sh Date Time',
			'sh_score' => 'Sh Score',
			'sh_order_history_id' => 'Sh Order History',
			'sh_user_id' => 'Sh User',
		);
	}
	
	
	/**
	 * 返回用户积分列表
	 * 刘长鑫
	 * 20150327
	 * @param int $userId
	 * @param int $pageIndex
	 * @param int $pageSize
	 * @param string $startTime
	 * @param string $endTime
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getUserScoreList($userId, $pageIndex=0, $pageSize=8, $startTime=NULL,$endTime=NULL){
	
	    $rlt = UTool::iniFuncRlt();
	    $criteria = new CDbCriteria ();
	    $criteria->order = 'sh_date_time DESC';
	    $criteria->addCondition ( 'sh_user_id=:user_id' );
	    $criteria->params [':user_id'] = $userId;
	
	    if (isset($startTime)){
	        $criteria->addCondition ( 'sh_date_time>=:start' );
	        $criteria->params [':start'] = date('Y-m-d H:i:s', strtotime( $startTime));
	    }
	    if (isset  ( $endTime )) {
	        $criteria->addCondition ( 'sh_date_time<=:end' );
	        $criteria->params [':end'] = date('Y-m-d H:i:s', strtotime( $endTime));
	    }
	
	    $dataProvider = new CActiveDataProvider ( $this, array (
	        'pagination' => array (
	            'pageSize' => $pageSize,
	            'currentPage'=>$pageIndex,
	        ),
	        'criteria' => $criteria
	    ) );
	    $rlt['status']=true;
	    $rlt['msg']='查询成功';
	    $rlt['data']=$dataProvider;
	    return $rlt;
	
	}

	/**
	 * 根据时间获取所有车行用户订单
	 * @param int $shopId
	 * @param string $beginTime
	 * @param string $endTime
	 * @param int $userId
	 * @return array
	 */
	public function getScoresByUserId($userId, $beginTime, $endTime){
		// 构造时间
		$rlt = UTool::iniFuncRlt ();
		$begin = date_parse ( $beginTime );
		$end = date_parse ( $endTime );
		if ($begin ['error_count'] > 0 || $end ['error_count'] > 0) {
			$rlt ['msg'] = '00008';
			return $rlt;
		}
	
		// 		用户订单数
		$criteria = new CDbCriteria ();
		// 		$criteria->select = 'sum(oh_value) as totalValue,
		// 		count(oh_user_id) as totalCount,
		// 		sum(oh_service_num) as totalServiceNum';
		$criteria->order = 'sh_date_time  DESC';
		$criteria->addCondition ( 'sh_user_id=:user_id' );
	
		
	
		$criteria->addCondition ( 'sh_date_time >= :order_date_time_begin', 'AND' );
		$criteria->addCondition ( 'sh_date_time < :order_date_time_end', 'AND' );
		$criteria->params [':user_id'] = $userId;
		$criteria->params [':order_date_time_begin'] = date ( 'Y-m-d H:i:s', strtotime ( $beginTime ) );
		$criteria->params [':order_date_time_end'] = date ( 'Y-m-d H:i:s', strtotime ( $endTime ) );
	

		$scores = $this->findAll ( $criteria );
		
	
		$rlt['status']=true;
		$rlt['data']=$scores;
		// 		Yii::log($beginTime,'error','orders.user.select');
		// 		Yii::log($endTime,'error','orders.user.select');
		return $rlt;
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
		$criteria->compare('sh_date_time',$this->sh_date_time,true);
		$criteria->compare('sh_score',$this->sh_score);
		$criteria->compare('sh_order_history_id',$this->sh_order_history_id,true);
		$criteria->compare('sh_user_id',$this->sh_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScoreHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
