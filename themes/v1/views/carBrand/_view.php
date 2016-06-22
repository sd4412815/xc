<?php
/* @var $this CarBrandController */
/* @var $data CarBrand */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cb_name')); ?>:</b>
	<?php echo CHtml::encode($data->cb_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cb_spell')); ?>:</b>
	<?php echo CHtml::encode($data->cb_spell); ?>
	<br />


</div>