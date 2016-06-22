<?php
/* @var $this TimeZoneController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Time Zones',
);

$this->menu=array(
	array('label'=>'Create TimeZone', 'url'=>array('create')),
	array('label'=>'Manage TimeZone', 'url'=>array('admin')),
);
?>

<h1>Time Zones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
