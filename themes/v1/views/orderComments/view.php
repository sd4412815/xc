<?php
/* @var $this OrderCommentsController */
/* @var $model OrderComments */

$this->breadcrumbs=array(
	'Order Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderComments', 'url'=>array('index')),
	array('label'=>'Create OrderComments', 'url'=>array('create')),
	array('label'=>'Update OrderComments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderComments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderComments', 'url'=>array('admin')),
);
?>

<h1>View OrderComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'oc_order_id',
		'oc_washshop_id',
		'oc_comment_user_id',
		'oc_comment_user_type',
		'oc_datetime',
	),
)); ?>
