<?php $user=User::model()->findByPk($boss['b_user_id']);?>

<div class="row">
<div class="col-sm-3">
<div class="row">
	<div class="text-center  hidden-xs">
		<div class="col-xs-12 ">
	<img style="width: 100%; height: 280px;"
					src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $shop['id'];?>/shop<?php echo $shop['id'];?>.jpg"
					alt="<?php echo $shop->ws_name;?>" />
		</div>

		
			</div>
			</div> <!-- row -->
		
			
	

</div>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-12">
<h4>
				<code><?php echo $user['u_tel'];?></code>
				您好！ <a
					href="<?php echo Yii::app()->createUrl('boss/wsInfo',array('id'=>'1'));?>"><small>维护车行信息</small></a>
				<small class="pull-right hidden-xs">适当营销车行可以有效提高竞争力哦！</small>
			</h4>
</div>

</div>
<div class="row">
<div class="hidden-xs col-sm-5 col-lg-6">
	<div class="small-box bg-blue">
						<div class="inner">
							<br>
							<p>
								<a target="_blank"
									href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id'])); ?>"
									style="color: #ffffd8;">名称：<?php echo $shop['ws_name'];?></a>
							</p>
							<p>
								<a target="_blank"
									href="<?php echo Yii::app()->createUrl('boss/wsInfo',array('id'=>$shop['id'])); ?>"
									style="color: #ffffd8;">车位：<?php echo $shop['ws_num'];?>个</a>
							</p>
							<p>已开:
<?php 
$services = WashShopService::model()->getServices($shop['id'])['data'];

// WashShopService::model()->findAllByAttributes(array('wss_ws_id'=>$shop['id']));

foreach ($services as $key=>$value):
?>
<code ><?php echo $value->wssSt['st_name'];?></code>
<?php endforeach;?>
							</p>
							<p>&nbsp;
							</p>
						

							<br>
						</div>
					</div>
</div>
<div class="col-sm-7 col-lg-6 ">
<div class="table-responsive">
		<table class="table table-bordered table-hover text-center">
			<tr>
				<th></th>
				
				
<?php
$startMonth = date ( 'Y-m-01 00:00:00' );
$endMonth = date ( 'Y-m-d 23:59:59', strtotime ( date ( 'Y-m-1 00:00:00' ) . ' + 1 month -1 day' ) );


// $sts = ServiceType::model ()->findAll (array('order'=>'st_flag ASC'));
$sts = WashShopService::model()->getServices($shop['id'])['data'];
$criteria= new CDbCriteria();
$stIds=array();
foreach ($sts as $key=>$value){
	$stIds[]=$value['wss_st_id'];
}
$criteria->addInCondition('id',$stIds);
$criteria->order='st_flag ASC';
$sts = ServiceType::model()->findAll ($criteria);


foreach ( $sts as $key => $value ) :
	?>
<th><?php echo $value['st_name'];?></th>
<?php endforeach;?>

</tr>
			<tr>
				<td>今日新增</td>
				

<?php
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php
	// echo
$startToday = date ( 'Y-m-d 00:00:00' );
$endToday =date ( 'Y-m-d 23:59:59' );
	$rlt = OrderHistory::model ()->getOrderStatistics ($shop['id'], $startToday, $endToday, $value ['id'] );
	if ($rlt ['status']) {
		echo $rlt ['data'] ['totalCount'];
	} else {
		echo CJSON::encode ( $rlt );
	}
	
	?>
</td>
<?php endforeach;?>


</tr>
	<tr>
				<td>本月新增</td>
		
		
<?php
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php

	$rlt = OrderHistory::model ()->getOrderStatistics ( $shop['id'], $startMonth, $endMonth, $value ['id'] );
	if ($rlt ['status']) {
		echo $rlt ['data'] ['totalCount'];
	} else {
		echo CJSON::encode ( $rlt );
	}
	
	?>
</td>
<?php endforeach;?>


</tr>
<tr>
				<td>总订单</td>

		
<?php
$startMonth = '2014-01-01';
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php
	// echo
	
	$rlt = OrderHistory::model ()->getOrderStatistics ( $shop['id'], $startMonth, $endMonth, $value ['id'] );
	if ($rlt ['status']) {
		echo $rlt ['data'] ['totalCount'];
	} else {
		echo CJSON::encode ( $rlt );
	}
	
	?>
</td>
<?php endforeach;?>


</tr>
<tr>
				<td>总收入</td>

		
<?php
$startMonth = '2014-01-01';
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>
<i class="fa fa-jpy"></i>
<?php
	// echo
	
	$rlt = OrderHistory::model ()->getOrderStatistics ( $shop['id'], $startMonth, $endMonth, $value ['id'] );
	if ($rlt ['status']) {
		echo $rlt ['data'] ['totalValue'];
	} else {
		echo CJSON::encode ( $rlt );
	}
	
	?>
</td>
<?php endforeach;?>


</tr>
		</table>
	


</div>
</div> <!-- col-sm-6 -->
</div><!-- row -->
<div class="row">
	<div class="col-xs-6  col-sm-2 col-md-3 ">
					<div class="box box-solid">
						<div class="box-header">
							<h5 class="text-center">
								<a href="<?php echo Yii::app()->createUrl('boss/list'); ?>" >总订单
									<span class="badge bg-red">
<?php
$rlt = OrderHistory::model ()->getBossTotalCount ( $user ['id'] );
if ($rlt ['status']) {
	echo $rlt ['data'];
} else {
	echo '0';
}
?>
								</span>
								</a>
							</h5>
						</div>
					</div>
				</div>
<div class="col-xs-6  col-sm-3">
					<div class="box box-solid">
						<div class="box-header">
							<h5 class="text-center">
								<a href="<?php echo Yii::app()->createUrl('boss/list'); ?>">待确认订单
									<span class="badge bg-red">
<?php
$rlt = OrderHistory::model ()->getBossUnAckCount ( $user ['id'] );
if ($rlt ['status']) {
	echo $rlt ['data'];
} else {
	echo '0';
}
?>								
								</span>
								</a>
							</h5>
						</div>
					</div>
				</div>	
				<div class="col-xs-6 col-sm-3">
					<div class="box box-solid bg-yellow">
						<div class="box-header">
							<h5 class="text-center">
								<a href="<?php echo Yii::app()->createUrl('boss/card'); ?>"
									style="color: #ffffd8;">已用次卡 <span class="badge bg-red">
<?php
$rlt = Cardinvite::model ()->getBossOneCardCount ( $boss ['b_user_id'] );
if ($rlt ['status']) {
	echo $rlt ['data'];
} else {
	echo $rlt ['msg'];
}
?>								
								</span></a>
							</h5>
						</div>
					</div>
				</div>		<div class="col-xs-6 col-sm-4 col-md-3">
					<div class="box box-solid bg-yellow">
						<div class="box-header">
							<h5 class="text-center">
								<a href="<?php echo Yii::app()->createUrl('boss/card'); ?>"
									style="color: #ffffd8;">已用首次优惠卡 <span class="badge bg-red">
<?php

$rlt = Cardinvite::model ()->getBossDiscountCardCount ( $boss ['b_user_id'] );
if ($rlt ['status']) {
	echo $rlt ['data'];
} else {
	echo '0';
}
?>									
								</span></a>
							</h5>
						</div>
					</div>
				</div>		
</div> <!-- row -->
</div> <!-- col-sm-9 -->

</div>



<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smorder').addClass('active');
", CClientScript::POS_READY );

?>	
                
                
                
             
                
  
     
