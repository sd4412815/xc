<?php
$this->pageTitle = '洗车服务设置';
?>

<div style="background:#eee;width:100%">

	<div class="text-center" >
		<?php if($shop['ws_state']==1):?>
			<p style="font-size:14px;color:red">本页设置自<?php echo date('m月d日',strtotime('+3 days'));?>起生效</p>
		<?php endif;?>
		
	</div>
	
</div>

<!-- </section> -->
<?php if($shop['ws_state']==2):?>
	<div class="alert alert-danger " role="alert">
    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    	<strong>注意!</strong> 保存设置后将初始化时间段信息！
	</div>
<?php endif;?>

<div style="background-color: #eee;">
	<?php $this->renderPartial('_shopServiceSetForm1',array('shop'=>$shop,'model'=>$model));?>
</div>
<?php
/*	Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
	 $('#serviceSet').addClass('active');
	", CClientScript::POS_READY );
*/?>


