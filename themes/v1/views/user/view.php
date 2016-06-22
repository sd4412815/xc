<?php
/* @var $this UserController */
/* @var $model User */
?>
 <script src="<?php echo Yii::app()->theme->baseUrl;?>/inc/js/jquery-1.10.2.min.js"></script>

<section class="page-head-holder">

	<div class="container">

		<div class="col-sm-6 col-xs-12">



			<h2>注册成功，恭喜您(<?php echo $model->u_tel;;?>)</h2>

		</div>

		<div class="col-sm-6 col-xs-12">

			<div class="breadcrumb-holder"></div>

		</div>

	</div>

</section>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'u_tel',
		'u_pwd',
		'u_name',
		'u_score',
	),
)); ?>
