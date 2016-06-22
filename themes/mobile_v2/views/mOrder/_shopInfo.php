<?php $shop=$data;?>
<?php 
$orderUrl= Yii::app()->createUrl('mOrder/new',array('id'=>$shop['id']));
?>

<div class="box box-default"
	style="margin-bottom: 10px; border-top: 1px;">
	<div class="box-header with-border">
		<a href="<?php echo $orderUrl;?>"
			class="box-title text-auto-hide col-xs-9  col-sm-6 box-header-title text-muted">
<?php
echo $shop ['name'] . ' ';
?>			
		</a>
		<div class="box-tools pull-right">
<?php

// 输出车行可以提供的服务
// $serviceTypeList
foreach ( $shop ['serviceList'] as $key => $serviceType ) {
	if (isset( $serviceTypeList[$serviceType['id']])){
		echo CHtml::decode ( $serviceTypeList [$serviceType ['id']]['code'] ) . ' ';
	}
	
}
?>	
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<div class="col-xs-4 pull-left">
				<a
					href="<?php echo $orderUrl;?>"><img
					class="lazy img-round"
					data-src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $shop['id'];?>/shop<?php echo $shop['id'];?>.jpg" /></a>
			</div>
			<!-- /.col -->
			<div class="col-xs-8" style="padding: 0">
				<ul class="nav nav-pills nav-stacked">
					<li class="h6 star">
			<?php
			$this->widget ( 'star.starWidget', array (
					'score' => $shop ['score'] 
			) );
			?><span class="text-green"><?php
			echo number_format ( $shop ['score'], 2 );
			;
			?>分</span><span class="pull-right text-primary"
						style="margin-right: 0">
<?php
$distance = $shop ['distance'];
// echo round($distance,0);
if ($distance < 100) {
	echo '100米内';
} elseif ($distance < 1000) {
	
	echo number_format ( $distance, 0 ) . '米';
} else if (($distance / 1000) < 100) {
	$distance = $distance / 1000;
	echo number_format ( $distance, 1 ) . '公里';
} else {
	$distance = $distance / 1000;
	// echo number_format($distance,1). '公里';
	echo '100公里外';
}
// echo $distance;
?>						
						</span>
					</li>
					<li class="h6 address"><div class="row">
							<div class="text-muted disabled text-auto-hide col-xs-10">
	
<?php
foreach ( $shop ['keyWords'] as $key => $word ) :
	?>						
<code><?php echo $word;?></code>
<?php
endforeach
;
?>							
							<?php echo $shop['address'];?>
							</div>
							<span class="pull-right text-muted "> 收藏 <?php echo $shop['favoriteCount'];?></span>
						</div></li>
					<li class="h6 hui"><div class="row">
							<div class="text-warning disabled text-auto-hide col-xs-10">
								<span class="btn btn-danger btn-flat btn-xs small-tag">惠</span>
			<span class="btn btn-primary btn-flat btn-xs small-tag">卡</span> <span
				class="btn btn-warning btn-flat btn-xs small-tag">券</span>
							</div>
							<span class="pull-right text-muted "> 会员 <?php echo $shop['memberCount'];?></span>
						</div></li>

				</ul>



			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.box-body -->
	<div class="box-footer no-padding" style="border-top: 0">

		<ul class="nav nav-pills nav-stacked" style="">
			<li>
				<div style="margin: -3px 0 0 0; padding: 0 5px 0 5px;">
					<div class="pull-left">
						<div class="bg-light-blue text-center"
							style="padding: 0 5px 0 5px;; margin: 0 0 0 5px;">
							<span class="h6">剩余席位<span><br> <span class="h4">

<?php 
echo $shop['countAvailable'];
?>
							</span>
									<sub class="">
<?php

// if ( $shop['countAvailable'] >=10){
// 	echo '充足';
// } else if ( $shop['countAvailable']>=5  ){
// echo '少量';
// } else {
// 	echo '紧张';
// }

echo '/'.$shop['countTotal'];


?></sub>
						
						</div>

					</div>
					<div class="pull-right">

						<i class="fa fa-jpy text-danger"></i><span class="text-danger h2"><?php						
if ($shop['valueMin']<1){
	echo number_format($shop['valueMin'],2);
}else{
	echo number_format($shop['valueMin'],0);
}
// echo json_encode($shop);
						
						?></span>
<?php
if ($shop ['valueDiscount'] > 0) :
	?>						
<sub class="text-danger text-delete"><?php 
// echo json_encode(current ($shop['serviceList'][$params['sTypeFilter']]['carGroupList'])['groupValue']);
// echo current(current( $shop['serviceList'][$params['sTypeFilter']])['carGroupList'])['groupValue'];
// echo json_encode($shop); 
// echo current ($shop['serviceList'][$params['sTypeFilter']]['carGroupList'])['groupValue'];
echo number_format($shop['valueDiscount']+$shop['valueMin'],0);
?></sub>
<?php
// echo $shop ['valueDiscount'];
endif;?>
						
						起
<?php 
if ($shop['status'] == WashShop::SHOP_STATE_PAUSE):
?>						
<div class="btn btn-danger btn-flat disabled"
							style="margin: -10px 0 0 0;">停业休息</div>
<?php elseif ($shop['status'] == WashShop::SHOP_STATE_STOP_ORDER):?>
<div class="btn btn-warning btn-flat disabled"
							style="margin: -10px 0 0 0;">暂停预约</div>
<?php elseif($shop['countAvailable']<1):?>
<a href="<?php echo $orderUrl;?>" class="btn  btn-success disabled btn-flat"
							style="margin: -10px 0 0 0;"><i class="fa fa-meh-o"></i> 抢光啦</a>	
<?php else:?>							
<a href="<?php echo $orderUrl;?>" class="btn btn-success btn-flat"
							style="margin: -10px 0 0 0;">免费预订</a>							
<?php endif;?>						

						
					</div>


<?php 
$percent = $shop['countAvailable']/$shop['countTotal']*100;
// $percentColor = '';
// if ( $shop['countAvailable'] >=10){
// 	$percentColor = 'progress-bar-primary';
// } else if ( $shop['countAvailable']>=5  ){
// 	$percentColor = 'progress-bar-warning';
// } else {
// 	$percentColor = 'progress-bar-danger';
// }

?>
					<div class="progress  progress-xxs">
						<div class="progress-bar progress-bar-primary" style="width: <?php echo $percent;?>%;"></div>
					</div>
					<div class="text-warning h6 text-auto-hide"
						style="margin: -5px 0 0 0; padding-left: 5px;">
						
						
						<marquee onMouseOut="this.start()" onMouseOver="this.stop()"  scrollamount="3" ><a href="<?php echo $orderUrl;?>">
						<i class="fa fa-bullhorn text-danger"></i>
<?php 
if(!empty( $shop['latestNews'])){
	echo $shop['latestNews'];
}else{
	echo '特价限时抢购';
}

?></a>	</marquee>					
						</div>


				</div>
			</li>


		</ul>
	</div>
	<!-- /.footer -->
</div>
