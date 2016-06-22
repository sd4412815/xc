<?php
$this->pageTitle = Yii::app ()->name . ' - 我的账户';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        面板<?php echo  date('Y-m-d');?>
                        <small>统计</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
                        <li class="active">面板</li>
                    </ol>
                </section>

                
                
                
                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                            
                                <div class="inner">
                                    <h3>
                                       <?php 
                                     $userModel=   Staff::model()->findByAttributes(array(
                                       	's_user_id'=>Yii::app()->user->id,
                                       ));
//                                        $boss = Boss::model()->findByPk(Yii::app()->user->id);
// getOrdersByStaffId($staffId, $beginTime, $endTime, $isDESC=true,$shopId=0, $isCount=FALSE,$isValid=TRUE)
   $rlt = OrderHistory::model()->getOrdersByStaffId($userModel['id'],  
date('Y-m-01 00:00:00', time()), 
date('Y-m-d h:i:00', time()+(7*24*60*60)), 1,0,true,true);
if ($rlt['status']) {
	echo $rlt['data'];
}else {
echo '0';
}

                                    
                                       ?>  <sup style="font-size: 20px">个</sup>
                                    </h3>
                                    <p>
                                      本月有效 预约订单
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="<?php echo Yii::app()->createUrl('order/new');?>" class="small-box-footer">
                                    马上预约<i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php
//                             echo   User::model()->findByPk(Yii::app()->user->id)->u_score;

// 上文已经检索了
// if (isset($userModel)) {
// 	echo       $userModel->s_score;
// }
// else {
// echo   User::model()->findByPk(Yii::app()->user->id)->u_score;
// }
                                
                                        ?>
                                        <sup style="font-size: 20px">分</sup>
                                    </h3>
                                    <p>
                                       我的积分
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                  积分历史 <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
              
                    </div><!-- /.row -->


                </section><!-- /.content -->
                
         <section class="col-lg-12 connectedSortable">
                   <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">今日预约</h3>
                         
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list">
                                    
                                   <?php 
                                   $rlt = OrderHistory::model()->getOrdersByStaffId($userModel['id'],
                                   		date('Y-m-d 00:00:01', time()),
                                   		date('Y-m-d 23:59:59', time()), false,0,false,true);
                                   if ($rlt['status']) {

foreach ($rlt['data'] as $key=>$data):?>

   <li>
                                            <!-- drag handle -->
                                            <span class="handle">
                                 
                                              
                                                  <?php echo $key+1;?>
                                             
                                            </span>
                                            <span class="text"></span>
                                        
                                            <!-- todo text -->
                                            <span class="text">
                                            <?php 
                                            if ($data->oh_type > 0) {
                                            	echo ServiceType::model()->findByPk($data->oh_type)['st_name'].'服务';
                                            }
                                            else {
                                            	echo '自助服务';
                                            }
                                            ?>
                                    </span>
                                           <span class="text"></span>
                                                  <span class="text">
                                                  <?php 
                                                  echo $data['oh_position'];
                                                  ?>号洗车位
                                                  </span>
                                            <!-- Emphasis label -->
                                                 <span class="text"></span>
                                            <span class="text-danger">
                                       
                                              <i class="fa fa-clock-o"></i>
                                            <?php 
                                            echo substr($data['oh_date_time'],10,6).' - '.substr($data['oh_date_time_end'],10,6);
                                            ?>
                                            </span>
                                          
                                            
                                    
                                        </li>

<?php endforeach;


                                   
                                   
                             
//                                    	echo CJSON::encode($rlt['data']);
                                   }else {
                                   	echo '0';
                                   }                                  
                                   
                                   ?>
                                      
                                     
                                    
                                    
                                    </ul>
                                </div><!-- /.box-body -->
                             
                            </div><!-- /.box -->
         </section>
                
                


           <!-- FLOT CHARTS -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.time.js"></script>
        <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
        <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
         <!-- Page script -->

