
   <!-- 左侧导航 -->
   <div class="row">
       <div class="col-sm-2 col-lg-offset-1 skin-blue">
	          <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	   
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-head">
		        <h4>常见问题</h4>
		   </div>
		   <div class="box-body">	
		   
		   <div class="row">
			 <div class="col-xs-12">	 				
            		<table class="table">
			   <tr>
			       <td><p style="color:#f8981d;">1.注册时手机号已经被注册过怎么办？</p>
				       您在登录页面点击“忘记密码”，找回用您的手机号注册的账户。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">2.如何更换手机号？</p>
				       您首先登录我的洗车，进入我的账户资料->账户安全->更换手机号，然后按操作步骤进行更换号码。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">3.如何查看其它城市洗车行价格？</p>
				       点击网站顶端的“我在：”，在列表中选择要查看的城市。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">4.如何查看我附近有哪些洗车行？</p>
				       您可以进入地图预定，在地图上查看您附近的洗车行。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">5.在哪里可以查看洗车行的打折信息？</p>
				       价格打折的车行，会在车行列表中的价格上显示“折”字样；您也可以关注车行最新动态。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">6.哪些洗车行有优惠卡？</p>
				       有首次预定优惠卡发放或者次卡出售的洗车行在车行列表页均含有优惠卡标识，你可以到洗车店获得。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">7.我的优惠卡到期了，可以延期使用吗？ </p>
				       很抱歉，优惠卡一旦到期无法延期使用，请您谅解。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">8.我洗车支持哪些付款方式？</p>
				       目前只支持到洗车行付款。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">9.页面显示可以预定的时间段，为什么预定不成功呢？</p>
				       可能是有其他客户同时选择该时间段抢先预定了，请您选择其他时间段。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">10.怎样取消订单？</p>
				       进入我的洗车->全部订单，选择要取消的订单，点击取消按钮。如果已过预定时间，订单不能取消。
				   </td>
			   </tr>
			   <tr>
			       <td><p style="color:#f8981d;">11.对车行服务不满意如何进行投诉？</p>
				       您可以通过帮助中心的在线留言向我洗车投诉。 
				   </td>
			   </tr>
			</table>
					
             </div>
           </div>
           </div>
         </div>			 
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smfaq').addClass('active');

", CClientScript::POS_READY );

?>	