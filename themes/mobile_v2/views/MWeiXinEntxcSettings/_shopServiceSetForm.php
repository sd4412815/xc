<?php
if (Yii::app ()->user->hasFlash ( 'serviceSetError' )) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('serviceSetError');?></div>
<?php endif;?>

<?php 
$form = $this->beginWidget ( 'CActiveForm', array (
        'action'=>'serviceSet',
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


<div class="table-responsive" style="width:100%">     
<table class="table table-bordered table-hover text-center" style="background:#FFF">
    <tr >
      <th style="width:20%;">服务</th><!--background:url(<?php //echo Yii::app()->theme->baseUrl?>/img/serviceset/basic_person.png) no-repeat;height:100px;background-position:center bottom;-->
        <th style="width:10%;" >用时(分)</th>
        <th style="width:10%;">休息(分)</th>
        
       <!-- <th style="width:10%;">&le;5座(元)</th> -->
       <th style="width:10%;">金额(元)</th>
    </tr>
    <?php 
        $shopServiceList = WashShopService::model()->getServices($shop['id'])['data']; 
        foreach ($shopServiceList as $key=>$value):
      ?>
    <tr >
        <?php 
            $CarGroup=CarGroup::model()->find('id=:id',array(":id"=>$value['wss_car_group']));
       ?>
        <td><?php echo $value->wssSt['st_name'];?>（<?php echo $CarGroup->cg_name ?>）</td>

        <td>
          <div>
                <?php
                  echo $form->hiddenField($model,'shopId');

                  echo $form->textField ( $model, 'wss_service_time', array (
                  		'class' => 'form-control text-center'
                  ) );
                  echo $form->error ( $model, 'wss_service_time'.$value['wss_st_id'] );
                ?>
          </div>
        </td>

        <td>
             <?php 
                echo $form->dropDownList($model,'wss_service_time_rest', array(0=>0,5=>5,10=>10,15=>15,20=>20,
                25=>25,30=>30,40=>40,50=>50,60=>60),array('class'=>'form-control','style'=>'padding:0'));
             ?>    
        </td>

        <td>
            <div>
                <?php 
                    echo $form->textField ( $model, 'wss_value', array ('class' => 'form-control text-center') );
                    // echo $form->error ( $model, 'wss_value');
                ?>     
            </div>
        </td>

        <!-- <td>  
            <div>
                <?php //echo $form->textField ( $model, 'wss_value2'.$value['wss_st_id'], array ('class' => 'form-control text-center') );?>
                <?php //echo $form->error ( $model, 'wss_value2'.$value['wss_st_id'] );?>
            </div>
        </td> -->
    </tr>
  <?php endforeach;?> 
    
</table>
</div>


<!-- <div>
    <input class="btn btn-warning btn-lg col-xs-offset-4 col-xs-4" type="submit" value="保存">
    <button class="btn btn-warning btn-lg col-xs-offset-4 col-xs-4" type="submit">保存</button>
</div> -->
   
<?php 
     $url = Yii::app()->createUrl('boss/ServiceSet');
        echo CHtml::ajaxSubmitButton('保  存', '', array(
        'beforeSend'=>'function(){
        $("#btn_submit").button("loading");
        }','success'=>'function(rlt){
        // alert(rlt);
        // $("#btn_submit").button("reset");
        window.location.reload();
        }'), array (
                		'class' => 'btn btn-warning btn-lg col-xs-offset-4 col-xs-4 ',
                		'id' => 'btn_submit' ,
                		'data-loading-text'=>'保存中……',
                		//'style'=>'width:100px;background:#FFF;color:orange;'
                ));
     ?> 
									
   <?php $this->endWidget(); ?>                       
                 