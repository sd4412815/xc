<?php
class SearchForm extends CFormModel {
	public $pid; // 省id
	public $cid; // 城市id
	public $aid; // 区域id
	public $q; // 搜索词
	public $sdate;
	public $bias;
	public $features;
	public $areas;
	

	public function rules() {
		return array (
				array(
					'q',
					'match',
					'pattern'=> '/[\x{4e00}-\x{9fa5}]|[a-zA-Z0-9. ]+$/u',
					'message'=>'搜索关键字只能包括数字、字母、下划线和汉字',
				),
				array (
						'bias',
						'numerical',
						'integerOnly'=>true,
				),
				array(
					'features,areas',
						'safe',
				)
// 				array(
// 					'sdate',
// 					'date',
// 					'format'=>'yyyy-MM-dd',
// 					'message'=>'日期违法',
// 				)


		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'pid' => '省份',
				'cid' => '城市',
				'aid' => '区域',
				'q' => '关键字',
				'sdate'=>'日期',
				'bias'=>'日期',
		);
	}


}
