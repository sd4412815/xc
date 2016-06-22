<section class="content-header">
<h1> 优惠券申请处理</h1>
</section>

<section class="content">			    					
               
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

<?php 
                   
                        
Yii::app()->clientScript->registerScript('btnAckCard',
"
function ackCard(id, code){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('cardGenHistory/ackCard')."',
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
 window.location.href='".Yii::app()->createUrl('mngr/card')."'; 
 //	$('#svalue').val('');

}
});
};
	  			

		",CClientScript::POS_END);


?>		