<section class="content-header">
	<h1>购买服务</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-6">
			<!-- DONUT CHART -->
			<div class="box box-primary">
				<div class="box-header">
					<!-- <i class="fa fa-bar-chart-o"></i> -->
					<h3 class="box-title">服务级别</h3>
				</div>
				<div class="box-body">
					<p>
                您是我们的<code><?php echo UWashShop::getLevel($shop['ws_level']);
?></code>客户！</p>

				</div>
				<!-- /.box-body-->
			</div>
			<!-- /.box -->
		</div>
		<div class="col-xs-6">
			<!-- DONUT CHART -->
			<div class="box box-primary">
				<div class="box-header">
					<!-- <i class="fa fa-bar-chart-o"></i> -->
					<h3 class="box-title">服务详情</h3>
				</div>
				<div class="box-body">
					<p>
						时间 <span class="text-green"><?php
if (empty($shop['ws_start_date'])) {
	echo date('Y-m-d',strtotime($shop['ws_join_date']));
}else{
	echo date('Y-m-d',strtotime($shop['ws_start_date']));
}
					 ?></span>
						到<code> <?php echo date('Y-m-d',strtotime($shop['ws_date_end'])); ?></code>，剩余
						<code> <?php
						$start = date_create ();
						$end = date_create ( $shop ['ws_date_end'] );
						$interval = date_diff ( $start, $end );
// 						echo var_dump($interval);
						echo $interval->format ( '%a' );
						?> </code>天
					</p>
				</div>
				<!-- /.box-body-->
			</div>
			<!-- /.box -->
		</div>

	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab">服务卡购买</a></li>
					<li><a href="#tab_2" data-toggle="tab">服务卡充值</a></li>

				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
	<table class="table table-bordered text-center">
										   <tr class="danger">
										      <th></th>
											  <th>钻石卡</th>
											  <th>金卡</th>
											  <th>银卡</th>
											  <th>体验卡</th>
										   </tr>
										   <tr>
										      <th>价格</th>
											  <td><?php
// 											   echo var_dump($joinStd);
											  echo $joinStd['diamond_'.$shopType.'_price'];
// 											   echo $joinStd['diamond'][$shopType]['price'];
											   ?>元</td>
											  <td><?php   echo $joinStd['golden_'.$shopType.'_price'];?>元</td>
											  <td><?php   echo $joinStd['silver_'.$shopType.'_price'];?>元</td>
											  <td>免费</td>
										   </tr>
										   <tr>
										      <th>服务时长</th>
											  <td><?php   echo $joinStd['diamond_'.$shopType.'_date_long'];?>个月</td>
											  <td><?php   echo $joinStd['golden_'.$shopType.'_date_long'];?>个月</td>
											  <td><?php   echo $joinStd['silver_'.$shopType.'_date_long'];?>个月</td>
											  <td><?php   echo $joinStd['free_date_long'];?>个月</td>
										   </tr>
										   <tr>
										      <th>赠送时长</th>
											  <td><?php   echo $joinStd['diamond_'.$shopType.'_date_long_free'];?>个月</td>
											  <td><?php   echo $joinStd['golden_'.$shopType.'_date_long_free'];?>个月</td>
											  <td><?php   echo $joinStd['silver_'.$shopType.'_date_long_free'];?>个月</td>
											  <td>无</td>
										   </tr>
										   <tr>
										      <th>更改洗车时间段价格</th>
											  <td>全部</td>
											  <td>20个/车位/天</td>
											  <td>10个/车位/天</td>
											  <td>2个/车位/天</td>
										   </tr>
										   <tr>
										      <th>更改打蜡时间段价格</th>
											  <td>全部</td>
											  <td>全部</td>
											  <td>全部</td>
											  <td>全部</td>
										   </tr>
										   <tr>
										      <th>更改精洗时间段价格</th>
											  <td>全部</td>
											  <td>全部</td>
											  <td>全部</td>
											  <td>全部</td>
										   </tr>
										   <tr>
										      <th>赠送制作门头费</th>
											  <td>2000元</td>
											  <td>900元</td>
											  <td>400元</td>
											  <td> 无 </td>
										   </tr>
										   <tr>
										      <th>搜索排序置前</th>
											  <td> √ </td>
											  <td> √ </td>
											  <td> √ </td>
											  <td> × </td>
										   </tr>
										   <tr>
										      <th>实时订单显示</th>
											  <td> √ </td>
											  <td> √ </td>
											  <td> √ </td>
											  <td> × </td>
										   </tr>
										   <tr>
										      <th>发布车行动态</th>
											  <td> √ </td>
											  <td> √ </td>
											  <td> √ </td>
											  <td> × </td>
										   </tr>
										   <tr>
										      <th>申请次卡</th>
											  <td> √ </td>
											  <td> √ </td>
											  <td> √ </td>
											  <td> × </td>
										   </tr>
										   <tr>
										      <th>赠送首次预定优惠卡</th>
											  <td>2000张</td>
											  <td>800张</td>
											  <td>300张</td>
											  <td>无</td>
										   </tr>
										   <tr>
										      <th>评论管理</th>
											  <td> √ </td>
											  <td> √ </td>
											  <td> √ </td>
											  <td> √ </td>
										   </tr>
										   <tr>
										       <td></td>
											   <td><button class="btn btn-warning" onclick="showBSModal(3)">立即购买</button></td>
											   <td><button class="btn btn-warning" onclick="showBSModal(2)">立即购买</button></td>
											   <td><button class="btn btn-warning" onclick="showBSModal(1)">立即购买</button></td>
											   <td></td>
										   </tr>
                                        </table>										
				
							

								<!-- Modal -->
								<div class="modal fade" id="bsModal" tabindex="-1" role="dialog"
									aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">
													<span aria-hidden="true">&times;</span><span
														class="sr-only">Close</span>
												</button>
												<h4 class="modal-title" id="myModalLabel">购买服务卡</h4>
											</div>
											<div class="modal-body">
											
											
												<div class="form-horizontal">
													感谢您选择我们的产品，请通过转账/汇款至沈阳喜车商务服务有限公司。为便于核实汇款信息，<code>请在备注栏填写购买人手机号</code> <br />汇款账户为：<?php echo Yii::app()->params['accountNum'];?> 
														<br />
								户名：<?php echo Yii::app()->params['accountName'];?>  <br />
								开户行：<?php echo Yii::app()->params['accountOwner'];?><br /> <br />
												
										
												</div>
<?php echo $this->renderPartial('_buyServiceForm',array('model'=>$model,'boss'=>$boss,'shop'=>$shop,'joinStd'=>$joinStd,'shopType'=>$shopType));?>												
											</div>
											
<?php

Yii::app ()->clientScript->registerScript ( 'btnBuyService', "
function showBSModal(type){
		$('#BuyServiceForm_level').val(type);
    $('#sLevel').val($('#BuyServiceForm_level').find('option:selected').text());
		$('#BuyServiceForm_value')[0].selectedIndex=type;
     $('#sValue1').val($('#BuyServiceForm_value').find('option:selected').text());
	$('#bsModal').modal();
}		
		", CClientScript::POS_END );

?>												
										</div>
									</div>
								</div>

					



					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab_2">
						<div class="row">
							<div class="col-md-12">
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">请输入充值密码</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder=" ">
										</div>
										<div class="col-sm-4">
											<button type="submit" class="btn btn-primary">充值</button>
										</div>
									</div>

								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4>充值记录</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover">
									<tr>
										<th>充值时间</th>
										<th>卡号</th>
										<th>服务卡类型</th>
										<th>服务时长</th>
									</tr>
								
								</table>
							</div>
						</div>

					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->

		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>
<!-- /.content -->

<?php

Yii::app ()->clientScript->registerScript ( 'iniready', "
		", CClientScript::POS_READY );

?>