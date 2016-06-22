
<div id="orderAck<?php echo $data['id'];?>" style="display: none;">
	
		<div>
			
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
			<div class="alert alert-default alert-dismissable">
				<i class="fa fa-check"></i> <b>确认订单!</b> 客户到店消费后及时确认订单，还可赚取经验值奖励哦！
			
				<div class="form-group">
<?php
echo $form->label ( $model, 'ontime', array (
		'class' => 'col-xs-6 control-label' ,
        'style'=>'padding-top:2%;'
) );
?>
	<div class="col-xs-6">
<?php
// echo CHtml::dropDownList($name, $select, $data)
echo $form->dropDownList ( $model, 'ontime', array('-20'=>'提前20分钟以上','-15'=>'提前15分钟','-10'=>'提前10分钟','-5'=>'提前5分钟','0'=>'按时到达','5'=>'迟到5分钟','10'=>'迟到10分钟','15'=>'迟到15分钟','20'=>'迟到20分钟','30'=>'迟到30分钟以上'),array (
		'placeholder' => '请选择到达时间',
		'class' => 'form-control',
		'style'=>'width:150px'
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
<!-- 			<div class="col-xs-offset-5 col-xs-7"> -->
			<div class="pull-right">
				<?php
				echo CHtml::ajaxSubmitButton ( '确认完成', $this->createUrl ( 'mweixinentorder/orderAckbyBossOk' ), array (
						'success' => 'function(data){$.fn.yiiListView.update(
        			                "ajaxOrderList"
        			            );}' 
				)
				, array (
						'class' => 'btn btn-success btn-sm',
						'id' => 'btn_ok'.$data['id'], 
				) );
				// echo CHtml::submitButton ( '确认完成', array (
				// 'class' => 'btn btn-success ',
				// 'id' => 'btn_submit'
				// ) );
				echo "&nbsp;&nbsp;";
				echo CHtml::button ( '返回', array (
						'class' => "btn btn-primary btn-sm",
						'onclick' => "$('#orderAck" . $data ['id'] . "').hide();" 
				) )?>


		     </div>
		</div>

     </div>
	 <?php $this->endWidget(); ?>	
	 
</div>

</div>

