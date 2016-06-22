<?php
$this->pageTitle = '基本信息';
?>
<section class="content-header">
	<h1>基本信息</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i
				class="fa fa-dashboard"></i>我的账户</a></li>
		<li class="active">基本信息</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<section class="col-sm-6 col-md-6 col-lg-4">
			<div class="box box-primary">
				<div class="box-body">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>

			</div>
			<!-- /.box-body -->
	</section>
<!-- /.content -->
	</div>
	<!-- /.box -->
</section>


<?php 
Yii::app()->clientScript->registerScript('ready',"
		 $('#menuUserInfo').addClass('active');	
",CClientScript::POS_READY);
?>