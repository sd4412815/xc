<?php
$this->pageTitle = $atype;
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
				<li class="active">验证身份</li>
				<li>设置新密码</li>
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
				'smsCode' 
		),
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
'validateOnChange' => true,
				'afterValidate' => 'js:function(form, data, hasError){
if(hasError){
return false;
}else{
layer.load("验证中...");
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
echo $form->label ( $model, 'u_tel', array (
		'class' => 'col-xs-4 control-label' 
) );
?>
	<div class="col-xs-6">
<?php

echo CHtml::label(Yii::app()->session['resetUserTel'], '', array (
// 		'class' => 'form-control' ,
) );
?>
    </div>
				</div>
	<div class="form-group">
<?php
echo CHtml::label('验证手机号','' , array (
		'class' => 'col-xs-4 control-label' 
) );
?>
	<div class="col-xs-6">
<?php
$tel = Yii::app()->session['resetUserTel'];

echo CHtml::label('****'.substr($tel, -4,4), '', array (
// 		'class' => 'form-control' ,
) );
?>
    </div>
				</div>
<div class="form-group">
<?php

echo $form->labelEx ( $model, 'smsCode', array (
		'class' => 'col-sm-4 control-label' 
) );
?>
<div class="col-sm-3">
<?php

echo $form->textField ( $model, 'smsCode', array (
		'placeholder' => '请输入短信验证码',
		'class' => 'form-control' 
) );
?>
<?php
echo $form->error ( $model, 'smsCode');
?>			  
</div>
					<div class="col-sm-3">
						<input type="button" class="btn btn-primary col-xs-12"
							name="btnSMS" id="btn_sms" onclick="sendMessage()"
							value="免费获取验证码" />
					</div>
				</div>		  	

			



<?php
if (Yii::app ()->user->hasFlash ( 'resetCheckError' ) ) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('resetCheckError');?></div>
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
   
   
 <?php 

   Yii::app ()->session ['send_code'] = UTool::randomkeys ( 6 );

Yii::app()->clientScript->registerScript('regsms',
"
var InterValObj; 
var count = 60; 
var curCount;

function sendMessage() {
	curCount = count;

	InterValObj = window.setInterval(SetRemainTime, 1000); 
	$.ajax({
		type: \"POST\", 
		dataType:'json',
		url: '".Yii::app()->createUrl('site/smsreset')."', 
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
