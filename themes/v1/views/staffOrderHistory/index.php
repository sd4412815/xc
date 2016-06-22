<?php
/* @var $this StaffOrderHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Order Histories',
);

$this->menu=array(
	array('label'=>'Create StaffOrderHistory', 'url'=>array('create')),
	array('label'=>'Manage StaffOrderHistory', 'url'=>array('admin')),
);
?>

<h1>Staff Order Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
