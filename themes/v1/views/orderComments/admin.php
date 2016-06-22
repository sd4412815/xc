<?php
/* @var $this OrderCommentsController */
/* @var $model OrderComments */

$this->breadcrumbs=array(
	'Order Comments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OrderComments', 'url'=>array('index')),
	array('label'=>'Create OrderComments', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-comments-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Order Comments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-comments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'oc_order_id',
		'oc_washshop_id',
		'oc_comment_user_id',
		'oc_comment_user_type',
		'oc_datetime',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
