<?php /* @var $this Controller */ ?>
<!DOCTYPE HTML>
<html lang="zh-CN">
<head>

<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">

<!-- jQuery -->
<?php
 Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/bootstrap.min.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/bootstrap-datetimepicker.min.css");


// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/font-awesome.min.css");
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/ichecksquare/green.css");

// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/jquery.raty.css");
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/ystep.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/style.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/custom.css");
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END);

// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/bootstrap-datetimepicker.min.js", CClientScript::POS_HEAD);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/laydate/laydate.js", CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.pin.js", CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/ystep.js", CClientScript::POS_END);

// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.inputmask.js", CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.inputmask.date.extensions.js", CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.inputmask.extensions.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END);

?>

<style>
@font-face {font-family: 'iconfont';
    src: url('iconfont.eot'); /* IE9*/
    src: url('iconfont.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
    url('iconfont.woff') format('woff'), /* chrome、firefox */
    url('iconfont.ttf') format('truetype'), /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
    url('iconfont.svg#uxiconfont') format('svg'); /* iOS 4.1- */
}
.iconfont{
    font-family:"iconfont" !important;
    font-size:18px;font-style:normal;
	color:#333333;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
    -moz-osx-font-smoothing: grayscale;}
body { 
     font-family: "Times New Roman", 
	 "Microsoft YaHei", "微软雅黑", 
	 STXihei, "华文细黑", 
	 serif;
}	
</style>
</head>



<body >

        <div id="preloader">

            <div id="status">&nbsp;</div>

            <noscript>JS脚本已禁用，请启用以访问本站全部内容.</noscript>

        </div>
	
<div class = "container">

   <div class="row">
     
	  <div class="col-xs-12 col-sm-8">
     <!--      <iframe allowtransparency="true" frameborder="0" width="600" height="20" scrolling="no" 
		  src="http://tianqi.2345.com/plugin/widget/index.htm?s=3&z=1&t=0&v=0&d=3&bd=0&k=&f=000000&q=1&e=1&a=1&c=54342&w=600&h=20&align=left"></iframe>	  
		   -->
	  </div>
	  <div class="col-xs-12 col-sm-4" style="text-align:right;">
			   <a href="#" style="font-weight:bold;font-size:12px;">加为首页&nbsp; </a>
			   <a href="#" style="font-weight:bold;font-size:12px;">收藏本页&nbsp; </a>
			   <a href="#" style="font-weight:bold;font-size:12px;">在线留言</a>
	  </div>
   </div>
   
      <!-- logo and banner -->
   <div class="row">
        <div class="col-xs-12">
		        <img style="height:80px;" src="<?php echo Yii::app()->theme->baseUrl;?>/img/banner6.png" />  
				 </div>
		<div class="col-xs-12 col-sm-9">
		     <!--      <img style="max-width:100%;min-width:50%;" src="<?php echo Yii::app()->theme->baseUrl;?>/img/banner4.png" />  -->
		</div>
		    
	    
   </div>
   
    <!--导航条 max-width:100%;min-width:50%;-->

        	<nav class="navbar navbar-inverse" role="navigation">
	   <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse"  data-target="#example-navbar-collapse">
			 <span class="sr-only">切换导航</span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
		  </button>
		  <a style="font-weight:bold;" class="navbar-brand" href="<?php echo Yii::app()->createUrl('site/index');?>">www.我洗车.com</a>
	   </div>
    <div class="collapse navbar-collapse" id="example-navbar-collapse">
     <ul class="nav navbar-nav">
							<li id="menu-home"><a href="<?php echo Yii::app()->createUrl('site/index');?>" style="color:#ffffff;font-weight:bold;">首 页</a></li>
							<li id="menu-joinus"><a href="<?php echo Yii::app()->createUrl('order/list');?>" >列表预定</a></li>
								<li id="menu-joinus"><a href="<?php echo Yii::app()->createUrl('order/map');?>" >地图预定</a></li>
						
						
							<li id="menu-joinus"><a href="<?php echo Yii::app()->createUrl('site/joinus');?>" >车行加盟</a></li>
						
							<li id="menu-about"><a href="<?php echo Yii::app()->createUrl('site/about');?>" >关于我们</a></li> 	
                        </ul>
                       <!-- <button type="button" class="btn btn-default navbar-btn ">登录</button> -->
					   <ul class="nav navbar-nav navbar-right">
					        <p class="navbar-text" style="color:#ffffff;font-weight:bold;">
					    <?php 
					    
					    $criteria=new CDbCriteria();
					    $criteria->addCondition('ot_state=1');
					    $criteria->addCondition('ot_date_time>:ctime');
					    $criteria->params['ctime']=date('H:i');
					    $available =OrderTemp::model()->count($criteria);
					    
					    	$total =OrderTemp::model()->count();


					    ?>    
					        剩余洗车位:<?php echo $available;?>/总数:<?php echo $total;?></p>
					        <li class="dropdown">
							    <a href="<?php echo  Yii::app()->createUrl('user/profile');?>" class="dropdown-toggle" data-toggle="dropdown" style="color:#ffffff;font-weight:bold;"  id="zz">我的洗车<span class="caret"></span></a>
							        <ul class="dropdown-menu" role="menu">
										<li><a href="<?php echo  Yii::app()->createUrl('user/profile');?>">我的订单</a></li>
										<li><a href="<?php echo  Yii::app()->createUrl('user/score');?>">我的积分</a></li>
										<li><a href="<?php echo  Yii::app()->createUrl('user/profile');?>">我的信息</a></li>
<!-- 										<li><a href="#">我的点评</a></li> -->
<!-- 										<li><a href="#">常去车行</a></li> -->
<!-- 										<li><a href="#">站内信</a></li> -->
							        </ul>
							</li>
					        <li><a href="<?php echo Yii::app()->createUrl('site/login');?>" >登录</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('user/reg');?>" >注册</a></li>
						</ul>
						
                   </div>
		        <!-- </div> -->
	        </nav>

<div>
<?php
   	 echo $content; 
   	 ?>
 </div>        



  <!-- footer -->
 <div class="row">
<div class="col-xs-12 visible-xs">
	<ul class="list-group">
		<li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('order/list');?>">车行列表</a></li>
		<li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('boss/profile');?>">车行通道</a></li>
		<li class="list-group-item"><a href="http://www.miitbeian.gov.cn" target="_blank">辽ICP备14013410号</a></li>
	</ul>
</div>
	<div class="col-xs-12 col-sm-12 hidden-xs">
	<table class="table table-striped"> 
	   <tr> 
		  <td class="col-sm-2">
			<ul style="list-style:none;text-align:center;">
			<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>"><h4>车行加盟</h4></a></li>
			<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>">加盟须知</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>">加盟申请</a></li>
			</ul>					
		  </td>
		  <td class="col-sm-2">
			 <ul style="list-style:none;text-align:center;">
				<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>"><h4>帮助</h4></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>">使用帮助</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>">常见问题</a></li> 				
			 </ul>
		  </td>
		  <td class="col-sm-2">
			 <ul style="list-style:none;padding-left:80px;">
				<li><a href="#"><h4>关注我们</h4></a></li>
				<li><a href="#">新浪微博</a></li>
				<li><a href="#">微信</a></li> 				
			 </ul>
		  </td>	
          <td  class="col-sm-6">
		       <label class="label label-danger" style="border-radius:14px;">
			   <span class="glyphicon glyphicon-hand-right"></span></label> 
			   <a href="<?php echo  Yii::app()->createUrl('boss/profile');?>"><span style="font-size:20px;">车行通道</span></a>
          </td>		  
	   </tr>
       <tr class="active">
	      <td class="col-sm-2">
		  </td>
		  <td class="col-sm-2" col-span="2">
		  </td>
	      <td class="col-sm-6">
			 <a herf="<?php echo Yii::app()->createUrl('site/index'); ?>">沈阳喜车商务服务有限公司  版权所有 Copyright &copy;  <?php echo date('Y');?>   All Rights Reserved.</a><br>
			 <a href="http://www.miitbeian.gov.cn" target="_blank">辽ICP备14013410号</a>
		  </td>
		  <td class="col-sm-2">
		  </td>
		</tr>	   
	 </table>
	 
	 </div>

          		 
</div>
	
</div> <!-- end of container -->
         

	



	







 <div style="display: none">
 <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1254078506'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1254078506%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
 </div>
</body>
</html>
   <?php 
Yii::app()->clientScript->registerScript('inputMask',
"
$(':input').inputmask();
",CClientScript::POS_READY);


?>
