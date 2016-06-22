<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD);

?>


<div  class="sDateListRatio">


 <?php 
 $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$dataProvider,
'itemView'=>'_timeListInfo',

 		'template'=>'<div class="list">{items}</div>',
//  		'template'=>'<div class="list">{items}</div><div class="pager">{pager}</div><div class="summary">{summary}</div><div class="sorter">{sorter}</div>',
 			
 		//template是整个CListView的模板：
 		
 		//{summary}的位置会显示基本描述，可修改summaryText项来设置描述的模板
 		
 		//{sorter}的位置会显示更改排序方式的按钮，需要定义sortableAttributes项来描述哪一属性是可排序的
 		
 		//{items}的位置会显示列表，列表中每一项的格式来自itemView项定义的文件
 		
 		//{pager}的位置会显示分页器，可通过定义pager项来设定分页器的显示方式
 		'ajaxVar' => '', //默认为page或ajax 去掉后url更简洁
 		'emptyText' => '
 		
<div class="alert">没有找到可预约时间段信息！	
</div>
 		
', //无数据时显示内容
 		'summaryCssClass'=>'summary_container contents grid-contents col-md-12 col-sm-6',//定义summary的div容器的class
 		
 		'summaryText'=>'共{count}条，当前页显示第{start}-{end}条',
 		
 		//定义summary的显示内容，其中可用到以下变量：
 		
 		//{start}表示本页的第一条是全部中的第几条
 		
 		//{end}表示本页最后一条是全部中的第几条
 		
 		//{count}表示全部共几条
 		
 		//{page}表示当前页码
 		
 		//{pages}表示总页数
 		'sortableAttributes'=>array('id','ws_name'),//定义可排序的属性
 		
 		'sorterCssClass'=>'sorter_container contents grid-contents col-md-12 col-sm-6',//定义sorter的div容器的class
 		
 		'sorterHeader'=>'更改排序：',//定义的文字显示在sorter可排序属性的前面
 		
 		'sorterFooter'=>'',//定义的文字显示在sorter可排序属性的后面
 		
 		
 		
 		'pagerCssClass'=>'pager_container contents grid-contents col-md-12 col-sm-6',//定义pager的div容器的class
 		'pager'=>array(
 		
 				'class'=>'CLinkPager',//定义要调用的分页器类，默认是CLinkPager，需要完全自定义，还可以重写一个，参考我的另一篇博文：http://blog.sina.com.cn/s/blog_71d4414d0100yu6k.html
 				'cssFile'=>false,//定义分页器的要调用的css文件，false为不调用，不调用则需要亲自己css文件里写这些样式
 				'header'=>'转往分页：',//定义的文字将显示在pager的最前面
 		
 				'footer'=>'',//定义的文字将显示在pager的最后面
 				'firstPageLabel'=>'首页',//定义首页按钮的显示文字
 				'lastPageLabel'=>'尾页',//定义末页按钮的显示文字
 				'nextPageLabel'=>'下一页',//定义下一页按钮的显示文字
 				'prevPageLabel'=>'前一页',//定义上一页按钮的显示文字
 		
 				//关于分页器这个array，具体还有很多属性，可参考CLinkPager的API
 		),
 		
 		
));
 
 ?>
 <br>  <span class="soper">
            <label> <input id="selall" name="timeListOper" type="checkbox" >全选</label>
                        <label> <input id="unsel" name="timeListOper" type="checkbox">反选</label>
                        <label> <input id="clear" name="timeListOper" type="checkbox">清空</label>
                    
          </span>   
 <?php          
          if (Yii::app()->user->hasFlash('discountNumWarning')):
?>
<br><br>
<div class="alert alert-danger alert-dismissable">
<i class="fa fa-warning"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>注意！</b><?php echo Yii::app()->user->getFlash('discountNumWarning'); ?> 
</div>

<?php endif;?> 
 
   
   </div>
    <?php 
 Yii::app()->clientScript->registerScript('icheck',"
 $('.sDateListRatio input').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
		cursor:true,
    increaseArea: '20%' // optional
	
  });          		
                    		
                    		",CClientScript::POS_READY);
 ?>   
   <?php 
 Yii::app()->clientScript->registerScript('dateRatio1',"

		
$('.sDateListRatio input[name=\"sdate\"]').on('ifChecked', function(event){
if($('.sDateListClass input[checked][enabled][name=\"sdate\"]').length<=1){	
$('#svalue').val($('#sTime'+this.value).data('price'));
}	
});	
		
                    		",CClientScript::POS_READY);
 ?>                       

                           
   
 <?php 
Yii::app()->clientScript->registerScript('stlOperation',"
$('#selall').on('ifChecked', function(event){
	$('#unsel').iCheck('uncheck');
		$('#clear').iCheck('uncheck');
	var checkboxes = $('.sDateListRatio input[name=\"sdate\"]:enabled');
	checkboxes.not(\":checked\").iCheck('check'); 
});
$('#unsel').on('ifChecked',function(event){
		$('#selall').iCheck('uncheck');
		$('#clear').iCheck('uncheck');
	var checkboxes = $('.sDateListRatio input[enabled][name=\"sdate\"]');
	checkboxes.iCheck('toggle');
		checkboxes.iCheck('update');
	
});
$('#clear').on('ifChecked',function(event){
		$('#selall').iCheck('uncheck');
		$('#unsel').iCheck('uncheck');
	var checkboxes = $('.sDateListRatio input[enabled][name=\"sdate\"]');
	checkboxes.filter(\":checked\").iCheck('uncheck'); 
});
		
",CClientScript::POS_READY);
?>

