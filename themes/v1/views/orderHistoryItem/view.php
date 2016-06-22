<?php
/* @var $this OrderHistoryItemController */
/* @var $model OrderHistoryItem */

$this->breadcrumbs=array(
	'Order History Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderHistoryItem', 'url'=>array('index')),
	array('label'=>'Create OrderHistoryItem', 'url'=>array('create')),
	array('label'=>'Update OrderHistoryItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderHistoryItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderHistoryItem', 'url'=>array('admin')),
);
?>

<h1>View OrderHistoryItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ohi_oh_id',
		'ohi_si_id',
	),
)); ?>
