<?php
/* @var $this OrderCommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order Comments',
);

$this->menu=array(
	array('label'=>'Create OrderComments', 'url'=>array('create')),
	array('label'=>'Manage OrderComments', 'url'=>array('admin')),
);
?>

<h1>Order Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
