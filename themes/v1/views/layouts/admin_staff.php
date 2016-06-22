<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/admin_main'); ?>

  <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/admin/img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo Yii::app()->user->name;?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> 
                            有效积分：<?php 
                                  
//                                        $userModel =  User::model()->findByPk(Yii::app()->user->id);
                                       $userModel=   Staff::model()->findByAttributes(array(
                                       		's_user_id'=>Yii::app()->user->id,
                                       ));
                                       if (isset($userModel)) {
                                       echo 	$userModel->s_score;
                                       }
                                        
                                        ?>
                            </a>
                        </div>
                    </div>
             
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo  Yii::app()->createUrl('staff/profile');?>">
                                <i class="fa fa-dashboard"></i> <span>账户概览</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('staff/list');?>">
                                <i class="fa fa-th"></i> <span>全部订单</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                                 <li>
                            <a href="<?php echo Yii::app()->createUrl('staff/score');?>">
                                <i class="fa fa-home"></i> <span>积分记录</span> 
                            </a>
                        </li>
                          <li>
                            <a href="<?php echo Yii::app()->createUrl('staff/eventList');?>">
                                <i class="fa fa-home"></i> <span>病事假管理</span> 
                            </a>
                        </li>
                          <li>
                            <a href="<?php echo Yii::app()->createUrl('site/index');?>">
                                <i class="fa fa-home"></i> <span>网站首页</span> 
                            </a>
                        </li>
                           <li>
                           <li><a  href="<?php echo Yii::app()->createUrl('site/logout')?>"><i class="fa fa-unlock"></i>注销(<?php echo Yii::app()->user->name;?>)</a></li>
                        </li>
                  
                
                
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                 <?php echo $content; ?>
                        </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

<?php $this->endContent(); ?>