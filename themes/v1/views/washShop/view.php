<?php
/* @var $this WashShopController */
/* @var $model WashShop */



$this->menu=array(
	array('label'=>'已加盟车行列表', 'url'=>array('index')),
	array('label'=>'新车行加盟申请', 'url'=>array('create')),
	array('label'=>'车行信息更新', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'删除车行', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'车行管理', 'url'=>array('admin')),
);
?>

<h1> <?php echo $model->ws_no; ?>号加盟车行信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ws_no',
		'ws_name',
		'ws_score',
		'ws_address',
		'ws_lat',
		'ws_lng',
		'ws_boss_id',
		'ws_time_zone_id',
		'ws_area_code',
		'ws_state',
		'ws_num',
	),
)); ?>
