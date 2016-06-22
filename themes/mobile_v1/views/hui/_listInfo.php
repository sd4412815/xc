<div class="col-xs-6" >
<?php 
$shop = $data->shop;
// echo $data->shop['ws_name'];
// var_dump($data->hui);
$shopImgUrl =  Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/' . $shop ['id'] . '/shop' . $shop ['id'] . '.jpg';
$shopOrderUrl = Yii::app()->createUrl('order/new',array('id'=>$shop['id']));;
?>
<div class="row" style="padding-left: 1px;">
<a href="<?php echo $shopOrderUrl;?>"><img alt="" src="<?php echo $shopImgUrl ?>" class="img-responsive" style="width: 100%"></a>
</div>
<div class="row">
<?php 
echo '【'.$shop->area['a_name'].'】'.$shop['ws_name']; 	
?>
</div>
<div class="row">
<?php 
$this->widget('star.starWidget',array('score'=> $shop['ws_score']));
?>
<a class="btn btn-warning" href="<?php echo $shopOrderUrl;?>" role="button">预约</a>
</div>

</div>