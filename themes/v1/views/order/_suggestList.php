<?php
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/jquery.raty.css" );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD );

?>
<div class="contents">


 <?php
	$this->widget ( 'zii.widgets.CListView', array (
			'dataProvider' => $dataProvider,
			'itemView' => '_suggestListInfo',
			'template'=>'<div>{items}</div>',
				
			'id' => 'ajaxSuggestList',
			'ajaxVar' => '', // 默认为page或ajax 去掉后url更简洁
			'emptyText' => '
<div class="alert alert-waning wide-fat green">
暂无推荐车行！
</div>
',
		
			'summaryCssClass'=>'summary_container contents grid-contents col-md-12 col-sm-6',//定义summary的div容器的class
				
			'summaryText'=>'共{count}条，当前页显示第{start}-{end}条',
				
		
			 	
	'pagerCssClass'=>'pager_container contents grid-contents  col-md-12 col-sm-6',//定义pager的div容器的class
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
	)
	 );
	
	?>

   </div>
