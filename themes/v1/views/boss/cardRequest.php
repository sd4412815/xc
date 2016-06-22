	<style>
		body { 
			 font-family: "Times New Roman", 
			 "Microsoft YaHei", "微软雅黑", 
			 STXihei, "华文细黑", 
			 serif;
			 color:#333;
		}
		
#msform {
	width: 800px; 
    /* width:65%; */
	margin: 50px auto;
	text-align: center;
	position: relative;
}
#msform fieldset {
	background: white;
	border: 0 none;
	border-radius: 3px;
	box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
	padding: 20px 30px;
	
	box-sizing: border-box;
    width: 84%; 
	margin: 0 10%;
	
	/*stacking fieldsets above each other*/
	position: absolute;
}
/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
	display: none;
}
/*inputs*/
#msform input, #msform textarea,#msform select{
	padding: 15px;
	border: 1px solid #ccc;
	border-radius: 3px;
	margin-bottom: 10px;
	width: 100%;
	box-sizing: border-box;
	font-family: montserrat;
	color: #2C3E50;
	font-size: 13px;
}
/*buttons*/
#msform .action-button {
	width: 100px;
	background: #27AE60;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px;
}
#msform .action-button:hover, #msform .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
}
/*headings*/
.fs-title {
	font-size: 15px;
	text-transform: uppercase;
	color: #2C3E50;
	margin-bottom: 10px;
}
.fs-subtitle {
	font-weight: normal;
	font-size: 13px;
	color: #666;
	margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: white;
	text-transform: uppercase;
	/* font-size: 9px; */
	width: 33.33%;
	float: left;
	position: relative;
}
#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	/* font-size: 10px; */
	font-size: 14px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #27AE60;
	color: white;
}

		</style>

<?php 


?>	
	
<section class="content-header">
<h1> 申请优惠劵</h1>
</section>

<section class="content" style="background-color:#39c;">
	<div style="height:800px;">
					    
						 <form id="msform">
						    <ul id="progressbar">
								<li class="active">填写信息</li>
								<li>填写收货地址</li>
								<li>确认信息并提交</li>
							</ul>
							<!-- fieldsets -->
							<fieldset class="form-horizontal">
								<h2 class="fs-title">第一步</h2>
								<h3 class="fs-subtitle">填写信息</h3>
								<!-- <input type="text" name="email" placeholder="发行店名" /> -->
								<div class="form-group">
									<label  class="col-sm-2 control-label">发行店名</label>
									<div class="col-sm-8">
									    <input id="s_name" type="text" class="form-control" placeholder="" value="<?php echo $shop['ws_name'];?>">									    
									</div>
								</div>
                                <div class="form-group">
									<label  class="col-sm-2 control-label">优惠类型</label>
									<div class="col-sm-8">
									    <!-- <input type="text" class="form-control" placeholder=" "> -->
									    <select id="cType" name="cardType">
										
											<option value='0'>首次优惠券</option>
											<option value='1'>次卡</option>
										</select>
									</div>
								</div>
                                
								<div class="form-group">
									<label  class="col-sm-2 control-label">服务类型</label>
									<div class="col-sm-8">
		
									
									    <select id="sType" name="serviceType" >
									    	<option value="0">不限</option>
									    <?php 
									    $services = WashShopService::model()->findAllByAttributes(array('wss_ws_id'=>$shop['id']));
									    
									    foreach ($services as $key=>$service):
									    ?>
									    <option value="<?php echo $service['wss_st_id'];?>"><?php
									    echo ServiceType::model()->findByPk($service['wss_st_id'])->st_name;
									    ?></option>
									    
									    <?php endforeach;?>
										
										
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label  class="col-sm-2 control-label">卡片数量</label>
									<div class="col-sm-8">
									    <input id='sNum' type="text" value="100" class="form-control" placeholder=" ">									    
									</div>
								</div>
								
								<div class="form-group">
									<label  class="col-sm-2 control-label">卡片面额</label>
									<div class="col-sm-8">
									    <input id="sValue" type="text" value="10" class="form-control" placeholder=" ">									    
									</div>
								</div>
								
								<div class="form-group">
									<label  class="col-sm-2 control-label">选择有效期</label>
									<div class="col-sm-8">
									     <input size="29" id="sDate"  class="laydate-icon   form-control input-md" value="<?php echo date('Y-m-d');?>">								    
<?php
	
		Yii::app()->clientScript->registerScript('sDate',"
		laydate({
elem:'#sDate',
format: 'YYYY-MM-DD',
min: laydate.now(+1),	
});
		",CClientScript::POS_READY);
		?>										
									</div>
								</div>
							
								<input type="button" name="next" class="next action-button" value="下一步" />
							</fieldset>
							<fieldset class="form-horizontal">
								<h2 class="fs-title">第二步</h2>
								<h3 class="fs-subtitle">填写收货地址</h3>
			
                                <div class="form-group">
									<label  class="col-sm-2 control-label">收货地址</label>
									<div class="col-sm-8">
									    <input id="sAddress" type="text" class="form-control" value="<?php echo $shop['ws_address'];?>" placeholder=" "/>									    
									</div>
								</div>
                                <div class="form-group">
									<label  class="col-sm-2 control-label">联系人</label>
									<div class="col-sm-8">
									    <input id="sContactor" type="text" class="form-control" value="<?php echo Boss::model()->findByAttributes(array(
				'b_user_id'=>Yii::app()->user->id,
		))['b_real_name'];?>"  placeholder=" "/>									    
									</div>
								</div>
                                <div class="form-group">
									<label  class="col-sm-2 control-label">联系电话</label>
									<div class="col-sm-8">
									    <input id="sTel" type="text" class="form-control" value="<?php echo User::model()->findByPk(Yii::app()->user->id)['u_tel'];?>"  placeholder=" "/>									    
									</div>
								</div>								
								<input type="button" name="previous" class="previous action-button" value="上一步" />
								<input type="button" name="next" class="next action-button" value="下一步" onclick="previewCard(0.5, 0.5)" />
							</fieldset>
							<fieldset>
								<h2 class="fs-title">第三步</h2>
								<h3 class="fs-subtitle">确认信息并提交</h3>
								
								<p><img style="width:200px;" src="<?php echo Yii::app()->theme->baseUrl;?>/img/card1.png" />
								   <img style="width:200px;" src="<?php echo Yii::app()->theme->baseUrl;?>/img/card1.png" /></p>
								<p>您已选择<span id="lcType"></span><span id="lsNum"></span>张，面额<span id="lsValue"></span>元，有效期至<span id="lsDate"></span></p>
								<p>应付成本费：¥ <span id="lsCValue"></span>
								保障金：¥ <span id="lsGValue"></span></p>	
								<p>合计：¥ <span id="lsTValue"></span></p>
								<p>汇款账户为：<?php echo Yii::app()->params['accountNum'];?> 
								户名：<?php echo Yii::app()->params['accountName'];?>  
								开户行：<?php echo Yii::app()->params['accountOwner'];?> </p>
								<input type="button" name="previous" class="previous action-button" value="上一步" />
				
									<button type="button" class="submit action-button" id="btnRequestCard" onclick="requestCard();">确定</button>
							</fieldset>
						 </form>>
						
					</div>




													
														<button type="button" class="btn btn-primary" id="btnRequestCard" onclick="requestCard();">确定</button>
	
<?php 
                   
                        
Yii::app()->clientScript->registerScript('btnRequestCard',
"
function requestCard(){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('boss/newRequestCard')."',
		data:{
	  		'id':".$shop['id'].",
		'num':$('#sNum').val(),
		'value':$('#sValue').val(),
		'ctype':$('#cType').val(),
		'stype':$('#sType').val(),
		'sDate':$('#sDate').val(),
		'sAddress':$('#sAddress').val(),
			'sContactor':$('#sContactor').val(),
			'sTel':$('#sTel').val(),
	},
 		async:false,
 	'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
 		'complete':function(){layer.close(loadi);},
		'success':function(html){
 		layer.msg('已提交申请，请等待结果！',2,1);
// 		$('#sDateList').html(html);
window.location.href='".Yii::app()->createUrl('boss/card')."'; 
 //	$('#svalue').val('');

}
});
};
	  			

		",CClientScript::POS_END);


?>					
											



</section>