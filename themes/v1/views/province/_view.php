<?php
/* @var $this ProvinceController */
/* @var $data Province */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_no')); ?>:</b>
	<?php echo CHtml::encode($data->p_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_name')); ?>:</b>
	<?php echo CHtml::encode($data->p_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_spell')); ?>:</b>
	<?php echo CHtml::encode($data->p_spell); ?>
	<br />


</div>