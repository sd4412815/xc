<?php
/* @var $this OrderCommentsController */
/* @var $model OrderComments */
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
		<?php echo $form->label($model,'oc_order_id'); ?>
		<?php echo $form->textField($model,'oc_order_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oc_washshop_id'); ?>
		<?php echo $form->textField($model,'oc_washshop_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oc_comment_user_id'); ?>
		<?php echo $form->textField($model,'oc_comment_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oc_comment_user_type'); ?>
		<?php echo $form->textField($model,'oc_comment_user_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oc_datetime'); ?>
		<?php echo $form->textField($model,'oc_datetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->