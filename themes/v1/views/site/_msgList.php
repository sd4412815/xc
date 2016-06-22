<div class="contents">
<?php
$this->widget ( 'zii.widgets.CListView', array (
		'dataProvider' => $dataProvider,
		'id' => 'ajaxMsgList',
		'itemView' => '_msgInfo',
		'template' => '<div class="list"><table class="table table-hover"><tr>   <th>时间</th>
 		<th>内容</th><th>状态</th>
 		</tr>{items}</table></div><div class="pager">{pager}</div><div class="summary">{summary}</div>',
		'ajaxVar' => '', // 默认为page或ajax 去掉后url更简洁
		'emptyText' => '
<DIV class="alert alert-waning wide-fat green">
还没有历史消息！
</DIV>
', // 无数据时显示内容
		'summaryCssClass' => 'summary_container contents grid-contents col-md-12 col-sm-6', // 定义summary的div容器的class
		
		'summaryText' => '共{count}条，当前页显示第{start}-{end}条',
		'sortableAttributes' => array (
				'id',
				'oh_type' 
		), // 定义可排序的属性
		
		'sorterCssClass' => 'sorter_container contents grid-contents col-md-12 col-sm-6', // 定义sorter的div容器的class
		
		'sorterHeader' => '更改排序：', // 定义的文字显示在sorter可排序属性的前面
		
		'sorterFooter' => '', // 定义的文字显示在sorter可排序属性的后面
		
		'pagerCssClass' => 'pager_container contents grid-contents col-md-12 col-sm-6', // 定义pager的div容器的class
		'pager' => array (
				
				'class' => 'CLinkPager', // 定义要调用的分页器类，默认是CLinkPager，需要完全自定义，还可以重写一个，参考我的另一篇博文：http://blog.sina.com.cn/s/blog_71d4414d0100yu6k.html
				'cssFile' => false, // 定义分页器的要调用的css文件，false为不调用，不调用则需要亲自己css文件里写这些样式
				'header' => '转往分页：', // 定义的文字将显示在pager的最前面
				
				'footer' => '', // 定义的文字将显示在pager的最后面
				'firstPageLabel' => '首页', // 定义首页按钮的显示文字
				'lastPageLabel' => '尾页', // 定义末页按钮的显示文字
				'nextPageLabel' => '下一页', // 定义下一页按钮的显示文字
				'prevPageLabel' => '前一页'  // 定义上一页按钮的显示文字
				) 
)
 )

;

?>

   </div>
