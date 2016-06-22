<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app ()->name;
?>

 <script src="<?php echo Yii::app()->theme->baseUrl;?>/inc/js/jquery-1.10.2.min.js"></script>
 
 

     
<?php 

?>
<div class="container">
 

<?php
// $this->beginWidget ( 'bootstrap.widgets.TbHeroUnit', array (
// 'heading' => '专业洗车，就选' . CHtml::encode ( Yii::app ()->name )
// ) );
$this->beginWidget ( 'bootstrap.widgets.TbHeroUnit', array (
		'heading' => CHtml::encode ( 'Web Services接口' ) 
) );
?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
// alert('dj');
</script>
<h3>百度地图APIs</h3>
<p>
	ak秘钥
	<code>atV54I5hflatOH00IebtxSwR</code>
	<br /> geotable_id
	<code>66526</code>
	<br /> 返回结果中
	<code>washshop_no</code>
	表示车行加盟编号，
	<code>washshop_id</code>
	表示车行id， 根据车行id可以得到车行具体信息
</p>
<h3>可用Web Services</h3>
<ul>
	<li><a href="http://202.118.21.228/xc/index.php?r=washshop/APIs">http://202.118.21.228/xc/index.php?r=washshop/APIs</a>
		<ul>
			<li>
					
							<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'idgetWashShopInfo')); ?>
<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
					<h4>getWashShopInfo(1)</h4>
				</div>
				<div class="modal-body">
					<p>	<?php
					echo CJSON::encode ( WashShop::model ()->getWashShopInfo ( 1 ) );
					// $rlt = WashShop::model ()->findByPk ( 1 )->attributes;
					// // $shopFeatures = WashShop::model()->findByPk(1)->washShopFeatures;
					
					// // foreach ($shopFeatures as $name=>$value){
					// // $rlt['shop_features'][$name] = $value->attributes;
					// // }
					
					// // $rlt['shop_feature']= WashShop::model()->findByPk(1)->washShopFeatures;
					// echo var_dump ( CJSON::encode ( $rlt ) );
					?></p>
				</div>
<?php $this->endWidget();?>
<?php

echo '<code>getWashShopInfo（1）</code> ';
$this->widget ( 'bootstrap.widgets.TbButton', array (
		'label' => '查看运行结果',
		'type' => 'primary',
		'size' => 'small',
		'htmlOptions' => array (
				'data-toggle' => 'modal',
				'data-target' => '#idgetWashShopInfo' 
		) 
) );
?>
</li>
			<li>
					
							<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'idGetAvailableTime')); ?>
<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
					<h4>getAvailableTime(1,1,0,true,1)</h4>
				</div>
				<div class="modal-body">
					<p>	<?php echo var_dump ( json_encode ( WashShop::model ()->getAvailableTime ( 1, 1, 0, $showAllState = true ,1) ) );?></p>
				</div>
<?php $this->endWidget();?>
<?php

echo '<code>getAvailableTime(1,1,0,true,1)</code> ';
$this->widget ( 'bootstrap.widgets.TbButton', array (
		'label' => '查看运行结果',
		'type' => 'primary',
		'size' => 'small',
		'htmlOptions' => array (
				'data-toggle' => 'modal',
				'data-target' => '#idGetAvailableTime' 
		) 
) );
?>
</li>
			<li>
					
							<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'idGetWashShopFeature')); ?>
<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
					<h4>getWashShopFeatures(1)</h4>
				</div>
				<div class="modal-body">
					<p>	<?php echo CJSON::encode(WashShop::model()->getWashShopFeatures(1));?></p>
				</div>
<?php $this->endWidget();?>
<?php

echo '<code>getWashShopFeatures(1)</code> ';
$this->widget ( 'bootstrap.widgets.TbButton', array (
		'label' => '查看运行结果',
		'type' => 'primary',
		'size' => 'small',
		'htmlOptions' => array (
				'data-toggle' => 'modal',
				'data-target' => '#idGetWashShopFeature' 
		) 
) );
?>
</li>
			<li><code>getTotalParkingCount('__0101')</code>运行结果如下：
					
			
					
					
					
<?php
echo var_dump ( json_encode ( WashShop::model ()->getTotalParkingCount ( '__0101' ) ) );
// echo CHtml::dropDownList('dd', '', CHtml::listData (WashShop::model()->getAvailableTime(1,7,-8),'timeIndex','timeStr'));
?>
			</li>
			<li><code>getServiceCount(1,false,true)</code>运行结果如下：			
<?php
echo CJSON::encode ( WashShop::model ()->getServiceCount ( 1, false, true ) );
// echo CHtml::dropDownList('dd', '', CHtml::listData (WashShop::model()->getAvailableTime(1,7,-8),'timeIndex','timeStr'));
?>
			</li>
						<li><code>getAvailableStaff(1,1,1,0)</code>运行结果如下：		
<?php
echo CJSON::encode ( WashShop::model ()->getAvailableStaff(1,1,1,0));
// echo CHtml::dropDownList('dd', '', CHtml::listData (WashShop::model()->getAvailableTime(1,7,-8),'timeIndex','timeStr'));
?>
			</li>
			
		</ul></li>
	<li><a href="http://202.118.21.228/xc/index.php?r=boss/APIs">http://202.118.21.228/xc/index.php?r=boss/APIs</a>
		<ul>
			<li><code>orderAdd(array(1,2),1,1,1,0)</code>
					运行结果如下：
<?php
echo var_dump ( json_encode ( Boss::model ()->orderAdd ( array (
		1,
		2 
), 1, 1, 1, 0 ) ) );
// echo CHtml::dropDownList('dd', '', CHtml::listData (WashShop::model()->getAvailableTime(1,7,-8),'timeIndex','timeStr'));
?>
</li>
			<li><code>orderDelete(array(1,2),1,1,1,0)</code>
					运行结果如下：
<?php
echo var_dump ( json_encode ( Boss::model ()->orderDelete ( array (
		1 
), 1, 1, 1, 0 ) ) );
// echo CHtml::dropDownList('dd', '', CHtml::listData (WashShop::model()->getAvailableTime(1,7,-8),'timeIndex','timeStr'));
?>
</li>
			<li>老板测试手机号：10000000000（对应车行1）或者10000000001（对应车行2），密码均为123；不同老板登录时自动判断bossID，故方法中bossId不影响返回结果</li>
		<li>
		<code>getWashShopId(1)</code>运行结果如下：
		<?php 
	 $shop =	 WashShop::model()->findByAttributes(array(
				'ws_boss_id'=>'1',
		));
echo $shop['id'];
		?>
		</li>
	
		</ul></li>
	<li><a href="http://202.118.21.228/xc/index.php?r=staff/APIs">http://202.118.21.228/xc/index.php?r=staff/APIs</a>
		<ul>
			<li>
					
							<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'idGetStaffs')); ?>
<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
					<h4>getStaffs(1)</h4>
				</div>
				<div class="modal-body">
					<p>	<?php  echo CJSON::encode( Staff::model()->getStaffs(1));?></p>
				</div>
<?php $this->endWidget();?>
<?php

echo '<code>getStaffs(1)</code> ';
$this->widget ( 'bootstrap.widgets.TbButton', array (
		'label' => '查看运行结果',
		'type' => 'primary',
		'size' => 'small',
		'htmlOptions' => array (
				'data-toggle' => 'modal',
				'data-target' => '#idGetStaffs' 
		) 
) );
?>
</li>
</li>
	<li><code>getStaffsUpdate(array(1,2),1)</code>运行结果如下：			
<?php
echo CJSON::encode ( Staff::model ()->getStaffsUpdate ( array (
		1,
		2 
), 1 ) );
;
// echo CHtml::dropDownList('dd', '', CHtml::listData (WashShop::model()->getAvailableTime(1,7,-8),'timeIndex','timeStr'));
?>
			</li>
			
		
</ul>
	<li><a href="http://202.118.21.228/xc/index.php?r=order/APIs">http://202.118.21.228/xc/index.php?r=order/APIs</a>
		<ul>
		<li>
		<code>getOrderNew ( 13, 1, 1, 1, 20, 0, array (
		1,
		2 
),1,2, 1, 0 );</code>运行结果如下：
<?php 
$getOrderNewRlt = OrderHistory::model ()->getOrderNew ( 13, 1, 1, 1, 20, 0, array (
		1,
		2
), 1,2,1, 0 );
echo var_dump ( $getOrderNewRlt );
?>
		</li>
		<li>
		<code>getOrderDelete(1)</code>运行结果如下：
		<?php 
		echo CJSON::encode(OrderHistory::model()->getOrderDelete(1));
		?>
		</li>
			<li>
		<code>getOrderUnit(1, 25)</code> 输入结果如下:
		<?php 
		echo CJSON::encode(Order::getOrderUnit(1, 25));
		?>
		</li>
		<li>
		<code>getOrderTime(1, 1, 1,0)</code>运行结果如下：
		<?php 
		echo CJSON::encode(Order::getOrderTime(1, 1, 1,0));
		?>
		</li>

		</ul>
		
	</li>
	<li><a href="http://202.118.21.228/xc/index.php?r=province/APIs">http://202.118.21.228/xc/index.php?r=province/APIs</a>
		<ul>
				<li>
		<code>getProvinceInfo('辽宁')</code>运行结果如下：
<?php 
	
echo CJSON::encode(Province::model()->getProvinceInfo('辽宁'));
?>
		</li>
					<li>
		<code>getProvinceInfoById(1)</code>运行结果如下：
<?php 
	
echo CJSON::encode(Province::model()->getProvinceInfoById(1));
?>
		</li>
		<li>
		<code>getProvinceItems (1);</code>运行结果如下：
<?php 
		
				$rlt = UTool::iniFuncRlt();
		$criteria=new CDbCriteria;
	
		$criteria->select=array('id,p_no,p_name,p_spell');
		$criteria->order = 'p_spell  ASC' ;//排序条件
		$areaItems = Province::model()->findAll($criteria);
		$list=array();
		foreach ($areaItems as $i=>$province){
			$list[$i] = array_filter($province->attributes,'strlen');
		}
		$rlt['data'] = $list;
		$rlt['state']=true;
		$rlt['msg']='';

echo CJSON::encode($rlt);
?>
		</li>
		
		
		
		</ul>
		
	</li>
		<li><a href="http://202.118.21.228/xc/index.php?r=city/APIs">http://202.118.21.228/xc/index.php?r=city/APIs</a>
		<ul>
			<li>
		<code>getCityInfo('沈阳')</code>运行结果如下：
<?php 
	
echo CJSON::encode(City::model()->getCityInfo('沈阳'));
?>
		</li>
					<li>
		<code>getCityInfoById(1)</code>运行结果如下：
<?php 
	
echo CJSON::encode(City::model()->getCityInfoById(1));
?>
		</li>
		<li>
		<code>getCityItems (1);</code>运行结果如下：
<?php 
	$rlt = UTool::iniFuncRlt();
	$criteria=new CDbCriteria;
	
	$criteria->select=array('id,c_no,c_name,c_spell,c_province_id');
	$criteria->order = 'c_spell ASC';
// 	$criteria->condition = 'c_province_id=1';
	$cityItems = City::model()->findAllByAttributes(array('c_province_id'=>'1'),$criteria);
	$list=array();
	foreach ($cityItems as $i=>$city){
		$list[$i] = array_filter($city->attributes,'strlen');
	}
	$rlt['data'] = $list;
	$rlt['state']=true;
	$rlt['msg']='';

echo CJSON::encode($rlt);
?>
		</li>
	
		<li>
		<code>getServiceTypes(1)</code>运行结果如下：
		<?php 
		echo CJSON::encode(City::model()->getServiceTypes(1));
		?>
		
		</li>

		</ul>
		
	</li>
		<li><a href="http://202.118.21.228/xc/index.php?r=area/APIs">http://202.118.21.228/xc/index.php?r=area/APIs</a>
		<ul>
		<li>
		<code>getAreaInfo('和平')</code>运行结果如下：
<?php 
	
echo CJSON::encode(Area::model()->getAreaInfo('和平'));
?>
		</li>
		<li>
		<code>getAreaInfoById(1)</code>运行结果如下：
<?php 
	
echo CJSON::encode(Area::model()->getAreaInfoById(1));
?>
		</li>
		<li>
		<code>getAreaItems (1);</code>运行结果如下：
<?php 
		
		$rlt = UTool::iniFuncRlt();
		$criteria=new CDbCriteria;
	
		$criteria->select=array('id,a_no,a_name,a_spell,a_city_id');
		$criteria->order='a_spell ASC';
		$areaItems = Area::model()->findAllByAttributes(array('a_city_id'=>'1'),$criteria);
		$list=array();
		foreach ($areaItems as $i=>$area){
			$list[$i] = array_filter($area->attributes,'strlen');
		}
		$rlt['data'] = $list;
		$rlt['state']=true;
		$rlt['msg']='';

echo CJSON::encode($rlt);
?>
		</li>
				
		</ul>
		
	</li>
		<li><a href="http://202.118.21.228/xc/index.php?r=orderHistory/APIs">http://202.118.21.228/xc/index.php?r=orderHistory/APIs</a>
		<ul>
		<li>
		<code>getOrderStatistics(1, '2014-07-10 00:00', '2014-07-18 23:59');</code>运行结果如下：
<?php 
	
	$rlt = OrderHistory::model()->getOrderStatistics(1, '2014-07-10 00:00', '2014-07-18 23:59');
echo CJSON::encode($rlt);
?>
		</li>
			<li>
		<code>getOrdersByTime(1, <?php echo  date('Y-m-d 00:00')?>, <?php echo date('Y-m-d 23:59')?>)</code>运行结果如下：
<?php 
	
	$rlt = OrderHistory::model()->getOrdersByTime(1, date('Y-m-d 00:00'), date('Y-m-d 23:59'));
echo CJSON::encode($rlt);
?>
		</li>
				<li>
		<code>getOrdersByUserId(1, <?php echo  date('Y-m-d 00:00')?>, <?php echo date('Y-m-d 23:59')?>)</code>运行结果如下：
<?php 
	
	$rlt = OrderHistory::model()->getOrdersByUserId(1, date('Y-m-d 00:00'), date('Y-m-d 23:59'));
echo CJSON::encode($rlt);
?>
		</li>
		<li>
		<code>getOrdersByStaffId(1, <?php echo  date('Y-m-d 00:00')?>, <?php echo date('Y-m-d 23:59')?>,true,1)</code>运行结果如下：
<?php 
	
	$rlt = OrderHistory::model()->getOrdersByStaffId(1, date('Y-m-d 00:00'), date('Y-m-d 23:59'),true,1);
echo CJSON::encode($rlt);
?>
		</li>
		</ul>
		
	</li>
			<li><a href="http://202.118.21.228/xc/index.php?r=serviceType/APIs">http://202.118.21.228/xc/index.php?r=serviceType/APIs</a>
		<ul>
		<li>
		<code>getServiceTypeItems(1)</code>运行结果如下：
<?php 
	
	$rlt =ServiceType::model()->getServiceTypeItems(1);
echo CJSON::encode($rlt);
?>
		</li>
		</ul>
		
	</li>
	
				<li><a href="http://202.118.21.228/xc/index.php?r=serviceItem/APIs">http://202.118.21.228/xc/index.php?r=serviceItem/APIs</a>
		<ul>
		<li>
		<code>getServiceItems(1)</code>运行结果如下：
<?php 
	
	$rlt =ServiceItem::model()->getServiceItems(1);
echo CJSON::encode($rlt);
?>
		</li>
		</ul>
		
	</li>
	
</ul>
<?php
// $rlt = WashShop::model()->getAvailableStaff(1, 1, 1);
// $rlt = $rlt['data'];
// in_array($needle, $haystack)
// echo CJSON::encode(WashShop::model()->getAvailableStaff(1, 1, 1));
// echo CJSON::encode(Province::model()->getProvinceInfo('辽宁'));
// $rlt = date_parse('20140718 12:203');
// $getOrderNewRlt = OrderHistory::model ()->getOrderNew ( 1, 1, 1, 1, 20, 0, array (
// 		1,
// 		2
// ), 1,2,1, 0 );
// $getOrderNewRlt = OrderHistory::model ()->getOrderNew ( 2, 1, 1, 1, 20, 0, array (
// 		1,
// 		2
// ), 2,1,1, 0 );
// echo CJSON::encode(OrderHistory::model()->getOrdersByStaffId(1, '2014-07-10', '2014-7-30'));
// // $rlt = OrderHistory::model()->getOrderStatistics(1, '2014-07-10 00:00', '2014-07-18 59:59');
// $rlt = City::model()->getServiceTypes(1);
// $rlt = ServiceType::model()->findByPk(1)->serviceTypeItems;
// $rlt=ServiceType::model()->getServiceItems(1);
// echo CJSON::encode($rlt);


// $items = ServiceItem::model()->findAllByAttributes(array(
// 		'si_city_id'=>'1',
// ));// $type->serviceTypeItems;
// $items=ServiceItem::model()->getServiceItems(1);
// echo CJSON::encode($items);

// $client = new SoapClient('http://202.118.21.228/xc/index.php?r=orderHistory/APIs&2222');
// echo  $client->getStaffs(1);
$client = OrderHistory::model();
$q=array();
for($i=0;$i<10;$i++)
{
$q[$i]=json_decode(CJSON::encode($client->getOrderStatistics(1, '2014-07-1'+$i+' 00:00', '2014-07-1'+$i+' 23:59')));
}
echo json_encode($q);

// $shop_id=$_POST['shop_id'];
	echo CJSON::encode( $client->getOrderStatistics(1, '2014-07-10 00:00', '2014-07-13 23:59'));

//  echo var_dump($bossInfo);
 
//  $rlt = Boss::model()->orderAdd(array(7), 1,1,2,0);
//  echo var_dump($rlt);
// 	$rlt = UTool::iniFuncRlt();
// 	$criteria=new CDbCriteria;
	
// 	$criteria->select=array('id,c_no,c_name,c_spell,c_province_id');
// 	$cityItems = City::model()->findAllByAttributes(array('c_province_id'=>'1'),$criteria);
// 	$list=array();
// 	foreach ($cityItems as $i=>$city){
// 		$list[$i] = array_filter($city->attributes,'strlen');
// 	}
// 	$rlt['data'] = $list;
// 	$rlt['state']=true;
// 	$rlt['msg']='';

// echo CJSON::encode($rlt);

?>
</div>

<script>
$(document).ready(function () {
    $('#menu_APIs').addClass("active");
});
</script>