<?php
/* @var $this TimeZoneController */
/* @var $model TimeZone */

$this->breadcrumbs=array(
	'Time Zones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TimeZone', 'url'=>array('index')),
	array('label'=>'Manage TimeZone', 'url'=>array('admin')),
);
?>

<h1>Create TimeZone</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>