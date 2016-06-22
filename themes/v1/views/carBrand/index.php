<?php
/* @var $this CarBrandController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Brands',
);

$this->menu=array(
	array('label'=>'Create CarBrand', 'url'=>array('create')),
	array('label'=>'Manage CarBrand', 'url'=>array('admin')),
);
?>

<h1>Car Brands</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
