		
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'invite-form',
		'focus' => array (
				$model,
				'u_tel', 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
	<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_tel', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
	<div class="col-sm-8">
<?php
echo $form->textField ( $model, 'u_tel', array (
		'placeholder' => '请输入手机号',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_tel');
?>	
    </div>
				</div>

<?php
if (Yii::app ()->user->hasFlash ( 'inviteError' ) ) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('inviteError');?></div>
<?php endif;?>
			
				<div class="form-group">
					<div class="col-sm-12 ">
<?php
// echo CHtml::ajax
$url = Yii::app()->createUrl('boss/inviteUser');
echo CHtml::ajaxSubmitButton('加入会员', '', array('beforeSend'=>'function(){
$("#btn_submit").button("loading");
}','success'=>'function(rlt){ 
		$("#inviteUser").html(rlt);

	}'), array (
		'class' => 'btn btn-warning col-sm-offset-4 col-sm-8 col-xs-12 ',
		'id' => 'btn_submit' ,
		'data-loading-text'=>'处理中……',
));
// echo CHtml::submitButton ( '购买', array (
// 		'class' => 'btn btn-warning col-sm-offset-3 col-sm-4 col-xs-6 ',
// 		'id' => 'btn_submit',
// 'onclick'=>
// ) );
// echo CHtml::submitButton ( '加入会员', array (
// 		'class' => 'btn btn-warning col-sm-offset-4 col-sm-8 col-xs-12 ',
// 		'id' => 'btn_submit' 
// ) );
?>
</div>
				</div>
<?php $this->endWidget(); ?>
	