<?php
/* @var $this CarBrandController */
/* @var $model CarBrand */

$this->breadcrumbs=array(
	'Car Brands'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarBrand', 'url'=>array('index')),
	array('label'=>'Create CarBrand', 'url'=>array('create')),
	array('label'=>'Update CarBrand', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarBrand', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarBrand', 'url'=>array('admin')),
);
?>

<h1>View CarBrand #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cb_name',
		'cb_spell',
	),
)); ?>
