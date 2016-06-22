<?php
$this->pageTitle = '错误' . $code;
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
		<h3><?php
		if ($code == 404) {
			echo CHtml::label ( '您请求的页面不存在', '' );
		} else if ($code == 403) {
			echo CHtml::label ( '权限不够', '' );
		} else if ($code == 500) {
			echo CHtml::label ( '请求异常，请稍后重试', '' );
		} else {
			echo CHtml::label ( $message, '' );
		}
		?></h3>
		<p>
			<i class="fa ">请您检查后重试 
		
		</p>
		<p>
			<i class="fa fa-caret-right"></i> 您可能
			<code>重复</code>
			点击 提交按钮
		</p>
		<p>
			<i class="fa fa-caret-right"></i> 您可能
			<code>频繁</code>
			刷新 页面
		</p>
		<p>
			<i class="fa fa-caret-right"></i> 您可能正在访问页面
			<code>不存在</code>

		</p>
		<p>
			<i class="fa fa-caret-right"></i> 服务器遇到
			<code>错误</code>
			未能完成请求
		</p>

	</div>
	<!-- /.error-content -->

	<h4 class="headline ">

		<a href="<?php echo Yii::app()->createUrl('site/index');?>"
			class="text-blue">点击返回<i class="fa fa-2x fa-home text-blue"></i>继续访问其它信息
		</a>
	</h4>
</div>
<!-- /.error-page -->



