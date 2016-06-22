<?php
$this->pageTitle = '';
?>
<?php

$this->renderPartial ( '_menu_order', array (
		'shopName' => $this->shopName 
) );
?>
<!-- Custom Tabs -->
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active text-center"><a href="#tab-order" data-toggle="tab">服务</a></li>
		<li class=" text-center"><a href="#tab-comments" data-toggle="tab">评论(<span
				class="text-danger"><?php echo $shop['commentCount'];?></span>)
		</a></li>
		<li class=" text-center"><a href="#tab-detail" data-toggle="tab">详情</a></li>
		<li class="pull-right " style="margin: 0;"><a href="#"
			class=" text-muted"><i class="fa fa-location-arrow"></i>导航</a></li>
		<li class="pull-right " style="margin: 0;"><a href="tel://13898800771"
			class=" text-muted"><i class="fa fa-phone"></i>电话</a></li>


	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-order">
<?php

$this->renderPartial ( '_service', array (
		'model' => $model,
		'shop' => $shop,
		'serviceTypeList' => $serviceTypeList,
		'carGroupList' => $carGroupList,
		'selectedParams' => $selectedParams,
		'timeList' => $timeList 
) );
?>
              </div>
		<!-- /.tab-pane -->
		<div class="tab-pane" id="tab-comments">
<?php

$this->renderPartial ( '_comments', array (
		'model' => $model,
		'shop' => $shop,
		'serviceTypeList' => $serviceTypeList 
) );
?>
              </div>
		<!-- /.tab-pane -->
		<div class="tab-pane" id="tab-detail">
<?php

$this->renderPartial ( '_detail', array (
		'shop' => $shop,
		'model' => $model,
		'serviceTypeList' => $serviceTypeList 
) );
?>
              </div>
		<!-- /.tab-pane -->
	</div>
	<!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->



<!-- Tab panes -->
<?php
$this->renderPartial ( '_footer_order' );
?>
<?php

Yii::app ()->clientScript->registerScript ( 'menu_order_list', ' 
list_filter_ini();          		
			', CClientScript::POS_READY );
?>

<?php

Yii::app ()->clientScript->registerScript ( 'ajaxTimeList', "
function ajaxUpdateTimelist(){
	$.ajax({
		type:'GET',
		url:'" . Yii::app ()->createUrl ( 'mOrder/ajaxTimeList', array (
		'id' => $shop ['id'] 
) ) . "',
        dataType:'JSON',
		data:{
		},
// 	 	async:true,
	 	'beforeSend':function(){ $('#stimelist').addClass('loader-inner ball-pulse');$('#stimelist').loaders(); },
	 	'complete':function(){},
		'success':function(rlt){
            $('#stimelist').removeClass('loader-inner ball-pulse');
            $.each(rlt, function(i,val){  
            	  $('#'+i).html(val);		    
  			});
		}
	});	
}
            		
function ajaxUpdatePrice(){
	$.ajax({
		type:'GET',
		url:'" . Yii::app ()->createUrl ( 'mOrder/ajaxPrice', array (
		'id' => $shop ['id'] 
) ) . "',
        dataType:'JSON',
		data:{	
            'orderId':$('#stimelist').find('.current').data('value'),	
		},
// 	 	async:true,
	 	'beforeSend':function(){  	$('#uPrice').html(' <i class=\"fa fa-spinner fa-pulse\"></i>');},
	 	'complete':function(){},
		'success':function(rlt){
            $.each(rlt['data'], function(i,val){  
            	$('#'+i).html(val);		    
  			});
            if(rlt['status']){
               	$('#sOrder').removeClass('disabled');
			}else{
               	$('#sOrder').addClass('disabled');
			}
               		
		}
	});	
}
					
var flavr_obj;					
				
function showCheckTel(){
	new $.flavr({ content
        : '<iframe id=\"checkTel\" width=\"300\" height=\"305\" src=\"" . Yii::app ()->createUrl ( 'mSite/CheckTel',array(
        'callback'=>Yii::app()->createUrl('mOrder/rlt'),'iframe'=>true,	
) ) . "\" frameborder=\"0\" scrolling=\"auto\" allowfullscreen></iframe>', 
			  onLoad   : function(){
    flavr_obj = this;
    },
        closeOverlay :true,closeEsc:true , animateEntrance:'fadeInDown',
		 animateClosing:'fadeOutDown',buttons : false });
};  
function close_flavr(){
 flavr_obj.closeAll(); 
}			
 iframe_resize(\"checkTel\");             		
               		
			", CClientScript::POS_END );

?>






