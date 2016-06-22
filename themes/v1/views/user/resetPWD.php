<?php
$this->pageTitle =  '找回密码';
UTool::setCsrfValidator();
UTool::checkRepeatActionReset();
?>
<div class="row">
	<div class="col-sm-offset-7  col-sm-3 text-right">
		<p>
			其它账户？ <a href="<?php echo Yii::app()->createUrl('site/login');?>"
				class="text-primary">马上登录</a>&nbsp;&nbsp;
		</p>
	</div>
</div>
    <div class="row"> 
    	<div class="col-md-offset-2  col-md-8" >
		<div class="box  box-warning" style="z-index:50;">
			<div class="box-header">
				<h3 class="box-title text-center text-yellow ">找回密码</h3>
			</div>
			<div >
				 <ul id="progressbar">
				<li class="active">填写账号</li>
				<li class="active">验证身份</li>
				<li class="active">设置新密码</li>
				<li>完成</li>
			</ul>
			</div>
			<!-- /.box-header -->
				<div class="box-body">
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'login-form',
		'action'=>Yii::app()->createUrl('user/resetCheck'),
		'focus' => array (
				$model,
				'u_tel' 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,
				'afterValidate' => 'js:function(form, data, hasError){
if(hasError){
return false;
}else{
layer.load("修改中...");
return true;
}

}',

		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
	<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_pwd', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
	<div class="col-sm-6">
<?php
echo $form->passwordField ( $model, 'u_pwd', array (
		'placeholder' => '密码只能包含数字、字母和下划线',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_pwd');
?>	
    </div>
				</div>

		<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_pwd2', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
	<div class="col-sm-6">
<?php
echo $form->passwordField ( $model, 'u_pwd2', array (
		'placeholder' => '密码只能包含数字、字母和下划线',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_pwd2');
?>	
    </div>
				</div>	

			



<?php
if (Yii::app ()->user->hasFlash ( 'resetError' ) ) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('resetError');?></div>
<?php endif;?>
			
				<div class="form-group">
					<div class="col-sm-12">
<?php

echo CHtml::submitButton ( '下一步', array (
		'class' => 'btn btn-warning col-sm-offset-4',
		'id' => 'btn_submit' 
) );
?>
</div>
				</div>
<?php $this->endWidget(); ?>
			</div>
			<!-- /.box-body -->
			
		</div>
		<!-- /.box -->
	</div>
        
   </div><!-- row -->