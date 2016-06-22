<?php
/* @var $this TimeZoneController */
/* @var $model TimeZone */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'time-zone-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tz_start'); ?>
		<?php echo $form->textField($model,'tz_start'); ?>
		<?php echo $form->error($model,'tz_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tz_interval'); ?>
		<?php echo $form->textField($model,'tz_interval'); ?>
		<?php echo $form->error($model,'tz_interval'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tz_stop'); ?>
		<?php echo $form->textField($model,'tz_stop'); ?>
		<?php echo $form->error($model,'tz_stop'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->