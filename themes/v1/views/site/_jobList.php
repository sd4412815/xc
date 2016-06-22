<?php
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/jquery.raty.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD);


?>
<div class="contents">


 <?php

 $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$dataProvider,
'itemView'=>'_jobListInfo',

 		'template'=>' <table class="table table-hover active"><tr>   <th>姓名</th>
 		<th>城市</th><th>提交时间</th><th>个人介绍</th><th>工作状态</th>
 		</tr>{items}</table><div class="pager">{pager}</div><div class="summary">{summary}</div>',
//  		'template'=>'<div class="list">{items}</div><div class="pager">{pager}</div><div class="summary">{summary}</div><div class="sorter">{sorter}</div>',
 			
 		//template是整个CListView的模板：
 		
 		//{summary}的位置会显示基本描述，可修改summaryText项来设置描述的模板
 		
 		//{sorter}的位置会显示更改排序方式的按钮，需要定义sortableAttributes项来描述哪一属性是可排序的
 		
 		//{items}的位置会显示列表，列表中每一项的格式来自itemView项定义的文件
 		
 		//{pager}的位置会显示分页器，可通过定义pager项来设定分页器的显示方式
 		'ajaxVar' => '', //默认为page或ajax 去掉后url更简洁
 		'emptyText' => '
 		
<DIV class="alert alert-waning wide-fat green">
没有找到相应的人才信息！请重新选择搜索条件！
 		
</DIV>
 		
', //无数据时显示内容
 		'summaryCssClass'=>'summary_container contents grid-contents col-md-12 col-sm-6',//定义summary的div容器的class
 		
 		'summaryText'=>'共{count}条，当前页显示第{start}-{end}条',

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

   </div>
  