<?php
// 直接输出当前城市位置信息
?>
<header class="main-header">
	<nav class="navbar navbar-static-top" style="min-height: 30px;padding:3px 5px 0px 0;">
			<span class="pull-left"> <span class="btn btn-flat"
		style="border: 0px; color: #fff;font-size:18px;">
<?php
echo $this->shopName;
?></span></span> <span class="pull-right">	<a href="
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
							</a></span>
	</nav>
</header>