<?php
$this->pageTitle = '我的账户';
?>
<section class="content-header">
	<h1>

<?php
echo $user['u_tel']
?><span class="badge"><?php

?></span> <small><?php echo date('Y年m月d日');?></small>
	</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('mngr/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">面板</li>
	</ol>
</section>
<section class="content">
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

					<div class="callout callout-info">
						<p>
							今日预约<a
								href="<?php
								echo Yii::app ()->createUrl ( 'mngr/orderList' );
								?>"> <code>
<?php
$startMonth = date ( 'Y-m-d 00:00:00' );
$endMonth = date ( 'Y-m-d 23:59:59');
// $endMonth = date ( 'Y-m-d 23:59:59' );
$rlt = OrderHistory::model ()->getOrderStatistics ( 0, $startMonth, $endMonth, 0, false );
if ($rlt ['status']) {
	echo $rlt ['data'] ['totalCount'];
} else {
	echo 0;
}
?>
</code>
							</a> 三日之内预约<a
								href="<?php echo Yii::app()->createUrl('mngr/orderList')?>"> <code>
<?php
$startMonth = date ( 'Y-m-d 00:00:00' );
$endMonth = date ( 'Y-m-d 23:59:59', strtotime ( ' + 2 day' ) );
$rlt = OrderHistory::model ()->getOrderStatistics ( 0, $startMonth, $endMonth, 0, false );
if ($rlt ['status']) {
	echo $rlt ['data'] ['totalCount'];
} else {
	echo '0';
}
?>
</code>
							</a>
					
						</p>
					</div>
<div class="callout callout-info">
						<p>

在线用户 <code><?php echo Yii::app()->userCounter->getOnline(); ?></code>
今日 <code><?php echo Yii::app()->userCounter->getToday(); ?></code>
昨日 <code><?php echo Yii::app()->userCounter->getYesterday(); ?></code>
总计 <code><?php echo Yii::app()->userCounter->getTotal(); ?></code>
单日最多 <code><?php echo Yii::app()->userCounter->getMaximal(); ?></code>
最多日期 <code><?php echo date('Y-m-d', Yii::app()->userCounter->getMaximalTime()); 
?></code>							
						</p></div>

				</div>
			</div>


		</div>

	</div>

	<!-- /.row -->
	<div class="table-responsive">
		<table class="table table-bordered table-hover text-center">
			<tr>
				<th></th>
				<th>用户</th>
				<th>车行</th>
<?php
$startMonth = date ( 'Y-m-01 00:00:00' );
$endMonth = date ( 'Y-m-d 23:59:59', strtotime ( date ( 'Y-m-1 00:00:00' ) . ' + 1 month -1 day' ) );
// $monthBegin =  date ( 'Y-m-1 00:00:00' );;
// $monthEnd =  date ( 'Y-m-d 23:59:59',strtotime(date('Y-m-1').'+1 months -1 days') );
$sts = ServiceType::model ()->findAll (array('order'=>'st_flag ASC'));
foreach ( $sts as $key => $value ) :
	?>
<th><?php echo $value['st_name'];?></th>
<?php endforeach;?>

</tr>
			<tr>
				<td>今日新增</td>
				<td>
<?php

$startToday = date ( 'Y-m-d 00:00:00' );
$endToday =date ( 'Y-m-d 23:59:59' );
$criteria = new CDbCriteria ();
$criteria->addCondition('u_type=0');
$criteria->addCondition ( 'u_join_date>:todayBegin' );
$criteria->params [':todayBegin'] =$startToday;
$criteria->addCondition ( 'u_join_date<:todayEnd' );
$criteria->params [':todayEnd'] = $endToday;
$todayUser = User::model ()->count ( $criteria );
echo $todayUser;
?>
</td>
				<td>
<?php
$criteria = new CDbCriteria ();
// $criteria->addCondition('ws_state')
$criteria->addCondition ( 'ws_join_date>:todayBegin' );
$criteria->params [':todayBegin'] = $startToday;
$criteria->addCondition ( 'ws_join_date<:todayEnd' );
$criteria->params [':todayEnd'] =$endToday;
$todayShop = WashShop::model ()->count ( $criteria );
echo $todayShop;
?>
</td>
<?php
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php
	// echo
	
	$rlt = OrderHistory::model ()->getOrderStatistics ( 0, $startToday, $endToday, $value ['id'] );
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
				<td>
<?php

$criteria = new CDbCriteria ();
$criteria->addCondition ( 'u_join_date>:monthBegin' );
$criteria->params [':monthBegin'] =$startMonth;
$criteria->addCondition ( 'u_join_date<:monthEnd' );
// echo  date ( 'Y-m-d 23:59:59',strtotime('+1 months -1 days') );
$criteria->params [':monthEnd'] =$endMonth;
// echo  $criteria->params [':todayEnd'] ;
$monthUser = User::model ()->count ( $criteria );
echo $monthUser;
?>
</td>
				<td>
<?php
$criteria = new CDbCriteria ();
$criteria->addCondition('ws_state>=0');
$criteria->addCondition ( 'ws_join_date>:monthBegin' );
$criteria->params [':monthBegin'] = $startMonth;
$criteria->addCondition ( 'ws_join_date<:monthEnd' );
$criteria->params [':monthEnd'] = $endMonth;
$monthShop = WashShop::model ()->count ( $criteria );
echo $monthShop;
?>
</td>
<?php
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php
	// echo
	
	$rlt = OrderHistory::model ()->getOrderStatistics ( 0, $startMonth, $endMonth, $value ['id'] );
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
				<td>总计</td>
				<td>
<?php
// $startMonth = '2014-01-01';

$criteria = new CDbCriteria ();
// $criteria->addCondition ( 'u_join_date>:monthBegin' );
// $criteria->params [':monthBegin'] =$startMonth;
$criteria->addCondition ( 'u_join_date<:monthEnd' );
// echo  date ( 'Y-m-d 23:59:59',strtotime('+1 months -1 days') );
$criteria->params [':monthEnd'] =$endMonth;
// echo  $criteria->params [':todayEnd'] ;
$monthUser = User::model ()->count ( $criteria );
echo $monthUser;
?>
</td>
				<td>
<?php
$criteria = new CDbCriteria ();
$criteria->addCondition('ws_state>=0');
// $criteria->addCondition ( 'ws_join_date>:monthBegin' );
// $criteria->params [':monthBegin'] = $startMonth;
// $criteria->addCondition ( 'ws_join_date<:monthEnd' );
// $criteria->params [':monthEnd'] = $endMonth;
$totalShop = WashShop::model ()->count ( $criteria );
echo $totalShop;
?><code>
<?php
$criteria->addCondition('ws_state=1');
// $criteria = new CDbCriteria();
// $criteria->

echo  WashShop::model ()->count ( $criteria );?></code>
</td>
<?php
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php
	// echo
	$startIni = '2014-01-01';
	$rlt = OrderHistory::model ()->getOrderStatistics ( 0, $startIni, date('Y-m-d 23:59:59',time()+3*23*3600), $value ['id'] ,false);
	if ($rlt ['status']) {
		echo $rlt ['data'] ['totalCount'];
	} else {
		echo CJSON::encode ( $rlt );
	}
	
	?>
</td>
<?php endforeach;?>


</tr>
		</table>
	</div>

	
<div class="table-responsive">
		<table class="table table-bordered table-hover text-center">
			
			
			
			<tr>
				<th></th>
				<th>车行总数</th>
				<th>在线车行</th>
				<th>本月增加车行</th>
				<?php 
				foreach ( $sts as $key => $value ) :
				?>
				<th><?php echo $value['st_name'];?></th>
				<?php endforeach;?>
			
				
			
</tr>
<?php 
$criteriaCity = new CDbCriteria();
$criteriaCity->addCondition('c_state>=0');
$criteriaCity->order = 'c_province_id ASC, c_state DESC, c_spell ASC';
$cityList = City::model()->findAll($criteriaCity);
foreach ($cityList as $key=>$city):

$criteriaShop = new CDbCriteria ();
$criteriaShop->addCondition('ws_state>=0');
$criteriaShop->addCondition('ws_city_id=:cid');
$criteriaShop->params[':cid']=$city['id'];

$totalShop = WashShop::model ()->count ( $criteriaShop );
if ($totalShop<1){continue;}

?>
<tr>
<td>
<?php 
echo $city['c_name'];
?>
</td>
<td>
<?php 
// $criteriaShop = new CDbCriteria ();
// $criteriaShop->addCondition('ws_state>=0');
// $criteriaShop->addCondition('ws_city_id=:cid');
// $criteriaShop->params[':cid']=$city['id'];

// $totalShop = WashShop::model ()->count ( $criteriaShop );
echo $totalShop;
$criteriaShop->addCondition ( 'ws_join_date>:monthBegin' );
$criteriaShop->params [':monthBegin'] = $startMonth;
$criteriaShop->addCondition ( 'ws_join_date<:monthEnd' );
$criteriaShop->params [':monthEnd'] = $endMonth;
// $criteriaShop->addCondition('ws_state>=0');

$monthShop=WashShop::model ()->count ( $criteriaShop );
?>


</td>

<td>
<?php 
$criteriaOnlineShop = new CDbCriteria();
$criteriaOnlineShop->addCondition('ws_city_id=:cid');
$criteriaOnlineShop->params[':cid']=$city['id'];


$criteriaOnlineShop->addCondition('ws_state=1');
$onlineShop = WashShop::model ()->count ( $criteriaOnlineShop );
echo $onlineShop;

?>
</td>
<td>
<?php 
// $criteriaShop->addCondition ( 'ws_join_date>:monthBegin' );
// $criteriaShop->params [':monthBegin'] = $startMonth;
// $criteriaShop->addCondition ( 'ws_join_date<:monthEnd' );
// $criteriaShop->params [':monthEnd'] = $endMonth;
// // $criteriaShop->addCondition('ws_state>=0');

// $monthShop=WashShop::model ()->count ( $criteriaShop );
echo $monthShop;
?>
</td>
<?php
// $sts=ServiceType::model()->findAll();
foreach ( $sts as $key => $value ) :
	?>
<td>

<?php
	// echo
	
	$rlt = OrderHistory::model ()->getOrderStatisByCity($city['id'], $value['id'],false);
	echo $rlt;
// 	if ($rlt ['status']) {
// 		echo $rlt ['data'] ['totalCount'];
// 	} else {
// 		echo CJSON::encode ( $rlt );
// 	}
	
	?>
</td>
<?php endforeach;?>

</tr>

<?php endforeach;?>


	

		</table>
	</div>
<?php
// $this->renderPartial ( '_profile', array (
// 		'shop' => $shop,
// 		'boss' => $boss 
// ) );
?>  
</section>






