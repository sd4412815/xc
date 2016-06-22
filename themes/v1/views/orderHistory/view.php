<?php
/* @var $this OrderHistoryController */
/* @var $model OrderHistory */

$this->breadcrumbs=array(
	'Order Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderHistory', 'url'=>array('index')),
	array('label'=>'Create OrderHistory', 'url'=>array('create')),
	array('label'=>'Update OrderHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderHistory', 'url'=>array('admin')),
);
?>

<h1>View OrderHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'oh_no',
		'oh_wash_shop_id',
		'oh_user_ack',
		'oh_boss_ack',
		'oh_staff_ack',
		'oh_order_date_time',
		'oh_date_time',
		'oh_value',
		'oh_value_src',
		'oh_state',
		'oh_user_id',
	),
)); ?>
