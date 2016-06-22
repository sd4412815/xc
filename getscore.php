<?php

	$client = new SoapClient('http://202.118.21.228/xc/index.php?r=washshop/APIs&4444');
	$shop_id = array();
	$shop_id = $_POST['shop_id'];
	// // echo json_encode(count($shop_id));
	//  
	$q=array();
	for($i=0;$i < count($shop_id);$i++){
		$s=array();
		$s[0]=json_decode($client->getWashShopInfo($shop_id[$i]));
		$s[1]=json_decode($client->getServiceCount($shop_id[$i]));
		$q[$i] = $s;
	}
	echo json_encode($q);
  
  
    //echo $client->getWashShopInfo(2);
//	$shop_id = $_POST['shop_id'];
//	echo $client->getServiceCount(1);
?>