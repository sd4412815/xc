<?php
/* @var $this OrderHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order Histories',
);

$this->menu=array(
	array('label'=>'Create OrderHistory', 'url'=>array('create')),
	array('label'=>'Manage OrderHistory', 'url'=>array('admin')),
);
?>

<h1>Order Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
