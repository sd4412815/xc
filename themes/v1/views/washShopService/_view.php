<?php
/* @var $this WashShopServiceController */
/* @var $data WashShopService */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wss_ws_id')); ?>:</b>
	<?php echo CHtml::encode($data->wss_ws_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wss_st_id')); ?>:</b>
	<?php echo CHtml::encode($data->wss_st_id); ?>
	<br />


</div>