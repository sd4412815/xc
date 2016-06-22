<?php
$this->pageTitle = '老板登录';
?>


<div class="row">
	<div class="col-md-offset-2 col-sm-5 col-md-4   hidden-xs">
		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/xi.png"
			style="height: 260px; width: 100%;" />
		
	</div>

	<div class="col-sm-6 col-md-5">
		<div class="box  box-warning">
			<div class="box-header">
				<h3 class="box-title text-center text-yellow ">老板登录</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
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
layer.load("登录中...");
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
<?php
echo $form->labelEx ( $model, 'u_tel', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
	<div class="col-sm-8">
<?php
echo $form->textField ( $model, 'u_tel', array (
		'placeholder' => '请输入手机号/用户名/ID登陆',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_tel');
?>	
    </div>
				</div>

				<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_pwd', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
 <div class="col-sm-8">
 <?php
	echo $form->passwordField ( $model, 'u_pwd', array (
			'placeholder' => '密码只包含数字、字母、下划线',
			'class' => 'form-control' 
	) );
	?>
<?php
	echo $form->error ( $model, 'u_pwd');
	?>
</div>
				</div>
					<div class="form-group">

					<div class="col-sm-offset-4 col-xs-12 col-sm-8">
<?php
echo $form->checkBox ( $model, 'rememberMe', array () );
?> 记住登录
<?php

echo $form->error ( $model, 'rememberMe', array (
		'class' => 'alert alert-danger',
		'role' => 'alert' 
) );
?>	
    </div>
				</div>
	
		

<?php
if (Yii::app ()->user->hasFlash ( 'loginError' ) ) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('loginError');?></div>
<?php endif;?>
			
				<div class="form-group">
					<div class="col-sm-12 ">
<?php

echo CHtml::submitButton ( '登录', array (
		'class' => 'btn btn-warning col-sm-offset-4 col-sm-8 col-xs-12 ',
		'id' => 'btn_submit' 
) );
?>
</div>
				</div>
<?php $this->endWidget(); ?>
			</div>
			<!-- /.box-body -->
			<div class="footer">
				<div class="row">
					<div class="col-sm-offset-6  col-sm-6 text-right">
						<p>
							忘记密码？<a href="<?php echo Yii::app()->createUrl('user/reset');?>"
								class="text-primary">找回密码</a>&nbsp;&nbsp;
						</p>
					</div>
				</div>
			</div>
			<!-- /.box-footer -->
		</div>
		<!-- /.box -->
	</div>
</div>
<!-- row -->
<?php 
// 这是一段,在显示后定里消失的JQ代码,已集成至Yii中.
							      // Yii::app()->clientScript->registerScript(
							      // 'myHideEffect',"
							      // $('.info').animate({opacity: 1.0}, 3000).fadeOut('slow');",
							      // CClientScript::POS_READY
							      // );
?>

