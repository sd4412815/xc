
   <div class="row">
       <div class="col-sm-2 col-lg-offset-1  skin-blue">
	      <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	   
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-head">
		        <h4> &nbsp&nbsp优惠券使用</h4>
		   </div>
		   <div class="box-body">
								<div class="row">
						<div class="col-xs-4 text-center">
							<img  src="<?php echo Yii::app()->theme->baseUrl;?>/img/card.jpg" />
						</div>
						<div class="col-xs-8">
							<h3 class="text-center">首次预定优惠卡</h3>
							<table class="table table-bordered">
								 <tr>
									  <th class="col-xs-3 col-sm-2">卡片介绍：</th>
									  <td  class="col-xs-9 col-sm-10">首次预定优惠卡是车行免费发放给车主，车主首次在指定车行预定服务时使用，用于减免到店支付金额的优惠措施。
		使用优惠卡提交订单时，若优惠卡金额大于订单需支付的金额，差额不予退回。单张订单只能使用一张优惠卡。
		</td>
								 </tr>
								 <tr>
									  <th>获取途径：</th>
									  <td>洗车行</td>
								 </tr>
								 <tr>
									  <th>使用限制：</th>
									  <td>只能在指定车行首次预定时使用，不受服务类别限制。</td>
								 </tr>
								 <tr>
									  <th>如何使用：</th>
									  <td>1. 登录 我的洗车->我的优惠券->输入优惠券密码->添加->在预定页面选择可使用的优惠券。
									  <br>2. 在预定页面直接输入优惠券密码->添加->默认被选择使用。"</td>
								 </tr>
							</table>
					    </div>
					
				   </div><!-- row end -->
				   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				     <div class="row">
		    <div class="col-xs-4 text-center">
							<img  src="<?php echo Yii::app()->theme->baseUrl;?>/img/card.jpg" />
						</div>
						<div class="col-xs-8">
							<h3 class="text-center">次卡</h3>
							<table class="table table-bordered">
                         <tr>
						      <th class="col-xs-4 col-sm-2">卡片介绍：</th>
							  <td  class="col-xs-8 col-sm-10">次卡是车行出售给车主，车主在指定车行预定服务时使用，用于抵消到店支付全部金额的优惠措施。
使用次卡提交订单时，不受实时价格的约束，均可抵消到店支付的全部金额。单张订单只能使用一张优惠卡。</td>
						 </tr>
						 <tr>
						      <th>获取途径：</th>
							  <td>洗车行</td>
						 </tr>
						 <tr>
						      <th>使用限制：</th>
							  <td>只能在指定车行使用；受服务类别限制。</td>
						 </tr>
						 <tr>
						      <th>如何使用：</th>
							  <td>1. 登录 我的洗车->我的优惠券->输入优惠券密码->添加->在预定页面选择可使用的优惠券。
								<br>2. 在预定页面直接输入优惠券密码->添加->默认被选择使用。"
							  </td>
						 </tr>
                    </table>
					    </div>
				   </div>
				  
				
				</div><!-- /.box-body -->
         </div>		
         </div>
         </div>
         
<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smcard').addClass('active');
", CClientScript::POS_READY );

?>	