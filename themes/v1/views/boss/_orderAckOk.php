
<tr id="orderAck<?php echo $data['id'];?>" style="display: none;">
	<td colspan="14" style="text-align: left;">
		<div>
			<br />
<?php
$model = new CommentForm ();
$model->setScenario('bossack');
$model ['score'] = 5;
$model ['id'] = $data ['id'];
$model['ontime']=0;


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
				<i class="fa fa-check"></i> <b>确认订单!</b> 请客户到店消费后及时确认订单，还可以赚取经验值奖励哦！
			
				<div class="form-group">
<?php
echo $form->label ( $model, 'ontime', array (
		'class' => 'col-sm-2 control-label' 
) );
?>
	<div class="col-sm-10">
<?php
// echo CHtml::dropDownList($name, $select, $data)
echo $form->dropDownList ( $model, 'ontime', array('-20'=>'提前20分钟以上','-15'=>'提前15分钟','-10'=>'提前10分钟','-5'=>'提前5分钟','0'=>'按时到达','5'=>'迟到5分钟','10'=>'迟到10分钟','15'=>'迟到15分钟','20'=>'迟到20分钟','30'=>'迟到30分钟以上'),array (
		'placeholder' => '请选择到达时间',
// 		'class' => 'col-sm-2 form-control' 
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
					echo CHtml::ajaxSubmitButton ( '确认完成', $this->createUrl ( 'orderHistory/orderAckbyBossOk' ), array (
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