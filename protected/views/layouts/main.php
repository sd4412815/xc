<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
<title><?php echo CHtml::encode($this->pageTitle).'-'.Yii::app ()->name; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<meta name="Keywords" content="洗车,打蜡,精洗,预约,优惠,省时,洗车位,免排队,我洗车"> 
<meta name="description" content="我洗车,全车洗车位预约系统，不用排队，尊享爱车养护服务，省钱，省时，就来我洗车.com！"> 
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/bootstrap.min.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/AdminLTE.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/font-awesome.min.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/custom.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END);

?>
</head>
<body class="container-fluid">
   <div class="row">
        <div class="col-sm-offset-2 col-sm-10">
			<a href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img style="max-height:80px;" 
			src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo.png" /></a>
		</div>
	
	</div>
	
<div class = "container">
<div>
<?php
echo $content; 
?>
</div>        
</div> <!-- end of container -->
  <!-- footer -->
<div class="row">
<div class="col-sm-12 text-center">
	  <p>    <a href="<?php echo Yii::app()->createUrl('site/index'); ?>">沈阳喜车商务服务有限公司 </a> 版权所有 Copyright &copy;   <?php echo date('Y');?>   All Rights Reserved.</p>
		<p>  <a href="http://www.miitbeian.gov.cn" target="_blank">辽ICP备14013410号</a></p>
</div>
</div> <!-- end of row footer -->         

 <div style="display: none">
 <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1254078506'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1254078506%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
 </div>
</body>
</html>
   <?php 
// Yii::app()->clientScript->registerScript('inputMask',
// "
// 		 $('input').iCheck({
//     checkboxClass: 'icheckbox_square-green',
//     radioClass: 'iradio_square-green',
// 		cursor:true,
//     increaseArea: '20%' // optional
//   });
// $(':input').inputmask();
// ",CClientScript::POS_READY);
?>
