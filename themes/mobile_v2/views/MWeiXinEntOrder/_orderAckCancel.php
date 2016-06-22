<div id="orderCancel<?php echo $data['id'];?>" style="display: none;">
	
<div >
	
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
	<div class="alert alert-default alert-dismissable">
		<i class="fa fa-warning"></i> <b>确认违约订单!</b> 本订单已过期，车主未到店？
<?php
					echo CHtml::ajaxSubmitButton ( '确认违约', $this->createUrl ( 'mweixinentorder/orderAckbyBossCancel' ), array (
							'success' => 'function(data){$.fn.yiiListView.update(
	        			                "ajaxOrderList"
	        			            );}' 
					)
					, array (
							'class' => 'btn btn-danger btn-sm',
							'id' => 'btn_cancel'.$data['id'], 
					) );

					echo "&nbsp;&nbsp;";
					echo CHtml::button ( '返回', array (
							'class' => "btn btn-primary btn-sm",
							'onclick' => "$('#orderCancel" . $data ['id'] . "').hide();" 
					) );?>		
	
	</div>
	<?php $this->endWidget(); ?>	
   </div>
	
</div>