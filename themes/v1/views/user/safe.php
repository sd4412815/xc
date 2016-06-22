<?php
$this->pageTitle = '账户安全';
?>
<section class="content-header">
	<h1>个人信息</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a
			href="<?php echo Yii::app()->createUrl(Yii::app()->controller->id.'/Profile');?>"><i
				class="fa fa-dashboard"></i> 个人主页</a></li>
		<li class="active">个人信息</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-2 control-label">昵称</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputPassword"
							placeholder="6-8个字符">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">性别</label>
					<div class="col-sm-10">
						<select class="form-control">
							<option>请选择</option>
							<option>男</option>
							<option>女</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">车型号</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputPassword"
							placeholder="车的品牌和型号">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">车牌号</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputPassword"
							placeholder=" ">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary col-sm-8">提交</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<!-- /.content -->