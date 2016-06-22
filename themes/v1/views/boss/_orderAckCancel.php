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
		<i class="fa fa-warning"></i> <b>确认违约订单!</b> 本订单已过期，车主未到店？
<?php
					echo CHtml::ajaxSubmitButton ( '确认违约', $this->createUrl ( 'orderHistory/orderAckbyBossCancel' ), array (
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