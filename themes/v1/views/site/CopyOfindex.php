<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app ()->name;
?>


<section id="featured" class="wide-fat">

	<div class="head-image-texts">
		<div class="texts">
			<h1 style="text-align: right;">专业洗车、打蜡、车内精洗</h1>


			<p style="text-align: right;">还在为了洗车苦苦等待吗，马上预约，享受五星级服务吧</p>
			<p style="text-align: right;">不需提前支付，零风险，还等什么呢</p>
		</div>
	</div>


	<div class="featured-inner">



		<div class="slider">
			<div id="top-slider" class="flexslider">
				<ul class="slides">
				
					<li><img
						src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/slider02.png"
						alt="Featured Image" /></li>
							<li><img
						src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/slider04.png"
						alt="Featured Image" /></li>
				
				</ul>
				<!-- /.slides -->


				<div class="opener-area">

					<a href="#" class="open-btn open-close-btn"><i
						class="fa fa-chevron-circle-right"></i></a>
					<ul class="social-icons vertical">
						<li><a href="#" class="open-btn open-close-btn">快速预约</a></li>

					</ul>
				</div>
				<div class="featured-overlay">

					<a id="close-form" href="#" class="button close open-close-btn"><i
						class="icon_close_alt2"></i></a>

					<div class="featured-overlay-inner">
<div class="form-horizontal">
			

						<div class=" form-group">
							<div class="col-sm-4" style="color: black;">
                                
                                <?php

echo CHtml::dropDownList ( 'idProvince', '', CHtml::listData ( Province::model ()->findAll (array(
	'order'=>'p_spell ASC',
)), 'id', 'p_name' ), array (
		'prompt' => '选择省份',
		'class'=>'chosen-select wide-fat',
		'ajax' => array (
				'type' => 'POST',
				'url' => $this->createUrl ( 'city/updateCities' ),
'async'=> false,
				'dataType' => 'json',
				'data' => array (
						'idProvince' => 'js:this.value' 
				),
				'success' => 'function(data) { 

$("#idCity").html(data.dropDownCities); 
$("#idCity").chosen().trigger("chosen:updated");
$("#idArea").html(data.dropDownAreas); 
$("#idArea").chosen().trigger("chosen:updated");
wsupdataAjax();

}' 
		) 
) );
?> 
                                </div> <!-- end  col -->
							<div class="col-sm-4" style="color: black;">
                                    
                                    <?php

echo CHtml::dropDownList ( 'idCity', '', array (), array(
		'prompt' => '选择城市',
'class'=>'chosen-select wide-fat',
		'ajax' => array(
				'type' => 'POST',
				'url' => $this->createUrl('area/updateAreas'),
				'async'=> false,
				'data' => array('idCity' => 'js:this.value'),
// 				'update' => '#idArea',
				'success'=>'function(data){
$("#idArea").html(data); 
$("#idArea").chosen().trigger("chosen:updated");

}'
		)));
?> 
                                    </div> <!-- end col -->

							<div class="col-sm-4" style="color: black;">
                                        <?php

echo CHtml::dropDownList ( 'idArea', '', array (), array (
		'prompt' => '选择区域' ,
'class'=>'chosen-select wide-fat ',
) );
?> 
                                        
                                        </div> <!-- end col -->

						</div> <!-- end  form-group -->

						
						
<div class="form-group" style="color: black;">
<div class="col-sm-12">
  <?php

echo CHtml::dropDownList ( 'idWS', '', array (), array (
		'prompt' => '选择车行' ,
'class'=>'chosen-select wide-fat ',
) );
?> 

</div>

</div> <!-- end form-group -->

<div class=" form-group">
<div class="col-sm-6" style="color: black;">
<span class="higlight">请选择车型</span><br/>
<select class="chosen-select wide-fat " name="idCarType" id="idCarType">

<option value="1">5座及以下</option>
<option value="2">7座及以上</option>
</select> 
  <?php

// echo CHtml::dropDownList ( 'idCarType', '', array (''), array (
// 		'prompt' => '选择车型' ,
// 'class'=>'chosen-select wide-fat ',
// ) );
?> 
</div>

<div class="col-sm-6" style="color: black;">
<span class="higlight">请选择预约服务类别</span><br/>
<select class="chosen-select wide-fat " name="idServiceType" id="idServiceType">

<option value="1">洗车</option>
<option value="2">打蜡</option>
<option value="3">车内精洗</option>
</select> 
<div style="display: none;">
<select name="idSTValue" id="idSTValue" >

<option value="30">30</option>
<option value="50">50</option>
<option value="150">150</option>
</select> 
</div>
  <?php

// echo CHtml::dropDownList ( 'idServiceType', '', array (), array (
// 		'prompt' => '服务类别' ,
// 'class'=>'chosen-select wide-fat ',
// ) );
?> 
</div>
</div> <!-- end form-group -->

<div class="form-group">
<div class="col-sm-6">
<input id="idOrderDate" class="traveline_date_input" type="text"
										value="<?php echo  date('Y-m-d');?>" />
									
</div>
<div class="col-sm-6" style="color:black;">
 <?php

echo CHtml::dropDownList ( 'idServiceTime', '', array (), array (
		'prompt' => '选择预约时间段' ,
'class'=>'chosen-select wide-fat ',
) );
?> 
</div>

</div> <!-- end form-group -->

<br />
<div class="form-group">
<div class="col-sm-12">
		<p>请牢记预约时间：<span id="lbServiceTime" class="h4 higlight">选择预约时间段</span></p>
<p>
		您预约了<span id="lbCarType" class="h4 higlight">5座及 以下</span>型车 <span id="lbServiceType" class="h4 higlight">
		洗车</span>服务，请到店支付<span style="font-family:Arial;">&yen;</span><span id="lbValue" class="h3 higlight">30</span>元
		</p>
</div>
</div>

<div class="form-group">
<div class="col-sm-8">
		<button type="submit" class="button green wide-fat" onclick='orderAdd()'><i class="fa fa-bolt"></i> 快速预约</button>
</div>
<div class="col-sm-4">
		<a class="button btn-primary wide-fat" href="<?php echo Yii::app()->createUrl('order/list');?>"><span style="color:white;"><i class="fa fa-search"></i> 车行列表</span></a>
</div>

</div>
		</div><!-- end form -->				
						
	<?php
// 	 $this->endWidget(); 
	?>		







					</div>
					<!-- /.featured-overlay-inner -->

				</div>
				<!-- /.featured-overlay -->

			</div>
		</div>
		<!-- /.slider -->


	</div>
	<!-- /.featured-inner -->

</section>
<!-- /#featured -->

<section id="amazing-tours"
	class="section section-amazing-tours wide-fat">


	<div class="container">

		<article class="contact section-intro">

			<h1 class="page-title">
				服务 <span class="higlight">特色</span>
			</h1>

		</article>

		<div class="row">
			<div class="col-xs-12 col-md-4">
				<div class="mix col-xs-12 tour-category-item amazing-tours-item">

					<div class="inner">


						<h3 class="category-heading">专业洗车</h3>

						<div class="featured-tour">

							<div class="image">
								<div class="hover">

									<a href="#" class="readmore-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-chevron-right fa-stack-1x"></i>
									</span>
									</a> <a href="#" class="permanent-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-link fa-stack-1x"></i>
									</span>
									</a>

								</div>
								<img
									src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/maojin.jpg"
									alt="专业洗车毛巾" class="responsive-image">
							</div>

							<div class="entry">

								<article class="entry-content">

									<h1>
										<a href="#" title="Siam Paragon, Bangkok">专车专业毛巾</a>
									</h1>

									<p>洗车介绍 洗车介绍 洗车介绍 洗车介绍 洗车介绍 洗车介绍 洗车介绍 洗车介绍</p>

								</article>



							</div>
							<!--/.entry -->

						</div>
						<!-- /.featured-tour -->




					</div>
					<!-- /.inner -->


				</div>
			</div>

			<div class="col-xs-12 col-md-4">
				<div class="mix col-xs-12 tour-category-item amazing-tours-item">

					<div class="inner">


						<h3 class="category-heading">专业打蜡</h3>

						<div class="featured-tour">

							<div class="image">
								<div class="hover">

									<a href="#" class="readmore-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-chevron-right fa-stack-1x"></i>
									</span>
									</a> <a href="#" class="permanent-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-link fa-stack-1x"></i>
									</span>
									</a>

								</div>
								<img
									src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/fuwu.png"
									alt="专业打蜡" class="responsive-image">
							</div>

							<div class="entry">

								<article class="entry-content">

									<h1>
										<a href="#" title="Siam Paragon, Bangkok">业界顶级龟博士白金蜡</a>
									</h1>

									<p>打蜡介绍介绍 打蜡介绍介绍 打蜡介绍介绍 打蜡介绍介绍 打蜡介绍介绍 打蜡介绍介绍 打蜡介绍介绍</p>

								</article>




							</div>
							<!--/.entry -->

						</div>
						<!-- /.featured-tour -->




					</div>
					<!-- /.inner -->


				</div>
			</div>

			<div class="col-xs-12 col-md-4">
				<div class="mix col-xs-12 tour-category-item amazing-tours-item">

					<div class="inner">


						<h3 class="category-heading">车内精洗</h3>

						<div class="featured-tour">

							<div class="image">
								<div class="hover">

									<a href="#" class="readmore-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-chevron-right fa-stack-1x"></i>
									</span>
									</a> <a href="#" class="permanent-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-link fa-stack-1x"></i>
									</span>
									</a>

								</div>
								<img
									src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/inner.jpg"
									alt="Siam Paragon, Bangkok" class="responsive-image">
							</div>

							<div class="entry">

								<article class="entry-content">

									<h1>
										<a href="#" title="Siam Paragon, Bangkok">以精洗的价格享受最接近翻新的服务，爱护无微不至</a>
									</h1>

									<p>车内精洗介绍 车内精洗介绍 车内精洗介绍 车内精洗介绍 车内精洗介绍 车内精洗介绍</p>

								</article>



							</div>
							<!--/.entry -->

						</div>
						<!-- /.featured-tour -->




					</div>
					<!-- /.inner -->


				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-4">
				<div class="mix col-xs-12 tour-category-item amazing-tours-item">

					<div class="inner">


						<h3 class="category-heading">顶级龟博士蜡</h3>

						<div class="featured-tour">

							<div class="image">
								<div class="hover">

									<a href="#" class="readmore-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-chevron-right fa-stack-1x"></i>
									</span>
									</a> <a href="#" class="permanent-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-link fa-stack-1x"></i>
									</span>
									</a>

								</div>
								<img
									src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/wax.jpg"
									alt="顶级龟博士蜡" class="responsive-image">
							</div>

							<div class="entry">

								<article class="entry-content">

									<h1>
										<a href="#" title="Siam Paragon, Bangkok">大品牌，放心蜡</a>
									</h1>

									<p>最好的蜡，只为保护您的爱车</p>

								</article>




							</div>
							<!--/.entry -->

						</div>
						<!-- /.featured-tour -->




					</div>
					<!-- /.inner -->


				</div>
			</div>

			<div class="col-xs-12 col-md-4">
				<div class="mix col-xs-12 tour-category-item amazing-tours-item">

					<div class="inner">


						<h3 class="category-heading">关怀无处不在</h3>

						<div class="featured-tour">

							<div class="image">
								<div class="hover">

									<a href="#" class="readmore-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-chevron-right fa-stack-1x"></i>
									</span>
									</a> <a href="#" class="permanent-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-link fa-stack-1x"></i>
									</span>
									</a>

								</div>
								<img
									src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/cup.png"
									alt="服务细节" class="responsive-image">
							</div>

							<div class="entry">

								<article class="entry-content">

									<h1>
										<a href="#" title="细节">每处细节，服务超出你想像</a>
									</h1>

									<p>服务态度介绍介绍介绍</p>

								</article>




							</div>
							<!--/.entry -->

						</div>
						<!-- /.featured-tour -->




					</div>
					<!-- /.inner -->


				</div>
			</div>


			<div class="col-xs-12 col-md-4">
				<div class="mix col-xs-12 tour-category-item amazing-tours-item">

					<div class="inner">


						<h3 class="category-heading">预约省时零等待</h3>

						<div class="featured-tour">

							<div class="image">
								<div class="hover">

									<a href="#" class="readmore-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-chevron-right fa-stack-1x"></i>
									</span>
									</a> <a href="#" class="permanent-link "> <span
										class="fa-stack fa-lg"> <i class="fa fa-circle-o fa-stack-2x"></i>
											<i class="fa fa-link fa-stack-1x"></i>
									</span>
									</a>

								</div>
								<img
									src="<?php echo Yii::app()->theme->baseUrl;?>/images/content/queue.png"
									alt="零等待" class="responsive-image">
							</div>

							<div class="entry">

								<article class="entry-content">

									<h1>
										<a href="#" title="Siam Paragon, Bangkok">提前预约，洗车不用等</a>
									</h1>

									<p>这里没有排队，您的预约，每个人都是超级VIP</p>

								</article>


							</div>
							<!--/.entry -->

						</div>
						<!-- /.featured-tour -->




					</div>
					<!-- /.inner -->


				</div>
			</div>

		</div>

		<button class="load-more button wide-fat">了解更多</button>
	</div>



</section>




<script>

function orderAdd()
{
	
	if($('#idWS').val() > 0 && $('#idServiceTime').val() > 0){

	$.ajax({
		type : 'POST',
		url:'<?php echo Yii::app()->createUrl("order/orderAdd");?>',
		dataType: 'json',
		async:false, // 可去掉
		data:{
// 			 idProvince:$('#idProvince').val(),
// 			idCity:$('#idCity').val(),
// 			idArea:$('#idArea').val()
			idWS:$('#idWS').val(),
			idCity:$('#idCity').val(),
			idOrderDate:$('#idOrderDate').val(),
			idCarType:$('#idCarType').val(),
// 			idServiceType: $('#idServiceType option:selected').text(),
			idServiceType: $('#idServiceType').val(),
			idServiceTime:$('#idServiceTime').val(),
			idValue:$('#idSTValue').val(),
		},
		success:function(data) { 
if(data=='true'){
    window.location.href="<?php echo Yii::app()->createUrl('user/profile');?>"; 
}
else
{

alert('预约失败！错误代码：['+data.msg+'],请查看帮助文档');
	}



	}

	}); // end ajax

	} // end if 判断是否提交
}

function wsupdataAjax(){

	$.ajax({
		type : 'POST',
		url:'<?php echo Yii::app()->createUrl("washShop/updateWSs");?>',
		dataType: 'json',
		async:false, // 可去掉
		data:{
			 idProvince:$('#idProvince').val(),
			idCity:$('#idCity').val(),
			idArea:$('#idArea').val()
		},
		success:function(data) { 

			$("#idWS").html(data.dropDownWSs); 
			$("#idWS").chosen().trigger("chosen:updated");

	}

	}); // end ajax

}

function orderTimeUpdataAjax(){
if($('#idWS').val() > 0){
	
	$.ajax({
		type : 'POST',
		url:'<?php echo Yii::app()->createUrl("order/updateTimes");?>',
		dataType: 'json',
		async:true,
		data:{
// 			 idProvince:$('#idProvince').val(),
idWS:$('#idWS').val(),
			idCity:$('#idCity').val(),
			idOrderDate:$('#idOrderDate').val(),
			idCarType:$('#idCarType').val(),
// 			idServiceType: $('#idServiceType option:selected').text()
				idServiceType: $('#idServiceType').val()
// 			idArea:$('#idArea').val()
		},
		success:function(data) { 
// alert(data.dropDownTimes);
			$("#idServiceTime").html(data.dropDownTimes); 
			$("#idServiceTime").chosen().trigger("chosen:updated");

	}

	}); // end ajax
}else{
	$("#lbServiceTime").text("选择预约时间段");
	$("#idServiceTime").html("<option value=''>选择预约时间段</option>"); 
	$("#idServiceTime").chosen().trigger("chosen:updated");
}


}



function serviceTypeUpdataAjax(){
if($('#idCity').val() > 0){
	
	$.ajax({
		type : 'POST',
		url:'<?php echo Yii::app()->createUrl("order/updateServiceType");?>',
		dataType: 'json',
		async:false,
		data:{
idCity:$('#idCity').val(),
			idCarType:$('#idCarType').val(),

		},
		success:function(data) { 
// alert(data);
			$("#idServiceType").html(data.dropDownServiceTypes); 
			$("#idServiceType").chosen().trigger("chosen:updated");
			$("#idSTValue").html(data.dropDownServiceTypeValues); 
			$("#idSTValue").chosen().trigger("chosen:updated");
			$("#idSTValue").val($('#idServiceType').val());
			$('#lbValue').text($('#idSTValue option:selected').text());
			$("#lbServiceType").html($('#idServiceType option:selected').text());

	}

	}); // end ajax
}else{
// 	$("#lbServiceTime").text("选择预约时间段");
// 	$("#idServiceTime").html("<option value=''>选择预约时间段</option>"); 
// 	$("#idServiceTime").chosen().trigger("chosen:updated");
}


}




$(document).ready(function () {
// 	$("#idWS").trigger("chosen:updated");

	
// 	var t=setTimeout('$("#idWS").chosen().trigger("chosen:updated");',15000);
    $('#menu-home').addClass("active");

$('#idOrderDate').on('change',function(){
	orderTimeUpdataAjax();
// 	alert('dd');
});

$('#idWS').on('change',function(){
	orderTimeUpdataAjax();
});

$('#idServiceTime').on('change',function(){
	$("#lbServiceTime").html($('#idServiceTime option:selected').text());
});

$('#idCarType').on('change',function(){
	$("#lbCarType").html($('#idCarType option:selected').text());
	serviceTypeUpdataAjax();
	orderTimeUpdataAjax();
});

$('#idServiceType').on('change',function(){
	$("#lbServiceType").html($('#idServiceType option:selected').text());
	$("#idSTValue").val($('#idServiceType').val());
	$('#lbValue').text($('#idSTValue option:selected').text());
	
	orderTimeUpdataAjax();
});


    
        $("#idCarType,#idServiceType").chosen({max_selected_options: 5,
      no_results_text: "未找到",
          	disable_search_threshold: 10,
          	});
    
    $("#idProvince").on('change',function(evt,params){
    	$.cookie('provinceId', $("#idProvince").val());
    	$.removeCookie('cityId');
    	$.removeCookie('areaId');
    	
    
    
    	});
    $("#idCity").on('change',function(evt,params){

    	$.cookie('cityId',$("#idCity").val());
    	$.cookie('cityName',$("#idCity option:selected").text());
    	$.removeCookie('areaId');
    	wsupdataAjax();
    	serviceTypeUpdataAjax();

    
    	});
    $("#idArea").on('change',function(evt,params){

    	$.cookie('areaId',$("#idArea").val());	  
    	$("#idWS").chosen().trigger("chosen:updated");
    	wsupdataAjax();
    	});


if($.cookie('provinceId') > 0){

	$("#idProvince").val($.cookie('provinceId'));
	$.ajax({
		type : 'POST',
		url:'<?php echo Yii::app()->createUrl('city/updateCities');?>',
		dataType: 'json',
		async:false,
		data:{
				idProvince: $.cookie('provinceId')
		},
		success:function(data) { 

	$("#idCity").html(data.dropDownCities); 
	$("#idCity").chosen().trigger("chosen:updated");
	$("#idArea").html(data.dropDownAreas); 
	$("#idArea").chosen().trigger("chosen:updated");

	}
		
		
	});
	wsupdataAjax();
	serviceTypeUpdataAjax();
}

    








	
});

</script>