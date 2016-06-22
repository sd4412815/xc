
   <!-- 左侧导航 -->
   <div class="row">
       <div class=" col-sm-2 col-lg-offset-1 skin-blue">
	          <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	    
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-head">
		        <h4> &nbsp&nbsp如何注册</h4>
		   </div>
		   <div class="box-body">	
		   
		    
				<p>1.点击页面顶部“注册”，进入注册页面；</p>  
				<p>2.填写手机号、密码、短信验证码等个人信息进行注册；</p>  
				<p>3.选中“我已阅读并同意《我洗车服务协议》”，点击“注册”，完成注册；</p> 
                <p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/zhu.png" /></p>				
				<p>4.对于忘记密码，我们提供了找回密码的功能，请在找回密码的页面中输入您的用户名、
				ID或已验证的手机号，系统将帮助您找回密码；</p> 
                <p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/mi.png" /></p>				
				<p>5.对于手机号已经被注册过，通过找回密码，接除绑定手机号，重新注册；</p>  
          
           </div>
         </div>			 
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smhelp_reg').addClass('active');
", CClientScript::POS_READY );

?>	