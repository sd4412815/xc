<?php
/* @var $this OrderHistoryItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order History Items',
);

$this->menu=array(
	array('label'=>'Create OrderHistoryItem', 'url'=>array('create')),
	array('label'=>'Manage OrderHistoryItem', 'url'=>array('admin')),
);
?>

<h1>Order History Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
