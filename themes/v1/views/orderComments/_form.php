<?php
/* @var $this OrderCommentsController */
/* @var $model OrderComments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-comments-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'oc_order_id'); ?>
		<?php echo $form->textField($model,'oc_order_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'oc_order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oc_washshop_id'); ?>
		<?php echo $form->textField($model,'oc_washshop_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'oc_washshop_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oc_comment_user_id'); ?>
		<?php echo $form->textField($model,'oc_comment_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'oc_comment_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oc_comment_user_type'); ?>
		<?php echo $form->textField($model,'oc_comment_user_type'); ?>
		<?php echo $form->error($model,'oc_comment_user_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oc_datetime'); ?>
		<?php echo $form->textField($model,'oc_datetime'); ?>
		<?php echo $form->error($model,'oc_datetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->