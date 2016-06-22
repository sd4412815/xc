<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'st_name'); ?>
		<?php echo $form->textField($model,'st_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'st_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'st_desc'); ?>
		<?php echo $form->textField($model,'st_desc',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'st_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'st_value'); ?>
		<?php echo $form->textField($model,'st_value'); ?>
		<?php echo $form->error($model,'st_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'st_score'); ?>
		<?php echo $form->textField($model,'st_score'); ?>
		<?php echo $form->error($model,'st_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'st_interval_num'); ?>
		<?php echo $form->textField($model,'st_interval_num'); ?>
		<?php echo $form->error($model,'st_interval_num'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->