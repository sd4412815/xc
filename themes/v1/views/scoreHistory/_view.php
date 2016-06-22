<?php
/* @var $this ScoreHistoryController */
/* @var $data ScoreHistory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sh_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->sh_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sh_score')); ?>:</b>
	<?php echo CHtml::encode($data->sh_score); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sh_order_history_id')); ?>:</b>
	<?php echo CHtml::encode($data->sh_order_history_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sh_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->sh_user_id); ?>
	<br />


</div>