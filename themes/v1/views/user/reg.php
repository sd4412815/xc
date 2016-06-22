<?php
UTool::setCsrfValidator ();
$this->pageTitle = '车主注册';
?>
<div class="row">
	<div class="col-sm-offset-8  col-sm-3 text-right">
		<p>
			已有账户？ <a href="<?php echo Yii::app()->createUrl('site/login');?>"
				class="text-primary">马上登录</a>&nbsp;&nbsp;
		</p>
	</div>
</div>

<div class="row">
	<div
		class="col-md-offset-1 col-lg-offset-2 col-sm-5 col-md-4 hidden-xs">
		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/xi.png"
			style="height: 300px; max-width: 100%;" />
	</div>

	<div class="col-sm-7 col-md-6 col-lg-5">
		<div class="box  box-warning">
			<div class="box-header">
				<h3 class="box-title text-center text-yellow ">车主注册</h3>
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
	$("#btn_submit").attr("disabled","disabled");
return false;
}else{
layer.load("注册中...");
return true;
}

}',
				'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
if(hasError){
	$("#btn_submit").attr("disabled","disabled");
	if(attribute.id=="LoginForm_u_tel"){
		$("#btn_sms").attr("disabled","disabled");
	}
}else{ 
$("#btn_submit").removeAttr("disabled");
if(attribute.id=="LoginForm_u_tel"){
$("#btn_sms").removeAttr("disabled");}
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
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-9">
<?php
echo $form->textField ( $model, 'u_tel', array (
		'placeholder' => '请输入11位手机号',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_tel' );
?>	
    </div>
				</div>

				<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_pwd', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
 <?php
	echo $form->passwordField ( $model, 'u_pwd', array (
			'placeholder' => '密码只包含数字、字母、下划线',
			'class' => 'form-control' 
	) );
	?>
<?php

	echo $form->error ( $model, 'u_pwd' );
	?>
</div>
				</div>

				<div class="form-group">
<?php

echo $form->labelEx ( $model, 'u_pwd2', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
<div class="col-sm-9">
<?php
echo $form->passwordField ( $model, 'u_pwd2', array (
		'placeholder' => '密码只包含数字、字母、下划线',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'u_pwd2' );
?>
    </div>
				</div>


				<div class="form-group">
<?php

echo $form->labelEx ( $model, 'smsCode', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
<div class="col-sm-5">
<?php

echo $form->textField ( $model, 'smsCode', array (
		'placeholder' => '请输入短信验证码',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'smsCode' );
?>			  
</div>
					<div class="col-sm-4">
						<input type="button" class="btn btn-primary col-xs-12"
							name="btnSMS" id="btn_sms" onclick="sendMessage()"
							value="免费获取验证码" />
					</div>
				</div>
<?php
if (Yii::app ()->user->hasFlash ( 'regError' )) :
	?>
<div class="alert alert-danger" role="alert"><?php
 echo Yii::app()->user->getFlash('regError');?></div>
<?php endif;?>
				<div class="form-group">

					<div class="col-sm-offset-3 col-xs-12 col-sm-9">
<?php
echo $form->checkBox ( $model, 'agree', array () );
?> 我已阅读并同意<a
							href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'agree'));?>"
							class="text-primary" target="_blank">《我洗车服务协议》</a>
<?php

echo $form->error ( $model, 'agree', array (
		'class' => 'alert alert-danger',
		'role' => 'alert' 
) );
?>	
    </div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
<?php

echo CHtml::submitButton ( '注册', array (
		'class' => 'btn btn-warning col-sm-offset-3 col-sm-9 col-xs-12',
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
</div>
<!-- row -->

   <?php 

   Yii::app ()->session ['send_code'] = UTool::randomkeys ( 6 );

Yii::app()->clientScript->registerScript('regsms',
"
var InterValObj; 
var count = 180; 
var curCount;

function sendMessage() {
	curCount = count;

	InterValObj = window.setInterval(SetRemainTime, 1000); 
	$.ajax({
		type: \"POST\", 
		dataType:'json',
		url: '".Yii::app()->createUrl('site/sms')."', 
		data: {
			'send_code':'".Yii::app()->session['send_code']."',
			'tel':$('#LoginForm_u_tel').val(),
			'oi':'".Yii::app ()->request->cookies ['_oi']."',
 	    },
		error: function (XMLHttpRequest, textStatus, errorThrown) {layer.msg('提交失败'); },
		success: function (rlt){
			$('#btn_sms').attr('disabled', 'true');
			$('#btn_sms').val('请输入验证码( '+ curCount + ')');
			if(rlt['status']){
				layer.msg(rlt['msg'],2,1);
			}else{
				layer.msg(rlt['msg']);
				curCount = 0;
				SetRemainTime();
            }
		}
     });
}

function SetRemainTime() {
            if (curCount <= 1) {                
                window.clearInterval(InterValObj);
                $('#btn_sms').removeAttr('disabled');
                $('#btn_sms').val('重新发送验证码');
            }
            else {
                curCount--;
                $('#btn_sms').val('请输入验证码(' + curCount + ')');
            }
        }
		

		",CClientScript::POS_END);


?>