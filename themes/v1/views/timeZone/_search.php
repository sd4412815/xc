<?php
/* @var $this TimeZoneController */
/* @var $model TimeZone */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tz_start'); ?>
		<?php echo $form->textField($model,'tz_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tz_interval'); ?>
		<?php echo $form->textField($model,'tz_interval'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tz_stop'); ?>
		<?php echo $form->textField($model,'tz_stop'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->