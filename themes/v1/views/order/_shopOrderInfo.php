<div class="row">
	<div class="col-xs-12 col-sm-6">
		<p>
			<b>预约服务</b>
		
			<span class="serviceTypeRatio ">
<?php

$shopServices = WashShopService::model()->getServices($shop['id'])['data'];
$setSTypeDefault=FALSE;
foreach ($shopServices as $key => $service) :
    $shopServiceType = $service->wssSt;
$strCls = "btn btn-app1"; 
if((isset($sType)&& $sType == $shopServiceType['id']) || (!isset($sType) && !$setSTypeDefault)){
    $strCls = $strCls = "btn btn-app1";
    $setSTypeDefault = true;
}else{
    $strCls = $strCls = "btn btn-app";
}
    ?>	


<a class="<?php echo $strCls;?>" name="sType"
				data-value="<?php echo $service['wss_st_id'];?>"
				id="sTypeRatioStr<?php echo $shopServiceType['id'];?>"
				<?php
    if ($service['wss_state'] != 1) :
        ?> disabled
				<?php endif;?>><?php echo $shopServiceType['st_name'];?></a>
	
<?php endforeach;?>						
					
</span>
		</p>

		<p>
			<b>预约日期</b>
	
	
			<span class="dateRatio"> <a class="<?php echo $bias==0? "btn btn-app1":"btn btn-app"?>" name="serviceDate"
				id="dateRatioStr0" data-value="0"><?php echo  date('m月d日',time());?></a>
				<a class="<?php echo $bias==1? "btn btn-app1":"btn btn-app"?>" name="serviceDate" id="dateRatioStr1"
				data-value="1"><?php echo  date('m月d日',time()+24*60*60*1);?></a> <a
				class="<?php echo $bias==2? "btn btn-app1":"btn btn-app"?>" name="serviceDate" id="dateRatioStr2"
				data-value="2"><?php echo  date('m月d日',time()+24*60*60*2);?></a>
			</span>
		</p>
		<p>
			<b>预约车型</b>
		
			<span class="carTypeRatio"> <a class="btn btn-app1" name="carType"
				id="carTypeStr1" data-value="1"><?php echo Yii::app()->params['carType'][1];?></a> <a class="btn btn-app"
				name="carType" id="carTypeStr2" data-value="2"><?php echo Yii::app()->params['carType'][2];?></a>
			</span>

		</p>

		<p>
			<b>预约位置</b>
		
			<span class="positionRatio"> <a class="btn btn-app1" name="position" data-value="1"
				id="sPositionRatioStr1"><span id="pcount1" class="badge bg-green">0</span>车位1</a>				
						<?php
    for ($i = 1; $i < $shop['ws_num']; $i ++) :
        ?>
	<a class="btn btn-app" name="position"
				id="sPositionRatioStr<?php echo $i+1;?>" data-value="<?php echo $i+1;?>"><span
					id="pcount<?php echo $i+1;?>" class="badge bg-green">0</span>车位<?php echo $i+1;?></a>														
						<?php endfor;?>
						</span>
		</p>

	</div>
	<!-- /.com-sm-6 -->
	<div class="col-xs-12 col-sm-6">
		<p>
			<b>预约时间</b>
		</p>
		<p>
		
		
		<div id="sDateList" class="sDateListClass"> </div>

		</p>
		  <p><b>优惠卡(共<?php
echo Cardinvite::model()->countByAttributes(array(
    'ci_state' => 1,
    'ci_owner' => Yii::app()->user->id
));

?>张)</b> &nbsp; 
		  
<?php 
if (Yii::app()->user->isGuest):
?>		  
		  <span><a href="<?php echo  Yii::app()->createUrl('site/login').'?callback='.Yii::app()->createAbsoluteUrl('order/new',array('id'=>$shop['id']));?>" class="text-yellow"> 登录</a> 后查看可用的优惠卡</span>
		  <?php endif;?>		  
		  </p>
<p>
		  <?php 
if (!Yii::app()->user->isGuest):
?>	
<div class="row">
			  <div class="col-xs-11 col-sm-12">
			 
			  	<div id="cardList" class="cardRatio"></div>
			     <div class="input-group">
			     
				  <input id="cardPWD" type="text" class="form-control" placeholder="输入8位优惠卡/次卡密码">
				  <span class="input-group-btn">
					<button class="btn btn-warning" type="button" onclick="addCard()">使用</button>
				  </span>
				</div><!-- /input-group -->
			
			
				
			  </div></div>
<?php endif;?>
			 </p>
			<p > 
              <p><button  class="btn btn-danger btn-lg" onclick="orderAdd()"> 免费预订 </button> <small class="form-control-static text-yellow">预订后会将服务密码发到您的手机上</small>	</p></p>		  
			  <p><small>历史成交: <a href="#settings" data-toggle="tab" class="text-yellow"><?php 
$orderCount = OrderHistory::model()->getOrderStatistics($shop['id'], '2014-01-01', date('Y-m-d H:i:s',time()+3*24*60*60),0,TRUE)['data']['totalCount'];
echo $orderCount;
			  ?>笔</a></small> &nbsp;&nbsp;&nbsp;&nbsp; <small>付款方式: 到店付款</small></p>
			  
			  </p>
	</div>

</div> <!-- /.row -->
<div class="row">			    
		  <div class="col-xs-12">
			<ul class="nav nav-tabs" role="tablist">
			  <li ><a href="#home" role="tab" data-toggle="tab">服务介绍</a></li>
			  <li class="active"><a href="#profile" role="tab" data-toggle="tab">车行详情</a></li>
			  <li><a href="#messages" role="tab" data-toggle="tab">用户评价<span class="text-yellow">(<?php 
	echo OrderComments::model()->count('oc_washshop_id=:shopId AND oc_comment_user_type=1',array(':shopId'=>$shop['id']));			
				?>)</span></a></li>
			  <li><a href="#settings" role="tab" data-toggle="tab">成交记录<span class="text-yellow">（<?php echo $orderCount;?>）</span></a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane " id="home">			     
				 <div class="row">
				     <div class="col-sm-offset-2 col-sm-8">
					    <h4 class="text-yellow">服务用时</h4>
				
						<p>
<?php
foreach ($shopServices as $key => $service) :
    $shopServiceType = $service->wssSt;
    ?>	
   <?php 
   if($service['wss_state']==1):
   ?>
   <strong><?php echo $shopServiceType['st_name'];?></strong>：<?php 
echo $service['wss_service_time'];?>分钟 &nbsp;&nbsp;
   <?php endif;?>
    
	
<?php endforeach;?>								
					
					
					 </div>
                 </div>
			     
			      
			  </div>
			  <div class="tab-pane active" id="profile">
			     <div class="row" style="height:5px;"></div>
			     <div class="row">
				   
				<div class="col-md-8">

						<img style="margin: 20px" width="100%" height="300" alt="车行位置"
							title="车行位置"
							src="http://api.map.baidu.com/staticimage?center=<?php echo $shop['ws_position'];?>&zoom=16&width=400&height=300&markers=<?php echo $shop['ws_position'];?>&markerStyles=l,A,,0xff0000" />

					</div>
					<div class="col-md-4">
						<p>
							<span style="font-weight: bold; color: #ff9900;">简介：</span>
					  <?php echo CHtml::decode($shop->ws_desc);?>
					</p>
						<p>

							<span style="font-weight: bold; color: #ff9900;">附近：</span>
					  <?php
							
$keywords = split ( '[; ,]', $shop->ws_key_words );
							?>
					<?php foreach ($keywords as $key=>$value):?>
					  <span class="label label-primary" style="font-size: 11px;"><?php echo $value;?></span> 
					  <?php endforeach;?>
					</p>

						<p>
							<span style="font-weight: bold; color: #ff9900;">地址：</span>
                       <?php echo $shop->ws_address;?></p>
						<p style="font-weight: bold; color: #ff9900;">服务特色：</p>
						<p>
					 
			
<?php

$features = $shop->washShopFeatures;
?>	
<?php
foreach ( $features as $key => $value ) :
	if ($value ['sf_type'] == 0) :
		?>				
<img
								src="<?php echo Yii::app()->theme->baseUrl.'/img/ico/'.$value->sf_img_name;?>"
								title="<?php echo  $value->sf_desc;?>" />	<?php echo $value->sf_desc;?> <br />
<?php elseif ($value['sf_type']==1):?>
<?php echo CHtml::decode($value['sf_code']); echo $value['sf_desc'];?>	<br />	
<?php endif;?>
<?php endforeach;?>			
			</p>
						<p>
							<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/shou.png"
								style="vertical-align: bottom;" title="首次优惠卡" /> 本店共发布首次预定优惠卡 <span
								class="text-red">
<?php
echo CardGenHistory::model ()->countByAttributes ( array (
		'cgh_type' => 0,
		'cgh_shop_id' => $shop['id'],
		'cgh_state' => 4 
) );

?>				
				</span> 张
						</p>
						<p>
							<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ci.png"
								style="vertical-align: bottom;" title="次卡" /> 本店共发布次卡 <span
								class="text-red">
<?php
echo CardGenHistory::model ()->countByAttributes ( array (
		'cgh_shop_id' => $shop['id'],
		'cgh_state' => 4 
), 'cgh_type>0' );
?>						
						</span> 张
						</p>
					</div>
				 </div>
			     <div class="row" style="height:50px;"></div>
				 
			  </div>
			  <div class="tab-pane" id="messages">
			     <div class="row" style="height:5px;"></div>
				 	 <div class="row">
				 <div class="col-xs-12">
				 <div class="no-padding">
	
					    

	<div id="commentList">
<?php
$criteria = new CDbCriteria ();
$criteria->order = 'oc_datetime DESC, oc_order_id DESC';

// $shopId = $shopId;
$criteria->addCondition ( 'oc_washshop_id = :shopId' );
$criteria->params [':shopId'] = $shop['id'];
$criteria->addCondition ( 'oc_comment_user_type = 1' );

$dataProvider = new CActiveDataProvider ( 'OrderComments', array (
		'pagination' => array (
				'pageSize' => Yii::app()->params['pageSize'],
		'route'=>'order/GetCommentList',
				),
		'criteria' => $criteria 
) );
$this->renderPartial ( '_commentList', array (
		'dataProvider' => $dataProvider 
) );
?>			  	
			  	</div> </div></div></div>

			
			  		
				
				
				 
				
				
				 
			  </div><!-- tab-pane -->
			  <div class="tab-pane" id="settings">
			  <div id="orderList">
<?php
$criteria = new CDbCriteria ();
$criteria->order = 'id desc';


$criteria->addCondition ( 'oh_wash_shop_id = :shopId' );
$criteria->params [':shopId'] = $shop['id'];
$criteria->addCondition ( 'oh_state >=2' );

$dataProvider = new CActiveDataProvider ( 'OrderHistory', array (
    'pagination' => array (
        'pageSize' => Yii::app()->params['pageSize'] ,
        'route'=>'order/GetOrderList',
    ),
    'criteria' => $criteria
) );

$this->renderPartial ( '_orderList', array (
		'dataProvider' => $dataProvider 
) );
?>			  	
			  	</div>
			  </div>
			 
			</div>
		  </div><!-- col-xs-12 -->
		</div>	<!-- row -->

<?php
Yii::app ()->clientScript->registerScript ( 'afterReady', "
			    yd();
", CClientScript::POS_END );
										
?>

