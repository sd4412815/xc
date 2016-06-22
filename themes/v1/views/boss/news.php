 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        动态发布
                    </h1>
                   
                </section>
                    
                <!-- Main content -->
                <section class="content">
				    
                    <div class="row">
					    <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">填写适合自己的店面营销内容</h3>
                                </div>
                                <div class="box-body">                                 
									<textarea id="news" class="form-control" rows="4"></textarea>
                                </div><!-- /.box-body -->
								<div class="box-footer">
								    <button class="btn btn-primary" onclick="newsAdd()">提交</button>
								</div>
                            </div><!-- /.box -->
					    </div>
					</div>
					
<?php 

Yii::app()->clientScript->registerScript('newsAdd',
"
		
function newsAdd(){
		
		var loadi;
$.ajax({
	  		type : 'POST',
url:'".Yii::app()->createUrl('shopNews/newsAdd')."',
		data:{
	  		'news':$('#news').val(),
	},
	  		'beforeSend':function(){ loadi = layer.load('发布中...');},
		'error':function(){ layer.msg('发布失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(data){
if(data=='true'){
	

 window.location.href='".Yii::app()->createUrl('boss/news')."'; 
}
else
{
layer.msg('发布失败！', 1, 0);
}
}
});
};
		",CClientScript::POS_END);


?>	
<table class="table table-hover">
<tr>   <th>发布时间</th>
 		
 		<th>内容</th>
 		</tr>
<?php 
$news = ShopNews::model()->findAllByAttributes(array(
	'sn_shop_id'=>$shop['id'],
),array('order'=>'sn_date DESC'));

foreach ($news as $key=>$new):

?>
<tr>
<th><?php 

echo date('m月d日',strtotime($new['sn_date'])) ;?></th>
<td><?php echo $new['sn_desc'];?></td>
</tr>
<?php endforeach;?>
</table>
