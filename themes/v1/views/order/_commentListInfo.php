<div class="panel-body">
	<div class="row">
		<div class="col-sm-6">
	<?php $this->beginWidget('CHtmlPurifier'); ?>    
<?php echo $data['oc_comment'];?>
<?php $this->endWidget(); ?>  
 <br> <span style="color: #888888;"><?php 
 $order = $data->Order;
 echo $order['oh_order_date_time'];?></span>
		</div>
		<div class="col-sm-2 text-center">
			
 <?php

 $this->widget('star.starWidget',array('score'=> $order ['oh_score'])); ?>			

	</div>
		<div class="col-sm-2">
		服务：<?php echo  $order->serviceType['st_name'];?>
	</div>
		<div class="col-sm-2"><?php
$user = $data->User;
$userTel = $user['u_tel'];

if(substr($userTel, -4,4) == $user['u_nick_name']){
	
	echo substr($userTel, 0,2).'***'.substr($userTel, -2,2);
}
else{
	echo $user['u_nick_name'];
	
}


// if (empty($user['u_nick_name'])) {
// 	echo '****'.substr($user['u_tel'],-4,4);
// }else{
// 		echo $data->User['u_nick_name'];}
		
		?></div>
	</div>

	</div>	

<?php
$rc = OrderComments::model ()->findByAttributes ( array (
		'oc_related_id' => $data ['id'] 
) );
if (isset ( $rc )) :
	?>

<ul class="list-group" style="border-top: 1px dashed #ccc;">
	<li class="list-group-item" style="border-top: 0px;"><strong>【店主回复】</strong>
						  	<?php $this->beginWidget('CHtmlPurifier'); ?>    
<?php echo $rc['oc_comment'];?>
<?php $this->endWidget(); ?>    
					 <span style="color: #888888;"><?php echo $rc['oc_datetime'];?></span>
	</li>
</ul>

<?php else :?>
	  <div style="border-top:1px solid  #ccc;">
					
					  </div>		
<?php endif;?>	
	
						