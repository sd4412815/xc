<?php




// $user_model = User::model ()->getUserByLoginName ('1=1' );
// // $loginName = 'rff';
// // $criteria = new CDbCriteria();
// // $criteria->addCondition('u_tel=:tel');
// // // $criteria->addCondition('u_name=:name','OR');
// // $criteria->addCondition('u_member_id=:uid','OR');
// // // 		$criteria->addCondition('u_state=0','AND');
// // $criteria->params[':tel']=$loginName;
// // // $criteria->params[':name']=$loginName;
// // $criteria->params[':uid']=$loginName;

// // $user = User::model()->find($criteria);
// echo CJSON::encode($user_model);
// UTool::setCsrfValidator();
// echo UTool::checkCsrf();
/* @var $this SiteController */
// $model = new Cardinvite();
// $model['ci_shop_id']=1;
// // $model['ci_sn'] = '1233';
// $model['ci_pwd']=UTool::randomkeys(16);
// $model['ci_state']=0;
// $model['ci_batch_no'] =1;
// $model['ci_owner']=-1;
// $model['ci_value']=30;
// if($model->save()){
// // 	$currentCount++;
// 	//Yii::log(CJSON::encode($genModel),'info','mngr.cardinvite.send');
// }else {
// 	//Yii::log(CJSON::encode($model),'info','mngr.cardinvite.send');
// }

// echo CJSON::encode($model);


// OrderHistory::model()->deleteAll();
// WashShop::model()->deleteOrderTempTable(1, 0);
// WashShop::model()->deleteOrderTempTable(1, 1);
// WashShop::model()->deleteOrderTempTable(1, 2);
// WashShop::model()->generateOrderTempTable(1, 0);
// WashShop::model()->generateOrderTempTable(1, 1);
// WashShop::model()->generateOrderTempTable(1, 2);

// WashShop::model()->generateOrderTempTable(2, 0);
// WashShop::model()->generateOrderTempTable(2, 1);
// WashShop::model()->generateOrderTempTable(2, 2);

// WashShop::model()->generateOrderTempTable(3, 0);
// WashShop::model()->generateOrderTempTable(3, 1);
// WashShop::model()->generateOrderTempTable(3, 2);

// WashShop::model()->generateOrderTempTable(4, 0);
// WashShop::model()->generateOrderTempTable(4, 1);
// WashShop::model()->generateOrderTempTable(4, 2);

// WashShop::model()->generateOrderTempTable(6, 0);
// WashShop::model()->generateOrderTempTable(6, 1);
// WashShop::model()->generateOrderTempTable(6, 2);

// $orderItem = OrderHistory::model()->findByPk(31);
// $start =  strtotime($orderItem['oh_order_date_time']);

// $end = strtotime($orderItem['oh_date_time']);

// // $bias = ceil( ($end-$start)/(24*60*60))

// $start = date_create ( date('Y-m-d',$start));
// $end = date_create ( date('Y-m-d',$end));
	
// $interval = date_diff ( $start, $end );
// $bias =  $interval->format ( '%d' );
// echo $bias;
// echo var_dump($interval);

// $criteria =new CDbCriteria();
// $criteria->addCondition('ws_state>=1');
// $shops = WashShop::model()->findAll($criteria);

// foreach ($shops as $shop){
// 	echo $shop['id'];
// 	OrderHistory::model()->deleteAll();
// 	WashShop::model()->deleteOrderTempTable($shop['id'], 0);
// 	WashShop::model()->deleteOrderTempTable($shop['id'], 1);
// 	WashShop::model()->deleteOrderTempTable($shop['id'], 2);
// 	echo $shop->generateOrderTempTable($shop['id'], 0)['state'];
// 	$shop->generateOrderTempTable($shop['id'], 1);
// 	$shop->generateOrderTempTable($shop['id'], 2);
	
// }
	WashShop::model()->deleteOrderTempTable(23, 0);
	WashShop::model()->deleteOrderTempTable(23, 1);
	WashShop::model()->deleteOrderTempTable(23, 2);
	 WashShop::model()->generateOrderTempTable(23, 0);
	WashShop::model()->generateOrderTempTable(23, 1);
	WashShop::model()->generateOrderTempTable(23, 2);


// $tt = WashShop::model()->getBasicInfobyType ( WashShop::model()->findByPk(20), 1, 0, false );
// echo var_dump($tt);
// 上传数据

// $url = 'http://api.map.baidu.com/geodata/v3/poi/create'; // POST请求

// // $url = 'http://api.map.baidu.com/geosearch/v3/local';
// $curlPostFields = array('ak'=> 'atV54I5hflatOH00IebtxSwR',
// 			'geotable_id'=> '66526',
// 			'latitude'=>'5',
// 			'longitude'=>'7.777',
// 		'coord_type'=>3,
// 		'washshop_id'=>5,
// 		'title'=>'dd',
// 		'address'=>'www',
// 		'tags'=>'sd,ewe',
		
// );
// $url = Yii::app()->createAbsoluteUrl('MUser/login');
// $params = array(
// 	'userName'=>'13898800771',
// 	'pwd'=>'111',
// );
// echo $url.'&'.http_build_query($params);
// $url = $url.'&'.http_build_query($params);
// $rlt =  file_get_contents($url);
// echo '<br>';
// echo $rlt;
// echo '<br>';

// // echo Yii::app()->session['csrfId'];
// $oi = CJSON::decode($rlt)['data']['oi'];
// echo 'oi:'.$oi;
// // $csrfId =  Yii::app()->session['csrfId'];
// echo '<br>';
// // echo Yii::app()->session['csrfId'];
// echo '<br>';


// $url = Yii::app()->createAbsoluteUrl('MUser/update');
// $params = array(
// 		'oi'=>$oi,
// 		'PHPSESSID'=>CJSON::decode($rlt)['data']['PHPSESSID'],
// );

// echo  UTool::curlPost($url, $params);



// echo UTool::curlPost($url, $curlPostFields);

// // 修改指定列数据
// $url = 'http://api.map.baidu.com/geodata/v3/column/update'; // POST请求

// // // $url = 'http://api.map.baidu.com/geosearch/v3/local';
// $curlPostFields = array('ak'=> 'atV54I5hflatOH00IebtxSwR',
// 			'geotable_id'=> '66526',
// 			'is_index_field'=>1,
// 		'id'=>65237,
// );


// echo UTool::curlPost($url, $curlPostFields);

// $url = 'http://api.map.baidu.com/geodata/v3/column/list';
// $params = array('ak'=> 'atV54I5hflatOH00IebtxSwR',
// 			'geotable_id'=> '66526',
// // 		'washshop_id'=>'5,5',
// );
// $params = http_build_query($params);
// echo $url.'&'.$params;
// echo file_get_contents($url.'&'.$params);

// $url='http://api.map.baidu.com/geodata/v3/poi/list';
// $params = array('ak'=> 'atV54I5hflatOH00IebtxSwR',
// 			'geotable_id'=> 66526,
// // 			'washshop_id'=>'5,5',
// );
// $params = http_build_query($params);
// $params = UMap::getMapUrl(UMapURLType::lbs_poi_list);
// $rlt= file_get_contents($params.'&washshop_id=5,5');

// // $rlt = CJSON::decode($rlt);
// echo $rlt;

// UTool::setCsrfValidator();
// UTool::clearCsrf();
// echo UTool::checkCsrf();

// echo CJSON::encode( CardGenHistory::model()->getGuarantee(1));
// echo CJSON::encode( Cardinvite::model()->getGValueRemain(1));

// $criteria = new CDbCriteria();
// $criteria->select = 'sum(gp_value) as gValueRequest';
// $criteria->addCondition('gp_shop_id=:shopId');
// $criteria->params[':shopId']=1;
// // $criteria->addCondition('gp_state>=0');
// $requestGValue = GuaranteePay::model()->find($criteria);
// $requestGValue =  $requestGValue-> gValueRequest;

// if (!is_numeric($requestGValue)) {
// 	$requestGValue = 0;
// }
// echo $requestGValue;
// WashShop::model()->generateShopService(1);
// WashShop::model()->generateShopService(2);
// WashShop::model()->generateShopService(3);
// WashShop::model()->generateShopService(4);
// WashShop::model()->generateShopService(6);

$this->pageTitle=Yii::app()->name . ' - 关于我们';
?>
   <div class="row">
      
	   <div class="col-md-12">
	       <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title" style="color:#ff9900;font-weight:bold;text-align:center;">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						   公司简介 
						   
						   <?php
						 
// 						  echo $this->getModule()->id; // module  
// echo $this->getId();  // controller  
// echo  $this->getAction()->id;  // action 
						  // $r = array();
						 //  echo var_dump($r);
						   
						 //  echo $r[0];
						   
// 						   array_push($r, 1);
// 						   echo var_dump($r);
						   
// 						  $rlt = WashShop::model()->getBasicInfobyType(WashShop::model()->findByPk(1),3,0,false);
// 						  echo CJSON::encode($rlt);
						   
						   ?>
						</a>
					  </h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel">
					  <div class="panel-body" style="color:#333333;font-weight:bold;">
						 <p style="text-indent:2em;">
						 
						 沈阳喜车公司是中国首家汽车美容店连锁服务平台，主要从事汽车美容店一体化解决方案。
						 公司成立于2014年5月，由xxx先生发起设立。 “我洗车”以其集成化的产品体系、
						 模块化的组合策略、覆盖式的经营思路，几乎涵括了汽车美容领域所有的板块。</p>
						 <p style="text-indent:2em;">以至高品质赢得市场，一至诚服务回报客户。依靠科技进步，强化质量管理，满足客户要求，
						 创造品牌效应。洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务，
						 我们将全方位提供优质服务。创新需要敏感洞察市场机会，实事求是，敢于突破，追求卓越。
						 我们把壮心作为保障自身永葆青春的力量源泉。</p>
						 <p style="text-indent:2em;">以至高品质赢得市场，一至诚服务回报客户。依靠科技进步，强化质量管理，满足客户要求，
						 创造品牌效应。洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务，
						 我们将全方位提供优质服务。创新需要敏感洞察市场机会，实事求是，敢于突破，追求卓越。
						 我们把壮心作为保障自身永葆青春的力量源泉。</p>
						 <p style="text-indent:2em;">以至高品质赢得市场，一至诚服务回报客户。依靠科技进步，强化质量管理，满足客户要求，
						 创造品牌效应。洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务，
						 我们将全方位提供优质服务。创新需要敏感洞察市场机会，实事求是，敢于突破，追求卓越。
						 我们把壮心作为保障自身永葆青春的力量源泉。</p>
						 <p style="text-indent:2em;">以至高品质赢得市场，一至诚服务回报客户。依靠科技进步，强化质量管理，满足客户要求，
						 创造品牌效应。洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务，
						 我们将全方位提供优质服务。创新需要敏感洞察市场机会，实事求是，敢于突破，追求卓越。
						 我们把壮心作为保障自身永葆青春的力量源泉。</p>
					  </div>
					</div>
				</div>
				
				
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title"  style="color:#ff9900;font-weight:bold;text-align:center;">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						   洗车流程
						</a>
					  </h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel">
						  <div class="panel-body">
							 
							 <div class="col-md-12">
							     <!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
									  <li class="active"><a href="#home" role="tab" data-toggle="tab">洗车</a></li>
									  <li><a href="#profile" role="tab" data-toggle="tab">打蜡</a></li>
									  <li><a href="#messages" role="tab" data-toggle="tab">精洗</a></li>
									  <li><a href="#settings" role="tab" data-toggle="tab">自助</a></li>
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
											<li class="time-label">
												<span class="bg-red">
													洗车流程
												</span>
											</li>
										   <!-- /.timeline-label -->
										   <!-- timeline item -->
											<li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
												<h3 class="timeline-header"><a href="#">引车
												<img src="img/ico/yinche32.png" title="引车" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li>
											 <i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
												<h3 class="timeline-header"><a href="#">喷软化剂 <img src="img/ico/ruanhua32.png" title="喷软化剂" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
												<h3 class="timeline-header"><a href="#">第一次冲水 <img src="img/ico/chongshui32.png" title="第一次冲水" /></a></h3>
													
												</div>
											</li>
                                            
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
												<h3 class="timeline-header"><a href="#">打泡沫、洗轮毂 <img src="img/ico/paomo32.png" title="打泡沫" />
												<img src="img/ico/lung32.png" title="洗轮毂" /></a></h3>
													
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
												<h3 class="timeline-header"><a href="#">第二次冲水 <img src="img/ico/chongshui32.png" title="第二次冲水" /></a></h3>
													
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第六步</span>
												<h3 class="timeline-header"><a href="#">擦干、内饰精洗 <img src="img/ico/cagan32.png" title="擦干" />
												<img src="img/ico/neishi32.png" title="内饰精洗" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第七步</span>
												<h3 class="timeline-header"><a href="#">吸尘、轮胎蜡 <img src="img/ico/xichen32.png" title="吸尘" />
												<img src="img/ico/luntaila32.png" title="轮胎蜡" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第八步</span>
												<h3 class="timeline-header"><a href="#">验收 <img src="img/ico/yanshou32.png" title="验收" />
												</a></h3>
													
												</div>
											</li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                </li>
                              </ul>
                           </div><!-- /.col -->
                      </div><!-- /.row -->


					  </div><!-- tab1 -->
					  
					  <div class="tab-pane" id="profile">
					    <!-- row -->
									<div class="row">
										 <div class="col-md-12">
										  <!-- The time line -->
										 <ul class="timeline">
											<!-- timeline time label -->
											<li class="time-label">
												<span class="bg-red">
													打蜡流程
												</span>
											</li>
										   <!-- /.timeline-label -->
										   <!-- timeline item -->
											<li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
												<h3 class="timeline-header"><a href="#">去除柏油虫胶 <img src="img/ico/baiyou32.png" title="去除柏油虫胶" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li>
											 <i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
												<h3 class="timeline-header"><a href="#">打蜡 <img src="img/ico/shang32.png" title="打蜡" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
												<h3 class="timeline-header"><a href="#">褪蜡 <img src="img/ico/maojin32.png" title="褪蜡" /></a></h3>
													
												</div>
											</li>
                                            
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
												<h3 class="timeline-header"><a href="#">清理边沿 <img src="img/ico/bianyan32.png" title="清理边沿" /></a></h3>
													
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
												<h3 class="timeline-header"><a href="#">验收 <img src="img/ico/yanshou32.png" title="验收" /></a></h3>
													
												</div>
											</li>
											
											
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                </li>
                              </ul>
                           </div><!-- /.col -->
                      </div><!-- /.row -->
					  </div><!-- tab2 -->
					  
					  <div class="tab-pane" id="messages">
					     <!-- row -->
									<div class="row">
										 <div class="col-md-12">
										  <!-- The time line -->
										 <ul class="timeline">
											<!-- timeline time label -->
											<li class="time-label">
												<span class="bg-red">
													精洗流程
												</span>
											</li>
										   <!-- /.timeline-label -->
										   <!-- timeline item -->
											<li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
												<h3 class="timeline-header"><a href="#">发动机普通清洗 <img src="img/ico/fadongji32.png" title="发动机普通清洗" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li>
											 <i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
												<h3 class="timeline-header"><a href="#">除泥去垢 <img src="img/ico/chuni32.png" title="除泥去垢" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
												<h3 class="timeline-header"><a href="#">除尘吸尘 <img src="img/ico/xichen32.png" title="吸尘" /></a></h3>
													
												</div>
											</li>
                                            
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
												<h3 class="timeline-header"><a href="#">清洗顶棚 <img src="img/ico/dingpeng32.png" title="清洗顶棚" /></a></h3>
													
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
												<h3 class="timeline-header"><a href="#">清洗车门 <img src="img/ico/shang32.png" title="清洗车门" /></a></h3>
													
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第六步</span>
												<h3 class="timeline-header"><a href="#">清洗座椅 <img src="img/ico/zuoyi32.png" title="清洗座椅" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第七步</span>
												<h3 class="timeline-header"><a href="#">清洗地毯 <img src="img/ico/ditan32.png" title="清洗地毯" /></a></h3>
													
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第八步</span>
												<h3 class="timeline-header"><a href="#">消毒除味 <img src="img/ico/xiaodu32.png" title="消毒除味" /></a></h3>
													
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第九步</span>
												<h3 class="timeline-header"><a href="#">验收 <img src="img/ico/yanshou32.png" title="验收" /></a></h3>
													
												</div>
											</li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                </li>
                              </ul>
                           </div><!-- /.col -->
                      </div><!-- /.row -->
					  </div><!-- tab3 -->
					  
					  <div class="tab-pane" id="settings">444444444444444444
					    <!-- row -->
									<div class="row">
										 <div class="col-md-12">
										  <!-- The time line -->
										 <ul class="timeline">
											<!-- timeline time label -->
											<li class="time-label">
												<span class="bg-red">
													洗车流程
												</span>
											</li>
										   <!-- /.timeline-label -->
										   <!-- timeline item -->
											<li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第一步</span>
												<h3 class="timeline-header"><a href="#">引车</a></h3>
													<div class="timeline-body">
														引车说明
													</div>
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
											<li>
											 <i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第二步</span>
												<h3 class="timeline-header"><a href="#">喷软化剂</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第三步</span>
												<h3 class="timeline-header"><a href="#">第一次冲水</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
                                            
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第四步</span>
												<h3 class="timeline-header"><a href="#">打泡沫、洗轮毂</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第五步</span>
												<h3 class="timeline-header"><a href="#">第二次冲水</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
											
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第六步</span>
												<h3 class="timeline-header"><a href="#">擦干、内饰精洗</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa bg-blue">1'</i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第七步</span>
												<h3 class="timeline-header"><a href="#">吸尘、轮胎蜡</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
											<!-- END timeline item -->
											<!-- timeline item -->
										    <li>
											<i class="fa fa-envelope bg-blue"></i>
												<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i>第八步</span>
												<h3 class="timeline-header"><a href="#">验收、出车</a></h3>
													<div class="timeline-body">
														说明
													</div>
												</div>
											</li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                </li>
                              </ul>
                           </div><!-- /.col -->
                      </div><!-- /.row -->
					  </div><!-- tab4 -->
					</div>

								 
								 
							 </div>

						  </div>
					</div>
				</div>
				
				
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title"  style="color:#ff9900;font-weight:bold;text-align:center;">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						   用户帮助
						</a>
					  </h4>
					</div>
					
					<div id="collapseFour" class="panel-collapse collapse" role="tabpanel">
					  <div class="panel-body">
						 <div class="row">
						    <div class="col-md-4">
							   <div class="row">
							      <div class="col-md-12">
								     <h4 style="color:#ff9900;font-weight:bold;">您的问题</h4>
								  </div>
							   </div> 
								
							   <div class="row">
							     <div class="col-md-1">
								 </div>
								 
								 <div class="col-md-11">
							     <form class="form-horizontal" role="form">
								   <div class="form-group form-group-sm">
									<label  class="col-sm-5 control-label" style="color:#333333;font-weight:bold;">问题分类</label>
									<div class="col-sm-7">
									  <select class="form-control input-sm">
									   <option>请选择</option>
									   <option>网站</option>
									   <option>手机客户端</option>
									  </select>
									</div>
								   </div>
                                   
								   <div class="form-group form-group-sm">
									<label class="col-sm-5 control-label" for="formGroupInputSmall">您的邮箱</label>
									<div class="col-sm-7">
									  <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder="">
									</div>
								   </div>
								   
								   <div class="form-group form-group-sm">
									<label class="col-sm-5 control-label" for="formGroupInputSmall">问题描述</label>
									<div class="col-sm-7">
									  <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder="">
									</div>
								   </div>
								   						   	  
					               <button type="button" class="btn btn-warning btn-sm">提交</button>
								  
								</form>
                                </div><!-- col-md-11 -->
							   </div><!-- row -->
							</div><!-- col-md-4 -->
							
							<div class="col-md-8">
						      <!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
								  <li class="active"><a href="#zy1" role="tab" data-toggle="tab" style="color:#ff9900;font-weight:bold;">车主使用帮助</a></li>
								  <li><a href="#zy2" role="tab" data-toggle="tab"  style="color:#ff9900;font-weight:bold;">员工使用帮助</a></li>
								  <li><a href="#zy3" role="tab" data-toggle="tab"  style="color:#ff9900;font-weight:bold;">店长使用帮助</a></li>
								  <!-- <li><a href="#zy4" role="tab" data-toggle="tab">Settings</a></li> -->
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
								  <div class="tab-pane active" id="zy1">1
								     <img src="img/chezhu.png" />
								  </div>
								  <div class="tab-pane" id="zy2">2
								     <img src="img/yuangong.png" />
								  </div>
								  <div class="tab-pane" id="zy3">3
								     <img src="img/dianzhang.png" /> 
								  </div>
								  <!-- <div class="tab-pane" id="zy4">...</div> -->
								</div>
							</div><!-- col-8 -->
							
						 </div><!-- row -->
					  </div><!-- panel-body -->
					</div><!-- collapseFour -->
				</div><!-- panel -->
				
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title"  style="color:#ff9900;font-weight:bold;text-align:center;">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						   在线留言
						</a>
					  </h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel">
					  <div class="panel-body">
						 <div class="col-md-2">
						 </div>
						 <div class="col-md-8">
						     <div class="row">
							     
							     <div class="col-md-4">
								    <input class="form-control input-sm" type="text" placeholder="关键字/用户名">
						         </div>
								 <div class="col-md-2">
								    <button type="button" class="btn btn-warning btn-sm">搜索</button>
						         </div>
								 
							 </div>
							 
							 <!-- 以下为留言展示 -->
							 <div class="row" style="height:20px;">
							 </div>
							 <div class="row">
							    <h5 style="color:#ff9900;font-weight:bold;font-size:16px;">留言板</h5>
							 </div>
							 <div class="row">
							     <table class="table table-hover">
						   
									<tr>
									   <td class="col-md-2">xyz000</td>
									   <td class="col-md-2">2014.09.29</td>
									   <td class="col-md-6">洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务</td>
									   <td class="col-md-2"><button type="button" class="btn btn-warning btn-xs">回复</button></td>
									</tr>
									<tr>
									   <td class="col-md-2">xyz000</td>
									   <td class="col-md-2">2014.09.29</td>
									   <td class="col-md-6">洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务</td>
									   <td class="col-md-2"><button type="button" class="btn btn-warning btn-xs">回复</button></td>
									</tr>
									<tr>
									   <td class="col-md-2">xyz000</td>
									   <td class="col-md-2">2014.09.29</td>
									   <td class="col-md-6">洗车效果好，并以优惠的价格，优质的服务。热枕欢迎广大客户前来洽谈业务</td>
									   <td class="col-md-2"><button type="button" class="btn btn-warning btn-xs">回复</button></td>
									</tr>
									
								 </table> 
							 </div>
				 
							 <div class="row">
							     <ul class="pagination">
								      <li class="disabled"><a href="#">&laquo;</a></li>
                                      <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
									  <li><a href="#">2</a></li>
									  <li><a href="#">3</a></li>
									  <li><a href="#">4</a></li>
									  <li><a href="#">5</a></li>
									  <li><a href="#">&raquo;</a></li>
								  </ul>
							 </div>
							 
							 <div class="row" style="height:20px;">
                             </div>
							
							<form class="form-horizontal" role="form">
							  <div class="form-group form-group-sm">
								<label class="col-sm-2 control-label" for="formGroupInputSmall">昵称<span style="color:red;">*</span></label>
								<div class="col-sm-8">
								  <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder="">
								</div>
							  </div>
							  
							  <div class="form-group form-group-sm">
								<label class="col-sm-2 control-label" for="formGroupInputSmall">电话</label>
								<div class="col-sm-8">
								  <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder="">
								</div>
							  </div>
							  
							  <div class="form-group form-group-sm">
								<label class="col-sm-2 control-label" for="formGroupInputSmall">邮箱<span style="color:red;">*</span></label>
								<div class="col-sm-8">
								  <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder="">
								</div>
							  </div>
							  
							  <div class="form-group form-group-sm">
								<label class="col-sm-2 control-label" for="formGroupInputSmall">地址</label>
								<div class="col-sm-8">
								  <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder="">
								</div>
							  </div>
							  
							  <textarea class="form-control" rows="4"></textarea>
							  
                              <button type="button" class="btn btn-warning btn-sm">提交意见</button>							  
							</form>
							
							
							
							
							<div class="row">
							     
							</div>
						 </div>
						 
					  </div><!-- panel-body -->
					</div>
				</div><!-- panel-default -->
				
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title"  style="color:#ff9900;font-weight:bold;text-align:center;">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						   联系我们
						</a>
					  </h4>
					</div>
					<div id="collapseFive" class="panel-collapse collapse" role="tabpanel">
						  <div class="panel-body">
							<div class="row">
							  <div class="col-md-1">
							  </div>
							  <div class="col-md-6">
							      <p style="color:#333333;font-weight:bold;">联系电话:83997646</p>
								  <p style="color:#333333;font-weight:bold;">电子邮箱:****@163.com</p>
								  <p style="color:#333333;font-weight:bold;">地址：沈阳市和平区三好街90号6-7-2</p>
							  </div>
							 
							</div>
						  </div>
					</div>
				</div>
		   </div><!--panel-group-->
		   
		   
	   </div>
	   
	   
   </div>
   
<?php 
Yii::app()->clientScript->registerScript('changeMenuStyle',
"

		
   $('#menu-about').addClass('active');

		",CClientScript::POS_READY);


?>

		