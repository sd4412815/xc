<?php
// 直接输出当前城市位置信息
?>
<header class="main-header">
	<nav class="navbar navbar-static-top" style="min-height: 30px;">
		<div class="container-fluid">
			<div class="row" style="margin:3px -25px 3px 0">
				<div class="col-xs-3 col-sm-1 text-center">
					
						<a href="<?php echo Yii::app()->createUrl('site/setCity'); ?>"
							class="btn btn-warning btn-flat" style="border: 0px; margin-left:-30px;"><i
							class="fa  fa-map-marker"></i> <span id="current_city_name">
<?php
$cityId = UPlace::getCityId ();
$city = City::model ()->findByPk ( $cityId );
if (isset ( $city )) {
	echo $city ['c_name'];
} else {
	echo '选择';
}
?></span> <span class="caret"></span></a>
					
				</div>
				<div class="col-xs-9 col-sm-11 text-right ">
					<div class="input-group">
						<span
							class="input-group-btn">
							<a href="
<?php
$backUrl = 	Yii::app()->request->urlReferrer;
$currentUrl = Yii::app()->request->hostInfo.Yii::app()->request->url;
if ($backUrl == $currentUrl){
	echo Yii::app()->homeUrl;
}else {
	echo Yii::app()->request->urlReferrer;
}

?>" type="button" class="btn btn-info btn-flat">
								<i class="fa fa-arrow-left"></i> 返回 
							</a>
						</span>
					</div>
				</div>
			</div>










		</div>

		<!-- /.container-fluid -->
	</nav>
</header>