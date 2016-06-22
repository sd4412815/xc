       <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> 预约单号：<?php echo $model->oh_no;?>
                                <small class="pull-right">下单时间：<?php echo  $model->oh_order_date_time;?></small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                           预约 服务
                            <address>
                                <strong><?php 
                                if ($model->oh_type > 0) {
                                	echo ServiceType::model()->findByPk($model->oh_type)['st_name'];
                                }
                                else {
                                	echo '自助服务';
                                }
                                ?></strong><br>
                        
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            预约车行
                            <address>
                                <strong><?php  echo WashShop::model()->findByPk($model['oh_wash_shop_id'])['ws_name'];?></strong><br>
                              
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>订单状态</b><br/>
                            <br/>
                            <b>用户确认</b> <?php echo CHtml::checkBox('', $model->oh_user_ack,array('disabled'=>'disabled'));?><br/>
                            <b>员工确认</b>  <?php echo CHtml::checkBox('', $model->oh_staff_ack,array('disabled'=>'disabled'));?><br/>
                            <b>店主确认</b>  <?php echo CHtml::checkBox('', $model->oh_boss_ack,array('disabled'=>'disabled'));?>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

         
                    <!-- this row will not appear when printing -->
                    <div class="row no-print" >
                        <div class="col-xs-12">
                            <button style="display:none;" class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                            <button onclick="window.print();" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i>打印</button>
                      
                        </div>
                    </div>
                </section><!-- /.content -->