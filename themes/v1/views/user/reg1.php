<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app ()->name . ' - 注册';
?>

<link rel="stylesheet"
	href="<?php echo Yii::app()->theme->baseUrl;?>/inc/icheck/all.css" />
<script type="text/javascript"
	src="<?php echo Yii::app()->theme->baseUrl;?>/inc/icheck/icheck.min.js"></script>

<section class="page-head-holder">

	<div class="container">

		<div class="col-sm-6 col-xs-12">



			<h2>新用户注册</h2>

		</div>

		<div class="col-sm-6 col-xs-12">

			<div class="breadcrumb-holder"></div>

		</div>

	</div>

</section>






<div class="modal-dialog">

	<div class="modal-content">



		<div class="modal-body">




			<form id="login-form"
				action="<?php echo Yii::app()->createUrl('user/reg');?>"
				method="post">
				<div class="form-group">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<input type="text" class="form-control" name="LoginForm[u_tel]"
							id="LoginForm_u_tel" placeholder="用户11位手机号" />
					</div>

				</div>
				<div class="form-group">

					<div class="col-sm-12 col-md-12 col-lg-12">
						<input type="password" class="form-control"
							name="LoginForm[u_pwd]" id="LoginForm_u_pwd"
							placeholder="密码只能包含数字、字母、下划线" />
					</div>

				</div>
				<div class="form-group">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<input type="password" class="form-control"
							name="LoginForm[u_pwd2]" id="LoginForm_u_pwd2"
							placeholder="再次输入密码" />
					</div>


				</div>
					
			  
			  
		
			  	<?php if(CCaptcha::checkRequirements()): ?>
			  <div class="form-group">
					<div class="col-sm-9 col-md-9 col-lg-9">
						<input type="text" class="form-control"
							name="LoginForm[verifyCode]" id="LoginForm_verifyCode"
							placeholder="输入右侧验证码" />
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
			  
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
			  	
				  <div class="form-group">
					<div class="col-sm-7 col-md-7 col-lg-7">
						<input type="text" class="form-control"
							name="LoginForm[verifyCode]" id="LoginForm_verifyCode"
							placeholder="输入短信验证码" />
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
						<input type="button" class="button green wide-fat"
							name="btnSMS" id="btn_sms" onclick="sendMessage()" value="免费获取验证码"
							/>
					</div>
					
					</div>
			  	<input type="submit" name="yt0"
					class="button green wide-fat btn-lg" value="注册" id="btnLogin" /> <label
					class="boolean optional control-label">已有账号？去这里</label> <a
					class="button"
					href="<?php echo Yii::app()->createUrl('site/login');?>">登录</a>


		<?php
		if ($model->scenario == 'loginError') :
			?>
		<div class="alert alert-danger" role="alert">用户名或密码错误</div>
			<?php endif;?>

	<?php echo var_dump( $model->errors); ?>
			
			

			</form>






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
     $("#btn_sms").val("请在" + curCount + "秒内输入验证码");
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
                $("#btn_sms").val("请在" + curCount + "秒内输入验证码");
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
	  

		
	$('#login-form').bootstrapValidator({
		   feedbackIcons: {
			    valid: 'fa fa-check',
			    invalid: 'fa fa-times',
			    validating: 'fa fa-refresh'
	        },
	        live:'enabled',
			fields:{
				"LoginForm[u_tel]": {
	                message: '用户手机号无效',
	                validators: {
	                	notEmpty: {
		                	enabled:true,
	                        message: '手机号不能为空'
	                    },
	                    regexp: {
	                        regexp: /^1\d{10}$/,
	                        message: '手机号格式不正确'
	                    },

	                }
	            },
	            "LoginForm[u_pwd]": {
	                validators: {
	                	notEmpty: {
		                	enabled:true,
	                        message: '密码不能为空'
	                    },

	                    regexp: {
	                        regexp: /^\w{1,20}$/,
	                        message: '密码只能包含数字、字母及下划线'
	                    },
	                    stringLength: {
	                        max: 20,
	                        message: '密码不能超过20个字符'
	                    },
	                    identical:{
	                    	field:"LoginForm[u_pwd2]",
	                    	message:'密码不一致'
	                    },
	        
	                }
	            },
	            "LoginForm[u_pwd2]": {
	                validators: {
	                	notEmpty: {
		                	enabled:true,
	                        message: '密码不能为空'
	                    },

	                    regexp: {
	                        regexp: /^\w{1,20}$/,
	                        message: '密码只能包含数字、字母及下划线'
	                    },
	                    stringLength: {
	                        max: 20,
	                        message: '密码不能超过20个字符'
	                    },
	                    identical:{
field:"LoginForm[u_pwd]",
message:'密码不一致'
		                    },
	        
	                }
	            },
	            



	            
				},
	        
		});
});
//-->
</script>
