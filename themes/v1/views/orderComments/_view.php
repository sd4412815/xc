<?php
/* @var $this OrderCommentsController */
/* @var $data OrderComments */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oc_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->oc_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oc_washshop_id')); ?>:</b>
	<?php echo CHtml::encode($data->oc_washshop_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oc_comment_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->oc_comment_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oc_comment_user_type')); ?>:</b>
	<?php echo CHtml::encode($data->oc_comment_user_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oc_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->oc_datetime); ?>
	<br />


</div>