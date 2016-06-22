<?php
/* @var $this WashShopServiceController */
/* @var $model WashShopService */

$this->breadcrumbs=array(
	'Wash Shop Services'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WashShopService', 'url'=>array('index')),
	array('label'=>'Create WashShopService', 'url'=>array('create')),
	array('label'=>'Update WashShopService', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WashShopService', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WashShopService', 'url'=>array('admin')),
);
?>

<h1>View WashShopService #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'wss_ws_id',
		'wss_st_id',
	),
)); ?>
