<?php

 	header('Content-Type:text/html; charset=utf-8');//使用gb2312编码，使中文不会变成乱码
	$client=new SoapClient('http://202.118.21.228/xc/index.php?r=orderHistory/APIs&4444');
	
    $shop_id=$_POST['shop_id'];
	$type=$_POST['type'];
//	if($type==1)
//	{
//		echo $client->getWashShopInfo($shop_id);
//	}else if($type==2)
//	{
//		$dTime=$_POST['dTime'];
//		$cDate=$_POST['cDate'];
//		$saState=$_POST['saState'];
//		$cNum=$_POST['cNum'];
//		$q=array();
//		for($i=1;$i<=$cNum;$i++)
//		{
//			$q[$i]=json_decode($client->getAvailableTime($shop_id,$dTime,$cDate,$saState,$i));
//		}
//		echo json_encode($q);
//	}
	if($type==1)
	{
		$Nums=$_POST['Nums'];
		$dYear=array();
		$dYear=$_POST['dYear'];
		$dMonth=array();
		$dMonth=$_POST['dMonth'];
		$dDay=array();
		$dDay=$_POST['dDay'];
		$q=array();
		for($i=0;$i<$Nums;$i++)
		{
			$q[$i]=json_decode($client->getOrderStatistics($shop_id, $dYear[$i].'-'.$dMonth[$i].'-'.$dDay[$i].' 00:00', $dYear[$i].'-'.$dMonth[$i].'-'.$dDay[$i].' 23:59'));
		}
		echo json_encode($q);
	}
	//echo $client->getOrderStatistics(1, '2014-07-18 00:00', '2014-07-18 23:59');
	//
//	$q=array();
//	$a=0;
//		for($i=18;$i<26;$i++)
//		{
//			$q[$a]=json_decode($client->getOrderStatistics(1, '2014-7-'.$i.' 00:00', '2014-7-'.$i.' 23:59'));
//			$a++;
//		}
//		echo json_encode($q);
?>