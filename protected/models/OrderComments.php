<?php

/**
 * This is the model class for table "{{order_comments}}".
 *
 * The followings are the available columns in table '{{order_comments}}':
 * @property string $id
 * @property string $oc_order_id
 * @property string $oc_washshop_id
 * @property string $oc_comment_user_id
 * @property integer $oc_comment_user_type
 * @property string $oc_datetime
 *
 * The followings are the available model relations:
 * @property OrderHistory $ocOrder
 * @property WashShop $ocWashshop
 */
class OrderComments extends CActiveRecord {
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{order_comments}}';
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
						'oc_order_id, oc_washshop_id, oc_comment_user_id, oc_comment_user_type, oc_datetime',
						'required' 
				),
				array (
						'oc_comment_user_type',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'oc_order_id, oc_washshop_id, oc_comment_user_id',
						'length',
						'max' => 10 
				),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array (
						'id, oc_order_id, oc_washshop_id, oc_comment_user_id, oc_comment_user_type, oc_datetime',
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
		return array (
				'Order' => array (
						self::BELONGS_TO,
						'OrderHistory',
						'oc_order_id' 
				),
				'Washshop' => array (
						self::BELONGS_TO,
						'WashShop',
						'oc_washshop_id' 
				),
				'User' => array (
						self::BELONGS_TO,
						'User',
						'oc_comment_user_id' 
				) 
		// 'RelatedComment'=>array(self::BELONGS_TO,'OrderComments','oc_related_id'),
				);
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'oc_order_id' => 'Oc Order',
				'oc_washshop_id' => 'Oc Washshop',
				'oc_comment_user_id' => 'Oc Comment User',
				'oc_comment_user_type' => 'Oc Comment User Type',
				'oc_datetime' => 'Oc Datetime' 
		);
	}
	
	/**
	 * 返回车行评论列表
	 * 刘长鑫
	 * 20150410
	 * @param int $shopId
	 * @param int $pageIndex
	 * @param int $pageSize
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getShopCommentList($shopId, $pageIndex=0, $pageSize=8){
	
	    $rlt = UTool::iniFuncRlt();
// 	    $criteria = new CDbCriteria ();
// 	   $criteria->order = 'oc_datetime DESC, oc_order_id DESC';
// 	    $criteria->addCondition ( 'fs_user_id=:user_id' );
// 	    $criteria->params [':user_id'] = $userId;
	
// 	    $dataProvider = new CActiveDataProvider ( $this, array (
// 	        'pagination' => array (
// 	            'pageSize' => $pageSize,
// 	            'currentPage'=>$pageIndex,
// 	        ),
// 	        'criteria' => $criteria
// 	    ) );
// 	    $rlt['status']=true;
// 	    $rlt['msg']='查询成功';
// 	    $rlt['data']=$dataProvider;
// 	    return $rlt;
	    
	    
// 	    $model = new OrderComments ();
	    	
	    $criteria = new CDbCriteria ();
	    $criteria->order = 'oc_datetime DESC, oc_order_id DESC';
	    	
	    
	    $criteria->addCondition ( 'oc_washshop_id = :shopId' );
	    $criteria->params [':shopId'] = $shopId;
	    $criteria->addCondition ( 'oc_comment_user_type = 1' );
	    
	    
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
	    	
// 	    $dataProvider = new CActiveDataProvider ( 'OrderComments', array (
// 	        'pagination' => array (
// 	            'pageSize' => Yii::app()->params['pageSize'] ,
// 	            'route'=>'order/GetCommentList',
// 	        ),
// 	        'criteria' => $criteria
// 	    ) );
	
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
		
		$criteria->compare ( 'id', $this->id, true );
		$criteria->compare ( 'oc_order_id', $this->oc_order_id, true );
		$criteria->compare ( 'oc_washshop_id', $this->oc_washshop_id, true );
		$criteria->compare ( 'oc_comment_user_id', $this->oc_comment_user_id, true );
		$criteria->compare ( 'oc_comment_user_type', $this->oc_comment_user_type );
		$criteria->compare ( 'oc_datetime', $this->oc_datetime, true );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	
	/**
	 * 增加订单评论
	 * 
	 * @param int $orderId
	 *        	订单id
	 * @param int $userId
	 *        	评论人id
	 * @param int $shopId
	 *        	车行id
	 * @param int $userType
	 *        	评论人类型 1用户 2员工 3 老板
	 * @return array
	 */
	public function getAddComment($orderId, $userId, $shopId, $userType) {
		$rlt = UTool::iniFuncRlt ();
		$comment = new OrderComments ();
		$comment ['oc_order_id'] = $orderId;
		$comment ['oc_washshop_id'] = $shopId;
		$comment ['oc_comment_user_id'] = $userId;
		$comment ['oc_comment_user_type'] = $userType;
		$comment ['oc_datetime'] = date ( 'Y-m-d H:i:s' );
		if ($comment->save ()) {
			$rlt ['status'] = true;
		} else {
			$rlt ['msg'] = '00020';
			Yii::log ( '增加订单评论失败' . CJSON::encode ( $comment ), 'error', 'orders.comment.add' );
		}
		
		return $rlt;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return OrderComments the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
