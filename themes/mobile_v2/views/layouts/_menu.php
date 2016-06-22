<?php
// 直接输出当前城市位置信息
?>
<header class="main-header">
	<nav class="navbar navbar-static-top " style="min-height: 30px;">
		
		
		<div class="container-fluid">
			<div class="row" style="margin: 3px -25px 3px 0">
				<div class="col-xs-3 col-sm-1 text-center">

					<a href="<?php echo Yii::app()->createUrl('site/setCity'); ?>"
						class="btn btn-warning btn-flat"
						style="border: 0px; margin-left: -30px;"><i
						class="fa  fa-map-marker"></i><span id="currentCity">
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
					<div class="input-group ">
						<input type="text" id="sQ" class="form-control"
							placeholder="门店名、商圈、关键字"> <span class="input-group-btn">
							<button type="button" class="btn btn-info btn-flat" onclick="list_search();">
								<i class="fa fa-search"></i> 查找
							</button>
						</span>
					</div>
				</div>
			</div>

		</div>
		<!-- /.container-fluid -->
	</nav>
</header>
<?php  
Yii::app()->clientScript->registerScript(
'searchBtn',
'	$.cookie("sQ", $("#sQ").val(), {
		expires : 1,
		path : "/"
	});',
CClientScript::POS_READY
);
?>