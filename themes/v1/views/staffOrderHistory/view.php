<?php
/* @var $this StaffOrderHistoryController */
/* @var $model StaffOrderHistory */

$this->breadcrumbs=array(
	'Staff Order Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StaffOrderHistory', 'url'=>array('index')),
	array('label'=>'Create StaffOrderHistory', 'url'=>array('create')),
	array('label'=>'Update StaffOrderHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StaffOrderHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StaffOrderHistory', 'url'=>array('admin')),
);
?>

<h1>View StaffOrderHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'soh_order_history_id',
		'soh_staff_id',
	),
)); ?>
