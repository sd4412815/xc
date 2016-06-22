<?php
/* @var $this WashShopController */
/* @var $model WashShop */


$this->menu=array(
	array('label'=>'已加盟车行列表', 'url'=>array('index')),
// 	array('label'=>'Manage WashShop', 'url'=>array('admin')),
);
?>

<h1>新车行加盟申请</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>