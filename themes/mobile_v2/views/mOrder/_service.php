<div class="row">
<div class="col-xs-12 gray-lite ">
<?php if(isset($shop['latestNews'])):?>

<p class="h6 text-auto-hide"><code> <?php echo $shop['latestNews'].$shop['latestNews'];?></code></p>

<?php endif;?>
<?php 

$criteira = new CDbCriteria();
$criteira->addCondition('sh_shop_id=:shopId');
$criteira->params[':shopId'] =$shop['id'];
$criteira->addCondition('sh_end_date > :currentDate');
$criteira->params[':currentDate'] = date ( 'Y-m-d');
$criteira->addCondition('sh_state=:state');
$criteira->params[':state'] = Hui::HUI_STATE_ONLINE;
$criteira->addCondition('sh_type=:type');
$criteira->params[':type'] = ShopHui::HUI_TYPE_AUTO;
//  ShopHui::model()
$huiList =ShopHui::model()->with('hui')->findAll($criteira);
foreach ($huiList as $key=>$value):
?>
<p class="h6 text-auto-hide"> <a href="
<?php echo Yii::app()->createUrl('mHui/list',array('id'=>$value['sh_hui_id'])); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value->hui['h_name'];?> </a></p>
<?php endforeach;?>
</div>
</div>





<div class="row">
	<div class=" col-xs-2 text-right h6">类型</div>
	<div class=" col-xs-10">

		<select class="cs-select cs-skin-elastic-service" id="sTypeList">
<?php
$sTypeSelectedValue = $selectedParams['sType'] ;

foreach ($shop['serviceList'] as $key=>$service):
?>
<option value="<?php echo $service['id'] ?>" <?php echo UCom::selectedStr($service['id'], $sTypeSelectedValue);?>>
<?php echo '【'.$service['name'].'】'.$serviceTypeList[$service['id']]['desc'];?>
</option>
<?php endforeach;?>

		</select>

	</div>
</div>

<div class="row">
	<div class=" col-xs-2 text-right h6">车型</div>
	<div class="col-xs-10 " id="scartypelist">
		<?php 
			// 设置初始值
			$selectedType =$selectedParams['sCarType'];
			$sTypeCarGroup = $shop['serviceList'][$sTypeSelectedValue]['carGroupList'];	
			// echo json_encode($sTypeCarGroup);
			$this->renderPartial('_service_car_type',array(
				'selectedType'=>$selectedType,
				'sTypeCarGroup'=>$sTypeCarGroup,
				'carGroupList'=>$carGroupList));	
		?>	
	</div>
</div>

<?php 
// 设置初始值
$selectedDate = $selectedParams['sDate'] ;
?>	
<div class="row">
	<div class=" col-xs-2 text-right h6">日期</div>
	<div class="col-xs-10 " id="sdatelist">
		<a name="sDate" class="btn btn-item time-info <?php echo UCom::currentStr($selectedDate, 1);?>" data-value="1">今天(<?php echo date('d日')?>)</a>
		<a name="sDate" class="btn btn-item time-info <?php echo UCom::currentStr($selectedDate, 2);?>" data-value="2">明天(<?php echo date('d日',time()+24*60*60);?>)</a>
		<a name="sDate" class="btn btn-item time-info <?php echo UCom::currentStr($selectedDate, 3);?>" data-value="3">后天(<?php echo date('d日',time()+2*24*60*60);?>)</a>

	</div>
</div>


<div class="row">
	<div class=" col-xs-2 text-right h6">时间</div>
	<div class="col-xs-10 " id="stimelist">
<?php 

$this->renderPartial('_service_time_list',array(
		'selectedType'=>$selectedType,
		'timeList'=>$timeList
		
));
?>		

	
	</div>
</div>
<div class="row">
	<div class=" col-xs-2 text-right h6">卡券</div>
	<div class="col-xs-10"></div>
</div>
<div class="row"></div>
<?php  
Yii::app()->clientScript->registerScript(
'selectFx',
'select_service_ini();
order_new_ini();			
			',
CClientScript::POS_READY
);
?>