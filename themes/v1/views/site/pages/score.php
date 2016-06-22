
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
		        <h4> &nbsp&nbsp积分说明</h4>
		   </div>
		   <div class="box-body">	
		   
		   <div class="row">
			 <div class="col-sm-offset-2 col-sm-8">	   				
                <p>车主可以通过预定服务完成订单、评价和完善个人资料获得积分。消费一元钱可获得一个积分，完成订单后进行评价可得到同样数量的积分。完善个人资料可获得100个积分</p>
				<table class="table table-bordered">
				   <tr>
				     <th>途径</th>
					 <th>获得积分</th>
				   </tr>
				   <tr>
				     <td>消费30元</td>
					 <td>30分</td>
				   </tr>
				   <tr>
				     <td>评价</td>
					 <td>30分</td>
				   </tr>
				   <tr>
				     <td>完善个人资料</td>
					 <td>100分</td>
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
$('#smscore').addClass('active');
", CClientScript::POS_READY );

?>	