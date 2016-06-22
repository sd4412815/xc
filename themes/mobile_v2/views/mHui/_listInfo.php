<div class="col-xs-6 col-sm-3" >
<?php 
$shop = $data->shop;
// echo $data->shop['ws_name'];
// var_dump($data->hui);
$shopImgUrl =  Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/shops/' . $shop ['id'] . '/shop' . $shop ['id'] . '.jpg';
$shopOrderUrl = Yii::app()->createUrl('mOrder/new',array('id'=>$shop['id']));;
?>
<div class="row" style="padding-left: 1px;">
<a href="<?php echo $shopOrderUrl;?>"><img alt=""  
class="lazy img-round"
					data-src="<?php echo $shopImgUrl ?>"
 style="width: 100%;height:100px;"></a>
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
<a class="btn btn-success btn-flat" href="<?php echo $shopOrderUrl;?>" role="button">免费预约</a>
</div>

</div>