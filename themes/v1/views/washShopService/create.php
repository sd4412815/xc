<?php
/* @var $this WashShopServiceController */
/* @var $model WashShopService */

$this->breadcrumbs=array(
	'Wash Shop Services'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WashShopService', 'url'=>array('index')),
	array('label'=>'Manage WashShopService', 'url'=>array('admin')),
);
?>

<h1>Create WashShopService</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>