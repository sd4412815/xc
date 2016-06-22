<?php
/* @var $this OrderHistoryController */
/* @var $data OrderHistory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_no')); ?>:</b>
	<?php echo CHtml::encode($data->oh_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_wash_shop_id')); ?>:</b>
	<?php echo CHtml::encode($data->oh_wash_shop_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_user_ack')); ?>:</b>
	<?php echo CHtml::encode($data->oh_user_ack); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_boss_ack')); ?>:</b>
	<?php echo CHtml::encode($data->oh_boss_ack); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_staff_ack')); ?>:</b>
	<?php echo CHtml::encode($data->oh_staff_ack); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_order_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->oh_order_date_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->oh_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_value')); ?>:</b>
	<?php echo CHtml::encode($data->oh_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_value_src')); ?>:</b>
	<?php echo CHtml::encode($data->oh_value_src); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_state')); ?>:</b>
	<?php echo CHtml::encode($data->oh_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oh_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->oh_user_id); ?>
	<br />

	*/ ?>

</div>