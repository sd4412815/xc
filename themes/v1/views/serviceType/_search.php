<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_name'); ?>
		<?php echo $form->textField($model,'st_name',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_desc'); ?>
		<?php echo $form->textField($model,'st_desc',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_value'); ?>
		<?php echo $form->textField($model,'st_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_score'); ?>
		<?php echo $form->textField($model,'st_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_interval_num'); ?>
		<?php echo $form->textField($model,'st_interval_num'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->