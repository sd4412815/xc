
<div class="row">
	<div class="col-sm-offset-1 col-sm-2 skin-blue">

		<section class="sidebar">
			<ul class="sidebar-menu">
				<li class="active"><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'process'));?>"> <i
						class="fa fa-dashboard"></i> <span>洗车流程</span>
				</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('site/sendMessage');?>"> <i class="fa fa-th"></i> <span>在线留言</span>
				</a></li>

				<li><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'aboutus'));?>"> <i class="fa fa-calendar"></i> <span>联系我们</span>
				</a></li>
			</ul>
		</section>
	</div>
	<div class=" col-sm-8">
		<div class="box box-warning">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10">

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li class="active"><a href="#home" role="tab" data-toggle="tab">洗车</a></li>
							<li><a href="#profile" role="tab" data-toggle="tab">打蜡</a></li>
							<li><a href="#messages" role="tab" data-toggle="tab">精洗</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="home">
								<!-- row -->
								<div class="row">
									<div class="col-md-12">
										<!-- The time line -->
										<ul class="timeline">
											<!-- timeline time label -->
											<li class="time-label"><span class="bg-red"> 洗车流程 </span></li>
											<!-- /.timeline-label -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
													<h3 class="timeline-header">
														<a href="#">引车 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/yinche32.png"
															title="引车" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
													<h3 class="timeline-header">
														<a href="#">喷软化剂 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/ruanhua32.png"
															title="喷软化剂" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
													<h3 class="timeline-header">
														<a href="#">第一次冲水 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/chongshui32.png"
															title="第一次冲水" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
													<h3 class="timeline-header">
														<a href="#">打泡沫、洗轮毂 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/paomo32.png"
															title="打泡沫" /> <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/lung32.png" title="洗轮毂" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
													<h3 class="timeline-header">
														<a href="#">第二次冲水 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/chongshui32.png"
															title="第二次冲水" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第六步</span>
													<h3 class="timeline-header">
														<a href="#">擦干、内饰精洗 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/cagan32.png"
															title="擦干" /> <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/neishi32.png"
															title="内饰精洗" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第七步</span>
													<h3 class="timeline-header">
														<a href="#">吸尘、轮胎蜡 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/xichen32.png"
															title="吸尘" /> <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/luntaila32.png"
															title="轮胎蜡" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第八步</span>
													<h3 class="timeline-header">
														<a href="#">验收 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/yanshou32.png"
															title="验收" />
														</a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<li><i class="fa fa-clock-o"></i></li>
										</ul>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->


							</div>
							<!-- tab1 -->

							<div class="tab-pane" id="profile">
								<!-- row -->
								<div class="row">
									<div class="col-md-12">
										<!-- The time line -->
										<ul class="timeline">
											<!-- timeline time label -->
											<li class="time-label"><span class="bg-red"> 打蜡流程 </span></li>
											<!-- /.timeline-label -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
													<h3 class="timeline-header">
														<a href="#">去除柏油虫胶 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/baiyou32.png"
															title="去除柏油虫胶" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
													<h3 class="timeline-header">
														<a href="#">打蜡 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/shang32.png"
															title="打蜡" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
													<h3 class="timeline-header">
														<a href="#">褪蜡 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/maojin32.png"
															title="褪蜡" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
													<h3 class="timeline-header">
														<a href="#">清理边沿 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/bianyan32.png"
															title="清理边沿" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
													<h3 class="timeline-header">
														<a href="#">验收 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/yanshou32.png"
															title="验收" /></a>
													</h3>

												</div></li>


											<!-- END timeline item -->
											<li><i class="fa fa-clock-o"></i></li>
										</ul>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- tab2 -->

							<div class="tab-pane" id="messages">
								<!-- row -->
								<div class="row">
									<div class="col-md-12">
										<!-- The time line -->
										<ul class="timeline">
											<!-- timeline time label -->
											<li class="time-label"><span class="bg-red"> 精洗流程 </span></li>
											<!-- /.timeline-label -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
													<h3 class="timeline-header">
														<a href="#">发动机普通清洗 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/fadongji32.png"
															title="发动机普通清洗" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
													<h3 class="timeline-header">
														<a href="#">除泥去垢 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/chuni32.png"
															title="除泥去垢" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
													<h3 class="timeline-header">
														<a href="#">除尘吸尘 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/xichen32.png"
															title="吸尘" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
													<h3 class="timeline-header">
														<a href="#">清洗顶棚 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/dingpeng32.png"
															title="清洗顶棚" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
													<h3 class="timeline-header">
														<a href="#">清洗车门 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/shang32.png"
															title="清洗车门" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第六步</span>
													<h3 class="timeline-header">
														<a href="#">清洗座椅 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/zuoyi32.png"
															title="清洗座椅" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第七步</span>
													<h3 class="timeline-header">
														<a href="#">清洗地毯 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/ditan32.png"
															title="清洗地毯" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第八步</span>
													<h3 class="timeline-header">
														<a href="#">消毒除味 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/xiaodu32.png"
															title="消毒除味" /></a>
													</h3>

												</div></li>

											<!-- END timeline item -->
											<!-- timeline item -->
											<li><i class="fa bg-blue">1'</i>
												<div class="timeline-item">
													<span class="time"><i class="fa fa-clock-o"></i>第九步</span>
													<h3 class="timeline-header">
														<a href="#">验收 <img
															src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/yanshou32.png"
															title="验收" /></a>
													</h3>

												</div></li>
											<!-- END timeline item -->
											<li><i class="fa fa-clock-o"></i></li>
										</ul>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- tab3 -->
						</div>
					</div>
					<!-- col-sm-10 -->
				</div>
				<!-- row -->
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->



	</div>
</div>