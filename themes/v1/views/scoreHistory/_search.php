<?php
/* @var $this ScoreHistoryController */
/* @var $model ScoreHistory */
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
		<?php echo $form->label($model,'sh_date_time'); ?>
		<?php echo $form->textField($model,'sh_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sh_score'); ?>
		<?php echo $form->textField($model,'sh_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sh_order_history_id'); ?>
		<?php echo $form->textField($model,'sh_order_history_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sh_user_id'); ?>
		<?php echo $form->textField($model,'sh_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->