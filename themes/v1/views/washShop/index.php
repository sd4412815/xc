<?php
/* @var $this WashShopController */
/* @var $dataProvider CActiveDataProvider */



$this->menu=array(
	array('label'=>'新车行加盟申请', 'url'=>array('create')),
// 	array('label'=>'加盟车行管理', 'url'=>array('admin')),
);
?>

<h1>加盟车行</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
