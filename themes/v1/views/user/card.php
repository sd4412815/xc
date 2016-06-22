<section class="content-header">
<h1> 我的优惠劵</h1>
</section>

<section class="content">			    					
    <div class="row">
						<div class="col-lg-12 col-xs-12">
						    <!-- Primary box -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">添加优惠券/卡</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
										    <div class="col-md-6">
											   <div class="form-horizontal" >
												  
												  <div class="form-group">
													<label for="inputPassword" class="col-sm-3 control-label">优惠卡密码</label>
													<div class="col-sm-9">
													  <input  type="text" class="form-control" id="cardPWD" placeholder=" ">
													</div>
												  </div>
												  <div class="form-group">
													<div class="col-sm-offset-3 col-sm-9">
													  <button  class="btn btn-primary col-sm-8" onclick="addCard()">添加</button>
													
<?php 
                   
                        
Yii::app()->clientScript->registerScript('btnRequestCard',
"
function addCard(){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('cardinvite/addCard')."',
		data:{
		'pwd':$('#cardPWD').val(),
	},
      dataType:'JSON',
 		async:false,
 	'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
 		'complete':function(){layer.close(loadi);},
		'success':function(html){
         if(html.status){
	layer.msg('添加成功...',2,1);
// 		$('#sDateList').html(html);
window.location.href='".Yii::app()->createUrl('user/card')."'; 
 //	$('#svalue').val('');
}else{
layer.msg(html.msg);
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
									</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
							
						
						</div><!-- ./col -->
					</div>               
 <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                               
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                    <?php 
                                    
                                    
                                    $this->beginContent('_cardList',array('dataProvider'=>$dataProvider));
                                  $this->endContent();
                                    
                                    ?>
                                       </div><!-- /.tab-pane -->	
                                         <div class="tab-pane" id="tab_2">				
					</div><!-- /.tab-pane -->	
						<div class="tab-pane" id="tab_3">
						</div><!-- /.tab-pane -->
					    
                                </div><!-- /.tab-content -->
                            </div><!-- nav-tabs-custom -->
                                  
                        </div><!-- /.col -->
                    </div> <!-- /.row -->					
</section>

