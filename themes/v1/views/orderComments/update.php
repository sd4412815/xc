<?php
/* @var $this OrderCommentsController */
/* @var $model OrderComments */

$this->breadcrumbs=array(
	'Order Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderComments', 'url'=>array('index')),
	array('label'=>'Create OrderComments', 'url'=>array('create')),
	array('label'=>'View OrderComments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderComments', 'url'=>array('admin')),
);
?>

<h1>Update OrderComments <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>