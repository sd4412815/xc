
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php 
                   $shopid = Yii::app()->session['shop']->id ;
                   echo $shopid;?>/shop<?php echo $shopid;?>.png"
					alt="<?php echo $shop->ws_name;?>" />
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username text-right">
                    <?php 
                  //$address = WashShop::model()->find('id=:id',array(":id"=>$shopid))->ws_address;
                  //echo $address;  
                  echo CHtml::encode($this->pageTitle); 
                  ?>
              </h3>
              <h6 class="widget-user-desc text-right">
                  <?php         
                    $shopid = Yii::app()->session['shop']->id ;
                    $name = WashShop::model()->find('id=:id',array(":id"=>$shopid))->ws_name;
                    echo $name;
                    ?>
                 
              </h6>
            </div>
            <div class="box-footer no-padding">
              <table class="table">
                  <tr class="text-center warning">
                     <th>统计类别</th>
                     <?php
                        $startMonth = date ( 'Y-m-01 00:00:00' );
                        $endMonth = date ( 'Y-m-d 23:59:59', strtotime ( date ( 'Y-m-1 00:00:00' ) . ' + 1 month -1 day' ) );
                        
                        
                        // $sts = ServiceType::model ()->findAll (array('order'=>'st_flag ASC'));
                        $sts = WashShopService::model()->getServices($shopid)['data'];
                        $criteria= new CDbCriteria();
                        $stIds = array();
                        foreach ($sts as $key=>$value){
                        	$stIds[]=$value['wss_st_id'];
                        }
                        $criteria->addInCondition('id',$stIds);
                        $criteria->order='st_flag ASC';
                        $sts = ServiceType::model()->findAll ($criteria);
                        
                        
                        foreach ( $sts as $key => $value ) :
                        	?>
                        <th><?php echo $value['st_name'];?></th>
                        <?php endforeach;?>
                  </tr>
                  <tr class="text-center">
                     <td><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/today.png" style="width: 20px;"> 本日新增</td>
                     <?php
                        // $sts=ServiceType::model()->findAll();
                        foreach ( $sts as $key => $value ) :
                        	?>
                        <td>
                        
                        <?php
                        	// echo
                        $startToday = date ( 'Y-m-d 00:00:00' );
                        $endToday =date ( 'Y-m-d 23:59:59' );
                        	$rlt = OrderHistory::model ()->getOrderStatistics ($shop['id'], $startToday, $endToday, $value ['id'] );
                        	if ($rlt ['status']) {
                        		echo $rlt ['data'] ['totalCount'];
                        	} else {
                        		echo CJSON::encode ( $rlt );
                        	}
                        	
                        	?>
                        </td>
                        <?php endforeach;?>
                  </tr>
                  
                   <tr class="text-center">
                     <td><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/today.png" style="width: 20px;"> 本周新增</td>
                     <?php
                        // $sts=ServiceType::model()->findAll();
                        foreach ( $sts as $key => $value ) :
                        	?>
                        <td>
                        
                        <?php
                        	// echo
                        $startToday = date ( 'Y-m-d 00:00:00' );
                        $endToday =date ( 'Y-m-d 23:59:59' );
                        	$rlt = OrderHistory::model ()->getOrderStatistics ($shop['id'], $startToday, $endToday, $value ['id'] );
                        	if ($rlt ['status']) {
                        		echo $rlt ['data'] ['totalCount'];
                        	} else {
                        		echo CJSON::encode ( $rlt );
                        	}
                        	
                        	?>
                        </td>
                        <?php endforeach;?>
                  </tr>
                  
                  <tr class="text-center">
                     <td><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/month.png" style="width: 20px;"> 本月新增</td>
                     <?php
                        // $sts=ServiceType::model()->findAll();
                        foreach ( $sts as $key => $value ) :
                        	?>
                        <td>
                        
                        <?php
                        
                        	$rlt = OrderHistory::model ()->getOrderStatistics ( $shop['id'], $startMonth, $endMonth, $value ['id'] );
                        	if ($rlt ['status']) {
                        		echo $rlt ['data'] ['totalCount'];
                        	} else {
                        		echo CJSON::encode ( $rlt );
                        	}
                        	
                        	?>
                        </td>
                        <?php endforeach;?>
                  </tr>
                  <tr class="text-center">
                     <td><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/totalorder.png" style="width: 20px;"> 订单总计</td>
                        <?php
                        $startMonth = '2014-01-01';
                        // $sts=ServiceType::model()->findAll();
                        foreach ( $sts as $key => $value ) :
                        	?>
                        <td>
                        
                        <?php
                        	// echo
                        	
                        	$rlt = OrderHistory::model ()->getOrderStatistics ( $shop['id'], $startMonth, $endMonth, $value ['id'] );
                        	if ($rlt ['status']) {
                        		echo $rlt ['data'] ['totalCount'];
                        	} else {
                        		echo CJSON::encode ( $rlt );
                        	}
                        	
                        	?>
                        </td>
                        <?php endforeach;?>
                  </tr>
                  <tr class="text-center">
                     <td><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/profit.png" style="width: 20px;"> 收入总计</td>
                     <?php
                        $startMonth = '2014-01-01';
                        // $sts=ServiceType::model()->findAll();
                        foreach ( $sts as $key => $value ) :
                        	?>
                        <td>
                        <i class="fa fa-jpy"></i>
                        <?php
                        	// echo
                        	
                        	$rlt = OrderHistory::model ()->getOrderStatistics ( $shop['id'], $startMonth, $endMonth, $value ['id'] );
                        	if ($rlt ['status']) {
                        		echo $rlt ['data'] ['totalValue'];
                        	} else {
                        		echo CJSON::encode ( $rlt );
                        	}
                        	
                        	?>
                        </td>
                        <?php endforeach;?>
                  </tr>
              </table>
              
             
              
<!--               <ul class="nav nav-stacked"> -->
<!--                 <li><a href="#">本日新增 <span class="pull-right badge bg-blue">31</span></a></li> -->
<!--                 <li><a href="#">本月新增 <span class="pull-right badge bg-aqua">5</span></a></li> -->
<!--                 <li><a href="#">订单总计 <span class="pull-right badge bg-green">12</span></a></li> -->
<!--                 <li><a href="#">收入统计<span class="pull-right badge bg-red">842</span></a></li> -->
<!--               </ul> -->
            </div>
          </div>
          
          
        

                
                
             
                
  
     
