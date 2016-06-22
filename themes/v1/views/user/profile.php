<?php
$this->pageTitle = '账户概览';
?>
<section class="content-header">
	<h1>账户概览</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i
				class="fa fa-dashboard"></i>我的账户</a></li>
		<li class="active">面板</li>
	</ol>
</section>



<!-- Main content -->
<section class="content">


<div class="row">
<div class="col-sm-3">
	<div class="row text-center ">
		<div class="col-xs-12 hidden-xs">
		
	<img style="width: 100%; height: 200px;"
					src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo4.png"
					alt="" />
		</div>
		
			<div class="col-xs-12">
				<div class="box box-solid bg-yellow">
					<div class="box-header">
						<h3 class="text-center white">
							<a href="<?php echo Yii::app()->createUrl('order/list');?>"
								style="color: white;"><strong>立即预定</strong></a>
						</h3>
					</div>
				</div>
			</div>
		
			
			</div>
	

</div>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-12">
<h4>
				<code><?php echo $user['u_tel'];?></code>
				您好！ <a href="<?php echo Yii::app()->createUrl('user/info');?>"><small>修改个人资料</small></a>
				<small class="pull-right hidden-xs">完善个人资料有积分奖励哦！</small>
			</h4>
</div>

</div>
<div class="row">
<div class="hidden-xs col-sm-6">
	<div class="small-box bg-blue">
						<div class="inner">
							<br> <br>
							<p>
								<a target="_blank"
									href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'level')); ?>"
									style="color: #ffffd8;">用户等级：<label class="label label-warning">LV1</label></a>
							</p>
							<p>当前积分为 <?php echo $user['u_score'];?>，再获得<?php
							$getLeveRlt = UScore::getLevel ( $user ['u_score'] );
							echo $getLeveRlt ['data'] ['next'] - $user ['u_score'];
							?>积分即可升级为LV2
							</p>
							<br> <br>

						</div>
					</div>
</div>
<div class="col-sm-6">
	<div class="row">
	<div class="col-xs-6">
	<div class="small-box bg-red ">

						<div class="inner">
							<sup style="font-size: 14px;">距上次洗车</sup>
							<p class="text-center">
							<?php
							$xiche = OrderHistory::model ()->getLatestOrder ( Yii::app ()->user->id, 1 );
							if ($xiche ['status']) :
								?>
							<strong>
<?php
								$start = date_create ( $xiche ['data'] ['oh_date_time'] );
								$end = date_create ();
								$interval = date_diff ( $start, $end );
// 								echo var_dump($start);
								if($xiche['data']['oh_state'] == 1 && $xiche['data']['oh_user_ack']==0){
									echo '预约中 '.date('m月d日',strtotime($xiche ['data'] ['oh_date_time']));
								}else{
									echo $interval->format ( '%a天' );}
// 								echo $interval->format ( '%d' );
								
								?>
							</strong>
							<?php else:?>
							立即洗车？<a
									href="<?php echo Yii::app()->createUrl('order/list');?>"> <i
									class="fa  fa-arrow-right"></i></a>
						
							<?php endif;?>
								
							</p>

						</div>
					</div>
	</div>
	<div class="col-xs-6">
		
					<div class="small-box bg-red ">
						<div class="inner">
							<sup style="font-size: 14px;">距上次打蜡</sup>
							<p class="text-center">
							<?php
							$xiche = OrderHistory::model ()->getLatestOrder ( Yii::app ()->user->id, 3 );
							if ($xiche ['status']) :
								?>
							<strong>
<?php
								$start = date_create ( $xiche ['data'] ['oh_date_time'] );
								$end = date_create ();
								$interval = date_diff ( $start, $end );
								if($xiche['data']['oh_state'] == 1 && $xiche['data']['oh_user_ack']==0){
									echo '预约中 '.date('m月d日',strtotime($xiche ['data'] ['oh_date_time']));
								}else{
									echo $interval->format ( '%a天' );}
						
								
								?>
							</strong>
							<?php else:?>
							立即体验？<a
									href="<?php echo Yii::app()->createUrl('order/list');?>"> <i
									class="fa  fa-arrow-right"></i></a>
							</p>
							<?php endif;?>
								
							</p>
						</div>
					</div>
	</div>
					
			
				</div>
<div class="row">
<div class="col-xs-6">
<div class="small-box bg-red">
						<div class="inner">
							<sup style="font-size: 14px;">距上次精洗</sup>
							<p class="text-center">
							<?php
							$xiche = OrderHistory::model ()->getLatestOrder ( Yii::app ()->user->id, 5 );
							if ($xiche ['status']) :
								?>
							<strong>
<?php
								$start = date_create ( $xiche ['data'] ['oh_date_time'] );
								$end = date_create ();
								$interval = date_diff ( $start, $end );
								if($xiche['data']['oh_state'] == 1 && $xiche['data']['oh_user_ack']==0){
									echo '预约中 '.date('m月d日',strtotime($xiche ['data'] ['oh_date_time']));
								}else{
								echo $interval->format ( '%a天' );}
								
								?>
							</strong>
							<?php else:?>
							立即精洗？<a
									href="<?php echo Yii::app()->createUrl('order/list');?>"> <i
									class="fa  fa-arrow-right"></i></a>
							</p>
							<?php endif;?>
								
							</p>
						</div>
					</div>
</div>

<div class="col-xs-6">
		<div class="small-box bg-red">
						<div class="inner">
							<sup style="font-size: 14px;">为您节省</sup>
							<p class="text-center">
								<strong>¥ <?php
								$criteria = new CDbCriteria ();
								$criteria->select = 'sum(oh_value_discount) as totalValue';
								$criteria->addCondition ( 'oh_user_id=:uid' );
								$criteria->params [':uid'] = Yii::app ()->user->id;
								$criteria->addCondition ( 'oh_state = 2' );
								$m = OrderHistory::model ()->find ( $criteria );
								
								if (empty ( $m->totalValue )) {
									echo '0';
								} else {
									echo $m->totalValue;
								}
								?></strong> 元
							</p>
						</div>
					</div>
</div>
</div>


</div>
</div>
<div class="row">
	<div class="col-xs-6  col-sm-3">
					<div class="box box-solid">
						<div class="box-header">
							<h5 class="text-center">
								<a href="<?php echo Yii::app()->createUrl('user/list'); ?>">总订单:
									<span class="badge bg-red">
<?php
$rlt = OrderHistory::model ()->getUserTotalCount ( $user ['id'] );
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
								<a href="<?php echo Yii::app()->createUrl('user/list'); ?>">待确认订单:
									<span class="badge bg-red">
<?php
$rlt = OrderHistory::model ()->getUserUnAckCount ( $user ['id'] );
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
								<a href="<?php echo Yii::app()->createUrl('user/card'); ?>"
									style="color: #ffffd8;">已用次卡: <span class="badge bg-red">
<?php
$rlt = Cardinvite::model ()->getUserOneCardCount ( Yii::app()->user->id );
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
				</div>		<div class="col-xs-6 col-sm-3">
					<div class="box box-solid bg-yellow">
						<div class="box-header">
							<h5 class="text-center">
								<a href="<?php echo Yii::app()->createUrl('user/card'); ?>"
									style="color: #ffffd8;">已用首次优惠卡: <span class="badge bg-red">
<?php

$rlt = Cardinvite::model ()->getUserDiscountCardCount (Yii::app()->user->id );
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

	
  

</section>
<!-- /.content -->
<?php
Yii::app ()->clientScript->registerScript ( 'ready', "
		 $('#menuProfile').addClass('active');	
", CClientScript::POS_READY );
?>
