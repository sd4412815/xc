<?php
/* @var $this AreaController */
/* @var $data Area */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_no')); ?>:</b>
	<?php echo CHtml::encode($data->a_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_name')); ?>:</b>
	<?php echo CHtml::encode($data->a_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_spell')); ?>:</b>
	<?php echo CHtml::encode($data->a_spell); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_city_id')); ?>:</b>
	<?php echo CHtml::encode($data->a_city_id); ?>
	<br />


</div>