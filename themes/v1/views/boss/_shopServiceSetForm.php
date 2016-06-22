<?php
if (Yii::app ()->user->hasFlash ( 'serviceSetError' )) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('serviceSetError');?></div>
<?php endif;?>

<?php 

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'service-set-form',
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

<div class="table-responsive">     
<table class="table table-bordered table-hover text-center">
  <tr >
<th></th>
    <th >用时(分)</th>
    <th >休息间隔(分)</th>
    <th >&le;5座(元)</th>
    <th >&ge;7座(元)</th>
  </tr>
  <?php 
  $shopServiceList = WashShopService::model()->getServices($shop['id'])['data'];
  foreach ($shopServiceList as $key=>$value):
  ?>
   <tr >
    <td>
<?php 
echo $value->wssSt['st_name'];
?>    
</td>
    <td>
         <div>
<?php
// CHtml::hiddenField($name)
echo $form->hiddenField($model,'shopId');

echo $form->textField ( $model, 'wss_service_time'.$value['wss_st_id'], array (
// 		'placeholder' => '收货人手机号',
		'class' => 'form-control text-center'
) );
echo $form->error ( $model, 'wss_service_time'.$value['wss_st_id'] );
?>
     </div>
</td>
      <td>
 <?php 
 echo $form->dropDownList($model,'wss_service_time_rest'.$value['wss_st_id'], array(0=>0,5=>5,10=>10,15=>15,20=>20,
25=>25,30=>30,40=>40,50=>50,60=>60),
array('class'=>'form-control'));
 ?>    
</td>
    <td>
         <div>
 <?php
echo $form->textField ( $model, 'wss_value1'.$value['wss_st_id'], array (
// 		'placeholder' => '收货人手机号',
		'class' => 'form-control text-center'
) );
echo $form->error ( $model, 'wss_value1'.$value['wss_st_id'] );
?>     </div>
    </td>
      <td>
      
      <div>


 <?php
echo $form->textField ( $model, 'wss_value2'.$value['wss_st_id'], array (
// 		'placeholder' => '收货人手机号',
		'class' => 'form-control text-center'
) );
	?>
<?php
echo $form->error ( $model, 'wss_value2'.$value['wss_st_id'] );
	?>
</div>
   
      </td>
    
  </tr>
  <?php endforeach;?>
 
</table>
</div>
<br>

<div class="row">
<?php 
//         $url = Yii::app()->createUrl('boss/ServiceSet');
      
        echo CHtml::ajaxSubmitButton('保存', '', array(
// 'dataType'=>'json',
// 'data'=>"js:$('#service-set-form').serialize()",
'beforeSend'=>'function(){
$("#btn_submit").button("loading");
}','success'=>'function(rlt){
// alert(rlt);
// $("#btn_submit").button("reset");
window.location.reload();
}'), array (
        		'class' => 'btn btn-warning col-xs-12 col-sm-offset-4 col-sm-4  ',
        		'id' => 'btn_submit' ,
        		'data-loading-text'=>'保存中……',
        ));
        ?> 
</div>
 

                  
							
									
   <?php $this->endWidget(); ?>                       
                 