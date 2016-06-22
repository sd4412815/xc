<?php
/* @var $this AreaController */
/* @var $model Area */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'area-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'a_no'); ?>
		<?php echo $form->textField($model,'a_no'); ?>
		<?php echo $form->error($model,'a_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'a_name'); ?>
		<?php echo $form->textField($model,'a_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'a_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'a_spell'); ?>
		<?php echo $form->textField($model,'a_spell',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'a_spell'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'a_city_id'); ?>
			<?php 


echo $form->dropDownList($model, 'a_city_id', CHtml::listData ( City::model ()->findAll ( array (
'order' => 'c_spell'
		) ), 'id', 'c_name' ))

	?>	
		
		<?php echo $form->error($model,'a_city_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->