<?php
/* @var $this StaffOrderHistoryController */
/* @var $model StaffOrderHistory */

$this->breadcrumbs=array(
	'Staff Order Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StaffOrderHistory', 'url'=>array('index')),
	array('label'=>'Manage StaffOrderHistory', 'url'=>array('admin')),
);
?>

<h1>Create StaffOrderHistory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>