<?php
/* @var $this WashShopController */
/* @var $data WashShop */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_no')); ?>:</b>
	<?php echo CHtml::encode($data->ws_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_name')); ?>:</b>
	<?php echo CHtml::encode($data->ws_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_score')); ?>:</b>
	<?php echo CHtml::encode($data->ws_score); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_address')); ?>:</b>
	<?php echo CHtml::encode($data->ws_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_lat')); ?>:</b>
	<?php echo CHtml::encode($data->ws_lat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_lng')); ?>:</b>
	<?php echo CHtml::encode($data->ws_lng); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_boss_id')); ?>:</b>
	<?php echo CHtml::encode($data->ws_boss_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_time_zone_id')); ?>:</b>
	<?php echo CHtml::encode($data->ws_time_zone_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_area_code')); ?>:</b>
	<?php echo CHtml::encode($data->ws_area_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ws_state')); ?>:</b>
	<?php echo CHtml::encode($data->ws_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wh_num')); ?>:</b>
	<?php echo CHtml::encode($data->wh_num); ?>
	<br />

	*/ ?>

</div>