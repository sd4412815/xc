<?php
/* @var $this ProvinceController */
/* @var $model Province */

$this->breadcrumbs=array(
	'Provinces'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Province', 'url'=>array('index')),
	array('label'=>'Create Province', 'url'=>array('create')),
	array('label'=>'View Province', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Province', 'url'=>array('admin')),
);
?>

<h1>Update Province <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>