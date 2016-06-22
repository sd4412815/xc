<?php
class CommentForm extends CFormModel {
	public $score;
	public $comment;
	public $id;
	public $ontime;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules() {
		return array (
				// name, email, subject and body are required
				array (
						'id',
						'required' ,
						
				),
				array (
						'score',
						'required',
						'on'=>'ack'
				),
				array (
						'comment',
						'length',
						'max' => 100,
						'tooLong' => '留言内容不超过100字' ,
						'on'=>'ack'
				),
				array (
						'id',
						'numerical',
						'integerOnly' => true 
				),
				array (
						'score',
						'numerical',
						'on'=>'ack' 
				),
				array (
						'ontime',
						'numerical',
						'integerOnly' => true,
						'on'=>'bossack'
				),
// 				array (
// 						'ontime',
// 						'numerical',
// 						'on'=>'bossack'
// 				),
			
				 
		);
	}
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels() {
		return array (
				'score' => '评分',
				'comment' => '评论内容' ,
				'ontime'=>'车主实际到店时间',
		);
	}
}