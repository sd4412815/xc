<?php 
$this->pageTitle = '';


// $news = WashShop::model()->findByPk(23)->latestNews;
// echo $news[0]['sn_desc']
// var_dump($news);
// $weChatEnt = new UWeChatEnt(AppName::$EntOrderMngr);

// $msgContent = array(
		
		
// 		"touser"=>100,
// 		'msgtype'=>'text',
// 		'agentid'=>$weChatEnt->agentId,
		
// 		'text'=>array(
// 				'content'=>'你的内容',
// 		),
// 		'safe'=>0,
// );

// $sendRlt = $weChatEnt->sendMsg($msgContent);
// $sendRlt = json_decode($sendRlt,JSON_UNESCAPED_UNICODE);
// if ($sendRlt['errcode'] != 0){
// 	echo '发送失败:'.$sendRlt['errmsg'];
// // }
// $shopIdArray=array();
// for ($i=22;$i<150;$i++){
// 	$shopIdArray[]=$i;
// }

// // echo json_encode($shopIdArray);
// // $shopIdArray=array(22,158,63,25,26,27,74,75,70);
// $orderTempList = OrderTemp::model()->getShopMinValue($shopIdArray, 1, "8:00", "17:00",0);

// // foreach ($orderTempList as $key=>$orderTemp){
// // 	echo $orderTemp['id'].' '.$orderTemp['ot_wash_shop_id'].' '.$orderTemp['ot_min_value'];
// // 	echo '<br>';
// // }
// echo json_encode($orderTempList);
// echo '<br>';
// echo '<br>';
// $orderTempList = OrderTemp::model()->getShopCount($shopIdArray, 1, "8:00", "17:00", 0,false);
// // $orderTempList = OrderTemp::model()->getShopInfoList($shopIdArray, array(6), "8:00", "17:00");

// echo json_encode($orderTempList);

// 获取车行价格，数量等信息
// $shopInfoList = OrderTemp::model ()->getShopInfoList ( $shopIdArray, 1, '8:00', '17:00', 0 );
	

// echo json_encode($shopInfoList);

?>
<div id="slide-hui" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?php echo Yii::app()->baseUrl;?>/images/hui/1/h1.jpg" alt="..." width="100%">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
       <img src="<?php echo Yii::app()->baseUrl;?>/images/hui/1/h1.jpg" alt="..."  width="100%">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    ...
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#slide-hui" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#slide-hui" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>