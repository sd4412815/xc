<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app ()->name;
?>

<div class="row">
	<!-- 固定表单  class="carousel-caption" --><!-- right:60%;bottom: 40%;text-align: center; -->
		 <div  class="text-center pull-left col-xs-12 col-sm-4 col-md-3" style="z-index: 10; position:absolute;padding-top:10px;" >
			  <div class="row" style="font-size:16px;">
				   <div class="col-xs-6">				       
					   <a href="<?php echo Yii::app()->createUrl('order/list');?>"><p style="font-size:large;font-weight:bold;color:#333333;">
					   <i class="fa fa-flash"></i> 洗车预约</p></a>
				   </div>
				   <div class="col-xs-6"> 
					   <a href="<?php echo Yii::app()->createUrl('order/map');?>"><p style="font-size:large;font-weight:bold;color:#333333;">
					   <i class="fa fa-map-marker"></i> 地图预约</p></a>
				   </div>
			   </div>
				
               <!--  <div class="row"> -->
				   
				   
					  <form class="form-horizontal" role="form">
					   <div class="form-group">
						 <label for="inputPassword" class="col-xs-4 control-label">所在城市</label>
					     <div class="col-xs-8">
						 	  <?php

echo CHtml::dropDownList ( 'idCity', '', CHtml::listData ( City::model ()->findAll (array(
	'order'=>'c_spell ASC',
)), 'id', 'c_name' ), array (
		'prompt' => '选择城市',
		'class'=>'form-control input-sm',
		) 
 );





?> 
						 </div>
					   </div>
					   
					   <div class="form-group">
						<label for="inputPassword" class="col-xs-4 col-sm-4 control-label">预约时间</label>
						<div class="col-xs-8 col-sm-8">
						
						  <input size="29" id="sDate"  class="laydate-icon   form-control input-md" value="<?php echo date('Y-m-d');?>">
	
	<?php
	
		Yii::app()->clientScript->registerScript('sDate',"
		laydate({
elem:'#sDate',
format: 'YYYY-MM-DD',
min: laydate.now(0),
max: laydate.now(+2),	
});
		",CClientScript::POS_READY);
		?>	
						</div>
					   </div>
					   
					   <div class="form-group">
						<label for="inputPassword" class="col-xs-4 control-label">洗车搜索</label>
						<div class="col-xs-8">
						  <input id="q" type="text" class="form-control input-sm" placeholder="店名/地址/关键字">
						</div>
					   </div>
					   
					   
			 <div class="form-group"><div class=" col-xs-12">
					    <button type="button" class="btn btn-danger btn-block"  onclick="wsFilter()">搜索</button>
			</div>		 	</div>	
				
					
<?php 
Yii::app()->clientScript->registerScript('searchi',
"
		 	
		function wsFilter(){
	
		var bu = '".Yii::app()->createUrl('order/list')."';
        var cid = $('#idCity').val();
        var sdate = $('#sDate').val();
        var q=$('#q').val();
        	
 		window.location.href=bu+'&cityId='+cid+'&sDate='+sdate+'&q='+q;
	
};

		",CClientScript::POS_END);


?>					   
					  </form>
				

		</div><!-- 固定表单结束 -->


		
		    <div >		
		<div class="col-xs-12 ">
		    <div class="visible-xs" style="height:230px;">
		    
		    
		    </div>
		    <div id="carousel-example-generic" class="carousel slide hidden-xs" data-ride="carousel">		   
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-example-generic" data-slide-to="1"></li>
					<li data-target="#carousel-example-generic" data-slide-to="2"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
					<div class="item active">
					  <a href="<?php echo Yii::app()->createUrl('order/list');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/y1.png" alt="洗车图片" /></a>
					</div>
					
					<div class="item">
					  <a href="<?php echo Yii::app()->createUrl('order/list');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/y2.png" alt="打蜡图片" /></a>
					</div>
					
					<div class="item">
					  <a href="<?php echo Yii::app()->createUrl('order/list');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/y3.png" alt="精洗图片" /></a>  
					</div>	
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				  </a>
			</div>
			

		</div>
		<!-- 图片上服务框 -->		
   </div><!-- 轮播结束-->
 </div>
   <div class="row" style="height:5px;">
   </div>
   
   <div class="row">
     
		
			    
			    <div class="col-xs-12 col-sm-3 hidden-xs text-center">
					<a href="<?php echo Yii::app()->createUrl('site/download');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/app.png" alt="手机App应用" class="img-circle"/></a>			  
				 <p style="text-align:center;font-weight:bold;"><a style="color:#ff9900;" href="<?php echo Yii::app()->createUrl('site/download');?>">手机客户端APP</a></p>
				</div>
				
				<div class="col-xs-12 col-sm-3 hidden-xs text-center" >
				     <a href="<?php echo Yii::app()->createUrl('site/joinus');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/add.png" alt="加盟我们" class="img-circle"></a>
				  <p><a style="color:#ff9900;" href="<?php echo Yii::app()->createUrl('site/joinus');?>"><strong>加盟我们</strong></a></p>
				</div>
				
				<div class="col-xs-12 col-sm-3 hidden-xs text-center" >
					<a href="<?php echo Yii::app()->createUrl('site/about#help');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/help.png" alt="帮助" class="img-circle"></a>     				
				 <p style="text-align:center;font-weight:bold;"><a style="color:#ff9900;" href="<?php echo Yii::app()->createUrl('site/about#help');?>">使用帮助</a></p>	
				</div>
				<div class="col-xs-12 col-sm-3 hidden-xs" style="border-left:2px solid #ff9900;z-index:10;">
					<marquee onmouseover=this.stop() onmouseout=this.start() scrollAmount=1 scrollDelay=60 direction=up style="height: 100px;">
						<div style="line-height:20px;text-align:left;font-size:12px;">

						<?php 
						$criteria = new CDbCriteria();
						$criteria->addCondition(array('ws_state'=>'1'));
						$criteria->order="ws_join_date DESC, id DESC";
						$wsrlt = WashShop::model()->findAll($criteria);

						$unixTime=strtotime(null);
						if (!$unixTime) {
							echo 'e';
						}
						echo $unixTime.'-';
						$checkDate= date('Y-m-d', $unixTime);
						echo $checkDate;

						foreach ($wsrlt as $key=>$shop):
						?>
<a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id'])); ?>" 
	>
	<?php echo $shop['ws_name'];?>&nbsp;&nbsp;&nbsp;地址：<?php echo $shop['ws_address'];?>
	</a><br>
	<?php endforeach;?>
					
						
				
						</div>
					</marquee>
						<p style="text-align:center;"><a href="<?php echo Yii::app()->createUrl('order/list');?>">加盟店铺</a></p>
				</div>
				
			</div>
			

	

<?php 
Yii::app()->clientScript->registerScript('changeMenuStyle',
"

   $('#menu-home').addClass('active');

		",CClientScript::POS_READY);


?>
   
   