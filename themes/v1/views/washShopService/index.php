<?php
/* @var $this WashShopServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Wash Shop Services',
);

$this->menu=array(
	array('label'=>'Create WashShopService', 'url'=>array('create')),
	array('label'=>'Manage WashShopService', 'url'=>array('admin')),
);
?>

<h1>Wash Shop Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
