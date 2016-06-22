<?php
/* @var $this ScoreHistoryController */
/* @var $model ScoreHistory */

$this->breadcrumbs=array(
	'Score Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ScoreHistory', 'url'=>array('index')),
	array('label'=>'Create ScoreHistory', 'url'=>array('create')),
	array('label'=>'View ScoreHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ScoreHistory', 'url'=>array('admin')),
);
?>

<h1>Update ScoreHistory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>