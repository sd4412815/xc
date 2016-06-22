
<section class="content-header">
<h1>  购买记录</h1>
</section>

<section class="content">			    					
               
 <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                               
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                    <?php 
                                    
                                    
                                    $this->beginContent('_serviceBuyList',array('dataProvider'=>$dataProvider));
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

<?php 
                   
                        
Yii::app()->clientScript->registerScript('btnAckServiceBuy',
"
function ackServiceBuy(id, code){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('shopPay/ackService')."',
		data:{
            'id':id,
	  		'code':code
	},
 		async:false,
 	'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
 		'complete':function(){layer.close(loadi);},
		'success':function(html){
 		layer.msg('状态更新中...',2,1);
// 		$('#sDateList').html(html);
 window.location.href='".Yii::app()->createUrl('mngr/shopServiceList')."'; 
 //	$('#svalue').val('');

}
});
};
	  			

		",CClientScript::POS_END);


?>		                 
                 