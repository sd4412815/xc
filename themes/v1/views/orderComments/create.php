<?php
/* @var $this OrderCommentsController */
/* @var $model OrderComments */

$this->breadcrumbs=array(
	'Order Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderComments', 'url'=>array('index')),
	array('label'=>'Manage OrderComments', 'url'=>array('admin')),
);
?>

<h1>Create OrderComments</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>