<?php
/* @var $this CarTypeController */
/* @var $model CarType */

$this->breadcrumbs=array(
	'Car Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarType', 'url'=>array('index')),
	array('label'=>'Create CarType', 'url'=>array('create')),
	array('label'=>'View CarType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarType', 'url'=>array('admin')),
);
?>

<h1>Update CarType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>