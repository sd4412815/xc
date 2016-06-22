<?php
/* @var $this CarTypeController */
/* @var $model CarType */

$this->breadcrumbs=array(
	'Car Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarType', 'url'=>array('index')),
	array('label'=>'Create CarType', 'url'=>array('create')),
	array('label'=>'Update CarType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarType', 'url'=>array('admin')),
);
?>

<h1>View CarType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ct_name',
		'ct_spell',
		'ct_car_brand_id',
	),
)); ?>
