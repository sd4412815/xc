<?php
/* @var $this WashShopController */
/* @var $model WashShop */



$this->menu=array(
	array('label'=>'已加盟车行列表', 'url'=>array('index')),
	array('label'=>'新车行加盟管理', 'url'=>array('create')),
	array('label'=>'车行信息查看', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'车行管理', 'url'=>array('admin')),
);
?>

<h1>Update WashShop <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>