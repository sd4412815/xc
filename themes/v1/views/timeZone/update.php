<?php
/* @var $this TimeZoneController */
/* @var $model TimeZone */

$this->breadcrumbs=array(
	'Time Zones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TimeZone', 'url'=>array('index')),
	array('label'=>'Create TimeZone', 'url'=>array('create')),
	array('label'=>'View TimeZone', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TimeZone', 'url'=>array('admin')),
);
?>

<h1>Update TimeZone <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>