<?php
/* @var $this BossController */
/* @var $model Boss */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'boss-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'b_name'); ?>
		<?php echo $form->textField($model,'b_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'b_name'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'b_pwd'); ?>
		<?php echo $form->textField($model,'b_pwd',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'b_pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'b_nick_name'); ?>
		<?php echo $form->textField($model,'b_nick_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'b_nick_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'b_type'); ?>
		<?php echo $form->textField($model,'b_type'); ?>
		<?php echo $form->error($model,'b_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->