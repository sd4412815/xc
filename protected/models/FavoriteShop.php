<?php

/**
 * This is the model class for table "{{favorite_shop}}".
 *
 * The followings are the available columns in table '{{favorite_shop}}':
 * @property integer $id
 * @property string $fs_shop_id
 * @property string $fs_user_id
 *
 * The followings are the available model relations:
 * @property WashShop $fsShop
 * @property User $fsUser
 */
class FavoriteShop extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{favorite_shop}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fs_shop_id, fs_user_id', 'required'),
			array('fs_shop_id, fs_user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fs_shop_id, fs_user_id', 'safe', 'on'=>'search'),
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
			'fsShop' => array(self::BELONGS_TO, 'WashShop', 'fs_shop_id'),
			'fsUser' => array(self::BELONGS_TO, 'User', 'fs_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fs_shop_id' => 'Fs Shop',
			'fs_user_id' => 'Fs User',
		);
	}
	

	/**
	 * 返回用户收藏列表
	 * 刘长鑫
	 * 20150328
	 * @param int $userId
	 * @param int $pageIndex
	 * @param int $pageSize
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getUserFavoriteList($userId, $pageIndex=0, $pageSize=8){
	
	    $rlt = UTool::iniFuncRlt();
	    $criteria = new CDbCriteria ();
	    $criteria->order = 'fs_datetime DESC';
	    $criteria->addCondition ( 'fs_user_id=:user_id' );
	    $criteria->params [':user_id'] = $userId;
	
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
	
	
	public function getUserFavoriteListWithDistance($currentLocation,$userId,$distanceLimit=10000){
		$criteria = new CDbCriteria();
		$criteria->addCondition('fs_user_id=:userId');
		$criteria->params[':userId']=$userId;
// 		$criteria->addCondition('ws_state=1');
		$shopList = $this->findAll($criteria);
		$currentLocation = @explode(',', $currentLocation);
		$currentLocation_lon = @$currentLocation[0];
		$currentLocation_lat = @$currentLocation[1];
		$rltList=array();
		foreach ( $shopList as $key => $favoriateShop ) {
			$shop = $favoriateShop->fsShop;
			if ($shop ['ws_state'] > 0) {
				$shopLocation = @explode ( ',', $shop ['ws_position'] );
				$shopLocation_lon = @$shopLocation [0];
				$shopLocation_lat = @$shopLocation [1];
				$distance = UMap::GetShortDistance ( $currentLocation_lon, $currentLocation_lat, $shopLocation_lon, $shopLocation_lat );
				if ($distance<$distanceLimit){
				$rltList [] = array (
						'id' => $shop ['id'],
						'address' => $shop ['ws_address'],
						'distance' => $distance,
						'name' => $shop ['ws_name'],
						'score' => $shop ['ws_score'] 
				);
				}
			}
		}
		$distanceArray = array ();
		$scoreArray = array ();
		foreach ( $rltList as $key => $value ) {
			$distanceArray [$key] = $value ['distance'];
			$scoreArray [$key] = $value ['score'];
		}
		
		array_multisort ( $distanceArray, SORT_ASC, $scoreArray, SORT_ASC, $rltList );
		return $rltList;
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
		$criteria->compare('fs_shop_id',$this->fs_shop_id,true);
		$criteria->compare('fs_user_id',$this->fs_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FavoriteShop the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
