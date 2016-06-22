<?php

/**
 * This is the model class for table "{{Wash_Shop_Feature}}".
 *
 * The followings are the available columns in table '{{Wash_Shop_Feature}}':
 * @property integer $id
 * @property integer $wsf_sf_id
 * @property string $wsf_ws_id
 *
 * The followings are the available model relations:
 * @property ShopFeature $wsfSf
 * @property WashShop $wsfWs
 */
class WashShopFeature extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{Wash_Shop_Feature}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wsf_sf_id, wsf_ws_id', 'required'),
			array('wsf_sf_id', 'numerical', 'integerOnly'=>true),
			array('wsf_ws_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wsf_sf_id, wsf_ws_id', 'safe', 'on'=>'search'),
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
			'wsfSf' => array(self::BELONGS_TO, 'ShopFeature', 'wsf_sf_id'),
			'wsfWs' => array(self::BELONGS_TO, 'WashShop', 'wsf_ws_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wsf_sf_id' => 'Wsf Sf',
			'wsf_ws_id' => 'Wsf Ws',
		);
	}
	
	/**
	 * 根据车行特征返回符合特征的车行id
	 * @param array $features
	 * @return array 车行id数组
	 */
	public function getShopIds($features){

		if(!is_array($features)){
			return array();
		}
		$criteria = new CDbCriteria();
		$criteria->select = 'wsf_ws_id';
		foreach ($features as $key=>$sf){
			$criteria->addCondition('wsf_sf_id=:sf'.$key,'or');
			$criteria->params[':sf'.$key]=$sf;
		}
		$criteria->group = 'wsf_ws_id';
		$criteria->having = 'count(*) = '.count($features);
		$criteria->distinct = true;
		
		$wsfs = $this->findAll($criteria);
		$rlt = array();
		foreach ($wsfs as $key=>$value){
			$rlt[]=$value['wsf_ws_id'];
		}
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
		$criteria->compare('wsf_sf_id',$this->wsf_sf_id);
		$criteria->compare('wsf_ws_id',$this->wsf_ws_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WashShopFeature the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * 更新车行特色
	 * @param int $id
	 * @param array $features
	 */
	public function updateShopFeatures($id, $features){
		$shopFeatures = WashShopFeature::model()->findAllByAttributes(array('wsf_ws_id'=>$id));
		$ssf = array();
		foreach ($shopFeatures as $feature){
			array_push($ssf, $feature['wsf_sf_id']);
		}
		// 删除不存在的
		foreach ($shopFeatures as $key=>$s){
			if(!in_array($s['wsf_sf_id'], $features)){
				$s->delete();
			}
		}
		// 		增加没有的
		foreach ($features as $s){
			if (!in_array($s, $ssf)) {
				$model = new WashShopFeature();
				$model['wsf_ws_id']=$id;
				$model['wsf_sf_id']=$s;
				
				if ($model->save()) {
					;
				}
			}
		}
	}
	
	
}
