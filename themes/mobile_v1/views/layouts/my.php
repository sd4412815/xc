<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
<title><?php echo CHtml::encode($this->pageTitle).'-'.Yii::app ()->name; ?></title>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="IE=edge">
<meta name="baidu-site-verification" content="0S1m86jlX6" />
<meta name="renderer" content="webkit">
<meta name="viewport"
	content="width=device-width, initial-scale=1,user-scalable=no">
<meta name="Keywords" content="洗车,打蜡,精洗,预约,优惠,省时,洗车位,免排队,我洗车">
<meta name="description"
	content="我洗车,中国首家全国洗车预约系统，洗车行全网营销系统领航者，告别排队，尽享爱车养护服务，省钱，省时，就来我洗车.com！">
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="shortcut icon"
	href="<?php echo Yii::app()->baseUrl;?>/favicon.ico"
	type="image/x-icon" />
<?php
Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/y.css" );

Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.js", CClientScript::POS_END);
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
?>
</head>

<body>
	<div class="container-fluid">
<?php if(Yii::app()->user->hasFlash('weixinAutologin')):?> 
<div class="row text-center alert-danger falshInfo" >
<?php echo Yii::app()->user->getFlash('weixinAutologin'); ?>
</div>
<?php endif; ?>
		<div class="row" style="background: #f8981d;">
		     <div class="col-xs-3">
		          <a href="#"><h5 class="text-white text-center"><span class="glyphicon glyphicon-chevron-left"></span></h5></a> 
		     </div>
			 <div class="col-xs-6">
		          <h5 class="text-white text-center">我的收藏</h5>
		     </div>
		</div>

<?php

echo $content;
?>

</div>

</body>

</html>
<?php  //这是一段,在显示后定里消失的JQ代码,已集成至Yii中.
Yii::app()->clientScript->registerScript(
'myHideEffect',
// '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
'$(".falshInfo").slideUp(2500);',
CClientScript::POS_READY
);
?>