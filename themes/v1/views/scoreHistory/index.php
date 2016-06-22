<?php
/* @var $this ScoreHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Score Histories',
);

$this->menu=array(
	array('label'=>'Create ScoreHistory', 'url'=>array('create')),
	array('label'=>'Manage ScoreHistory', 'url'=>array('admin')),
);
?>

<h1>Score Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
