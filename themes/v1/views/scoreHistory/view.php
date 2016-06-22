<?php
/* @var $this ScoreHistoryController */
/* @var $model ScoreHistory */

$this->breadcrumbs=array(
	'Score Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ScoreHistory', 'url'=>array('index')),
	array('label'=>'Create ScoreHistory', 'url'=>array('create')),
	array('label'=>'Update ScoreHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ScoreHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ScoreHistory', 'url'=>array('admin')),
);
?>

<h1>View ScoreHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sh_date_time',
		'sh_score',
		'sh_order_history_id',
		'sh_user_id',
	),
)); ?>
