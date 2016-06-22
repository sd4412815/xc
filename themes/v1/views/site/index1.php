<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app ()->name;
?>
<section class="content">
	<div class="row">
		<div class="col-sm-6">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">预约服务类型</h3>
				</div>
				<div class="box-body chart-responsive">
					<?php

$cid = UPlace::getCityId();					
$sts = ServiceType::model()->findAll();
$dataArray=array();
$total = 0;
foreach ($sts as $key=>$st){
	$stvalue =OrderHistory::model()->getOrderStatisByCity($cid, $st['id']); 
	$total += $stvalue;
	$dataArray[]=array('label'=>$st['st_name'],
			'value'=>$stvalue);
}
if ($total==0) {
	$total=1;
}

foreach ($dataArray as $key=>$sd){
	$dataArray[$key]['value'] =round($sd['value']/$total*100,1);
}

				$this->widget ( 'ext.morris.MorrisChartWidget', array (
							'id' => 'myChartElement',
							'options' => array (
									'chartType' => 'Donut',
									'data' => $dataArray,
									
									'colors' => array (
											"#3c8dbc",
											"#f56954",
											"#00a65a" 
									) ,
									'formatter' => "js:function (y,data) { return y+'%';}",
							)
							 
					) );
?>					
					
					
				</div>
			
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<div class="col-sm-6">
			<div class="box box-danger col-md-6">
				<div class="box-header">
					<h3 class="box-title">最满意车行</h3>
				</div>
				<div class="box-body">
					<?php 
					$shops = WashShop::model()->getTopWSs(10, $cid);
					foreach ($shops as $key=>$shop):
					?>
					<a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']));?>">
<?php echo $shop['ws_name'];?>					</a><?php echo $shop['ws_score'];?> <br>
<?php endforeach;?>		
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
	<!-- /.row -->

</section>

<div class="row">
	<div class="col-xs-3  col-sm-3 text-center">
		<a
			href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'card'));?>"><img
			src="<?php echo Yii::app()->theme->baseUrl;?>/img/youhui.png"
			alt="优惠卡" class="img-circle" title="优惠卡" /></a>
		<p>
			<a href="#"><strong>优惠卡</strong></a>
		</p>

	</div>

	<div class="col-xs-3  text-center">
		<a href="#"><img
			src="<?php echo Yii::app()->theme->baseUrl;?>/img/jia1.png" alt="加盟"
			class="img-circle" title="加盟我们" /></a>
		<p>
			<a href="#"><strong>加盟我们</strong></a>
		</p>
	</div>

	<div class="col-xs-3 text-center">
		<a href="#"><img
			src="<?php echo Yii::app()->theme->baseUrl;?>/img/help.png" alt="帮助"
			class="img-circle" title="使用帮助" /></a>
		<p>
			<a href="#"><strong>使用帮助</strong></a>
		</p>
	</div>
	<div class="col-xs-3 text-center">
		<a href="#"><img
			src="<?php echo Yii::app()->theme->baseUrl;?>/img/app.png" alt="客户端"
			class="img-circle" title="手机APP" /></a>
		<p>
			<a href="#"><strong>手机应用</strong></a>
		</p>
	</div>
</div>
<!-- row -->






<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhome').addClass('active');
", CClientScript::POS_READY );

?>
   
   