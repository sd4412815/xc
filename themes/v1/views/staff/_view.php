<?php
/* @var $this StaffController */
/* @var $data Staff */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_tel')); ?>:</b>
	<?php echo CHtml::encode($data->s_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_pwd')); ?>:</b>
	<?php echo CHtml::encode($data->s_pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_name')); ?>:</b>
	<?php echo CHtml::encode($data->s_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_score')); ?>:</b>
	<?php echo CHtml::encode($data->s_score); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_wash_shop_id')); ?>:</b>
	<?php echo CHtml::encode($data->s_wash_shop_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_state')); ?>:</b>
	<?php echo CHtml::encode($data->s_state); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('s_sex')); ?>:</b>
	<?php echo CHtml::encode($data->s_sex); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_age')); ?>:</b>
	<?php echo CHtml::encode($data->s_age); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s_tag')); ?>:</b>
	<?php echo CHtml::encode($data->s_tag); ?>
	<br />

	*/ ?>

</div>