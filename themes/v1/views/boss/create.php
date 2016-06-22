<?php
/* @var $this BossController */
/* @var $model Boss */

$this->breadcrumbs=array(
	'Bosses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Boss', 'url'=>array('index')),
	array('label'=>'Manage Boss', 'url'=>array('admin')),
);
?>

<h1>Create Boss</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>