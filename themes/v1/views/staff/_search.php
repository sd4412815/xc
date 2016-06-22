<?php
/* @var $this StaffController */
/* @var $model Staff */
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
		<?php echo $form->label($model,'s_tel'); ?>
		<?php echo $form->textField($model,'s_tel',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_pwd'); ?>
		<?php echo $form->textField($model,'s_pwd',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_name'); ?>
		<?php echo $form->textField($model,'s_name',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_score'); ?>
		<?php echo $form->textField($model,'s_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_wash_shop_id'); ?>
		<?php echo $form->textField($model,'s_wash_shop_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_state'); ?>
		<?php echo $form->textField($model,'s_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_sex'); ?>
		<?php echo $form->textField($model,'s_sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_age'); ?>
		<?php echo $form->textField($model,'s_age'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_tag'); ?>
		<?php echo $form->textField($model,'s_tag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->