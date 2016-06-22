<?php
/* @var $this CarTypeController */
/* @var $model CarType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ct_name'); ?>
		<?php echo $form->textField($model,'ct_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ct_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ct_spell'); ?>
		<?php echo $form->textField($model,'ct_spell',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'ct_spell'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ct_car_brand_id'); ?>
		<?php echo $form->textField($model,'ct_car_brand_id'); ?>
		<?php echo $form->error($model,'ct_car_brand_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->