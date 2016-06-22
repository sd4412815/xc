<?php
/* @var $this StaffOrderHistoryController */
/* @var $data StaffOrderHistory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('soh_order_history_id')); ?>:</b>
	<?php echo CHtml::encode($data->soh_order_history_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('soh_staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->soh_staff_id); ?>
	<br />


</div>