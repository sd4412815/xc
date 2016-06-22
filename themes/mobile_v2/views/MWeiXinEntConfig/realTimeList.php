<?php
$this->pageTitle ='实时预约单';
// $boss = Boss::model()->findByAttributes(array(
// 		'b_user_id'=>Yii::app()->user->id,
// ));

// $shop = $boss->washShop;
$shopId = $shop['id'];
?>


<section class="content-header">
<h1>实时预约单<small>
<span class="dateRatio icheck">
					<label>    <input type="radio" name="serviceDate" value="0" id="serviceDate0" checked> 
				<span id="dateRatioStr0"><?php echo  date('m月d日',time());?> </span>	  
				</label>
<label>  <input type="radio" name="serviceDate" value="1" id="serviceDate1"  >
<span id="dateRatioStr1"><?php  echo  date('m月d日',time()+24*60*60*1);?> </span>
</label>  
<label>  <input type="radio" name="serviceDate" value="2"  id="serviceDate2"> 
<span id="dateRatioStr2"><?php echo date('m月d日',time()+24*60*60*2);?> </span>
</label>  
<label>  <input type="radio" name="serviceDate" value="-1"  id="serviceDate-1"> 
<span id="dateRatioStr-1">全部</span>
</label>  
				</span>


</small> </h1>
 <?php 
 Yii::app()->clientScript->registerScript('dateRatio',"
	
$('.dateRatio input').on('ifChecked', function(event){
		getRealTimeList();
});	   

                    		",CClientScript::POS_READY);
 ?>  
 <ol class="breadcrumb hidden-xs">
 <li><a href="<?php echo Yii::app()->createUrl('boss/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
<li class="active">实时预约单</li>
</ol>
</section>
    
 
 <section class="content">
 <div >
 
 <div class="col-xs-12">
 	<div id="sDateList" class="sDateListClass"></div>
 </div>
 
 </div>
 
 </section>


 <?php 
                   
                        
Yii::app()->clientScript->registerScript('getTimeList',
"
function getRealTimeList(){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('boss/getRealTimelist')."',
		data:{
	  		'id':".$shopId.",
		'bias':$('input[name=\"serviceDate\"]:checked').val()
	},
 		async:false,
 	'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
 		'complete':function(){layer.close(loadi);},
		'success':function(html){
		$('#sDateList').html(html);

}
});
};
	  			

		",CClientScript::POS_END);


?>


<?php 

Yii::app()->clientScript->registerScript('ready',"
		 $('#menu-realTimeList').addClass('active');	
getRealTimeList();
window.setInterval(getRealTimeList, ".Yii::app()->params['autoRefreshTime']."); 

",CClientScript::POS_READY);
?>