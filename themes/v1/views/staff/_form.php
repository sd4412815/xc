<?php
/* @var $this StaffController */
/* @var $model Staff */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'s_tel'); ?>
		<?php echo $form->textField($model,'s_tel',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'s_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_pwd'); ?>
		<?php echo $form->textField($model,'s_pwd',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'s_pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_name'); ?>
		<?php echo $form->textField($model,'s_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'s_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_score'); ?>
		<?php echo $form->textField($model,'s_score'); ?>
		<?php echo $form->error($model,'s_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_wash_shop_id'); ?>
		<?php echo $form->textField($model,'s_wash_shop_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'s_wash_shop_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_state'); ?>
		<?php echo $form->textField($model,'s_state'); ?>
		<?php echo $form->error($model,'s_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_sex'); ?>
		<?php echo $form->textField($model,'s_sex'); ?>
		<?php echo $form->error($model,'s_sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_age'); ?>
		<?php echo $form->textField($model,'s_age'); ?>
		<?php echo $form->error($model,'s_age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_tag'); ?>
		<?php echo $form->textField($model,'s_tag',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'s_tag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->