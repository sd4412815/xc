<?php
/* @var $this BossController */
/* @var $model Boss */

$this->breadcrumbs=array(
	'Bosses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Boss', 'url'=>array('index')),
	array('label'=>'Create Boss', 'url'=>array('create')),
	array('label'=>'View Boss', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Boss', 'url'=>array('admin')),
);
?>

<h1>Update Boss <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>