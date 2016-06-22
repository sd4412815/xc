<?php
$model->tel = User::model()->findByPk(Yii::app()->user->id)['u_tel'];
$model->address = $shop['ws_address'];
$model->name = $boss['b_real_name'];


$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'buy-service-form',
// 		'action'=>Yii::app()->createUrl('ShopPay/NewRequestPay'),
		'focus' => array (
				$model,
				'remark' 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,
		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
<div class="form-group">
<?php
echo $form->labelEx ( $model, 'level', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-9">
<?php
echo CHtml::textField('sLevel','',array (
		'class' => 'form-control',
		'disabled'=>'disabled',
        'id'=>'sLevel'
));

echo $form->dropDownList($model, 'level', array(0=>'体验卡',1=>'银卡',2=>'金卡',3=>'钻石卡'),array (
		'class' => 'form-control',
		'style'=>'display:none',
));
?>
<?php

echo $form->error ( $model, 'level' );
?>	
    </div>
</div>

<div class="form-group">
<?php

echo $form->labelEx ( $model, 'value', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-9">
<?php

echo CHtml::textField('sValue1','的',array (
		'class' => 'form-control',
		'disabled'=>'disabled',
        'id'=>'sValue1'
));
$silverPrice = $joinStd['silver_'.$shopType.'_price'];
$goldenPrice = $joinStd['golden_'.$shopType.'_price'];
$diamondPrice = $joinStd['diamond_'.$shopType.'_price'];
$priceArray = array(0=>'免费',$silverPrice=>$silverPrice.'元',$goldenPrice=>$goldenPrice.'元',$diamondPrice=>$diamondPrice.'元');


echo $form->dropDownList($model, 'value',$priceArray,array (
		'class' => 'form-control',
			'style'=>'display:none',
));

?>
<?php

echo $form->error ( $model, 'value' );
?>	
    </div>
</div>

<div class="form-group">
<?php
echo $form->labelEx ( $model, 'name', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-9">
<?php
echo $form->textField ( $model, 'name', array (
		'placeholder' => '请输入收货人姓名',
		'class' => 'form-control' 
) );
?>
<?php

echo $form->error ( $model, 'name' );
?>	
    </div>
</div>

<div class="form-group">
<?php
echo $form->labelEx ( $model, 'tel', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
 <?php
	echo $form->textField ( $model, 'tel', array (
			'placeholder' => '收货人手机号',
			'class' => 'form-control' 
	) );
	?>
<?php

	echo $form->error ( $model, 'tel' );
	?>
</div>
</div>
<div class="form-group">
<?php
echo $form->labelEx ( $model, 'address', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
 <?php
	echo $form->textField ( $model, 'address', array (
			'placeholder' => '收货地址',
			'class' => 'form-control' 
	) );
	?>
<?php

	echo $form->error ( $model, 'address' );
	?>
</div>
</div>
<div class="form-group">
<?php
echo $form->labelEx ( $model, 'remark', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
 <?php
	echo $form->textField ( $model, 'remark', array (
			'placeholder' => '备注',
			'class' => 'form-control' 
	) );
	?>
<?php

	echo $form->error ( $model, 'remark' );
	?>
</div>
</div>



<?php
if (Yii::app ()->user->hasFlash ( 'buyError' )) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('buyError');?></div>
<?php endif;?>

<div class="form-group">
	<div class="col-sm-12 ">
<?php
// echo CHtml::ajax
$url = Yii::app()->createUrl('boss/serviceList');
echo CHtml::ajaxSubmitButton('购买', '', array('beforeSend'=>'function(){
$("#btn_submit").button("loading");
}','success'=>'function(){ window.location.href="'.$url.'";}'), array (
		'class' => 'btn btn-warning col-sm-offset-3 col-sm-4 col-xs-6 ',
		'id' => 'btn_submit' ,
        'data-loading-text'=>'购买中……',
));
// echo CHtml::submitButton ( '购买', array (
// 		'class' => 'btn btn-warning col-sm-offset-3 col-sm-4 col-xs-6 ',
// 		'id' => 'btn_submit',
// 'onclick'=> 
// ) );
?>
<button type="button" class="btn btn-primary col-sm-offset-1 col-sm-4 col-xs-6"
													data-dismiss="modal">取消</button>
</div>
</div>
<?php $this->endWidget(); ?>
