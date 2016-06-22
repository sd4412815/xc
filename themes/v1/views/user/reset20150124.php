<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app ()->name . ' - 找回密码';
?>

<link rel="stylesheet"
	href="<?php echo Yii::app()->theme->baseUrl;?>/inc/icheck/all.css" />
<script type="text/javascript"
	src="<?php echo Yii::app()->theme->baseUrl;?>/inc/icheck/icheck.min.js"></script>

<section class="page-head-holder">

	<div class="container">

		<div class="col-sm-6 col-xs-12">



			<h2><?php 
			
			$type = $model->user_type;
		
				switch ($type){
					case '0': echo '车主';break;
					case '1': echo '员工';break;
					case '2': echo '老板';break;
					}
		
				
			?>找回密码</h2>

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
				'class' => 'col-sm-3 control-label' ,

		) );
		?>
		  <div class="col-sm-9">
     <?php
					
echo $form->passwordField ( $model, 'u_pwd', array (
							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
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
    </div>
		<?php
		
echo $form->error ( $model, 'u_pwd2', array (
				'class' => 'alert alert-danger',
				'role' => 'alert' 
		) );
		?>
		
	</div>
	
			
						  	<?php if(CCaptcha::checkRequirements()): ?>
						  	
						  	<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'verifyCode', array (
				'class' => 'col-sm-3 control-label' 
		) );
		?>
			  <div class="col-sm-6">
     <?php
					
echo $form->textField ( $model, 'verifyCode', array (
							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' 
					) );
					?>
    </div>
		  <div class="col-sm-3">
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
		<?php
		
echo $form->error ( $model, 'verifyCode', array (
				'class' => 'alert alert-danger',
				'role' => 'alert' 
		) );
		?>
		
	</div>
			 	<?php endif; ?>
			
   
	<?php
	if ($model->scenario == 'loginError') :
		
		?>
		<div class="alert alert-danger" role="alert">用户名或密码错误</div>
			<?php endif;?>

		
		
			<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'smsCode', array (
				'class' => 'col-sm-3 control-label' 
		) );
		?>
			  <div class="col-sm-6">
			      <?php
					
echo $form->textField ( $model, 'smsCode', array (
							'placeholder' => '请输入短信验证码-(测试期不用)',
							'class' => 'form-control' 
					) );
					?>
			  
			  </div>
			  
			  <div class="col-sm-3">
			  
			  
			  			  	<input type="button" class="button green wide-fat"
							name="btnSMS" id="btn_sms" onclick="sendMessage()" value="免费获取验证码"
							/>
			  </div>
			  

			  
			  </div>
		
		
		
	<div class="form-group">
					<div class="col-sm-12">
		<?php
		
echo CHtml::submitButton ( '重设密码', array (
				'class' => 'button green wide-fat' 
		) );
		?>
		</div>

				</div>
				<div class="form-group">
					<div class="col-sm-6">

	
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


var InterValObj; //timer变量，控制时间
var count = 5; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
  　curCount = count;
　　//设置button效果，开始计时
     $("#btn_sms").attr("disabled", "true");
     $("#btn_sms").val("请输入验证码(" + curCount + ")");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
　　  //向后台发送处理数据
//      $.ajax({
//      　　type: "POST", //用POST方式传输
//      　　dataType: "text", //数据格式:JSON
//      　　url: 'Login.ashx', //目标地址
//     　　 data: "dealType=" + dealType +"&uid=" + uid + "&code=" + code,
//     　　 error: function (XMLHttpRequest, textStatus, errorThrown) { },
//      　　success: function (msg){ }
//      });
}

//timer处理函数
function SetRemainTime() {
            if (curCount <= 1) {                
                window.clearInterval(InterValObj);//停止计时器
                $("#btn_sms").removeAttr("disabled");//启用按钮
                $("#btn_sms").val("重新发送验证码");
            }
            else {
                curCount--;
                $("#btn_sms").val("请输入验证码(" + curCount + ")");
            }
        }



function sendSMSCode(val){

// 	var smscount= $.cookie('sms_count');

// 	if(smscount != null){
// 	$.cookie('sms_count',smscount+1,{expires:1});
// 		}
// 	else
// 	{
// 		$.cookie('sms_count',1,{expires:1});
// 		}
	
	settime(val);
	
}

$(document).ready(function(){
if($.cookie('sms_count') > 5)
{

// 	$('#btn_sms').attr('disabled',false);
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
