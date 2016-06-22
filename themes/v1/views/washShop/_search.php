<?php
/* @var $this WashShopController */
/* @var $model WashShop */
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
		<?php echo $form->label($model,'ws_no'); ?>
		<?php echo $form->textField($model,'ws_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_name'); ?>
		<?php echo $form->textField($model,'ws_name',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_score'); ?>
		<?php echo $form->textField($model,'ws_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_address'); ?>
		<?php echo $form->textField($model,'ws_address',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_lat'); ?>
		<?php echo $form->textField($model,'ws_lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_lng'); ?>
		<?php echo $form->textField($model,'ws_lng'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_boss_id'); ?>
		<?php echo $form->textField($model,'ws_boss_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_time_zone_id'); ?>
		<?php echo $form->textField($model,'ws_time_zone_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_area_code'); ?>
		<?php echo $form->textField($model,'ws_area_code',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ws_state'); ?>
		<?php echo $form->textField($model,'ws_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wh_num'); ?>
		<?php echo $form->textField($model,'wh_num'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->