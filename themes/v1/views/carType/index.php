<?php
/* @var $this CarTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Types',
);

$this->menu=array(
	array('label'=>'Create CarType', 'url'=>array('create')),
	array('label'=>'Manage CarType', 'url'=>array('admin')),
);
?>

<h1>Car Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
