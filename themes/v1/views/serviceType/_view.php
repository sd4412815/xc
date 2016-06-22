<?php
/* @var $this ServiceTypeController */
/* @var $data ServiceType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_name')); ?>:</b>
	<?php echo CHtml::encode($data->st_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_desc')); ?>:</b>
	<?php echo CHtml::encode($data->st_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_value')); ?>:</b>
	<?php echo CHtml::encode($data->st_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_score')); ?>:</b>
	<?php echo CHtml::encode($data->st_score); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_interval_num')); ?>:</b>
	<?php echo CHtml::encode($data->st_interval_num); ?>
	<br />


</div>