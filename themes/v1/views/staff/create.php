<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Staff'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Staff', 'url'=>array('index')),
	array('label'=>'Manage Staff', 'url'=>array('admin')),
);
?>

<h1>Create Staff</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>