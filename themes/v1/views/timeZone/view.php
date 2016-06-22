<?php
/* @var $this TimeZoneController */
/* @var $model TimeZone */

$this->breadcrumbs=array(
	'Time Zones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TimeZone', 'url'=>array('index')),
	array('label'=>'Create TimeZone', 'url'=>array('create')),
	array('label'=>'Update TimeZone', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TimeZone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TimeZone', 'url'=>array('admin')),
);
?>

<h1>View TimeZone #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tz_start',
		'tz_interval',
		'tz_stop',
	),
)); ?>
