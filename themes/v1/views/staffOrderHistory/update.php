<?php
/* @var $this StaffOrderHistoryController */
/* @var $model StaffOrderHistory */

$this->breadcrumbs=array(
	'Staff Order Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StaffOrderHistory', 'url'=>array('index')),
	array('label'=>'Create StaffOrderHistory', 'url'=>array('create')),
	array('label'=>'View StaffOrderHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StaffOrderHistory', 'url'=>array('admin')),
);
?>

<h1>Update StaffOrderHistory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>