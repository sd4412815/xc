<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	

	<div class="row">
		<?php echo $form->labelEx($model,'c_name'); ?>
		<?php echo $form->textField($model,'c_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'c_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'c_spell'); ?>
		<?php echo $form->textField($model,'c_spell',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'c_spell'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'c_province_id'); ?>
	<?php 


echo $form->dropDownList($model, 'c_province_id', CHtml::listData ( Province::model ()->findAll ( array (
'order' => 'p_spell'
		) ), 'id', 'p_name' ));

	?>	
	
	
		<?php echo $form->error($model,'c_province_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->