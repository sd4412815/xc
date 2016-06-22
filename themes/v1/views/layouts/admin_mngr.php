<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/admin_main'); ?>

  <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
           
             
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo  Yii::app()->createUrl('mngr/profile');?>">
                                <i class="fa fa-dashboard"></i> <span>系统概览</span>
                            </a>
                        </li>
                           <li >
                            <a href="<?php echo  Yii::app()->createUrl('srbac');?>" target="_black">
                                <i class="fa fa-dashboard"></i> <span>系统权限管理</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i> 
								<span>优惠券管理</span>
                                <i class="fa fa-angle-left pull-right"></i>                                
                            </a>
							<ul class="treeview-menu">
                                <li><a href="<?php echo Yii::app()->createUrl('mngr/card');?>"><i class="fa fa-angle-double-right"></i> 优惠券申请处理</a></li>
                                 <li><a href="<?php echo Yii::app()->createUrl('mngr/guarantee');?>"><i class="fa fa-angle-double-right"></i> 保证金申请处理</a></li>	
                              							
                            </ul>
                        </li>   
                        
                        <li class="treeview">
                              <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>服务管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                              <ul class="treeview-menu">
                              	    <li >
                            <a href="<?php echo  Yii::app()->createUrl('mngr/sit');?>">
                                <i class="fa fa-dashboard"></i> <span>服务小项模版管理</span>
                            </a>
                        </li>
                          <li >
                            <a href="<?php echo  Yii::app()->createUrl('mngr/si');?>">
                                <i class="fa fa-dashboard"></i> <span>服务小项管理</span>
                            </a>
                        </li>
                           <li >
                            <a href="<?php echo  Yii::app()->createUrl('mngr/st');?>">
                                <i class="fa fa-dashboard"></i> <span>服务类型管理</span>
                            </a>
                        </li>
                          <li >
                            <a href="<?php echo  Yii::app()->createUrl('mngr/sti');?>">
                                <i class="fa fa-dashboard"></i> <span>服务类型包含小项管理</span>
                            </a>
                        </li>
                              </ul>
                        
                        </li>
                        
                    
                              <li class="treeview" id="menuShop" >
                            <a href="#" >
                                <i class="fa fa-bar-chart-o"></i>
                                <span>车行管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul  class="treeview-menu">
                               <li id="menuShopList">
                            <a href="<?php echo Yii::app()->createUrl('mngr/shopList');?>">
                                <i class="fa fa-angle-double-right"></i> <span>车行列表</span> 
                            </a>
                        </li>
                         
                             <li>
                            <a href="<?php echo Yii::app()->createUrl('mngr/shopServiceList');?>">
                                <i class="fa fa-angle-double-right"></i> <span>购买服务列表</span> 
                            </a>
                        </li>
                        
                              <li>
                            <a href="<?php echo Yii::app()->createUrl('mngr/shopReport');?>">
                                <i class="fa fa-angle-double-right"></i> <span>车行运营报表</span> 
                            </a>
                        </li>
                                    </ul>
                        </li>
                            <li>
                            <a href="<?php echo Yii::app()->createUrl('city/joinStd');?>">
                                <i class="fa fa-th"></i> <span>加盟费设置</span> <small class="badge pull-right bg-green">ok</small>
                            </a>
                        </li>
                        <li id="orderList">
                            <a href="<?php echo Yii::app()->createUrl('mngr/orderList');?>">
                                <i class="fa fa-th"></i> <span>全部订单</span> <small class="badge pull-right bg-red">new</small>
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