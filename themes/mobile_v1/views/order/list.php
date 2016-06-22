<?php
$this->pageTitle = '车行列表';
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/mobile.css" );
?>
<?php
// $shopList = $shopList['content'];
foreach ( $shopList as $key => $shop ) :
	?>
<div class="row" style="border-bottom: 1px solid #eee; padding: 10px;">

	<div class="col-xs-4">
		<a
			href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']));?>"><img
			class="img-responsive" style="width: 100%; height: 60px;"
			src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $shop['id'];?>/shop<?php echo $shop['id'];?>.jpg" /></a>
	</div>
	<div class="col-xs-8">
		<a
			href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']));?>"
			style="font-size: 15px;"><strong><?php echo $shop['name'];?></strong></a>
		<code><?php echo round(4.55,1,PHP_ROUND_HALF_UP);?>分</code>
		<br> <small>地址：<?php echo $shop['address'];?>
		<?php
	// echo UMap::getLocationDistance('123.331567,41.806402',50000,0,5,null,null);
	?></small> <br> <strong><small>洗车 <span class="text-yellow"> <?php
	$queryRlt = WashShop::model ()->getBasicInfobyType ( WashShop::model ()->findByPk ( $shop ['id'] ), 1, 0, false );
	if ($queryRlt ['status']) {
		echo $queryRlt ['data'] ['minValue'];
	} else {
		echo '30';
	}
	?></span>元起
		</small></strong> <small class="text-red pull-right"> <strong>
<?php
	$distance = $shop ['distance'];
	if ($distance < 100) {
		echo '100米以内';
	} elseif ($distance < 1000) {
		
		echo round ( $distance, 0, PHP_ROUND_HALF_UP ) . '米';
	} else {
		echo round ( $distance / 1000, 1, PHP_ROUND_HALF_DOWN ) . '公里';
	}
	// echo $distance;
	?></strong></small>
	</div>
</div>

<?php endforeach;?>
