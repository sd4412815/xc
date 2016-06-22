<?php
$this->pageTitle = '历史通知信息';
?>
<section class="content-header">
	<h1>
		历史通知信息
	</h1>
	<ol class="breadcrumb hidden-xs">
	<li><a
			><i
				class="fa fa-dashboard"></i> 个人主页</a></li>
		<li class="active">个人信息</li>
	</ol>
</section>




<!-- Main content -->
<section class="content">
	
		<div class="box box-none">

			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">



				<div id="msgList">
 <?php
	$this->renderPartial ( '_msgList', array (
			'dataProvider' => $dataProvider 
	) );
	?>
 </div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	

</section>
<!-- /.content -->
<?php 
Yii::app()->clientScript->registerScript('search','
function readmsg(id) {
		showMsgModal(id);
        $.fn.yiiListView.update(
                "ajaxMsgList"
            );

}
',CClientScript::POS_END);
?>


