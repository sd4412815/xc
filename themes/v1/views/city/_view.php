<?php
/* @var $this CityController */
/* @var $data City */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('c_no')); ?>:</b>
	<?php echo CHtml::encode($data->c_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('c_name')); ?>:</b>
	<?php echo CHtml::encode($data->c_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('c_spell')); ?>:</b>
	<?php echo CHtml::encode($data->c_spell); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('c_province_id')); ?>:</b>
	<?php echo CHtml::encode($data->c_province_id); ?>
	<br />


</div>