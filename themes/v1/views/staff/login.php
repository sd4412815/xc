<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app ()->name . ' - 登录';

?>
<link rel="stylesheet"
	href="<?php echo Yii::app()->theme->baseUrl;?>/inc/icheck/all.css" />
<script type="text/javascript"
	src="<?php echo Yii::app()->theme->baseUrl;?>/inc/icheck/icheck.min.js"></script>
<section class="page-head-holder">

	<div class="container">

		<div class="col-sm-6 col-xs-12">



			<h2>用户登录</h2>

		</div>

		<div class="col-sm-6 col-xs-12">

			<div class="breadcrumb-holder"></div>

		</div>

	</div>

</section>



<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-body">

			<div>
<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'login-form',
		'enableAjaxValidation'=>true, //是否启用ajax验证
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true ,
'validateOnChange'=>true, //输入框值改变时验证
		),
		'htmlOptions' => array (
// 				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>



	<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'u_tel', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->textField ( $model, 'u_tel', array (
							'placeholder' => '请输入11位手机号',
							'class' => 'form-control' 
					) );
					?>
    </div>
		<?php
		
echo $form->error ( $model, 'u_tel', array (
				'class' => 'alert alert-danger',
				'role' => 'alert' 
		) );
		?>
		
	</div>

				<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'u_pwd', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->passwordField ( $model, 'u_pwd', array (
							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' 
					) );
					?>
    </div>
		<?php
		
echo $form->error ( $model, 'u_pwd', array (
				'class' => 'alert alert-danger',
				'role' => 'alert' 
		) );
		?>
		
	</div>
				<div class="form-group">
		<?php
		
echo $form->label ( $model, 'rememberMe', array (
				'class' => 'col-sm-2' 
		) );
		?>
		  <div class="col-sm-10" style="text-align: left;">
     <?php echo  $form->checkBox($model,'rememberMe'); ?>
    </div>
		<?php
		
echo $form->error ( $model, 'rememberMe', array (
				'class' => 'alert alert-danger',
				'role' => 'alert' 
		) );
		?>
		
	</div>
   
	<?php
	if ($model->scenario == 'loginError') :
		
		?>
		<div class="alert alert-danger" role="alert">用户名或密码错误</div>
			<?php endif;?>

		
		
	<div class="form-group">
					<div class="col-sm-12">
		<?php
		
echo CHtml::submitButton ( '登录', array (
				'class' => 'button green wide-fat' 
		) );
		?>
		</div>

				</div>
				<div class="form-group">
					<div class="col-sm-6">

						<span>忘记密码？</span>
	   <?php
				
$this->widget ( 'bootstrap.widgets.TbButton', array (
						'buttonType' => 'link',
						'type' => 'link',
						'label' => '重置密码',
						'url' => array (
								'/user/reset' 
						) 
				) )?>
	</div>

					<div class="col-sm-6">
						<span>还没有账户？</span>
	<?php
	
$this->widget ( 'bootstrap.widgets.TbButton', array (
			'buttonType' => 'link',
			'type' => 'link',
			'label' => '马上注册',
			'url' => array (
					'/user/reg' 
			) 
	) )?>
	</div>
				</div>
	

<?php $this->endWidget(); ?>
</div>
			<!-- form -->
		</div>

	</div>
</div>
<script type="text/javascript">
<!--
$(document).ready(function(){
	if($.cookie('sms_count') > 5)
	{

//	 	$('#btn_sms').attr('disabled',false);
	}
		
	// alert($.cookie('sms_count'));
		
		  $('input').iCheck({
			    checkboxClass: 'icheckbox_minimal-orange',
			    radioClass: 'iradio_minimal-orange',
			    increaseArea: '20%' // optional
			  });
		  });
//-->
</script>



