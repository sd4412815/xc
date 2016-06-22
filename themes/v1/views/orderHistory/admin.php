<?php
/* @var $this OrderHistoryController */
/* @var $model OrderHistory */

$this->breadcrumbs=array(
	'Order Histories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OrderHistory', 'url'=>array('index')),
	array('label'=>'Create OrderHistory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-history-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Order Histories</h1>

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
	'id'=>'order-history-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'oh_no',
		'oh_wash_shop_id',
		'oh_user_ack',
		'oh_boss_ack',
		'oh_staff_ack',
		/*
		'oh_order_date_time',
		'oh_date_time',
		'oh_value',
		'oh_value_src',
		'oh_state',
		'oh_user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
