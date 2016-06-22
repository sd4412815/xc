<?php
/* @var $this BossController */
/* @var $model Boss */
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
		<?php echo $form->label($model,'b_name'); ?>
		<?php echo $form->textField($model,'b_name',array('size'=>20,'maxlength'=>20)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model,'b_pwd'); ?>
		<?php echo $form->textField($model,'b_pwd',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'b_nick_name'); ?>
		<?php echo $form->textField($model,'b_nick_name',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'b_type'); ?>
		<?php echo $form->textField($model,'b_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->