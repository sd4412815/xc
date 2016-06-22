<?php
/* @var $this ScoreHistoryController */
/* @var $model ScoreHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'score-history-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sh_date_time'); ?>
		<?php echo $form->textField($model,'sh_date_time'); ?>
		<?php echo $form->error($model,'sh_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sh_score'); ?>
		<?php echo $form->textField($model,'sh_score'); ?>
		<?php echo $form->error($model,'sh_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sh_order_history_id'); ?>
		<?php echo $form->textField($model,'sh_order_history_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sh_order_history_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sh_user_id'); ?>
		<?php echo $form->textField($model,'sh_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sh_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->