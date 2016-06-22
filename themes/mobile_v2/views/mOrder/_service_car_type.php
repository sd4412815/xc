<?php 
// 'selectedType'=>$selectedType,
// 'sTypeCarGroup'=>$sTypeCarGroup,
// 'carGroupList'=>$carGroupList));

foreach ($carGroupList as $key=>$carGroup):
?>		
<?php if (isset($sTypeCarGroup[$carGroup['id']])):?>
<a name="sCarType" class="btn btn-item time-info <?php echo UCom::currentStr($selectedType, $carGroup['id']);?>" data-value="<?php echo $carGroup['id'];?>"><?php echo $carGroup['name']; ?></a>

<?php endif;?>


<?php 
endforeach;?>
<?php
Yii::app ()->clientScript->registerScript ( 'car_type_list', ' 
set_cartype_change_ini();       		
			', CClientScript::POS_READY );
?>	
