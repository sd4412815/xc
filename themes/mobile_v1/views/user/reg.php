<?php
$this->pageTitle = '车主注册';
?>
    <div class="row" style="padding-left:1%;padding-right:1%;">
	    
		<div class="col-xs-offset-1 col-xs-10">
		  <p class="text-right">已有账户？<a href="<?php echo Yii::app()->createUrl('site/login');?>"
				class="text-yellow">马上登录</a></p>
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
				<div class="input-group">
				  <span class="input-group-addon" id="basic-tel"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span></span>
				 <?php
echo $form->textField ( $model, 'u_tel', array (
		'placeholder' => '请输入11位手机号',
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
					  <span class="input-group-addon" id="basic-pwd"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></span>
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
					<div class="input-group">
					  <span class="input-group-addon" id="basic-pwd2"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></span>
<?php
echo $form->passwordField ( $model, 'u_pwd2', array (
		'placeholder' => '密码只包含数字、字母、下划线',
		'class' => 'form-control' ,
		'aria-describedby'=>'basic-pwd2'
) );
?>

					</div> 
<?php

echo $form->error ( $model, 'u_pwd2',array('class'=>'text-danger') );
?>					
				</div>
				<div class="form-group">
					<div class="input-group">
<?php

echo $form->textField ( $model, 'smsCode', array (
		'placeholder' => '请输入短信验证码',
		'class' => 'form-control' 
) );
?>

	
					  <span class="input-group-btn">
						<input type="button" class="btn btn-danger" name="btnSMS" id="btn_sms" onclick="sendMessage()"
							value="免费获取验证码" />
					  </span><br >

					</div><!-- /input-group -->
<?php
echo $form->error ( $model, 'smsCode',array('class'=>'text-danger') );
?>			

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
<?php

echo CHtml::submitButton ( '注册', array (
		'class' => 'btn btn-warning col-xs-12',
		'id' => 'btn_submit' 
) );
?>
				</div>
<?php $this->endWidget(); ?>
		</div>
		
	</div>
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