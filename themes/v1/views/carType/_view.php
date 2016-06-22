<?php
/* @var $this CarTypeController */
/* @var $data CarType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_name')); ?>:</b>
	<?php echo CHtml::encode($data->ct_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_spell')); ?>:</b>
	<?php echo CHtml::encode($data->ct_spell); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_car_brand_id')); ?>:</b>
	<?php echo CHtml::encode($data->ct_car_brand_id); ?>
	<br />


</div>