<?php
$this->pageTitle = '车品牌设置';
?>
<section class="content-header">
	<h1>车品牌设置</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('mngr/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">面板</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
	</div>

</section>
