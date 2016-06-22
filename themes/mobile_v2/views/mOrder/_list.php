<?php



 if(Yii::app()->user->hasFlash('listRefresh')):?> 
<div class="row text-center alert-info notify-flash" >
<?php echo Yii::app()->user->getFlash('listRefresh'); ?>
</div>
<?php endif; ?>

 <?php
	$this->widget ( 'zii.widgets.CListView', array (
			'dataProvider' => $dataProvider,
			'viewData' => array (
					'serviceTypeList' => $serviceTypeList , 
					'params'=>$params
			),
			'id' => 'ajaxList',
// 			'htmlOptions'=>array('class'=>"loader-inner ball-pulse"),
'beforeAjaxUpdate'=> 'js:function(){$("#ajaxList").addClass("loader-inner ball-pulse");$("#ajaxList").loaders();}',
			 'afterAjaxUpdate' => 'js:function(){$("#ajaxList").removeClass("loader-inner ball-pulse");$("img.lazy").lazyLoadXT();}',
			'itemView' => '_shopInfo',
			'template' => '{items}<div class="pager">{pager}</div>',
			'ajaxVar' => '', // 默认为page或ajax 去掉后url更简洁
			'emptyText' => '
 <div class="alert" style="height:500px;">
暂未找到门店信息，请稍后再试……
</div>		
',
			"loadingCssClass"=>"",
// 			'pagerCssClass' => 'pager_container contents grid-contents col-xs-12', // 定义pager的div容器的class
			'pager' => array (
					'class' => 'CLinkPager', // 定义要调用的分页器类，默认是CLinkPager，需要完全自定义，还可以重写一个，参考我的另一篇博文：http://blog.sina.com.cn/s/blog_71d4414d0100yu6k.html
					'cssFile' => false, // 定义分页器的要调用的css文件，false为不调用，不调用则需要亲自己css文件里写这些样式
					'header' => '', // 定义的文字将显示在pager的最前面
					
					'footer' => '', // 定义的文字将显示在pager的最后面
					'firstPageLabel' => '首页', // 定义首页按钮的显示文字
					'lastPageLabel' => '尾页', // 定义末页按钮的显示文字
					'nextPageLabel' => '下一页', // 定义下一页按钮的显示文字
					'prevPageLabel' => '前一页' 
			) 
	) ); // 定义上一页按钮的显示文字

	
	?>

