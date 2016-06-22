<?php
// 直接输出当前城市位置信息
?>
<header class="main-header">
	<nav class="navbar navbar-static-top" style="min-height: 30px;padding:3px 5px 3px 0;">
			<span class="pull-left col-xs-9 text-auto-hide" style="padding:5px 0 0 4px;"> 

<?php 
if(FALSE):
?>	
	
<div  class="btn btn-primary btn-flat  btn-xs " title="已收藏" >
								<i class="fa fa-star"></i>
							</div> 
<?php else:?>

<a href="#" type="button" title="添加到收藏"  class="btn btn-primary btn-flat btn-xs">
								<i class="fa fa-star-o"></i> 
							</a> 							
<?php endif;?>
	
<?php 
if(FALSE):
?>		
<div class="btn btn-primary btn-flat btn-xs" title="已加入会员 ">
								<i class="fa fa-user"></i> 
							</div> 							
<?php else:?>
<a href="" type="button" class="btn btn-primary btn-flat btn-xs" title=" 加入会员 ">
								<i class="fa fa-user-plus"></i>
							</a> 							
<?php endif;?>			
			
			

<span class=""
		style="border: 0px; color: #fff;font-size:18px;">
<?php
echo $this->shopName;
?></span>
</span>
<span class="pull-right">	<a href="
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