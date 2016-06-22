<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */

$this->breadcrumbs=array(
	'Service Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceType', 'url'=>array('index')),
	array('label'=>'Manage ServiceType', 'url'=>array('admin')),
);
?>

<h1>Create ServiceType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>