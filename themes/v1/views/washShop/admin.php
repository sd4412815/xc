<?php
/* @var $this WashShopController */
/* @var $model WashShop */

$this->breadcrumbs=array(
	'Wash Shops'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WashShop', 'url'=>array('index')),
	array('label'=>'Create WashShop', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#wash-shop-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Wash Shops</h1>

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
	'id'=>'wash-shop-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'ws_no',
		'ws_name',
		'ws_score',
		'ws_address',
		'ws_lat',
		/*
		'ws_lng',
		'ws_boss_id',
		'ws_time_zone_id',
		'ws_area_code',
		'ws_state',
		'wh_num',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
