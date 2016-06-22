<?php
$this->pageTitle = Yii::app ()->name . ' - 预约列表';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        预约列表
                        <small>统计</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
                        <li class="active">预约列表</li>
                    </ol>
                </section>

                
                
                
                <!-- Main content -->
                <section class="content">
                  <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">时间<input id="idOrderDate" class="date_input" type="text"
										value="<?php echo  date('Y-m-d');?>" /></h3>
                                    <div class="box-tools">
                                        <div class="input-group">
                                            <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>订单号</th>
                                            <th>服务项目</th>
                                            <th>预约时间</th>
                                            <th>预约状态</th>
                                            <th>评论</th>
                                        </tr>
                                        
                                        <?php 
                                        $rlt = OrderHistory::model()->getOrdersByUserId(Yii::app()->user->id,
                                        		date('Y-m-d H:i:00', time()-(30*24*60*60)),
                                        		date('Y-m-d h:i:00', time()+(3*24*60*60)), false, false);

                                        if ($rlt['state']) {
                                        	$rlt = $rlt['data'];
                                        	foreach ($rlt as $orderItem){
                                        ?>
                                        
                                         
                                        <tr>
                                            <td><?php echo $orderItem['oh_no'];?></td>
                                            <td><?php 
                                           if ($orderItem['oh_type']==0) {
                                           	echo "自助服务";
                                           }else {
$type = ServiceType::model()->findByPk($orderItem['oh_type']);
echo $type['st_name'];
}
?></td>
                                            <td><?php echo substr($orderItem['oh_date_time'],0,16);?></td>
                                            <td>
                                            <?php if ($orderItem['oh_state'] == 0):?>
                                            <span class="label label-danger">已取消</span>
                                            <?php elseif($orderItem['oh_state'] == 1):?>
                                            <span class="label label-success">未确认评价</span>
                                            <?php else :?>
                                              <span class="label label-success">已确认</span>
                                            <?php endif;?>
                                            
                                            </td>
                                            <td>
                                            <?php if($orderItem['oh_state']==1 && $orderItem['oh_user_ack']==0):?>
                                            
                                             <span class="label label-primary">确认并评价</span>
                                             <?php elseif($orderItem['oh_state']>=1):?>
                                              <span id="str<?php echo $orderItem['id'];?>"></span>
 <script type="text/javascript">
 $("#str<?php echo $orderItem['id'];?>").raty({
	 readOnly: true,
	 half:true,
	  score: <?php echo $orderItem['oh_score'];?>
	 });
 </script>
 
 <?php endif;?>
                                            </td>
                                        </tr>
                                    
                                       <?php }}?> 
                                   
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                </section><!-- /.content -->
                
            <script type="text/javascript">
<!--
$(document).ready(function () {

    if ($('.date_input').length > 0) {
        jQuery('.date_input').datepicker({
            dateFormat: 'yy-mm-dd', // Date format http://jqueryui.com/datepicker/#date-formats
	// showButtonPanel: true,
 minDate: -30,
maxDate:60, 
defaultDate:0
        });
}
    });

//-->
</script>  
