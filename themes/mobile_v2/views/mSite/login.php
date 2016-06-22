<?php 
$this->pageTitle = '用户登录';
?>
<!-- Input addon -->
<div class="box"
	style="margin-bottom: -140px; border-top: 0; box-shadow: 0 0 0; border-radius: 0;">
	<div class="box-header bg-yellow  text-center">
		<h3 class="box-title">用户登录</h3>
	</div>
	<div class="box-body" style="padding-bottom: 0;">
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'login-form',
		'focus' => array (
				$model,
				'u_tel' 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,
		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
		<div class="input-group ">
			<span class="input-group-addon"><i
				class="fa fa-user
                "></i></span> 
 <?php
	echo $form->textField ( $model, 'u_tel', array (
			'placeholder' => '已验证手机/用户名',
			'class' => 'form-control',
			'id' => "u_tel" 
	) );
	?>            
		</div>
		<span style="padding-left: 40px;"><span id="u_tel_err"
			class="text-danger h6">&nbsp;</span></span>		
		<?php
		echo $form->error ( $model, 'u_tel', array (
				'id' => 'u_tel_err',
				'inputID' => 'u_tel',
				'errorCssClass' => 'has-error',
				'successCssClass' => 'has-success',
		) );
		?>	
	

		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-key"></i></span>
<?php

echo $form->textField ( $model, 'u_pwd', array (
		'placeholder' => '密码只包含数字/字母/下划线',
		'class' => 'form-control',
		'id' => 'u_pwd' ,
		
) );
?>
		</div>
		<span style="padding-left: 40px;"><span id="u_pwd_err"
			class="text-danger h6">&nbsp;</span></span>	
<?php

echo $form->error ( $model, 'u_pwd', array (
		'id' => 'u_pwd_err',
		'inputID' => 'u_pwd',
		'errorCssClass' => 'has-error',
		'successCssClass' => 'has-success' 
) );
?>	
	

	

		<div class="social-auth-links">
<?php 
			echo CHtml::submitButton ( '登录', array (
					'class' => 'btn btn-success btn-flat  btn-block',
					'id' => 'btn_login'
			) );			
?>	
<br>
					<h6  class="text-primary">没有账号/忘记密码? 请通过手机验证码登录</h6>
					<a  id="btn_tel_pass" href="<?php echo Yii::app()->createUrl('mSite/checkTel').'?'.Yii::app()->getRequest()->queryString;;?>"
				class='btn btn-primary btn-flat btn-social  btn-block'><i class="fa fa-mobile"></i>通过手机验证码登录</a>
		</div>
	
		

	<?php $this->endWidget(); ?>
	<!-- /.box-body -->
</div>
<!-- /.box -->

