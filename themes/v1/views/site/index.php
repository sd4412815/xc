<?php
/* @var $this SiteController */
$this->pageTitle = '首页';
$cid = UPlace::getCityId ();
?>


<div>
	<div class="row">
		<div id="carousel-example-generic" class="carousel slide"
			data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0"
					class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<a href="<?php echo Yii::app()->createUrl('order/list');?>"> <img
						src="<?php echo Yii::app()->theme->baseUrl;?>/img/pic3.jpg" width="100%"
						alt="..."></a>
				</div>
				<div class="item">
					<a href="<?php echo Yii::app()->createUrl('site/joinus');?>"> <img
						src="<?php echo Yii::app()->theme->baseUrl;?>/img/pic2.jpg" width="100%"
						alt="..."></a>

				</div>
				<div class="item">
					<a href="<?php echo Yii::app()->createUrl('order/list');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/pic1.jpg" width="100%"
						alt="..."></a>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- row轮播结束-->





<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhome').addClass('active');
", CClientScript::POS_READY );

?>
   
   