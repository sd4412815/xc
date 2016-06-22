<?php
/* @var $this TimeZoneController */
/* @var $data TimeZone */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tz_start')); ?>:</b>
	<?php echo CHtml::encode($data->tz_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tz_interval')); ?>:</b>
	<?php echo CHtml::encode($data->tz_interval); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tz_stop')); ?>:</b>
	<?php echo CHtml::encode($data->tz_stop); ?>
	<br />


</div>