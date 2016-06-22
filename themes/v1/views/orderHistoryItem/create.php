<?php
/* @var $this OrderHistoryItemController */
/* @var $model OrderHistoryItem */

$this->breadcrumbs=array(
	'Order History Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderHistoryItem', 'url'=>array('index')),
	array('label'=>'Manage OrderHistoryItem', 'url'=>array('admin')),
);
?>

<h1>Create OrderHistoryItem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>