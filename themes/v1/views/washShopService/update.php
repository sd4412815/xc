<?php
/* @var $this WashShopServiceController */
/* @var $model WashShopService */

$this->breadcrumbs=array(
	'Wash Shop Services'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WashShopService', 'url'=>array('index')),
	array('label'=>'Create WashShopService', 'url'=>array('create')),
	array('label'=>'View WashShopService', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WashShopService', 'url'=>array('admin')),
);
?>

<h1>Update WashShopService <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>