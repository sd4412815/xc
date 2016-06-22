<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
?>

<h1>登录2</h1>


<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">带<span class="required">*</span>为必填项目.</p>
	<?php 
// 	echo $form->errorSummary($model, "<b>请更正错误：</b>"); 
?>
	<?php echo $form->textFieldRow($model,'u_tel'); ?>

	<?php echo $form->passwordFieldRow($model,'u_pwd'); ?>
	
	
 
 <!--  
    <?php echo $form->passwordFieldRow($model,'u_pwd',array(
        'hint'=>'密码只能包括数字、字母和下划线',
    )); ?>
    --> 

	<?php echo  $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'登录',
			'size'=>'large',
        )); ?>
        	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'link',
		'type'=>'link',
		'label'=>'忘记密码?',
        'url'=>array('/user/user',view=>'reg'),
	))?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
