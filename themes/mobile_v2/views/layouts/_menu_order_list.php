
<div style="padding: 0; background-color: white;margin:0 0 10px 0;" >
<div  id="top-bar" class="loader-inner ball-pulse"><div></div><div></div><div></div>
</div>
	<div class="btn-group btn-group-justified" role="group" id="filter-menu" style="display: none;">
		<li class="btn btn-default btn-flat"
			style=" padding: 0px;border:1px solid #00a65a;border-top:none;border-left:none;"><select id="sTypeFilter"
			class="cs-select cs-skin-elastic-list">

<?php 
// 查找系统开通的服务
$serviceList = ServiceType::model()->getAllServiceType();

if (empty($serviceList) ){
	new CHttpException( 500, '系统服务设置错误' );
}

// 设置初始值
$selectedValue = UCom::getCookieInt("sTypeFilter", $serviceList[0]["id"]);
// var_dump($serviceList) ;
foreach ($serviceList as $key=>$service):
?>
	<option value="<?php echo $service['id'];?>" <?php echo UCom::selectedStr($service['id'], $selectedValue);?> ><?php echo $service['name'];?></option>
<?php 
endforeach;
?>
			
		</select></li>
		<li class="btn btn-default btn-flat"
			style="padding: 0px;border:1px solid #00a65a;border-top:none;border-left:none;"><select id="sDateFilter"
			class=" cs-select cs-skin-elastic-list">

<?php 
// 设置初始值
$selectedValue = UCom::getCookieInt("sDateFilter", 1);
?>			
				<option value="1" <?php echo UCom::selectedStr(1, $selectedValue);?> ><?php echo date('d号');?>(今天)</option>
				<option value="2" <?php echo UCom::selectedStr(2, $selectedValue);?> ><?php echo date('d号',time()+24*60*60);?>(明天)</option>
				<option value="3" <?php echo UCom::selectedStr(3, $selectedValue);?> ><?php echo date('d号',time()+2*24*60*60);?>(后天)</option>
		</select></li>
		<li class="btn btn-default btn-flat"
			style="padding: 0px;border:1px solid #00a65a;border-top:none;border-left:none;"><select id="sTimeFilter"
			class="cs-select cs-skin-elastic-list" >
<?php 
// 设置初始值
$selectedValue = UCom::getCookieInt("sTimeFilter", 0);
?>	
				<option value="0" <?php echo UCom::selectedStr(0, $selectedValue);?>>不限</option>
				<option value="1" <?php echo UCom::selectedStr(1, $selectedValue);?> >上午</option>
				<option value="2" <?php echo UCom::selectedStr(2, $selectedValue);?>>中午</option>
				<option value="3" <?php echo UCom::selectedStr(3, $selectedValue);?>>下午</option>
				<option value="4" <?php echo UCom::selectedStr(4, $selectedValue);?>>傍晚</option>
				<option value="5" <?php echo UCom::selectedStr(5, $selectedValue);?>>晚上</option>
		</select></li>
			<li class="btn btn-default btn-flat"
			style="padding: 0px;border-bottom:1px solid #00a65a;"><select id="sOrderFilter"
			class="cs-select cs-skin-elastic-list">
<?php 
// 设置初始值
$selectedValue = UCom::getCookieInt("sOrderFilter", 1);
?>				
				<option value="1"  <?php echo UCom::selectedStr(1, $selectedValue);?>>离我最近</option>
				<option value="2"  <?php echo UCom::selectedStr(2, $selectedValue);?>>最受好评</option>
				<option value="3"  <?php echo UCom::selectedStr(3, $selectedValue);?>>价格最低</option>
				<option value="4"  <?php echo UCom::selectedStr(4, $selectedValue);?>>收藏最多</option>
				<option value="5"  <?php echo UCom::selectedStr(5, $selectedValue);?>>会员最多</option>
				<option value="6"  <?php echo UCom::selectedStr(6, $selectedValue);?>>销量最广</option>
		</select></li>

	</div>
</div>
<?php
Yii::app ()->clientScript->registerScript ( 'menu_order_list', ' 
list_filter_ini();
			', CClientScript::POS_READY );
?>

