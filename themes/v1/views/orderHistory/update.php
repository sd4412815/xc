<?php
/* @var $this OrderHistoryController */
/* @var $model OrderHistory */

$this->breadcrumbs=array(
	'Order Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderHistory', 'url'=>array('index')),
	array('label'=>'Create OrderHistory', 'url'=>array('create')),
	array('label'=>'View OrderHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderHistory', 'url'=>array('admin')),
);
?>

<h1>Update OrderHistory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>