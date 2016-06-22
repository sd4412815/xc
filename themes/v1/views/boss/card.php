<section class="content-header">
<h1> 优惠券管理</h1>
</section>

<section class="content">			    					
                    <div class="row">
					   <div class="col-lg-12 col-xs-12">
						    
							<div class="box box-solid box-primary">
								<div class="box-header">
									<h3 class="box-title">优惠卡统计</h3>
								</div>
<?php 
$firstCardRlt = Cardinvite::model()->statisticCount($shop['id'],0);
$xicheCardRlt = Cardinvite::model()->statisticCount($shop['id'],1);
$dalaCardRlt = Cardinvite::model()->statisticCount($shop['id'],3);
$jingxiCardRlt = Cardinvite::model()->statisticCount($shop['id'],5);

?>								
								<div class="box-body">
								    <p>首次优惠券  已使用 <span class="text-green"><?php 
								    echo $firstCardRlt['data']['usedCount'];
								    ?></span> 张，激活总数<?php 
								    echo $firstCardRlt['data']['totalCount'];
								    ?> 张</p>
								   <div class="row">
								      <div class="col-md-4">								  
										  <p>洗车消费卡  &nbsp&nbsp已使用 <span class="text-green"><?php 
								    echo $xicheCardRlt['data']['usedCount'];
								    ?></span> 张，申请总数 <?php 
								    echo $xicheCardRlt['data']['totalCount'];
								    ?>张</p>								    
										  <p>打蜡消费卡  &nbsp&nbsp已使用 <span class="text-green"><?php 
								    echo $dalaCardRlt['data']['usedCount'];
								    ?></span> 张，激活总数 <?php 
								    echo $dalaCardRlt['data']['totalCount'];
								    ?> 张</p>								     
										  <p>精洗代金券  &nbsp&nbsp已使用 <span class="text-green"><?php 
								    echo $jingxiCardRlt['data']['usedCount'];
								    ?></span> 张，激活总数 <?php 
								    echo $jingxiCardRlt['data']['totalCount'];
								    ?> 张</p>								     
									  </div>
									  
								   </div>
								</div>
							</div><!-- /.box -->
						</div>
					</div>
 <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">申请记录</a></li>
                                
									
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                    <?php 
                                    
                                    
                                    $this->beginContent('_cardList',array('dataProvider'=>$dataProvider));
                                  $this->endContent();
                                    
                                    ?>
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
 window.location.href='".Yii::app()->createUrl('boss/card')."'; 
 //	$('#svalue').val('');

}
});
};
	  			

		",CClientScript::POS_END);


?>	