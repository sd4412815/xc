<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'user-form',
		'focus' => array (
				$model,
				'u_nick_name' 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true,
				'afterValidate' => 'js:function(form, data, hasError){
if(hasError){
return false;
}else{
layer.load("更新中...");
return true;
}

}' 
		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>
<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_nick_name', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
	<div class="col-sm-9">
<?php
echo $form->textField ( $model, 'u_nick_name', array (
		'placeholder' => '数字、字母、下划线，支持中文',
		'class' => 'form-control' ,
	'maxLength'=>10,
) );
?>
<?php

echo $form->error ( $model, 'u_nick_name' );
?>	
    </div>
</div>

<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_age', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
 <?php
	$ageList = array (
			'255' => '未设置',
			'25' => '18-25',
			'30' => '26-30',
			'35' => '31-35',
			'40' => '36-40',
			'45' => '41-45',
			'50' => '46-50',
			'55' => '51-55',
			'60' => '56-60',
			'65' => '60岁以上' 
	)
	;
	
	echo $form->dropDownList ( $model, 'u_age', $ageList, array (
			'placeholder' => '年龄',
			'class' => 'form-control' 
	) );
	
	?>
<?php

	echo $form->error ( $model, 'u_age' );
	?>
</div>
</div>
<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_sex', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
 <?php
	
	echo $form->dropDownList ( $model, 'u_sex', array (
			'0' => '男',
			'1' => '女',
			'2' => '未设置' 
	), array (
			'placeholder' => '年龄',
			'class' => 'form-control' 
	) );
	?>
<?php

	echo $form->error ( $model, 'u_sex' );
	?>
</div>
</div>
<div class="form-group">
<?php
echo $form->labelEx ( $model, 'u_car_brand', array (
		'class' => 'col-sm-3 control-label' 
) );
?>
 <div class="col-sm-9">
  <?php
  Yii::import('select2.Select2');
  echo  Select2::dropDownList('User[u_car_brand]',$model['u_car_brand'], CHtml::listData ( CarBrand::model ()->findAll ( array (
'order' => 'cb_spell ASC'
		) ), 'id', 'cb_name' ), array (
'select2Options'=>array('matcher'=>'js:function(term, text) {  
            var mod=ZhToPinyin(text);  
            var tf1=mod.a.toUpperCase().indexOf(term.toUpperCase())==0;  
            var tf2=mod.b.toUpperCase().indexOf(term.toUpperCase())==0;  
            return (tf1||tf2);  
        }  '),
		'prompt' => '选择车辆品牌',
		'style' => 'width:100%;',
		
		'ajax' => array (
				'type' => 'POST',
				'url' => $this->createUrl ( 'carBrand/updateTypes' ),
				'data' => array (
						'cb' => 'js:this.value'
				),
'success'=>'js:function(data){
$(\'#User_u_car_type\').html(data);
$(\'#User_u_car_type\').val(null).trigger("change");
}',
// 				'update' => '#User_u_car_type'
		)
));
  
  
// 		echo $form->dropDownList ( $model, 'u_car_brand', CHtml::listData ( CarBrand::model ()->findAll ( array (
// 				'order' => 'cb_spell ASC' 
// 		) ), 'id', 'cb_name' ), array (
// 				'prompt' => '选择车辆品牌',
// 				'class' => 'form-control ',
// 				'ajax' => array (
// 						'type' => 'POST',
// 						'url' => $this->createUrl ( 'carBrand/updateTypes' ),
// 						'data' => array (
// 								'cb' => 'js:this.value' 
// 						),
// 						'update' => '#User_u_car_type' 
// 				) 
// 		) );
		?> 
<?php

echo $form->error ( $model, 'u_car_brand' );
?>
</div>
</div>
<div class="form-group">
      <?php
						echo $form->labelEx ( $model, 'u_car_type', array (
								'class' => 'col-sm-3 control-label' 
						) );
						?>
 <div class="col-sm-9">
  <?php
$criteria = new CDbCriteria();
$criteria->addCondition('ct_car_brand_id=:brandId');
$criteria->params[':brandId']=User::model()->findByPk(Yii::app()->user->Id)['u_car_brand'];
$criteria->order='ct_spell ASC';

	echo	Select2::dropDownList('User[u_car_type]',$model['u_car_type'], CHtml::listData ( CarType::model ()->findAll ($criteria ), 'id', 'ct_name' ), 
array (
'select2Options'=>array('matcher'=>'js:function(term, text) {
            var mod=ZhToPinyin(text);
            var tf1=mod.a.toUpperCase().indexOf(term.toUpperCase())==0;
            var tf2=mod.b.toUpperCase().indexOf(term.toUpperCase())==0;
            return (tf1||tf2);
        }  '),
				'prompt' => '选择车型',
			'style' => 'width:100%;',
		) );
		?> 
<?php

echo $form->error ( $model, 'u_car_type' );
?>
</div>
</div>


<div class="form-group">
	<div class="col-sm-12 ">
<?php

echo CHtml::submitButton ( '更新', array (
		'class' => 'btn btn-primary col-sm-offset-3 col-sm-9 col-xs-12 ',
		'id' => 'btn_submit' 
) );
?>
</div>
</div>
<?php
if (Yii::app ()->user->hasFlash ( 'userInfo' )) :
	?>
<div class="form-group">
	<div class="col-sm-12 ">
		<div class="col-sm-offset-3  col-sm-9  text-red" role="alert"><?php echo Yii::app()->user->getFlash('userInfo');?></div>
	</div>
</div>
<?php endif;?>




<?php $this->endWidget(); ?>

