
<div class="row">
       <div class=" col-sm-2 col-lg-offset-1 skin-blue">
	     
	    <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
		</div>
	   <div class="col-sm-10 col-lg-8">
           <div class="box box-warning">
		   <div class="box-body">	
		   
		   <div class="row">
			 <div class="col-xs-12">
		   <h4 style="color:#ff9900;font-weight:bold;">您的问题</h4>
		<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'msg-form',
// 		'focus' => array (
// 				$model,
// 				'u_tel', 
// 		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,
				'afterValidate' => 'js:function(form, data, hasError){
if(hasError){
return false;
}else{
layer.load("保存中...");
return true;
}

}',
		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
		   	<div class="form-group">
<?php
echo $form->labelEx ( $model, 'om_type', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-8">
<?php
echo $form-> dropDownList( $model, 'om_type', array('0'=>'网站相关','1'=>'手机客户端相关'),array (
		'placeholder' => '请选择问题分类',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'om_type');
?>	
    </div>
				</div>	
			
			   	<div class="form-group">
<?php
echo $form->labelEx ( $model, 'om_contactor', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-8">
<?php
echo $form->textField ( $model, 'om_contactor', array (
		'placeholder' => '请输入有效手机号/邮箱，以方便我们联系您',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'om_contactor');
?>	
    </div>
				</div>
			 	   	<div class="form-group">
<?php
echo $form->labelEx ( $model, 'om_content', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-8">
<?php
// echo CHtml::textArea($name)
echo $form->textArea ( $model, 'om_content', array (
		'placeholder' => '问题描述',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'om_content');
?>	
    </div>
				</div>
			   

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-7">
					<?php

echo CHtml::submitButton ( '提交', array (
		'class' => 'btn btn-warning col-sm-offset-4 col-sm-8 col-xs-12 ',
		'id' => 'btn_submit' 
) );
?>

					</div>
				  </div>
		<?php
if (Yii::app ()->user->hasFlash ( 'msgError' ) ) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('msgError');?></div>
<?php endif;?>
			<?php $this->endWidget(); ?>
			</div><!-- col-sm-10 -->
			</div><!-- row -->
			
			</div>
			</div><!-- box -->
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
 $('#smsendmsg').addClass('active');
", CClientScript::POS_READY );

?>		
  