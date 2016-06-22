<?php
/* @var $this CarTypeController */
/* @var $model CarType */

$this->breadcrumbs=array(
	'Car Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarType', 'url'=>array('index')),
	array('label'=>'Manage CarType', 'url'=>array('admin')),
);
?>

<h1>Create CarType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>