<?php
$this->pageTitle = $atype;
Yii::app()->session['resetUserStep'] =  'reset';
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
				<h3 class="box-title text-center text-yellow "><?php echo $atype;?></h3>
			</div>
			<div >
				 <ul id="progressbar">
				<li class="active">填写账号</li>
				<li >验证身份</li>
				<li>设置新密码</li>
				<li>完成</li>
			</ul>
			</div>
			<!-- /.box-header -->
				<div class="box-body">
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
				'afterValidate' => 'js:function(form, data, hasError){
if(hasError){
return false;
}else{
layer.load("查询中...");
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
echo $form->labelEx ( $model, 'u_tel', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
	<div class="col-sm-6">
<?php
echo $form->textField ( $model, 'u_tel', array (
		'placeholder' => '请输入手机号/用户名/ID',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_tel');
?>	
    </div>
				</div>

		  	<?php if(CCaptcha::checkRequirements()): ?>
						  	
						  	<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'verifyCode', array (
				'class' => 'col-sm-4 control-label' 
		) );
		?>
			  <div class="col-sm-4">
     <?php		
echo CHtml::activeTextField ( $model, 'verifyCode', array (
							'placeholder' => '请输入图形验证码',
							'class' => 'form-control' 
					) );
					?>
						<?php
		
echo $form->error ( $model, 'verifyCode');
		?>
    </div>
		  <div class="col-sm-2">
   <?php
							
$this->widget ( 'CCaptcha', array (
									'buttonLabel' => '刷新',
									'showRefreshButton' => false,
									'clickableImage' => true,
									'imageOptions' => array (
											'alt' => '点击刷新',
											'title' => '点击换图',
											'style' => 'cursor:pointer' 
									) 
							) );
							?>
						
    </div>
		
		
	</div>
			 	<?php endif; ?>

			



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