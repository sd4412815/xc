<?php
$this->pageTitle = '我的账户';
?>
<section class="content-header">
	<h1>

<?php
echo $shop ['ws_name'];
?>
		<small><?php echo $shop['ws_address'];?></small>
	</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('boss/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">面板</li>
	</ol>
</section>
<section class="content">








<?php
if (Yii::app ()->user->hasFlash ( 'onlineMsg' )) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('onlineMsg');?></div>
<?php endif;?>

<?php  if ($shop['ws_state'] == 2){
	$this->renderPartial('_profile_wellcome',array('shop' => $shop,
'boss' => $boss));
}

?>

<?php  if ($shop['ws_state'] == 1):?>

	<div class="row">

		<div class="col-sm-12">
			<div class="box box-warning">
				<div class="box-header">
					<i class="fa fa-bullhorn"></i>
					<h3 class="box-title">公告板</h3>
					<div class="pull-right box-tools">
						<button class="btn btn-info btn-sm" data-widget="remove"
							data-toggle="tooltip" title data-original-title="隐藏">
							<i class="fa fa-times"></i>
						</button>
					</div>
				</div>

				<div class="box-body">
				
<?php if ($shop['ws_level'] == 0 && 0):?>	<div class="callout callout-danger">
						<p>
							<code>收费版</code>
							提供更高效的营销服务，可以获得更好的经营效果 <a
								href="<?php echo Yii::app()->createUrl('boss/service');?>"
								class="btn btn-primary btn-sm">了解更多</a> <a
								href="<?php echo Yii::app()->createUrl('boss/service');?>"
								class="btn btn-warning btn-lg">去购买</a>
						</p>
						<p>
					
					</div>
<?php endif;?>


<div class="callout callout-info">
						<p>今日预约：<a href="<?php 
if ($shop['ws_level']>0) {
	echo  Yii::app()->createUrl('boss/realTimelist');
}else{
	echo Yii::app()->createUrl('boss/list');
}						
						?>">
<code>
<?php 
$startMonth = date ( 'Y-m-d 00:00:00' );
$endMonth = date ( 'Y-m-d 23:59:59');
$rlt = OrderHistory::model ()->getOrderStatistics ( $shop ['id'], $startMonth, $endMonth, 0,false );
if ($rlt ['status']) {
	echo $rlt ['data'] ['totalCount'];
} else {
	echo 0;
}
?>
</code> </a>	


三日之内预约：<a href="<?php echo Yii::app()->createUrl('boss/list')?>">
<code>
<?php 
$startMonth = date ( 'Y-m-d 00:00:00' );
$endMonth = date ( 'Y-m-d 23:59:59', strtotime (  ' + 2 day' ) );
$rlt = OrderHistory::model ()->getOrderStatistics ( $shop ['id'], $startMonth, $endMonth, 0,false );
if ($rlt ['status']) {
	echo $rlt ['data'] ['totalCount'];
} else {
	echo '0';
}
?>
</code> </a>						
						</p>
					</div>					
					
		<div class="callout callout-info">
					
							<p>
							有效订单<code>
<?php 
$rlt = OrderHistory::model()->getBossTotalCount($boss['b_user_id']);
if ($rlt['status']){
	echo $rlt['data'];
}else{
	echo '0';
}				
// echo CJSON::encode($rlt);			
							?></code>
							
						
							历史车主<code>
<?php 
$rlt = OrderHistory::model()->getBossTotalUser($boss['b_user_id']);
if ($rlt['status']){
	echo $rlt['data'];
}else{
	echo '0';
}				
// echo CJSON::encode($rlt);			
							?></code>
							
						
							会员数量<code>
<?php 
$rlt = OrderHistory::model()->getBossTotalMember($boss['b_user_id']);
if ($rlt['status']){
	echo $rlt['data'];
}else{
	echo '0';
}				
// echo CJSON::encode($rlt);			
							?>							</code>
							
						</p>
					</div>
				</div>
			</div>


		</div>

	</div>

	<!-- /.row -->

<?php endif;?>

<?php
$this->renderPartial ( '_profile', array (
		'shop' => $shop,
		'boss' => $boss ,
// 'upload'=>$upload
) );
?>  
</section>






