<?php
$this->pageTitle = '时间段管理';
?>


<section class="content-header">
<h1>时间段管理<small>统计</small> </h1>
 <ol class="breadcrumb hidden-xs">
 <li><a href="<?php echo Yii::app()->createUrl('boss/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
<li class="active">时间段管理</li>
</ol>
</section>
    
 
 <section class="content">
 
 <div class="container-fluid">
 	<div class="col-md-8 col-sm-12 col-xs-12" >
 	<?php 
 	$bias = 0;
 	$sType=1;
//  	$boss = Boss::model()->findByAttributes(array(
//                         		'b_user_id'=>Yii::app()->user->id,
//                         ));
                        
//     $shop = $boss->washShop;
    $shopId = $shop['id'];
 	?>
 			<p><span style="color:#ff9900;font-weight:bold;font-size:14px;">选择服务</span>
						
						<span class="serviceTypeRatio icheck">
					<?php 

// $hasFirstChecked = false;
 
// 			$shopServices=		WashShopService::model()->findAllByAttributes(array('wss_st_id'=>$shop['id']));
					
$shopServices = WashShopService::model()->getServices($shop['id'])['data'];
foreach ($shopServices as $key=>$service):
?>		
<label><input type="radio" name="sType" value="<?php echo $service['wss_st_id'];?>"  
<?php if ( $sType==$service['wss_st_id']) {						
	echo 'checked';
}?>   <?php if ($service['wss_state']!=1) {
							echo 'disabled';
						} ?>>
						<span id="sTypeRatioStr1" <?php if ($service['wss_state']!=1):?>
style="color: #D3D3D3;"
<?php endif;?>><?php echo  $service->wssSt['st_name'];?></span>   </label>				
						
						
<?php endforeach;?>				
</span>   
<?php 
Yii::app()->clientScript->registerScript('getShopCount',"
		function getShopCount(){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('order/getShopCount')."',
	  		dataType: 'json',
		data:{
	  		'id':".$shopId.",
	  'bias':$('input[name=\"serviceDate\"]:checked').val(),
	'sType':$('input[name=\"sType\"]:checked').val(),
	},
 		'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
		'error':function(){ layer.msg('加载失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(data){
		$('#availableCount').html(data.availableCount);
		$('#totalCount').html(data.totalCount);

}
});
};
		
		
		",CClientScript::POS_END);
?>

<?php 
 Yii::app()->clientScript->registerScript('dateRatio1',"

		
$('.serviceTypeRatio input').on('ifChecked', function(event){
			getShopCount();
	//	getProcessList();
});	
getShopCount();		
getTimeList();		
                    		",CClientScript::POS_READY);
 ?>  


</p>
					    <p><span style="color:#ff9900;font-weight:bold;font-size:14px;">服务日期</span>
					
					<span class="dateRatio icheck">
					<label>    <input type="radio" name="serviceDate" value="0" id="serviceDate0" <?php if ($bias == 0) {
						echo 'checked';
					}?> > 
				<span id="dateRatioStr0"><?php echo  date('m月d日',time());?> </span>	  
				</label>
<label>  <input type="radio" name="serviceDate" value="1" id="serviceDate1" <?php if ($bias == 1) {
						echo 'checked';
					}?> >
<span id="dateRatioStr1"><?php  echo  date('m月d日',time()+24*60*60*1);?> </span>
</label>  
<label>  <input type="radio" name="serviceDate" value="2" <?php if ($bias == 2) {
						echo 'checked';
					}?>  id="serviceDate2"> 
<span id="dateRatioStr2"><?php echo date('m月d日',time()+24*60*60*2);?> </span>
</label> 
 
				</span></p>
				
 <?php 
 Yii::app()->clientScript->registerScript('dateRatio',"
	
$('.dateRatio input').on('ifChecked', function(event){
		getTimeList();
});	   

$('.carTypeRatio input').on('ifChecked', function(event){
	//	$('#carType').html($('#carTypeRatioStr'+this.value).html());

	getTimeList();
});	
			
$('.serviceTypeRatio input').on('ifChecked', function(event){

//		$('#sType').html($('#sTypeRatioStr'+this.value).html());
		getTimeList();
});		

$('.positionRatio input').on('ifChecked', function(event){

		getTimeList();
});	
		
                    		",CClientScript::POS_READY);
 ?>  
				
						
						<p><span style="color:#ff9900;font-weight:bold;font-size:14px;">选择车型</span>
						<span class="carTypeRatio icheck">
						<label><input type="radio" name="carType" value="1" checked>
						<span id="carTypeStr1"><?php echo Yii::app()->params['carType'][1];?></span>   </label>
						<label>
<input type="radio" name="carType" value="2">
<span id="carTypeStr1"><?php echo Yii::app()->params['carType'][2];?></span></label></span> </p>


			
                   
						
						<p> <span style="color:#ff9900;font-weight:bold;font-size:14px;">选择位置</span>
						<span class="positionRatio icheck">
		<label><input type="radio" name="position" value="1" checked>
						<span id="sTypeRatioStr1">车位1</span>   </label>				
						<?php 
						for ($i = 1; $i < $shop['ws_num']; $i++):?>
<label><input type="radio" name="position" value="<?php echo $i+1;?>">
						<span id="sTypeRatioStr<?php echo $i+1;?>">车位<?php echo $i+1;?></span>   </label>							
						
							
						
						<?php endfor;?>
						</span>
</p>	
                        
                        <p style="color:#ff9900;font-weight:bold;font-size:14px;">选择时间
                        
                        </p>
                        
                      <div id="sDateList" class="sDateListClass"></div>
                    
                    
                        <?php 
                   
                        
Yii::app()->clientScript->registerScript('getTimeList',
"
function getTimeList(){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('boss/getTimelist')."',
		data:{
	  		'id':".$shopId.",
	  'bias':$('input[name=\"serviceDate\"]:checked').val(),
	  'carType':$('input[name=\"carType\"]:checked').val(),
	'sType':$('input[name=\"sType\"]:checked').val(),
	  		'position':$('input[name=\"position\"]:checked').val()
	},
 		async:false,
 	'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
		'success':function(html){
		$('#sDateList').html(html);
	layer.close(loadi);
 	$('#svalue').val('');

}
});
};
	  			

		",CClientScript::POS_END);


?>
      
      

                    

                  
		<div id="svalidate" >
		
<div class="form-group has-warning">
<label class="control-label" >服务价格(<i class="fa fa-jpy"></i>)</label>
<input type="text" class="form-control input-lg" name="svalue" id="svalue" placeholder="您的价格低于初始价格，页面会显示‘折’标注"/>

<?php 

Yii::app()->clientScript->registerScript('svalueMask',"
$('#svalidate').bootstrapValidator({
	        live:'enabled',
			fields:{
				\"svalue\": {
	                message: '输入价格不合法',
	                validators: {
	                	notEmpty: {
		                	enabled:true,
	                        message: '价格不能为空'
	                    },
	                    regexp: {
	                        regexp: /^\d{1,3}$/,
	                        message: '价格设置不合法'
	                    },

	                }
	            },

				},
	        
		});

		
	  
",CClientScript::POS_READY);
?>
</div>
	 <div class="form-group">
	 <div class="col-xs-12 col-md-2">
	  <input type="button" class="btn btn-info col-xs-12" id="btnDisableOrder"  onclick="orderAdd(1)" value="禁用选中车位" />
	 </div>
	
	<div class="col-xs-12 col-md-2">
	 <input type="button" id="btnEnableOrder" class="btn btn-success col-xs-12" onclick="orderAdd(2)" value="启用选中车位" />
	</div>
	 
	
	 	<div class="col-xs-12 col-md-3"><button type="submit" id="btnOrderAdd" class="btn btn-warning col-xs-12" onclick="orderAdd(3)">重新设置选中时间段信息</button></div>
	 

	 </div>
			
		</div>					
   <?php 

Yii::app()->clientScript->registerScript('orderAdd',
"
		
function orderAdd(utype){
		
if($('.sDateListClass input[enabled][name=\"sdate\"]:checked').length<1){
	layer.msg('请选择预约时间段', 1, 0);
		return false;
}		
var arr_d=new Array(); 
           $('.sDateListClass input:checked[name=\"sdate\"]').each(function(){ 
                   arr_d.push(this.value); 
            });		
		

		var loadi;
$.ajax({
	  		type : 'POST',
url:'".Yii::app()->createUrl('boss/orderUpdate')."',
		data:{
    		'ut':utype,
    		'sType':$('.serviceTypeRatio input:checked').val(),
    		  'carType':$('input[name=\"carType\"]:checked').val(),
	  		  'sValue':$('#svalue').val(),
    		'dates':arr_d.join(','),
	},
    dataType:'JSON',
    		async:false,
	  	
    		'beforeSend':function(){ loadi = layer.load('更新中...');},
		'error':function(){ layer.msg('加载失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(rlt){
    
if(rlt['status']){
	layer.msg(rlt['msg'],2,1);


  getTimeList();
  
}
else
{
// layer.msg(rlt['msg'], 1, 0);
     getTimeList();
}
}
});
};
		",CClientScript::POS_END);


?>						
				
					</div>
 </div>
 </section>

     
 