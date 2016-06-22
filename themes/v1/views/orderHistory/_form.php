<?php
/* @var $this OrderHistoryController */
/* @var $model OrderHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-history-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_no'); ?>
		<?php echo $form->textField($model,'oh_no',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'oh_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_wash_shop_id'); ?>
		<?php echo $form->textField($model,'oh_wash_shop_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'oh_wash_shop_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_user_ack'); ?>
		<?php echo $form->textField($model,'oh_user_ack'); ?>
		<?php echo $form->error($model,'oh_user_ack'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_boss_ack'); ?>
		<?php echo $form->textField($model,'oh_boss_ack'); ?>
		<?php echo $form->error($model,'oh_boss_ack'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_staff_ack'); ?>
		<?php echo $form->textField($model,'oh_staff_ack'); ?>
		<?php echo $form->error($model,'oh_staff_ack'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_order_date_time'); ?>
		<?php echo $form->textField($model,'oh_order_date_time'); ?>
		<?php echo $form->error($model,'oh_order_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_date_time'); ?>
		<?php echo $form->textField($model,'oh_date_time'); ?>
		<?php echo $form->error($model,'oh_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_value'); ?>
		<?php echo $form->textField($model,'oh_value'); ?>
		<?php echo $form->error($model,'oh_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_value_src'); ?>
		<?php echo $form->textField($model,'oh_value_src',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'oh_value_src'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_state'); ?>
		<?php echo $form->textField($model,'oh_state'); ?>
		<?php echo $form->error($model,'oh_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oh_user_id'); ?>
		<?php echo $form->textField($model,'oh_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'oh_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->