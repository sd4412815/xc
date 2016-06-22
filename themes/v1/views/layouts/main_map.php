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
<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/favicon.ico" type="image/x-icon" />
<?php
Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/y.css" );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/mod.udatas.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ichecksquare/green.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/tooltipster.css" );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.tooltipster.min.js", CClientScript::POS_END );
// admin_main

?>
<style>
 body {  
      font-family:   
	 "Microsoft YaHei", "微软雅黑",  
 	 STXihei, "华文细黑",  
 	 serif; 
	 color:#000; 
 } 

.btn.btn-app1 {
  position: relative;
 /*  padding: 15px 5px; */
  padding: 5px 5px;
  /* margin: 0 0 10px 10px; */
  margin: 0 3px 2px 1px;
  /* min-width: 80px; */
  min-width: 70px;
 /*  height: 60px; */
  height: 30px;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
  text-align: center;
  color: #666;
  border: 1px solid #f8981d;
  background-color: #fafafa;
  background:url(img/btn.png);
  font-size: 12px;
}
.btn.btn-app1 > .badge {
  position: absolute;
  top: -5px;
  right: -6px;
  font-size: 10px;
  font-weight: 100;
}

</style>
<script
	src="<?php echo Yii::app()->theme->baseUrl;?>/js/layer/layer.min.js"
	type="text/javascript"></script>
<?php
$cid = UPlace::getCityId ();
$available  = OrderTemp::model()->getStatAvailableCount($cid)['data'];
$total  = OrderTemp::model()->getStatTotalCount($cid)['data'];

?>
</head>
<body >
<div class="container-fluid">


	<div class="row" style="background-color:#eee;height:20px;">
<div class="col-xs-12">
		
		<div class="row visible-xs">
	<div class="text-left "><span class="glyphicon glyphicon-map-marker text-danger"
				aria-hidden="true"></span> <span style="font-size: 16px;">我在: </span>
			 <?php
				$cid = UPlace::getCityId ();
				Yii::import ( 'select2.Select2' );
				$criteria = new CDbCriteria ();
				$criteria->addCondition ( 'c_state>=0' );
				$criteria->order = 'c_state DESC, c_spell ASC';
				
				$citiesListmodel = City::model ()->findAll ( $criteria );
				$disabledOptions = array ();
				foreach ( $citiesListmodel as $key => $city ) {
					if ($city ['c_state'] < 1) {
						$disabledOptions [$city ['id']] = array (
								'disabled' => true 
						);
					}
				}
				$url = Yii::app()->createAbsoluteUrl('order/map');
				echo Select2::dropDownList ( 'autoCity1', $cid, CHtml::listData ( $citiesListmodel, 'id', function ($city) {
					return CHtml::encode ( $city->c_name );
				} ), array (
						'options' => $disabledOptions,
						'select2Options' => array (
								'matcher' => 'js:function(term, text) {
            var mod=ZhToPinyin(text);
            var tf1=mod.a.toUpperCase().indexOf(term.toUpperCase())==0;
            var tf2=mod.b.toUpperCase().indexOf(term.toUpperCase())==0;
            return (tf1||tf2);
        }  ',
								'width' => '90px' 
						),
						'onChange' => "document.cookie='_ucid='+this.value+';path=/';
				    window.location.href='".$url."'; 
				   " 
				) );
				?></div>
	</div> <!-- end row -->
	
	
			<div class="row">
			
				<div class="col-lg-offset-1 col-xs-6 col-lg-5 text-left">
				
<p>
剩余洗车位：<?php echo $available;?> / 共：<?php echo $total;?></p>
			</div>
				<div class="col-xs-6 col-lg-5 text-right">
					<ul class="list-inline">
					您好！
<?php if(Yii::app()->user->isGuest):?>	
	<li>请 <a href="<?php echo Yii::app()->createUrl('site/login');?>">登录
						</a> 或 <a href="<?php echo Yii::app()->createUrl('user/reg');?>">免费注册</a></li>				
					
<?php else :?>

						<li><a href="<?php echo Yii::app()->createUrl('site/logout');?>"><?php
	if (isset ( Yii::app ()->user->_nickName )) {
		echo @Yii::app ()->user->_nickName;
	}
	
	?> [退出] </a></li>

<?php endif;?>
					
	<?php $userModel = new User();?>		
	<li>|</li>			
							<li class="dropdown user user-menu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown"> <i
								class="fa fa-user  "></i> <span> 我的洗车 <i class="caret"></i>
							</span>
						</a>
							<ul class="dropdown-menu text-left" style="z-index: 2000;">
<?php
if (! Yii::app ()->user->isGuest) :
	?>
<?php if(Yii::app()->user->checkAccess('boss')):?>
	<li> <a 
									href="<?php echo Yii::app()->createUrl('boss/profile');?>"><i class="fa fa-hand-o-right text-yellow"></i>车行通道</a>
								</li>
<?php endif;?>
<?php endif;?>

								<li class="user-body"><a
									href="<?php echo Yii::app()->createUrl('user/profile');?>">账户概览</a>
								</li>
								<li class="user-body"><a
									href="<?php echo Yii::app()->createUrl('user/list');?>">我的订单</a>
								</li>
								<li class="user-body"><a
									href="<?php echo Yii::app()->createUrl('user/card');?>">我的优惠劵</a>
								</li>
								<li class="user-body"><a
									href="<?php echo Yii::app()->createUrl('user/Favorite');?>">我的收藏</a>
								</li>
								<li class="user-body"><a
									href="<?php echo Yii::app()->createUrl('user/score');?>">我的积分</a>
								</li>


							</ul></li>
							<li>|</li>
							<li> <a href="<?php echo  Yii::app()->createUrl('boss/login');?>">商家入口</a> </li>
							<li>|</li>
			  <li ><a href="#" class="text-black">收藏本站</a></li>
					</ul>

				</div>
			</div><!-- end row  -->

		</div> <!-- end  col -->
		
	</div>
	<!-- row -->

	</div> <!-- end contrainer -->
	
	<div class="container-fluid">
	<div class=" row hidden-xs" >
		<div class="col-lg-offset-1 col-sm-6 col-md-5  col-lg-4 pull-left">
			<a href="<?php echo Yii::app()->createUrl('site/index');?>"><img
				src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo_2.png" /></a>
			<span class="glyphicon glyphicon-map-marker text-danger"
				aria-hidden="true"></span> <span style="font-size: 16px;">我在: </span>
			 <?php
// 				$cid = UPlace::getCityId ();
// 				Yii::import ( 'select2.Select2' );
// 				$criteria = new CDbCriteria ();
// 				$criteria->addCondition ( 'c_state>=0' );
// 				$criteria->order = 'c_state DESC, c_spell ASC';
				
// 				$citiesListmodel = City::model ()->findAll ( $criteria );
// 				$disabledOptions = array ();
// 				foreach ( $citiesListmodel as $key => $city ) {
// 					if ($city ['c_state'] < 1) {
// 						$disabledOptions [$city ['id']] = array (
// 								'disabled' => true 
// 						);
// 					}
// 				}
				echo Select2::dropDownList ( 'autoCity', $cid, CHtml::listData ( $citiesListmodel, 'id', function ($city) {
					return CHtml::encode ( $city->c_name );
				} ), array (
						'options' => $disabledOptions,
						'select2Options' => array (
								'matcher' => 'js:function(term, text) {
            var mod=ZhToPinyin(text);
            var tf1=mod.a.toUpperCase().indexOf(term.toUpperCase())==0;
            var tf2=mod.b.toUpperCase().indexOf(term.toUpperCase())==0;
            return (tf1||tf2);
        }  ',
								'width' => '90px' 
						),
						'onChange' => "document.cookie='_ucid='+this.value+';path=/';
				         window.location.href='".$url."'; 
				    " 
				) );
				?>
<?php
				// $this->widget('city.cityWidget');
				?>
		</div>
		<div class="col-sm-6 col-md-7 col-lg-6  text-right" id="head-nav">
		 <a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'card'));?>"><img src="<?php echo  Yii::app()->theme->baseUrl;?>/img/grey1.png" /></a>
			<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'icon'));?>"><img src="<?php echo  Yii::app()->theme->baseUrl;?>/img/grey2.png" /></a>
			<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'faq'));?>"><img src="<?php echo  Yii::app()->theme->baseUrl;?>/img/question.png" /></a>
			<a href="<?php echo Yii::app()->createUrl('site/sendMessage');?>"><img src="<?php echo  Yii::app()->theme->baseUrl;?>/img/message.png" /></a>
			
		</div>
		
	</div>
	<nav class="hidden-xs navbar navbar-default">
	  <div class="container-fluid  ">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <!-- <a class="navbar-brand" href="#">Brand</a> -->
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li id="mhome"><a
					href="<?php echo Yii::app()->createUrl('site/index');?>">首 页</a></li>
			<li id="mlist"><a
					href="<?php echo Yii::app()->createUrl('order/list');?>">预定车行</a></li>	
			<li id="mmap"><a
					href="<?php echo Yii::app()->createUrl('order/map');?>">地图查看</a></li>
				<li id="mjoinus"><a
					href="<?php echo Yii::app()->createUrl('site/joinus');?>">车行加盟</a></li>
			<li id="mhelp"><a
					href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'help_reg'));?>">帮助</a></li>
		  </ul>

		 
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="row visible-xs">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header" style="margin-left: -30px;margin-right:-30px;">

					<a name="mhelp"
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'order'));?>"
						class="navbar-toggle collapsed"> 帮助</a> <a name="mjoinus"
						href="<?php echo Yii::app()->createUrl('site/joinus');?>"
						class="navbar-toggle collapsed"> 加盟 </a>  <a
						href="<?php echo Yii::app()->createUrl('order/map');?>"
						class="navbar-toggle collapsed"> 地图 </a> <a
						href="<?php echo Yii::app()->createUrl('order/list');?>"
						class="navbar-toggle collapsed"> 预定 </a> <span
						class="navbar-toggle pull-left" style="border: none;"> <a
						href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img
							style="height: 30px; border: 0;"
							src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo_white.png" /></a></span>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->

				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->

		</nav>
	</div>

 </div>

	<?php
echo $content;
?>



<div class="container">
	<!-- footer -->
	<div class="row">
		<div class="col-xs-12 visible-xs">
			<ul class="list-group">
				<li class="list-group-item"><a
					href="<?php echo Yii::app()->createUrl('order/list');?>">车行列表</a></li>
				<li class="list-group-item"><a
					href="<?php echo Yii::app()->createUrl('boss/login');?>">车行通道</a></li>
			</ul>
		</div>

	</div>

	<div class="row">

		<div class="col-sm-12 hidden-xs">

			<div class="col-sm-3">
				<ul style="list-style: none; text-align: center;">
					<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>"><h4>车行加盟</h4></a></li>
					<li><a
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'join_readme'));?>">加盟须知</a></li>
					<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>">加盟申请</a></li>
				</ul>
			</div>
			<div class="col-sm-3">
				<ul style="list-style: none; text-align: center;">
					<li><a href="<?php echo Yii::app()->createUrl('site/joinus');?>"><h4>帮助</h4></a></li>
					<li><a
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'help_reg'));?>">使用帮助</a></li>
					<li><a
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'faq'));?>">常见问题</a></li>
				</ul>
			</div>
			<div class="col-sm-3">
				<ul style="list-style: none; padding-left: 80px;">
					<li><a
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'aboutus'));?>"><h4>关注我们</h4></a></li>
					<li><a
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'aboutus'));?>">新浪微博</a></li>
					<li><a
						href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'aboutus'));?>">微信</a></li>
				</ul>
			</div>
			<div class="col-sm-3">
				<label class="label label-danger" style="border-radius: 14px;"> <span
					class="glyphicon glyphicon-hand-right"></span></label> <a
					href="<?php echo  Yii::app()->createUrl('boss/login');?>"><span
					style="font-size: 20px;">车行通道</span></a>
			</div>


		</div>


	</div>

	<div class="row">
		<div class="col-sm-12 text-center">
			<p>
				<a href="<?php echo Yii::app()->createUrl('site/index'); ?>">沈阳喜车商务服务有限公司
				</a> 版权所有 Copyright &copy;   <?php echo date('Y');?>   All Rights Reserved.</p>
			<p>
				<a href="http://www.miitbeian.gov.cn" target="_blank">辽ICP备14013410号</a>
			</p>
		</div>

		<div style="display: none">
			<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1254078506'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1254078506%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
		</div>
	</div>
	
	</div> <!-- end container -->
</body>
</html>

