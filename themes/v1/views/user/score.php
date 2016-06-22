<?php
$this->pageTitle = '我的积分';
$user = User::model ()->findByPk ( Yii::app ()->user->id );
?>
<section class="content-header">
	<h1>我的积分</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">预约列表</li>
	</ol>
</section>




<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-lg-6 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						<?php echo $user['u_score'];?> <sup style="font-size: 18px">分</sup>
					</h3>
					<p>我的积分</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="<?php echo Yii::app()->createUrl('order/list'); ?>"
					class="small-box-footer"> 马上预约 <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-6 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3>
						Lv
<?php
$getLeveRlt = UScore::getLevel ( $user ['u_score'] );
echo $getLeveRlt ['data'] ['level']?> <sup style="font-size: 18px">当前等级</sup>
					</h3>
					<p>还需 <?php echo  $getLeveRlt['data']['next']-$user['u_score'];?> 积分即可升级到 Lv2</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?php echo Yii::app()->createUrl('order/list'); ?>"
					class="small-box-footer"> 马上预约 <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->
	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-xs-12">
			<div class="box">

				<div class="box-body table-responsive no-padding">

					<div id="list">
 <?php
	$this->renderPartial ( '_score', array (
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

<?php
Yii::app ()->clientScript->registerScript ( 'ready', "
		 $('#menuScore').addClass('active');	
", CClientScript::POS_READY );
?>
