<?php
// $model->tel = User::model()->findByPk(Yii::app()->user->id)['u_tel'];
// $model->address = $shop['ws_address'];
// $model->name = $boss['b_real_name'];
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'join-price-form',
//     'action'=>Yii::app()->createUrl('city/UpdateJoinForm'),
    'focus' => array(
        $model,
        'pid'
    ),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal'
    )
));
?>
<div class="row">
<div class="col-sm-4">

</div> 
<div class="col-sm-4">
<div class="panel panel panel-primary">
<div class="form-group">
<?php
echo $form->labelEx($model, 'free_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
	<div class="col-sm-3">
<?php
echo $form->hiddenField($model, 'cid');

echo $form->textField($model, 'free_date_long', array(
    'placeholder' => '试用月数',
    'class' => 'form-control'
));
?>
<?php

echo $form->error($model, 'free_date_long');
?>	
    </div>
</div>
</div>
</div> 
</div><!-- row -->
<div class="row">

<div class="col-sm-4">


<div class="panel panel-primary">
<div class="form-group">
<?php

echo $form->labelEx($model, 'silver_one_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'silver_one_date_long', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'silver_one_date_long');
?>  
    </div>
</div>

<div class="form-group">
<?php

echo $form->labelEx($model, 'silver_one_price', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'silver_one_price', array(
    'placeholder' => '元',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'silver_one_price');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'silver_one_date_long_free', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'silver_one_date_long_free', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'silver_one_date_long_free');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'silver_more_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'silver_more_date_long', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'silver_more_date_long');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'silver_more_price', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'silver_more_price', array(
    'placeholder' => '元',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'silver_more_price');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'silver_more_date_long_free', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'silver_more_date_long_free', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'silver_more_date_long_free');
?>  
    </div>
</div>
</div>
</div>
<div class="col-sm-4">

<div class="panel panel-primary">
<div class="form-group">
<?php

echo $form->labelEx($model, 'golden_one_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'golden_one_date_long', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'golden_one_date_long');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'golden_one_price', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'golden_one_price', array(
    'placeholder' => '元',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'golden_one_price');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'golden_one_date_long_free', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'golden_one_date_long_free', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'golden_one_date_long_free');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'golden_more_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'golden_more_date_long', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'golden_more_date_long');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'golden_more_price', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'golden_more_price', array(
    'placeholder' => '元',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'golden_more_price');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'golden_more_date_long_free', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'golden_more_date_long_free', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'golden_more_date_long_free');
?>  
    </div>
</div>

</div>
</div>
<div class="col-sm-4">


<div class="panel panel-primary">
<div class="form-group">
<?php

echo $form->labelEx($model, 'diamond_one_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'diamond_one_date_long', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'diamond_one_date_long');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'diamond_one_price', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'diamond_one_price', array(
    'placeholder' => '元',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'diamond_one_price');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'diamond_one_date_long_free', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'diamond_one_date_long_free', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'diamond_one_date_long_free');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'diamond_more_date_long', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'diamond_more_date_long', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'diamond_more_date_long');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'diamond_more_price', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'diamond_more_price', array(
    'placeholder' => '元',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'diamond_more_price');
?>  
    </div>
</div>
<div class="form-group">
<?php

echo $form->labelEx($model, 'diamond_more_date_long_free', array(
    'class' => 'col-sm-9 control-label'
));
?>
    <div class="col-sm-3">
<?php
echo $form->textField($model, 'diamond_more_date_long_free', array(
    'placeholder' => '月数',
    'class' => 'form-control'
));

?>
<?php

echo $form->error($model, 'diamond_more_date_long_free');
?>  
    </div>
</div>

</div>



</div>

</div> <!-- row -->

<div class="row">
<?php
if (Yii::app()->user->hasFlash('joinError')) :
    ?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('joinError');?></div>
<?php endif;?>


</div>




<div class="form-group">
	<div class="col-sm-12 ">
<?php
// echo CHtml::ajax
echo CHtml::ajaxSubmitButton('保存','', array('beforeSend'=>'function(){
$("#btn_submit").button("loading");
}','success'=>'function(html){
$("#joinStd").html(html);    
$("#btn_submit").button("reset")}'), array (
'class' => 'btn btn-warning  col-xs-12 ',
'id' => 'btn_submit' ,
'data-loading-text'=>'保存中……',
));
// echo CHtml::submitButton('修改', array(
//     'class' => 'btn btn-warning col-xs-12 ',
//     'id' => 'btn_submit',
//     'onSubmit'=>'alert("d")',
// ));
?>
</div>
</div>
<?php $this->endWidget(); ?>
