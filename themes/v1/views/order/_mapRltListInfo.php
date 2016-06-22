<?php 
$pageCount = $widget->dataProvider->pagination->pageCount;
$pageSize = $widget->dataProvider->pagination->pageSize;
$currentPage = $widget->dataProvider->pagination->currentPage + 1;
?>
<li class="list-group-item">
	<h4>
		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ma<?php
		 echo $pageSize*($currentPage-1)+$index+1;
// 		 echo $index+1;
		 ?>.png" /> <a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$data['id']));?>"><?php echo $data['ws_name'];?></a>
		 <a
					href="<?php
		
echo Yii::app ()->createUrl ( 'order/new', array (
				'id' => $data ['id'],
				
		) );
		?>"
					class="btn btn-warning btn-bg" type="button">预定</a>
	</h4>
	<div>评分值： <?php $this->widget('star.starWidget',array('score'=> $data['ws_score'])); ?>	</div> 地址：<?php echo $data['ws_address'];?>
	<br >
<?php
$bias = 0;
$shopServices = WashShopService::model()->findAllByAttributes(array(
	'wss_ws_id'=>$data['id'],
	'wss_state'=>'1'));

// $shopServices = $data->washShopServices;
// echo CJSON::encode($shopServices);

?>
<?php 
foreach ($shopServices as $key=>$service):?>

<b>
<?php echo $service->wssSt['st_name'];?></b>
<?php 
$queryRlt = $data->getBasicInfobyType ( $data, $service ['wss_st_id'], $bias, false );
?>

<i class="fa fa-jpy"> <span style="color:#009900;"><?php echo $queryRlt ['data'] ['minValue'];?></span></i>起
	<?php
	if ($queryRlt ['data'] ['minValue'] < $queryRlt ['data'] ['stdValue']) :
		?>
				<span class="label label-danger" style="font-size:12px;">折</span>
		<?php endif;?>
	
<?php endforeach;?>
    

	</li>