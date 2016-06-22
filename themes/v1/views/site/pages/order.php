
   <div class="row">
       <div class=" col-sm-2 col-lg-offset-1 skin-blue">
	          <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	   
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-head">
		        <h4> &nbsp&nbsp预定车位流程</h4>
		   </div>
		   <div class="box-body">	
		   	<div class="row">
				 <div class="col-sm-offset-2 col-sm-8">	  
		   <p>1.注册</p>
                    <p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/zhu.png" /></p>							
					<p>2.搜索车行</p>
					<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/list.jpg" /></p>	
					<p>3.预定服务</p> 
					<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/order.jpg" /></p>				
					<p>4.提交订单</p> 
					<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ding.png" /></p>				
					<p>5.到店消费</p>
					<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/men.jpg" /></p>	
                    <p>6.确认订单并评价</p>
                    <p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ping.png" /></p>	
		     				
               		
           </div>
         </div>	
           </div>
         </div>			 
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smorder').addClass('active');
", CClientScript::POS_READY );

?>	