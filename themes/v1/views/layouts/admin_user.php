<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/admin_main'); ?>

  <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

             
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li id="menuProfile">
                            <a href="<?php echo  Yii::app()->createUrl('user/profile');?>">
                                <i class="fa fa-dashboard"></i> <span>账户概览</span>
                            </a>
                        </li>
                        <li id="menuList">
                            <a href="<?php echo Yii::app()->createUrl('user/list');?>">
                                <i class="fa fa-th"></i> <span>全部订单</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                         <li>
                            <a href="<?php echo Yii::app()->createUrl('user/card');?>">
                                <i class="fa fa-home"></i> <span>我的优惠劵</span> 
                            </a>
                        </li>
                            <li id="menuScore">
                            <a href="<?php echo Yii::app()->createUrl('user/score');?>">
                                <i class="fa fa-home"></i> <span>我的积分</span> 
                            </a>
                        </li>
                           <li id="menuFavorite">
                            <a href="<?php echo Yii::app()->createUrl('user/favorite');?>">
                                <i class="fa fa-home"></i> <span>我的收藏</span> 
                            </a>
                        </li>
                     	
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>我的账户资料</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                           <ul class="treeview-menu">
							      <li id="menuUserInfo">
                            <a href="<?php echo Yii::app()->createUrl('user/info');?>">
                                <i class="fa fa-home"></i> <span>基本信息</span> 
                            </a>
                        </li>
							    <li id="menuUserSafe"><a href="<?php echo Yii::app()->createUrl('user/safe');?>"><i class="fa fa-angle-double-right"></i> <span> 账户安全</span></a></li>                             
                              							
                            </ul>
                        </li>
                        
                      
                           
                          <li>
                            <a href="<?php echo Yii::app()->createUrl('site/index');?>">
                                <i class="fa fa-home"></i> <span>网站首页</span> 
                            </a>
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