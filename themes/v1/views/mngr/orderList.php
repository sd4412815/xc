<?php
$this->pageTitle = Yii::app ()->name . ' - 预约列表';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        预约列表
                       
                    </h1>
                    <ol class="breadcrumb hidden-xs">
                        <li><a href="<?php echo Yii::app()->createUrl('mngr/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
                        <li class="active">预约列表</li>
                    </ol>
                </section>

                
                
                
                <!-- Main content -->
                <section class="content">
                  <div >
                            <div class="box">

                                <div class="box-body  no-padding">


                                  <div id="list" >
 <?php 
  $this->renderPartial('_orderList',array(
 'dataProvider'=>$dataProvider,
 ));
 ?>
 </div>             
                                        </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                </section><!-- /.content -->
                

<?php
Yii::app ()->clientScript->registerScript ( 'ready', "
$('#orderList').addClass('active');	
", CClientScript::POS_READY );
?>