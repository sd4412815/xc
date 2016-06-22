<?php
/* @var $this OrderHistoryController */
/* @var $model OrderHistory */

$this->breadcrumbs=array(
	'Order Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderHistory', 'url'=>array('index')),
	array('label'=>'Manage OrderHistory', 'url'=>array('admin')),
);
?>

<h1>Create OrderHistory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>