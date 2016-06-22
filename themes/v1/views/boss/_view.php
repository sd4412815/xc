<?php
/* @var $this BossController */
/* @var $data Boss */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('b_name')); ?>:</b>
	<?php echo CHtml::encode($data->b_name); ?>
	<br />

	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('b_pwd')); ?>:</b>
	<?php echo CHtml::encode($data->b_pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('b_nick_name')); ?>:</b>
	<?php echo CHtml::encode($data->b_nick_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('b_type')); ?>:</b>
	<?php echo CHtml::encode($data->b_type); ?>
	<br />


</div>