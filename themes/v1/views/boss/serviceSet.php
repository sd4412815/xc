<?php
$this->pageTitle = '服务基准设置';
?>
<section class="content-header">
	<h1>
服务基准设置
		<?php if($shop['ws_state']==1):?>
		<small><code>本页设置自<?php echo date('m月d日',strtotime('+3 days'));?>起生效</code></small>
		<?php endif;?>
		
	</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('boss/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">面板</li>
	</ol>
</section>

<section class="content">
<?php if($shop['ws_state']==2):?>
  <div class="alert alert-danger " role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>注意!</strong> 保存设置后将初始化时间段信息！
    </div>
<?php endif;?>

    <div class="row">
					    <div class="col-md-12">
                            <div class="box box-primary">
                               <div class="box-body">   
<?php
 $this->renderPartial('_shopServiceSetForm',array('shop'=>$shop,'model'=>$model));
 ?>
         </div><!-- /.box-body --> 
      </div><!-- /.box -->
					    </div>
					</div>
</section>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#serviceSet').addClass('active');
", CClientScript::POS_READY );

?>	