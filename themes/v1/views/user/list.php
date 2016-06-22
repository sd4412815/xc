<?php
$this->pageTitle = '订单列表';
?>
<section class="content-header">
	<h1>
		订单列表
	</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">订单列表</li>
	</ol>
</section>




<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-body table-responsive no-padding">



					<div id="list">
 <?php
	$this->renderPartial ( '_list', array (
			'dataProvider' => $dataProvider 
	) );
	?>
 </div>

				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<!-- /.content -->

<script type="text/javascript">
<!--

function orderAck(orderId,ackType){

	var mydata;
	if(ackType==1){

		mydata={
	id:orderId,
	type:ackType,
	score:$("#star"+orderId).raty('score'),
	comment:$("#text"+orderId).val()
				};
	}else{

		mydata = {
			id:orderId,
			type:ackType
		};
	}
	        	  
	        		$.ajax({
	        			type : 'POST',
	        			url:'<?php echo Yii::app()->createUrl("orderHistory/orderAckbyUser");?>',
	     
	        			dataType: 'json',
	        			async:false, // 可去掉
	        			data:mydata,
	        			success:function(data) { 

	        			if(data.state == true){
	        				 $.fn.yiiListView.update(
	        			                'ajaxOrderList'
	        			            );

	        
	        			
	            			}
	        			else
	        			{
	            			alert("确认失败");

	            			}

	        		}

	        		}); // end ajax

	              
	     }

//-->
</script>
<?php
Yii::app ()->clientScript->registerScript ( 'dzratyUpdates', "
function dzRatyUpdate() {
	jQuery('.raty-cell').raty({'space':false,'width':100,'score':function(){ return $(this).data('score'); }}).each(function(){
					jQuery('#'+jQuery(this).data('target')).hide();
				});}
", CClientScript::POS_BEGIN );
?>
<?php
Yii::app ()->clientScript->registerScript ( 'ready', "
		 $('#menuList').addClass('active');	
", CClientScript::POS_READY );
?>