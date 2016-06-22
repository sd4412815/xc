<tr id="orderCancel<?php echo $data['id'];?>" style="display: none;">
	<td colspan="14" style="text-align: left;">	
<div >
	<br />
<?php
$model = new CommentForm ();

$model ['id'] = $data ['id'];

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'comment-form',

		'clientOptions' => array (
				'validateOnSubmit' => true 
				),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>	
<?php
echo $form->hiddenField ( $model, 'id' );
?>			
	<div class="alert alert-warning alert-dismissable">
		<i class="fa fa-warning"></i> <b>取消订单!</b> 您真的要取消预约订单？
<?php
					echo CHtml::ajaxSubmitButton ( '确认取消', $this->createUrl ( 'orderHistory/orderAckbyUserCancel' ), array (
							'success' => 'function(data){$.fn.yiiListView.update(
	        			                "ajaxOrderList"
	        			            );}' 
					)
					, array (
							'class' => 'btn btn-danger ',
							'id' => 'btn_cancel'.$data['id'], 
					) );

					
					echo CHtml::button ( '返回', array (
							'class' => "btn btn-primary",
							'onclick' => "$('#orderCancel" . $data ['id'] . "').hide();" 
					) );?>		
	
	</div>
	<?php $this->endWidget(); ?>	
</div>
	</td>
</tr>