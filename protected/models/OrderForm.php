<?php
class OrderForm extends CFormModel {
	private  $_order_no;
	public $shopId; // 车行id
	private  $_orderDatatime;
	public $orderDate; // 订单日期
	public $orderTime; // 订单时间段
	public $orderTimeIndex; //订单时间段序号
	public  $orderValue; // 订单金额
	public $carType; // 车型选择
	public $serviceType; // 服务类型
	private $_order_value_src;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array (
// 				验证必选项
				array (
						'shopId, orderDate, orderTimeIndex',
						'required',
						'message' => '请选择{attribute}' 
				),

		);
	}
	
	
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'order_value' => '订单金额',
				'shopId'=>'车行',
				'orderDate'=>'日期',
				'orderTime'=>'时间段',
				'carType'=>'车型',

		);
	}
	
	public function orderAdd(){
		return true;
	}
	
	
	
	
}