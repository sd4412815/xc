  <section class="sidebar">		   
			<ul class="sidebar-menu">
				<li id="smhelp_reg" >
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'help_reg'));?>">
						<i class="fa fa-sign-in"></i> <span>如何注册</span>
					</a>
				</li>
				<li id="smorder">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'order'));?>">
						<i class="fa fa-book"></i> <span>预定车位流程</span> 
					</a>
				</li>
				
				<li id="smicon">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'icon'));?>">
						<i class="fa fa-tachometer"></i> <span>特色服务标识</span>
					</a>
				</li>
                <li id="smscore">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'score'));?>">
						<i class="fa fa-sort-numeric-asc"></i> <span>积分说明</span>
					</a>
				</li>
                <li id="smlevel">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'level'));?>">
						<i class="fa fa-bar-chart-o"></i> <span>用户等级说明</span>
					</a>
				</li>
                <li id="smcard">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'card'));?>">
						<i class="fa fa-credit-card"></i> <span>优惠券使用</span>
					</a>
				</li>		
				   <li id="smjoin_readme">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'join_readme'));?>">
						<i class="fa fa-calendar"></i> <span>加盟须知</span>
					</a>
				</li>
				   <li id="smfaq">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'faq'));?>">
						<i class="fa fa-question"></i> <span>常见问题</span>
					</a>
				</li>		
				   <li id="smsendmsg">
					<a href="<?php echo Yii::app()->createUrl('site/sendMessage');?>">
						<i class="fa fa-comment"></i> <span>在线留言</span>
					</a>
				</li>	
					   <li id="smaboutus">
					<a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'aboutus'));?>">
						<i class="fa fa-user"></i> <span>关于我们</span>
					</a>
				</li>			
			</ul>
		</section>