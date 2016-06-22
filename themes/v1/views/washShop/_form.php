<?php
/* @var $this WashShopController */
/* @var $model WashShop */
/* @var $form CActiveForm */
?>

<div class="form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'wash-shop-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false 
) );
?>

	<p class="note">
		带<span class="required">*</span>为必填项
	</p>

	<?php echo $form->errorSummary($model); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'ws_name'); ?>
		<?php echo $form->textField($model,'ws_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'ws_name'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'ws_address'); ?>
		<?php echo $form->textField($model,'ws_address',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'ws_address'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'ws_boss_id'); ?>

		<?php
		
echo $form->error ( $model, 'ws_boss_id' );
		?>
			<?php
			
			echo $form->dropDownList ( $model, 'ws_boss_id', CHtml::listData ( Boss::model ()->findAll ( array (
					'order' => 'b_real_name' 
			) ), 'id', 'b_real_name' ) );
			
			?>	
	</div>





	<div class="row">
		<?php echo $form->labelEx($model,'ws_num'); ?>
	
		<?php echo $form->error($model,'ws_num'); ?>
				<?php
			
			echo $form->dropDownList ( $model, 'ws_num', array(1,2));
			
			?>	
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '申请' : '保存'); ?>
		
	</div>
	


<?php $this->endWidget(); ?>

</div>
<!-- form -->