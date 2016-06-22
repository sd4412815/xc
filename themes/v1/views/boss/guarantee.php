     <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        我的保证金
                    </h1>

                </section>
                    
                <!-- Main content -->
                <section class="content">
				    <div class="row">

						<div class="col-lg-6 col-xs-12">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">保证金统计</h3>
                                    <div class="box-tools pull-right">
                                        
                                    </div>
                                </div>
                                <div class="box-body">                                  
                                    <p>抵押保证金  <span class="text-blue"> ￥<?php
                                     echo CardGenHistory::model()->getGuarantee($shop['id']);?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                     当前可退  <span class="text-blue"> ￥<?php
                                     echo Cardinvite::model()->getGValueRemain($shop['id']);?></span></p>
                                    <p style="text-align:center;"><button class="btn btn-primary btn-sm"data-toggle="modal" data-target="#myModal">申请返还</button></p>                                      									
                                </div><!-- /.box-body -->							
                            </div><!-- /.box -->
							
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">退还保证金</h4>
								  </div>
								  <div class="modal-body">
									<input id="gvalue" type="text" class="col-xs-12">
								  </div>
								  <div class="modal-footer">						
									<button type="button" class="btn btn-primary" onclick="gvalueRequest()">确定</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
									  <?php 
Yii::app()->clientScript->registerScript('btnGvalueRequest',
"
function gvalueRequest(){
$.ajax({
url:'".Yii::app()->createUrl('guaranteePay/newRequest')."',
		data:{
	  'value':$('#gvalue').val(),
	
	},
		'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
		'error':function(){ layer.msg('申请失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(html){
                		if(html == 'true'){
  window.location.href='".Yii::app()->createUrl('boss/guarantee')."';
}else{
layer.msg(html);
}
      

}
});
};




		",CClientScript::POS_END);


?>
								  </div>
								</div>
							  </div>
							</div>

							
                        </div><!-- ./col -->
                        
                    </div><!-- /.row -->
					
                    <div class="row">
					    <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">保证金退还记录</h3>
                                </div>
                                <div class="box-body">                                 
									<table class="table table-hover">
									   <tr>
									      <th>申请时间</th>
									      <th>退还时间</th>										  
										  <th>金额(单位：元)</th>
										  <th>状态</th>
                                          <th>操作</th>										  
									   </tr>
									   <?php 
									   $pays = GuaranteePay::model()->findAllByAttributes(array(
									   	'gp_shop_id'=>$shop['id'],
									   ),array('order'=>'gp_date DESC'));
										foreach ($pays as $key=>$pay):
									   ?>
									   	   <tr>									      
										  <td><?php echo $pay['gp_date'];?></td>
										  <td><?php echo $pay['gp_date_pay'];?></td>
										  <td><?php echo $pay['gp_value'];?></td>
										  <td>
										  <?php if($pay['gp_state']==0):?>
										   <span class="label label-warning">申请已提交</span>
										   <?php elseif ($pay['gp_state']==1):?>
										   <span class="label label-success">申请已确认</span>
										  <?php elseif ($pay['gp_state']==2):?>
										  <span class="label label-primary">已退还</span>
										  <?php endif;?>
										  
										 </td>
										    <td><a href="<?php echo Yii::app()->createUrl('boss/guaranteeView',array('id'=>$pay['id']));?>" class="btn btn-primary btn-xs">查看进度</a></td>
									   </tr>
									   <?php endforeach;?>
									   
									 
									 
									 
                                    
									 
															   
									</table>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
					    </div>
					</div>
                </section><!-- /.content -->