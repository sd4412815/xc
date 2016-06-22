<?php
/* @var $this ScoreHistoryController */
/* @var $model ScoreHistory */

$this->breadcrumbs=array(
	'Score Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ScoreHistory', 'url'=>array('index')),
	array('label'=>'Manage ScoreHistory', 'url'=>array('admin')),
);
?>

<h1>Create ScoreHistory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>