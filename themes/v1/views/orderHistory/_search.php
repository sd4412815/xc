<?php
/* @var $this OrderHistoryController */
/* @var $model OrderHistory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_no'); ?>
		<?php echo $form->textField($model,'oh_no',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_wash_shop_id'); ?>
		<?php echo $form->textField($model,'oh_wash_shop_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_user_ack'); ?>
		<?php echo $form->textField($model,'oh_user_ack'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_boss_ack'); ?>
		<?php echo $form->textField($model,'oh_boss_ack'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_staff_ack'); ?>
		<?php echo $form->textField($model,'oh_staff_ack'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_order_date_time'); ?>
		<?php echo $form->textField($model,'oh_order_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_date_time'); ?>
		<?php echo $form->textField($model,'oh_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_value'); ?>
		<?php echo $form->textField($model,'oh_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_value_src'); ?>
		<?php echo $form->textField($model,'oh_value_src',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_state'); ?>
		<?php echo $form->textField($model,'oh_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oh_user_id'); ?>
		<?php echo $form->textField($model,'oh_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->