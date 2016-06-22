<?php
/* @var $this ProvinceController */
/* @var $model Province */

$this->breadcrumbs=array(
	'Provinces'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Province', 'url'=>array('index')),
	array('label'=>'Create Province', 'url'=>array('create')),
	array('label'=>'Update Province', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Province', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Province', 'url'=>array('admin')),
);
?>

<h1>View Province #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'p_no',
		'p_name',
		'p_spell',
	),
)); ?>
