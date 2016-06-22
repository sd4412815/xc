<?php
/* @var $this StaffOrderHistoryController */
/* @var $model StaffOrderHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-order-history-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'soh_order_history_id'); ?>
		<?php echo $form->textField($model,'soh_order_history_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'soh_order_history_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'soh_staff_id'); ?>
		<?php echo $form->textField($model,'soh_staff_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'soh_staff_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->