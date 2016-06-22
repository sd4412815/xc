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




			<form id="login-form" action="<?php echo Yii::app()->createUrl('site/login');?>"   method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="LoginForm[u_tel]" id="LoginForm_u_tel"
						placeholder="用户11位手机号" />
				</div>
				<div class="form-group">
					<input type="password" class="form-control"  name="LoginForm[u_pwd]" id="LoginForm_u_pwd"
						placeholder="密码" />
				</div>
				
				       <div class="custom-checkbox-holder">

                                        <input  type="checkbox" name="LoginForm[rememberMe]" id="LoginForm_rememberMe" >



                                        <span>下次自动登录</span>

                                    </div>

		<?php 
		if ($model->scenario == 'loginError'):
			
		
		?>
		<div class="alert alert-danger" role="alert">用户名或密码错误</div>
			<?php endif;?>

				<input type="submit" name="yt0" class="button green wide-fat" value="登录" id="btnLogin"/>

			</form>






		</div>



	</div>

</div>


<script type="text/javascript">
<!--
$(document).ready(function(){
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
	                    }
	                }
	            },


	            
				},
	        
		});
});
//-->
</script>



