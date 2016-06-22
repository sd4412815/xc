
<tr id="orderAck<?php echo $data['id'];?>" style="display: none;">
	<td colspan="14" style="text-align: left;">
		<div>
			<br />
<?php
$model = new CommentForm ();
$model->setScenario('ack');
$model ['score'] = 5;
$model ['id'] = $data ['id'];

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'comment-form',
		'focus' => array (
				$data,
				'comment' 
		),
		// 'action' =>array('orderHistory/orderAckbyUserOk'),
		// 'enableAjaxValidation' => true,
		// 'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true 
		// 'validateOnChange' => true,
				),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>			
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i> <b>确认订单!</b> 请您到店消费后及时确认订单，还可以赚取积分奖励哦！
				<div class="form-group">
<?php
echo $form->label ( $model, 'score', array (
		'class' => 'col-sm-2 control-label' 
) );
?>
	<div class="col-sm-10">
<?php
$this->widget ( 'dzRaty.DzRaty', array (
		'model' => $model,
		'id' => 'star' . $data ['id'],
		'options' => array (
				'half' => TRUE ,
'width'=>200,
		),
		'htmlOptions' => array (
				'style' => 'display:inline-block;padding:5px;' ,
				'class'=>'raty-cell',
		),
		'attribute' => 'score' 
) );
?>
<?php

echo $form->error ( $model, 'score' );
?>	
    </div>
				</div>
				<div class="form-group">
<?php
echo $form->label ( $model, 'comment', array (
		'class' => 'col-sm-2 control-label' 
) );
?>
	<div class="col-sm-10">
<?php
// echo CHtml::textArea($name)
echo $form->textArea ( $model, 'comment', array (
		'placeholder' => '请输入评论内容 (不超过100字)',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'comment' );
?>	
    </div>
				</div>
		
<?php
echo $form->hiddenField ( $model, 'id' );
?>		
	
		<div class="form-group">
					<div class="col-sm-offset-2 col-sm-3">
					<?php
					echo CHtml::ajaxSubmitButton ( '确认完成', $this->createUrl ( 'orderHistory/orderAckbyUserOk' ), array (
							'success' => 'function(data){$.fn.yiiListView.update(
	        			                "ajaxOrderList"
	        			            );}' 
					)
					, array (
							'class' => 'btn btn-success ',
							'id' => 'btn_ok'.$data['id'], 
					) );
					// echo CHtml::submitButton ( '确认完成', array (
					// 'class' => 'btn btn-success ',
					// 'id' => 'btn_submit'
					// ) );
					
					echo CHtml::button ( '返回', array (
							'class' => "btn btn-primary",
							'onclick' => "$('#orderAck" . $data ['id'] . "').hide();" 
					) )?>


			</div>
				</div>




			</div>
					<?php $this->endWidget(); ?>	
</div>
	</td>
</tr>