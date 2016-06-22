 		<div class="col-sm-3">
		    <div class="thumbnail">
			  <div style="background:url(images/shops/<?php echo $data->id;?>/shop<?php echo $data->id;?>.jpg) no-repeat; height:280px;width:100%;">
			     <p><label class="label label-primary" title="WIFI">网</label> <label class="label label-success" title="免费赠饮">饮</label> 
				   <label class="label label-danger" title="优惠券">券</label></p>
			  </div>
			  <div class="caption">
				<h4><a><?php echo $data->ws_name;?></a> <a href="<?php echo  Yii::app()->createUrl('order/new',array('id'=>$data->id));?>" class="btn btn-warning btn-sm pull-right" role="button">预定</a></h4>
				<p>	     <div>
                                                 车行评分值：<span id="star<?php echo $data->id;?>"></span>

 <?php 
 Yii::app()->clientScript->registerScript('idstar'.$data->id,"

         $('#star".$data->id."').raty({
half:true,
			   		readOnly: true,
	  score: ".$data->ws_score." });           		
                    		
                    		",CClientScript::POS_READY);
 ?>    
 
                                                    </div></p>	
 <?php 
$shopServices = $data->washShopServices;
?>                                                   
				<p>
<?php 
foreach ($shopServices as $key=>$service):
?>
<?php echo $service->wssSt['st_name'];?>
	<?php if($service['wss_state']==1):?>
		<span style="color:#009900;">
		<?php
		$queryRlt = $data->getBasicInfobyType($data,$service['wss_st_id'],$bias,false);
			if ($queryRlt['status']) {
				echo $queryRlt['data']['minValue'];
			}else {echo $service['wss_value1'];}
					  
		?>
		</span>元起
		<?php
			if ($queryRlt['data']['minValue'] < $service['wss_value1']):?>
				<span class="label label-danger" style="font-size:12px;">折</span>
		<?php endif;?>
	<?php else:?>
		:未开通
	<?php endif;?>
	
	
	
	

	

<?php endforeach;?>

			
			
				<p>地址：<?php echo $data->ws_address;?></p>		
			  </div>
			</div>
		</div>
 
 