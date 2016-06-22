<?php
/* @var $this Controller */
$id = Yii::app ()->user->id;
if (! is_int ( ( int ) $id ) || $id <= 0) {
	throw new CHttpException ( 404, '访问页面不存在' );
} else {
	$userModel = User::model ()->findByPk ( $id );
}
if ($userModel === null)
	throw new CHttpException ( 404, '访问页面不存在' );
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<title><?php echo CHtml::encode($this->pageTitle).'-'.Yii::app ()->name; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport"
	content="width=device-width, initial-scale=1,user-scalable=no">
<meta name="Keywords" content="洗车,打蜡,精洗,预约,优惠,省时,洗车位,免排队,我洗车">
<meta name="description"
	content="我洗车,全车洗车位预约系统，不用排队，尊享爱车养护服务，省钱，省时，就来我洗车.com！">
<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/favicon.ico" type="image/x-icon" />	
   
<?php

Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/mod.udatas.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-datetimepicker.min.css" );

Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ichecksquare/green.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrapValidator.min.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/jquery.raty.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ystep.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/style.css" );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD );

// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );

Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-datetimepicker.min.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/laydate/laydate.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrapValidator.min.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/language/zh_CN.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.easing.min.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/zzsc.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/ystep.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END );

// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.inputmask.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.inputmask.date.extensions.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.inputmask.extensions.js", CClientScript::POS_END );
?>        
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

<!-- iCheck -->


</head>

<body class="skin-blue">
	<!-- header logo: style can be found in header.less -->
	<header class="header ">


		<a href="<?php echo Yii::app()->createUrl('site/index');?>"
			class="icon logo"> <!-- Add the class icon to your logo image or logo icon to add the margining -->
			<img
			src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo_white.png"
			alt="logo" height="43px;" />
		</a>

		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top " role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas"
				role="button"> <span class="sr-only">切换菜单</span> <span style="color:white;"><strong>导航</strong> </span>
			</a>
			<div class="navbar-right">
				<ul class="nav navbar-nav">
<?php if(false && (Yii::app()->controller->id=='boss') && Yii::app()->user->checkAccess('boss')):?>
	<li> <a class="dropdown user"
									href="<?php echo Yii::app()->createUrl('boss/service');?>"><span class="badge">
<?php
$shop = UTool::getShop();
echo UWashShop::getLevel($shop['ws_level']); ?></span></a>
								</li>
<?php endif;?>			
				
			
					<li class="dropdown notifications-menu"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"> <i
							class="fa fa-envelope"></i> 
<?php
$unreadCount = Message::model ()->getUnReadCount ( $userModel ['id'] );
if ($unreadCount > 0):
?>
<span class="label label-danger" id="msgCount" name="msgCount"><?php echo $unreadCount;?></span>
<?php else :?>
<span class="label label-success" id="msgCount" name="msgCount"><?php echo $unreadCount;?></span>
<?php endif;?>
					</a>
						<ul class="dropdown-menu">
							<li class="header">您有 <code><span name="msgCount"><?php echo $unreadCount;?></span></code> 
								条未读信息
							</li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul class="menu" id='msgList'>
								<?php
								$this->renderPartial ( '/layouts/_message', array (
										'userId' => $userModel ['id'] 
								) );
								?>

<!-- end message -->
								</ul>
							</li>
							<li class="footer bg-light-blue">
<?php if((Yii::app()->controller->id=='boss') && Yii::app()->user->checkAccess('boss')):?>
	<a href="<?php echo Yii::app()->createUrl('boss/msgList');?>" class="text-red">查看所有信息</a></li>
<?php elseif ((Yii::app()->controller->id=='user')):?>
<a href="<?php echo Yii::app()->createUrl('site/msgList');?>" class="text-red">查看所有信息</a></li>	
<?php endif;?>
						
						</ul></li>
					<li class="dropdown user user-menu"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"> <i
							class="glyphicon glyphicon-user"></i> <span><?php echo  $userModel['u_nick_name'];?> <i
								class="caret"></i> <label class="label label-warning">LV1</label></span>
					</a>
						<ul class="dropdown-menu">
							<li class="user-footer bg-light-blue">
								<div class="pull-left ">
								<a href="" class="btn text-muted">积分：<?php echo $userModel['u_score'];?></a>
								</div>
								<div class="pull-right">
									<a href="<?php echo Yii::app()->createUrl('site/logout');?>"
										class="btn btn-default btn-flat">退出</a>
								</div>
							</li>
						</ul></li>
				</ul>
			</div>
		</nav>
	</header>


       	<?php echo $content; ?>
       <!-- Modal -->
	<div class="modal fade" id="msgModal" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<i class="fa fa-clock-o"></i> <span class="modal-title text-muted" id="msgDatetime"></span>
				</div>
				<div class="modal-body">
					<p id="msgContent">读取中……</p>
				</div>
			</div>
		</div>
	</div>


	<script
		src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/AdminLTE/app.js"
		type="text/javascript"></script>
	<div style="display: none">
		<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1254078506'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1254078506%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
	</div>
</body>

</html>

<?php
Yii::app ()->clientScript->registerScript ( 'showMsgModal', "
function showMsgModal(mid){
$.ajax({
	url:'" . Yii::app ()->createUrl ( 'message/show' ) . "',
 	async:false,
	data:{
		'id':mid,		
},
			dataType:'JSON',
	'success':function(html){
			if(html['status']){
$('#msgDatetime').html(html['data']['time']);
$('#msgContent').html(html['data']['content']);
$('#msgList').html(html['data']['list']);
$(\"span[name='msgCount']\").each(function(index,element){
		var count=html['data']['count'];
		$(this).html(count);
		if(count==0){
	$('#msgCount').removeClass('label-danger').addClass('label-success');
}
});
}else{
	$('#msgDatetime').html(html['msg']);
}
 	$('#msgModal').modal();
	if($('#ajaxMsgList').length>0){
	    $.fn.yiiListView.update(
                'ajaxMsgList'
            );}
	}
});	

	}
		

", CClientScript::POS_END );

?>

