<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class StaffEventForm extends CFormModel {
	public $type; // 
	public $desc; // 
	public $datetime; //

	

	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array (
				array (
						'type',
						'required',
						'message' => '请选择{attribute}' 
				),


// 				手机号长度11位，保证输入长度不超限
				array (
						'desc',
						'length',
						'max' => 200,
						'tooLong' => '{attribute}不超过200字' 
				),
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'type' => '缘由',
				'desc' => '备注说明',
				'datetime' => '起始时间',
		);
	}
	

}
