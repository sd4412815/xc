<?php
/* @var $this OrderHistoryItemController */
/* @var $model OrderHistoryItem */

$this->breadcrumbs=array(
	'Order History Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderHistoryItem', 'url'=>array('index')),
	array('label'=>'Create OrderHistoryItem', 'url'=>array('create')),
	array('label'=>'View OrderHistoryItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderHistoryItem', 'url'=>array('admin')),
);
?>

<h1>Update OrderHistoryItem <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>