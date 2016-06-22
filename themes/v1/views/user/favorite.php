<?php
$this->pageTitle = '我的收藏';
$user = User::model ()->findByPk ( Yii::app ()->user->id );
?>
<section class="content-header">
	<h1>我的收藏</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('user/profile');?>"><i
				class="fa fa-dashboard"></i> 个人主页</a></li>
		<li class="active">我的收藏</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"></h3>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<tr>
							<td class="col-sm-3 col-md-2">店名</td>
							<td class="col-sm-5 col-md-6">地址</td>
							<td class="col-sm-2 col-md-2">评分</td>
							<td class="col-sm-2 col-md-2">操作</td>
						</tr>
<?php
$favoriates = User::model ()->findByPk ( Yii::app ()->user->id )->favoriateShops;
foreach ( $favoriates as $key => $fs ) :
$shop = $fs->fsShop;	
?>
<tr>
							<td><a
								href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']));?>"><?php echo $shop['ws_name'];?></a></td>
							<td><?php echo $shop['ws_address'];?></td>
							<td>
 <?php echo  $this->widget('star.starWidget',array('score'=> $shop['ws_score'])); ?>									
							</td>
							<td><a
								href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']))?>"
								class="btn btn-warning btn-sm">预定</a>
<?php echo CHtml::link(CHtml::encode('删除'),
		array('FavoriteShop/delete','id'=>$fs['id']),
		array(
'submit'=>array('FavoriteShop/delete','id'=>$fs['id']),
				'class'=>'btn btn-danger btn-sm','confirm'=>'确认删除该收藏?'));?>
								</td>
						</tr>
									   <?php endforeach;;?>
									  
									   
									</table>

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
		 $('#menuFavorite').addClass('active');	
", CClientScript::POS_READY );
?>