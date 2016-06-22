<?php
/* @var $this OrderHistoryItemController */
/* @var $data OrderHistoryItem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ohi_oh_id')); ?>:</b>
	<?php echo CHtml::encode($data->ohi_oh_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ohi_si_id')); ?>:</b>
	<?php echo CHtml::encode($data->ohi_si_id); ?>
	<br />


</div>