<?php
$this->pageTitle = '敬请期待';
// code: HTTP 状态码（比如 403, 500）；
// type: 错误类型（比如 CHttpException, PHP Error）；
// message: 错误信息；
// file: 发生错误的PHP文件名；
// line: 错误所在的行；
// trace: 错误的调用栈信息；
// source: 发生错误的代码的上下文。

// echo $trace;
// echo '<br>';
// echo '<strong>'.$line.'</strong>';
// echo '<br>';
// echo $file;
// echo '<br>';
// echo $code;
// echo '<br>';
// echo $message;
// echo '<br>';
?>
<div class="error-page">
	<h2 class="headline text-info">
	<i class="fa fa-warning text-yellow"></i>
		
	</h2>
	<div class="error-content">
		<h3>敬请期待……</h3>
	
		
	</div>
	<!-- /.error-content -->
	
		<h4 class="headline ">
	
		<a  href="<?php echo Yii::app()->createUrl('site/index');?>" class="text-blue">点击返回<i class="fa fa-2x fa-home text-blue"></i>继续访问其它信息</a>
	</h4>
</div>
<!-- /.error-page -->



