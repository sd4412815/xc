<?php
class BuyServiceForm extends CFormModel {
	
	// public $shopId; // 车行id
	public $level; // 服务等级
	public $value; // 价格
	public $address; // 收货地址
	public $name; // 收货人姓名
	public $tel; // 收货人电话
	public $remark; // 备注
	                // private $_order_value_src;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array (
				// 验证必选项
				array (
						'tel,address,name',
						'required',
						'message' => '{attribute}不能为空' 
				)
				,
				// 手机号长度11位，保证输入长度不超限
				array (
						'tel',
						'length',
						'min' => 11,
						'max' => 11,
						'tooLong' => '{attribute}格式不正确',
						'tooShort' => '{attribute}格式不正确' 
				),
				// 手机号格式验证：需为 1xxxxxxxxxx
				array (
						'tel',
						'match',
						'pattern' => '/^1\d{10}$/',
						'message' => '{attribute}格式不正确' 
				),
				array (
						'value,',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'level',
						'in',
						'range' => array (
								ShopPay::SERVICE_LEVEL_FREE,
								ShopPay::SERVICE_LEVEL_SILVER,
								ShopPay::SERVICE_LEVEL_GOLDER,
								ShopPay::SERVICE_LEVEL_DIAMOND,
						) 
				)
				 
		)
		;
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'level' => '服务级别',
				'value' => '价格',
				'address' => '收货地址',
				'name' => '收货人姓名',
				'tel' => '手机号',
				'remark' => '备注' 
		)
		;
	}
	
	/**
	 * 车行购买服务
	 * 刘长鑫
	 * 20150309
	 * @param int $bossId
	 * @return array()
	 */
	public function Buy($bossId) {
		$rlt = UTool::iniFuncRlt();
		$shop = WashShop::model()->findByAttributes(array('ws_boss_id'=>$bossId));
		if (!isset($shop)) {
			$rlt['msg']='车行不存在';
			return $rlt;
		}
		$shopId = $shop['id'];
		
		
		$model = new ShopPay ();
		$model ['sp_type'] = $this->level;
		$model ['sp_datetime'] = date ( 'Y:m:d H:i:s' );
		$model ['sp_value'] = $this->value;
		$model ['sp_user_id'] = $bossId;
		$model ['sp_state'] = 0;
		$model ['sp_remark'] = $this->remark;
		$model ['sp_shop_id'] = $shopId;
		$model ['sp_datetime_update'] = $model ['sp_datetime'];
		$model ['sp_name'] = $this->name;
		$model ['sp_address'] = $this->address;
		$model ['sp_tel'] = $this->tel;
		switch ($this->level) {
			case ShopPay::SERVICE_LEVEL_FREE :
				$model ['sp_date_long'] = 3;
				$model['sp_date_long_free'] = 0;
				break;
			case ShopPay::SERVICE_LEVEL_SILVER :
				$model ['sp_date_long'] = 6;
				$model['sp_date_long_free'] = 1;
				break;
			case ShopPay::SERVICE_LEVEL_GOLDER:
				$model ['sp_date_long'] = 12;
				$model['sp_date_long_free'] = 3;
				break;
			case ShopPay::SERVICE_LEVEL_DIAMOND :
				$model ['sp_date_long'] = 24;
				$model['sp_date_long_free'] = 7;
				break;
			default :
				$model ['sp_date_long'] = 3;
				$model['sp_date_long_free'] = 0;
				break;
		}
		if ($model->save ()) {
			$rlt['msg']='购买服务申请成功，请在3个工作日内查看申请结果';
			$rlt['status']=true;
		}else{
			$rlt['msg']='保存购买服务申请时出现意外，请稍后重试';
		}
		
		return $rlt;
	}
}