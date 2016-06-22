<?php
class ShopForm extends CFormModel {
	public $url;
	

	public function rules() {
		return array (
				array(
					'url',
					'file',
						'allowEmpty'=>true,
						'types'=>'jpg,png',   //上传文件
						'maxSize'=>1024*1024*10,    //上传大小限制，注意不是php.ini中的上传文件大小
				 'tooLarge'=>'文件大于10M，上传失败！请上传小于10M的文件！'  ,
						'on'=>'upload'
				
				),

		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array (
				'url' => '选择图片',
				
		);
	}


}
