<?php
$this->pageTitle = '车主登录';
?>
<div class="row" style="padding-left: 1%; padding-right: 1%;">

	<div class="col-xs-offset-1 col-xs-10">
		<p class="text-right">
			还没账号？<a class="text-yellow" href="<?php echo Yii::app()->createUrl('user/reg'); ?>">马上注册</a>
		</p>
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'login-form',
		'focus' => array (
				$model,
				'u_tel', 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,
				'afterValidate' => 'js:function(form, data, hasError){
if(hasError){
	$("#btn_submit").attr("disabled","disabled");
return false;
}else{
layer.load(1,"登录中...");
return true;
}

}',
				'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
if(hasError){
	$("#btn_submit").attr("disabled","disabled");
}else{ 
$("#btn_submit").removeAttr("disabled");
}
}' 
		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" id="basic-tel"><span
						class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
<?php
echo $form->textField ( $model, 'u_tel', array (
		'placeholder' => '请输入手机号/用户名/ID登陆',
		'class' => 'form-control',
		'aria-describedby'=>'basic-tel' 
) );
?>

			
				</div>
<?php
echo $form->error ( $model, 'u_tel',array('class'=>'text-danger') );
?>	
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon" id="basic-pwd"><span
						class="glyphicon glyphicon-pencil" aria-hidden="true"></span></span>
						 <?php
	echo $form->passwordField ( $model, 'u_pwd', array (
			'placeholder' => '密码只包含数字、字母、下划线',
			'class' => 'form-control',
			'aria-describedby'=>'basic-pwd'
	) );
	?>
				</div>
<?php
echo $form->error ( $model, 'u_pwd',array('class'=>'text-danger') );
?>					
			</div>
			<div class="form-group">
				<label><?php
echo $form->checkBox ( $model, 'rememberMe' );
?>  记住密码</label>	 <span
					class="pull-right"><a href="<?php echo   Yii::app()->createUrl('user/reset');?>">忘记密码?</a></span>
<?php

echo $form->error ( $model, 'rememberMe', array (
		'class' => 'text-danger',
) );
?>			
			</div>
			<?php
if (Yii::app ()->user->hasFlash ( 'loginError' ) ) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('loginError');?></div>
<?php endif;?>
			<div class="form-group">
			<?php

echo CHtml::submitButton ( '登录', array (
		'class' => 'btn btn-warning col-xs-12 ',
		'id' => 'btn_submit' 
) );
?>
			
			</div>
	<?php $this->endWidget(); ?>

	</div>
</div>