<?php
/* @var $this CarBrandController */
/* @var $model CarBrand */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-brand-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cb_name'); ?>
		<?php echo $form->textField($model,'cb_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cb_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cb_spell'); ?>
		<?php echo $form->textField($model,'cb_spell',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'cb_spell'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->