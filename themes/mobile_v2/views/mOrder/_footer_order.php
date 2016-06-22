<footer class="main-footer navbar-fixed-bottom"
	style="padding: 2px 0 2px 0; background-color: #f9fafc">
<div class="col-xs-12 text-auto-hide bg-info"  style="margin: -2px 0 3px 0;"><span id="uGiftStr" class="h6"></span></div>
	<div class="pull-left col-xs-8  text-auto-hide text-center"
		id="order-info"> 
		<span class=" h4 " id="uType">请选择时间</span> 
		<i class="fa fa-jpy text-danger"></i><span class="text-danger h2" id="uPrice"></span>
		<span class="h6 text-delete" id="uPriceIni"></span>
		<code> <span id="uTime"></span> </code> 
		<span class="btn btn-flat" style="border: 0px;"></span>
	</div>
	<div class="pull-right">
<?php 
if (Yii::app()->user->isGuest):
?>	
		<button id="sOrder"	class="btn btn-success btn-flat disabled" onclick="showCheckTel();">
			<i class="fa fa-cart-plus"></i> 免费预订
		</button>
<?php else:?>
<?php
// Yii::app ()->user->logout ();
// 		Yii::app()->session->clear();
// 		Yii::app()->session->destroy();
?>
<a id="sOrder" href="<?php echo Yii::app()->createUrl('mOrder/rlt');?>"
			class="btn btn-success btn-flat disabled">
			<i class="fa fa-cart-plus"></i> 免费预订
		</a>
<?php endif;?>
	</div>
		
<!-- 	$(document).on("click","#sOrder",function(){showCheckTel();}); -->
</footer>
<!-- The Right Sidebar -->






