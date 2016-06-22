<?php
	header('Content-Type:text/html; charset=utf-8');//使用gb2312编码，使中文不会变成乱码
	
	$url_this ='http://'. $_SERVER["SERVER_NAME"]. $_SERVER["REQUEST_URI"];
	$p = strrpos($url_this,'/');
$url_this = substr($url_this,0, $p);
	//	$url_this =  "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
//echo $url_this;
		$client=new SoapClient($url_this.'/index.php?r=city/APIs&4444');

	$getTime=new SoapClient($url_this.'/index.php?r=washshop/APIs&4444');
	$getStaff=new SoapClient($url_this.'/index.php?r=staff/APIs&4444');
	$getOrder=new SoapClient($url_this.'/index.php?r=order/APIs&4444');
	
	//$client=new SoapClient('http://202.118.21.228/xc/index.php?r=city/APIs&4444');

	//$getTime=new SoapClient('http://202.118.21.228/xc/index.php?r=washshop/APIs&4444');
	//$getStaff=new SoapClient('http://202.118.21.228/xc/index.php?r=staff/APIs&4444');
	//$getOrder=new SoapClient('http://202.118.21.228/xc/index.php?r=order/APIs&4444');
//echo $getTime->getWashShopFeatures(1);
//echo $getTime->getServiceCount(1,false,true);
	//echo $getTime->getAvailableTime(1,4,0,true,1);
//	$type=$_POST['type'];
	//echo $getTime->getAvailableTime(1,1,0,true,1);
		//echo $client->getServiceTypes(1);
	//echo $getTime->getAvailableStaff(1,1,1,0);
	//echo $getStaff->getStaffs(1);
	//echo $client->getServiceTypes(1);
	//echo $getTime->getWashShopInfo(3);
	//echo $getTime->getServiceCount(1,false,true);
	$type=$_POST['type'];
	if($type==1)
	{
		$shop_id=$_POST['shop_id'];
		$city_id=$_POST['city_id'];
		$q=array();
		$q[0]=json_decode($client->getServiceTypes($city_id));
		$q[1]=json_decode($getTime->getWashShopInfo($shop_id));
		$q[2]=json_decode($getTime->getServiceCount($shop_id,false,true));
		echo json_encode($q);
	}else if($type==2)
	{
		$shop_id=$_POST['shop_id'];
		$IntervalNum=$_POST['IntervalNum'];
		$cDate=$_POST['cDate'];
		$saState=$_POST['saState'];
		//$z=json_decode($getTime->getWashShopInfo($shop_id));
//		$cNum=$z->data->ws_num;
//		$timeCount=($z->data->ws_count)/$cNum;
		$cNum=$_POST['carNum'];
		$q=array();
		for($i=1;$i<=$cNum;$i++)
		{
			//if($i==0)
//			{
//				$w=array();
//				$w[0]=$timeCount;
//				$w[1]=$cNum;
//				$w[2]=json_decode($getTime->getAvailableTime($shop_id,1,0,true,1));
//				$q[$i]=$w;
//			}
//			else
//			{
				$q[$i]=json_decode($getTime->getAvailableTime($shop_id,$IntervalNum,$cDate,$saState,$i));
			//}
		}
		echo json_encode($q);
		
	}else if($type==3)
	{
		$shop_id=$_POST['shop_id'];
		echo $getStaff->getStaffs($shop_id);
	}else if($type==4)
	{
		$shop_id=$_POST['shop_id'];
		$timeIndex=$_POST['timeIndex'];
		$IntervalNum=$_POST['IntervalNum'];
		$cDate=$_POST['cDate'];
		$q=array();
		$q[0]=json_decode($getStaff->getStaffs($shop_id));
		$q[1]=json_decode($getTime->getAvailableStaff($shop_id,$timeIndex,$IntervalNum,$cDate));
		echo json_encode($q);
	}else if($type==5)
	{
		$shop_id=$_POST['shop_id'];
		echo $getTime->getWashShopInfo($shop_id);
	}else if($type==6)
	{
		$shop_id=$_POST['shop_id'];
		$timeIndex=$_POST['timeIndex'];
		$IntervalNum=$_POST['IntervalNum'];
		$position=$_POST['position'];
		$order_value=$_POST['order_value'];
		$order_type=$_POST['order_type'];
		$staff1_id=$_POST['staff1_id'];;
		$staff2_id=$_POST['staff2_id'];
		$user_id=$_POST['user_id'];
		$cDate=$_POST['cDate'];
		$returnData=json_decode($getOrder->getOrderNew ( $timeIndex, $shop_id, $position, $IntervalNum, $order_value,$order_type, json_encode(array ()),$staff1_id,$staff2_id, $user_id,$cDate ));
		if($returnData->state=="true")
		{
			echo json_encode("OK");
		}
		else
		{
			echo json_encode("Failure");
		}
	}
	//echo $getOrder->getOrderNew ( 37, 1, 1, 1, 20, 1, json_encode(array ()),1,2, 1, 0 );
	//echo $getTime->getWashShopInfo(1);
	//$qw=json_decode($getTime->getWashShopInfo(1));
//	echo var_dump($qw->data->ws_num);
//
//		$q=array();
//		for($i=1;$i<=2;$i++)
//		{
//			//if($i==0)
////			{
////				$q[$i]=$timeCount;
////			}
////			else
////			{
//				$q[$i]=json_decode($getTime->getAvailableTime(1,2,0,true,$i));
//			//}
//		}
//		echo json_encode($q);

?>