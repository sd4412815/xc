
<div class="row">
<div class="col-sm-6">
<p>

<?php
$shopServiceList = WashShopService::model()->getServices(22);
echo CJSON::encode($shopServiceList);

// $shopset = new ShopServiceSetForm();
// $shopset->load(22);
// echo CJSON::encode($shopset);
// $joinStd = array();
// $joinStd['free'] = array('dateLong'=>0,'price'=>0,'dataLongFree'=>0);
// $one =array('dateLong'=>6,'price'=>1780,'dataLongFree'=>1);
// $more = array('dateLong'=>6,'price'=>3500,'dataLongFree'=>1);
// $joinStd['silver'] = array('one'=>$one,'more'=>$more);

// $one =array('dateLong'=>12,'price'=>3000,'dataLongFree'=>3);
// $more = array('dateLong'=>12,'price'=>6000,'dataLongFree'=>3);
// $joinStd['golden'] = array('one'=>$one,'more'=>$more);

// // $one =array('dateLong'=>24,'price'=>5000,'dataLongFree'=>7);
// $one = array();
// $more = array('dateLong'=>24,'price'=>10000,'dataLongFree'=>7);
// $joinStd['diamond'] = array('one'=>$one,'more'=>$more);
// @$d = $joinStd['diamond']['one']['dateLong'];
//  echo  $d;
//  if (isset($d)) {
//  	echo  $d;
//  }else{
//  	echo 'dd';
//  }
// echo CJSON::encode($joinStd);

?>
</p>
</div>
</div>