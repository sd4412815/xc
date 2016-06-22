<?php /* @var $this Controller */ ?>
<?php //$this->beginContent('//layouts/admin_main'); ?>
  <div class="wrapper row-offcanvas row-offcanvas-left">

            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li >
                            <a href="<?php echo  Yii::app()->createUrl('boss/profile');?>">
                                <i class="fa fa-dashboard"></i> <span>账户概览</span>
                            </a>
                        </li>
                         <li><a href="<?php echo Yii::app()->createUrl('boss/realTimelist');?>"><i class="fa fa-angle-double-right"></i> 实时订单</a></li>
                                <li><a href="<?php echo Yii::app()->createUrl('boss/list');?>"><i class="fa fa-angle-double-right"></i> 全部订单  <small class="badge pull-right bg-success">确认送经验值</small></a></li>								
 <li><a href="<?php echo Yii::app()->createUrl('boss/inviteUser');?>"><i class="fa fa-angle-double-right"></i> <span><small class="badge pull-right bg-red">新</small></span>会员管理</a></li>                   
                           <li><a href="<?php echo Yii::app()->createUrl('boss/timeList');?>"><i class="fa fa-angle-double-right"></i> 时间段管理</a></li>
                        		<li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i> 
								<span>车行管理</span>
                                <i class="fa fa-angle-left pull-right"></i>                                
                            </a>
							<ul class="treeview-menu">
                                <li id="serviceSet"><a href="<?php echo Yii::app()->createUrl('boss/serviceSet');?>"><i class="fa fa-angle-double-right"></i> 服务基准设置</a></li>				
                                <li><a href="<?php echo Yii::app()->createUrl('boss/wsInfo',array('id'=>1));?>"><i class="fa fa-angle-double-right"></i> 车行信息维护</a></li>								
                            </ul>
                        </li>
                        
                        
                               
							 <li> <a href="<?php echo Yii::app()->createUrl('boss/news');?>">
                              <i class="fa fa-bar-chart-o"></i> <span>动态发布</span>
                            </a>      </li>
                            	<li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i> 
								<span>优惠卡/券管理</span>
                                <i class="fa fa-angle-left pull-right"></i>                                
                            </a>
							<ul class="treeview-menu">
                               <li><a href="<?php echo Yii::app()->createUrl('boss/card');?>"><i class="fa fa-angle-double-right"></i> 我的优惠券</a></li>
                                 <li><a href="<?php echo Yii::app()->createUrl('boss/cardRequest');?>"><i class="fa fa-angle-double-right"></i> 申请优惠劵</a></li>	
                                							
                            </ul>
                        </li>
                        	<li>
                            <a href="<?php echo Yii::app()->createUrl('boss/guarantee');?>">
                                <i class="fa fa-calendar"></i> <span> 我的保障金</span>
                            </a>
                        </li>
						
						<li>
                            <a href="<?php echo Yii::app()->createUrl('boss/comment');?>">
                                <i class="fa fa-calendar"></i> <span> 我的评论</span>
                            </a>
                        </li>
						  <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i> 
								<span>购买服务</span>
                                <i class="fa fa-angle-left pull-right"></i>                                
                            </a>
							<ul class="treeview-menu">
                                <li><a href="<?php echo Yii::app()->createUrl('boss/service');?>"><i class="fa fa-angle-double-right"></i> 购买服务</a></li>
                                <li><a href="<?php echo Yii::app()->createUrl('boss/serviceList');?>"><i class="fa fa-angle-double-right"></i>购买记录</a></li>								
                            </ul>
                        </li>
						
						<li>
                            <a >
                                <i class="fa fa-calendar"></i> <span> 财务管理 <small class="badge pull-right bg-yellow">建设中</small></span>
                            </a>
                        </li>
                        <li>
							<ul class="treeview-menu">
                                <li><a href="<?php echo Yii::app()->createUrl('boss/timeList');?>"><i class="fa fa-angle-double-right"></i> 时间段管理</a></li>
                                <li><a href="<?php 
//                            $shopId = Boss::model()->findByAttributes(array(
// 'b_user_id'=>Yii::app()->user->id,
// ))->washShop['id'];
$shopId = UTool::getShop()['id'];
                           echo Yii::app()->createUrl('boss/wsinfo',array('id'=>$shopId));?>"><i class="fa fa-angle-double-right"></i> 车行信息维护</a></li>								
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

<?php //$this->endContent(); ?>
