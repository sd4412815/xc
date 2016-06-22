<?php 
?>
<div class="panel panel-default" style="font-size: 12px;">

	<div class="row" style="height: 3px;"></div>
	<div class="row">
		<div class="col-sm-2 hidden-xs">
			<img style="max-width: 50%; min-width: 100%; height: 70px;"
				src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $data->id;?>/shop<?php echo $data->id;?>.jpg"
				alt="<?php echo $data->ws_name;?>" />
		</div>
		<div class="col-sm-5">
			<a
				href="<?php echo  Yii::app()->createUrl('order/new',array('id'=>$data->id));?>">
				<span style="color: #ff9900; font-weight: bold; font-size: 18px;">
					<?php echo $data->ws_name;?>
					</span>
			</a><?php
			
$features = $data->washShopFeatures;
			?>	
<?php
foreach ( $features as $key => $value ) :
	if ($value ['sf_position'] == 1 && $value ['sf_type'] == 0) :
		?>				
<img
				src="<?php echo Yii::app()->theme->baseUrl.'/img/ico/'.$value->sf_img_name;?>"
				title="<?php echo  $value->sf_desc;?>" />	
<?php elseif ($value['sf_position'] == 1 && $value['sf_type']==1):?>
<?php echo CHtml::decode($value['sf_code']);?>		
<?php endif;?>
<?php endforeach;?>	
					<p>附近：
					  <?php
							
$keywords = split ( '[; ,]', $data->ws_key_words );
							?>
					<?php foreach ($keywords as $key=>$value):?>
					  <span class="label label-default" style="font-size: 11px;"><?php echo $value;?></span> 
					  <?php endforeach;?>
					  <br>地址：<?php echo $data->ws_address;?></p>

		</div>
		<div class="col-sm-5">
			<p>
				
				
<?php
foreach ( $features as $key => $value ) :
	if ($value ['sf_position'] == 0 && $value ['sf_type'] == 0) :
		?>				
<img
					src="<?php echo Yii::app()->theme->baseUrl.'/img/ico/'.$value->sf_img_name;?>"
					title="<?php echo  $value->sf_desc;?>" />	
<?php elseif ($value['sf_position'] == 0 && $value['sf_type']==1):?>
<?php echo CHtml::decode($value['sf_code']);?>		
<?php endif;?>
<?php endforeach;?>	
				
					
				     
			<div>
车行评分值： 
<?php $this->widget('star.starWidget',array('score'=> $data['ws_score'])); ?>
   
 
                                                    </div>
			<div>
                                               车行经验值： <?php $this->widget('star.starWidget',array('score'=> $data['ws_exp'])); ?>	
  
 
                                                    
			
			</div>
				  </div>
				</div>
	
	
	<!-- row -->
							
				  
<?php
$shopServices  = WashShopService::model()->getServices($data['id'],true)['data']
// $shopServices = WashShopService::model()->findAllByAttributes(array(
// 	'wss_ws_id'=>$data['id'],
// 	'wss_state'=>'1'));

// $shopServices = $data->washShopServices;
// echo CJSON::encode($shopServices);

?>
<table
		class="table table-condensed table-striped table-bordered table-hover text-center"
		style="font-size:12px;font-weight:bold;">
 <thead>  </thead>
 <tbody>
<?php
foreach ( $shopServices as $key => $service ) :
	?>
	<?php if($service['wss_state']==1):?>
		<tr>
	<?php else:?>
		
			
			
			<tr class="disabled">
	<?php endif;?>
	
	
	<td class="col-xs-2 col-md-1 text-center"
					style="color:#ff9900;font-weight:bold;"><?php
					echo $service->wssSt['st_name'];?></td>
	<td class="col-xs-4 col-md-2">剩余:
	<?php
	$queryRlt = $data->getBasicInfobyType ( $data, $service ['wss_st_id'], $bias, false );
	if ($queryRlt ) {
		echo $queryRlt ['data'] ['numAvailable'];
	} else {
		echo 0;
	}
	?> 
	 共:
	<?php
	if ($queryRlt ) {
		echo $queryRlt ['data'] ['numTotal'];
	} else {
		echo 0;
	}
	?>
	</td>
	 <td class="col-xs-3">
		<span style="color:#009900;">
		<?php
	if ($queryRlt ) {
		echo $queryRlt ['data'] ['minValue'];
	} else {
		echo $service ['wss_value1'];
	}
	
	?>
		</span>元起
		<?php
	if ($queryRlt ['data'] ['minValue'] <$queryRlt ['data'] ['stdValue']) :
		?>
				<span class="label label-danger" style="font-size:12px;">折</span>
		<?php endif;?>
	</td>

	<td class="col-sm-2 hidden-xs">
		<span class="label label-warning" style="font-size:12px;">原价</span>
		<?php echo $queryRlt ['data'] ['stdValue'];?>元起
	</td>
	<td class="col-xs-1">
		<?php if ($service['wss_state'] ==1 ):?>
			<a
					href="<?php
		
echo Yii::app ()->createUrl ( 'order/new', array (
				'id' => $data ['id'],
				'st' => $service ['wss_st_id'] 
		) );
		?>"
					class="btn btn-warning btn-xs" type="button">预定</a>
		<?php else :?>
			<span class="btn btn-warning btn-xs disabled">暂不可预定</span>
		<?php endif;?>
	
	</td>

<?php endforeach;?>
 <marquee scrollAmount='2' behavior="alternate"> <?php
	$latestNew = ShopNews::model ()->findByAttributes ( array (
			'sn_shop_id' => $data ['id'] 
	), array (
			'order' => 'sn_date DESC' 
	) );
	echo $latestNew ['sn_desc'];
	?> </marquee>

		
		</tbody>
 </table>
 </div><!-- panel -->
	     