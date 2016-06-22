<?php
$this->pageTitle = '预约';

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.rotate.min.js", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_HEAD);
$shop = $model;
// $sType = Yii::app()->request->getParam('st',1);
$shopId = $shop['id'];
// @$shopId = $_GET['id'];

?>


<!--  navbar-btn  -->
<nav class="navbar navbar-default  navbar-fixed-bottom"
	style="position: fixed; bottom: 1px; width: 100%;" role="navigation">
	<div class="container">
		<h4 class="text-center">
			您已选择了 <span style="color: #fff;" id="sType">
<?php
echo ServiceType::model()->findByPk($sType)['st_name'];
?></span> 服务，预约时间 <span style="color: #fff;" id="selDate">未选择</span> <span
				style="color: #fff;" id="selTime"></span> ， <span id="selDiscount"></span>到店支付<span
				style="font-family: Arial;">&yen;</span> <span class="badge bg-red"
				id="sValue">0</span> 元 &nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-danger btn-lg" onclick="orderAdd()">免费预定</button>
		</h4>
	</div>
</nav>

<div class="row">
	<div class="col-lg-offset-1 col-lg-10">
		<ol class="breadcrumb" style="background: none;">
			<li><a href="#" class="text-black"><?php
echo $shop->city['c_name'];
?></a></li>
			<li><a href="#" class="text-black"><?php
echo $shop->area['a_name'];
?>			  
			  </a></li>
			<li class="active"><?php
echo $shop['ws_name'];
?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-offset-1 col-lg-10"">

		<marquee style="color: #f8981d; height: 10px border="
			0" scrolldelay="120">
			<b><?php
$latestNew = ShopNews::model()->findByAttributes(array(
    'sn_shop_id' => $shop['id']
), array(
    'order' => 'sn_date DESC'
));
echo $latestNew['sn_desc'];
?></b>
		</marquee>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-9 col-lg-8 col-lg-offset-1">
<?php
echo $this->renderPartial('_shopOrderInfo', array(
    'shop' => $shop,
    'bias' => $bias,
	'sType'=>$sType,
));
?>
</div>
	<div class="col-xs-12 col-sm-3 col-lg-2"
		style="border: 1px solid #f8981d; border-radius: 10px; padding: 5px 10px; background: #fee0b9;">
<?php
echo $this->renderPartial('_shopOverview', array(
    'shop' => $shop
));
?>
</div>


</div>


<?php
Yii::app()->clientScript->registerScript('getShopCount', "
		function getShopCount(){
$.ajax({
url:'" . Yii::app()->createUrl('order/getShopCount') . "',
	  		dataType: 'json',
		data:{
	  		'id':" . $shopId . ",
	  'bias': $('.dateRatio').find('.btn-app1').data('value'),
	'sType':$('.serviceTypeRatio').find('.btn-app1').data('value'),
	},
		'success':function(data){
		$('#availableCount').html(data.availableCount);
		$('#totalCount').html(data.totalCount);

}
});
};
		
		
		", CClientScript::POS_END);
?>


          
          

<?php

Yii::app()->clientScript->registerScript('btnRequestCard', "
function addCard(){
		var loadi;
$.ajax({
url:'" . Yii::app()->createUrl('cardinvite/addCard') . "',
		data:{
		'pwd':$('#cardPWD').val(),
	},
		dataType:'JSON',
 		async:false,
 	'beforeSend':function(){ },
 		'complete':function(){},
		'success':function(html){
         if(html.status){
	layer.msg('添加成功...',2,1);
// 		$('#sDateList').html(html);
userCardList();
		$('#cardPWD').val('');
 //	$('#svalue').val('');
}else{
layer.msg(html.msg);
}
 	

}
});
};
	  			

		", CClientScript::POS_END);

?>	          	



						
   <?php

Yii::app()->clientScript->registerScript('orderAdd', "
		
function orderAdd(){
		
if($('.sDateListRatio').find('.btn-app1').length<1){
	layer.msg('请选择预约时间段', 1, 0);
		return;
}		
		var loadi;
$.ajax({
	  		type : 'POST',
url:'" . Yii::app()->createUrl('order/orderAdd') . "',
		data:{
	  		'id':$('.sDateListRatio').find('.btn-app1').data('value'),
	  		  'sValue':$('.sDateListRatio').find('.btn-app1').data('price'),
         'ct':  $('.carTypeRatio').find('.btn-app1').data('value'),
          'card':$('.cardRatio input[name=\"cards\"]:checked').val(),
		'timeInfo':$('.sDateListRatio').find('.btn-app1').data('discount'),
	},
		dataType:'JSON',
	  		'beforeSend':function(){ loadi = layer.load('预定中...');},
		'error':function(data){
		alert(data);
window.location.href='" . Yii::app()->createUrl('site/login',array('type'=>'autoredirect')). "';

},
		'complete':function(){ layer.close(loadi);},
		'success':function(data){
if(data.status){
window.location.reload();
}
else
{
layer.msg(data.msg, 2, 0);
}
}
});
};
		", CClientScript::POS_END);

?>						
				
                 
 <?php
Yii::app()->clientScript->registerScript('getTimeList', "
function getTimeList(){
		var loadi;
$.ajax({
url:'" . Yii::app()->createUrl('order/getTimelist') . "',
    dataType:'JSON',
		data:{
	  		'id':" . $shopId . ",
	  'bias': $('.dateRatio').find('.btn-app1').data('value'),
	  'carType':$('.carTypeRatio').find('.btn-app1').data('value'),
	'sType':  $('.serviceTypeRatio').find('.btn-app1').data('value'),
	  		'position':$('.positionRatio').find('.btn-app1').data('value')
	},
		'beforeSend':function(){ loadi = layer.load(" . Yii::app()->params['loadString'] . ");},
		'error':function(){ layer.msg('加载失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(rlt){
		$('#sDateList').html(rlt.timeList);
 for(var i=1;i<=rlt.count.size;i++){
    $
$('#pcount'+i).html(rlt.count['p'+i]);
}   
    $('#pcount').html(rlt.count);
	$('#selDate').html('');
			$('#sValue').html('0');
		$('#selTime').html('未选择');
}
});
};

		", CClientScript::POS_END);

?>
      

 <?php
// Yii::app ()->clientScript->registerScript ( 'getCommentList', "
// function getCommentList(){
// var loadi;
// $.ajax({
// type : 'POST',
// url:'" . Yii::app ()->createUrl ( 'order/getCommentList' ) . "',
// data:{
// 'id':" . $shopId . ",
// },
// 'beforeSend':function(){ loadi = layer.load(" . Yii::app ()->params ['loadString'] . ");},
// 'error':function(){ layer.msg('加载失败');},
// 'complete':function(){ layer.close(loadi);},
// 'success':function(html){jQuery('#commentList').html(html)}
// });
// };

// ", CClientScript::POS_END );
										
										?>
			
			
						
			  			  <?php
// 										Yii::app ()->clientScript->registerScript ( 'getNewList', ";
// function getNewList(){
// var loadi;
// $.ajax({
// type : 'POST',
// url:'" . Yii::app ()->createUrl ( 'order/getNewList' ) . "',
// data:{
// 'id':" . $shopId . ",
// },
// 'beforeSend':function(){ loadi = layer.load(" . Yii::app ()->params ['loadString'] . ");},
// 'error':function(){ layer.msg('加载失败');},
// 'complete':function(){ layer.close(loadi);},
// 'success':function(html){jQuery('#commentList').html(html)}
// });
// };

// ", CClientScript::POS_END );
			    ?>




<?php
Yii::app()->clientScript->registerScript('changeMenuStyle', "
		
var rotation = function (){
   $(\"#sValue\").rotate({
      angle:0, 
      animateTo:360, 
      callback: rotation
   });
}
rotation(); 		
   $('#mlist').addClass('active');

		", CClientScript::POS_READY);

?>

			  			  <?php
        Yii::app()->clientScript->registerScript('userCardList', "
function userCardList(){
		var loadi;
$.ajax({
			type : 'POST',
url:'" . Yii::app()->createUrl('order/userCardList') . "',
		data:{
		'id':" . $shop['id'] . ",
		'sType':$('.serviceTypeRatio').find('.btn-app1').data('value'),
		 'bias': $('.dateRatio').find('.btn-app1').data('value'),
		'timeInfo':$('.sDateListRatio').find('.btn-app1').data('discount'),
	},
		'beforeSend':function(){ },
		'error':function(){ layer.msg('加载失败');},
		'complete':function(){ },
		'success':function(html){ 		$('#cardList').html(html);}
});
};

		", CClientScript::POS_END);
        ?>
										


 