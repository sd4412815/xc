<?php 
$this->pageTitle = '手机验证';

// $cs = Yii::app()->getClientScript();
// $cs->registerScript('f1','	alert($(window.parent.document).find(".flavr-container").length);;');


?>
<!-- Input addon -->
<div class="box"
	style="margin-bottom:-140px; border-top: 0; box-shadow: 0 0 0; border-radius: 0;">
	<div class="box-header bg-yellow  text-center">
		<h3 class="box-title">手机验证</h3>
	</div>
	<div class="box-body" style="padding: 0 10px 0 10px;">
	<h6  class="text-primary text-center">为防止用户信息被盗用，请使用本机号码</h6>
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'check-tel-form',
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
				class="glyphicon glyphicon-phone
                "></i></span> 
 <?php
	echo $form->textField ( $model, 'u_tel', array (
			'placeholder' => '手机号码',
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
			<span class="input-group-addon"><i class="glyphicon glyphicon-check"></i></span>
<?php

echo $form->textField ( $model, 'smsCode', array (
		'placeholder' => '短信验证码',
		'class' => 'form-control',
		'id' => 'smsCode' ,
		'maxlength'=>6,
		'minlength'=>4,
		
) );
?>

			 <span class="input-group-btn"><input type="button" id="btn_sms"
				class='btn btn-info btn-flat'  onclick="sendMessage()"
				value="免费获取验证码" /></span>
		</div>
		<span style="padding-left: 40px;"><span id="u_sms_code_err"
			class="text-danger h6">&nbsp;</span></span>	
<?php

echo $form->error ( $model, 'smsCode', array (
		'id' => 'u_sms_code_err',
		'inputID' => 'smsCode',
		'errorCssClass' => 'has-error',
		'successCssClass' => 'has-success' 
) );
?>	
	

		

		<div class="social-auth-links text-center">
			<button  id="btn_tel_pass"
				class='btn btn-success btn-flat  btn-block'>下一步</button>
			<h6>或者</h6>
					<a  id="btn_tel_pass" href="<?php echo Yii::app()->createUrl('mSite/login').'?'.Yii::app()->getRequest()->queryString;?>"
				class='btn btn-danger btn-flat btn-social  btn-block'><i class="fa fa-user"></i>使用已有 <b>我洗车</b> 账户</a>
		</div>
	
		

	<?php $this->endWidget(); ?>
	<!-- /.box-body -->
</div>
<!-- /.box -->
<?php
Yii::app ()->session ['send_code'] = UTool::randomkeys ( 4 );

Yii::app ()->clientScript->registerScript ( 'regsms', "
var InterValObj; 
var count = 180; 
var curCount;

function sendMessage() {
	curCount = count;

	InterValObj = window.setInterval(SetRemainTime, 1000); 
	$.ajax({
		type: \"POST\", 
		dataType:'json',
		url: '" . Yii::app ()->createUrl ( 'site/sms' ) . "', 
		data: {
			'send_code':'" . Yii::app ()->session ['send_code'] . "',
			'tel':$('#u_tel').val(),
// 			'oi':'" . Yii::app ()->request->cookies ['_oi'] . "',
 	    },
		error: function (XMLHttpRequest, textStatus, errorThrown) {alert('提交失败'); },
		success: function (rlt){
			if(rlt['status']){
				showInfoFlash(rlt['msg']);
				$('#btn_sms').attr('disabled', 'true');
			$('#btn_sms').val('请输入验证码( '+ curCount + ')');
			}else{
				showWarning(rlt['msg']);
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
                $('#btn_sms').val('免费获取验证码');
            }
            else {
                curCount--;
                $('#btn_sms').val('请输入验证码 (' + curCount + ')');
            }
        }
		

		", CClientScript::POS_END );

?>
