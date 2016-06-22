<?php
/* @var $this BossController */
/* @var $model Boss */

$this->breadcrumbs=array(
	'Bosses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Boss', 'url'=>array('index')),
	array('label'=>'Create Boss', 'url'=>array('create')),
	array('label'=>'Update Boss', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Boss', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Boss', 'url'=>array('admin')),
);
?>

<h1>View Boss #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'b_name',

		'b_pwd',
		'b_nick_name',
		'b_type',
	),
)); ?>
