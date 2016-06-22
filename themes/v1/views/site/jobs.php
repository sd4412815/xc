  <div class="row">

	  
      <div class="col-md-12"> 	     
		    <div class="col-md-8">				
				<div class="row">
				    <div class="col-md-3">
					    <p style="color:#ff9900;font-weight:bold;font-size:18px;">求职信息</p>						
					 </div>					 
					 <div class="col-md-6">
					    <div class="input-group">
						  <input type="text" id="inputQ" class="form-control input-sm" placeholder="地址/店名/关键字">
						  <span class="input-group-btn">
							<button class="btn btn-warning btn-sm" type="button">搜索</button>
						  </span>
						</div><!-- input-group	 -->					
					 </div>
				</div><!-- row -->
				
				<div class="row" style="height:5px;">
                </div>
							
				 <div class="row">
				 <div id="staffList"></div>
				 <?php 
Yii::app()->clientScript->registerScript('staffFilter',
"
		function staffFilter(){
	var loadi;
$.ajax({
url:'".Yii::app()->createUrl('site/staffList')."',
		data:{
	'cid':'1',
		'q':$('#inputQ').val(),
	},
			'beforeSend':function(){ loadi = layer.load('加载中...');},
		'success':function(html){
		layer.close(loadi);
		$('#staffList').html(html)}
});
};
staffFilter();						

		",CClientScript::POS_END);


?>
				 
				
				 </div>
				 
		
				 
			</div>
			
			
			<div class="col-md-4">
			    <h4 style="color:#ff9900;font-weight:bold;">投简历 找工作</h4>
			    <form class="form-horizontal" role="form" style="font-size:12px;">
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">姓名<span style="color:red;font-size:10px;">*(必填)</span></label>
						<div class="col-sm-8">
						  <input class="form-control input-sm" type="text" id="uname" placeholder="">
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">性别<span style="color:red;">*</span></label>
						<div class="col-sm-8">
						  <select class="form-control input-sm" id="usex">
						     <option>请选择</option>
							 <option>男</option>
							 <option>女</option>
						  </select>
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">年龄<span style="color:red;">*</span></label>
						<div class="col-sm-8">
						  <select class="form-control input-sm" id="uage">
						     <option>请选择</option>
							 <option>18-25</option>
							 <option>26-35</option>
							 <option>35-45</option>
							 <option>其他</option>
						  </select>
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">学历</label>
						<div class="col-sm-8">
						  <select class="form-control input-sm" id="uedu">
						     <option>请选择</option>
							 <option>初中</option>
							 <option>高中</option>
							 <option>专科</option>
							 <option>本科及以上</option>
						  </select>
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">期望薪资<span style="color:red;">*</span></label>
						<div class="col-sm-8">
						  <select class="form-control input-sm" id="usalary">
						     <option>请选择</option>
							 <option>1500-2000</option>
							 <option>2000-2500</option>
							 <option>2500以上</option>						
						  </select>
						</div>
					  </div>
					  
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">工作地点<span style="color:red;">*</span></label>
						<div class="col-sm-8">
						  <input class="form-control input-sm" type="text" id="ulocation" placeholder="期望工作地点">
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">您的电话<span style="color:red;">*</span></label>
						<div class="col-sm-8">
						  <input class="form-control input-sm" type="text" id="utel" placeholder="">
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">您的邮箱</label>
						<div class="col-sm-8">
						  <input class="form-control input-sm" type="text" id="uemail" placeholder="">
						</div>
					  </div>
					  
					  <div class="form-group form-group-sm">
						<label class="col-sm-4 control-label" for="formGroupInputSmall">所在城市<span style="color:red;">*</span></label>
						<div class="col-sm-8">
						  <!-- <input class="form-control input-sm" type="text" id="formGroupInputSmall" placeholder=""> -->
						
						  <?php

echo CHtml::dropDownList ( 'idCity', '', CHtml::listData ( City::model ()->findAll (array(
	'order'=>'c_spell ASC',
)), 'id', 'c_name' ), array (
		'prompt' => '选择城市',
		'class'=>'form-control input-sm',
		) 
 );
?>
						
						</div>
					  </div>
					  
					  <textarea class="form-control" rows="3" placeholder="自我介绍" id="udesc"></textarea>
					  
					  <button type="button" class="btn btn-warning btn-sm" onClick="staffInfoAdd();">提交</button>

	<?php
	
		Yii::app()->clientScript->registerScript('staffInfoAdd',"
function	staffInfoAdd(){

};
		",CClientScript::POS_END);
		?>	
										
	       </div>					  
			    </form>
	        </div>
	     
      </div>	  
   </div>
   
   <div class="row" style="height:20px;">
   </div>
   
   <!-- 图片及优势介绍 -->
   <div class="row">
      <div class="col-md-2">
	  </div>
	  
      <div class="col-md-8">  
	    <div class="row">
		
		<div class="col-md-8">
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  
			  <ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			  </ol>

              <!--Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
				<div class="item active">
				  <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/job/job1.png" alt="...">
				  <div class="carousel-caption">
					
				  </div>
				</div>
				
				<div class="item">
				  <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/job/job2.png" alt="...">
				  <div class="carousel-caption">
					
				  </div>
				</div>
				
				<div class="item">
				  <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/job/job3.png" alt="...">
				  <div class="carousel-caption">
					
				  </div>
				</div>
				
				<div class="item">
				  <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/job/job4.png" alt="...">
				  <div class="carousel-caption">
					
				  </div>
				</div>
				
			  </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			  </a>
			</div>
	    </div>
		
		<div class="col-md-4">
		  <h4 style="color:#ff9900;font-weight:bold;">我们的优势</h4>
		  <div class="row">
			 
			<div class="col-xs-12">
			<p>1.为您提供良好的工作条件和工作环境</br>
				我们为员工提供免费宿舍和有竞争力的薪酬，宽敞明亮的工作空间，统一整齐的工作服装，设身处地的为员工排解工作和生活上的困难。
			</br>2.前景光明的职业规划</br>
				洗车工的未来在哪里？谁来帮助洗车工考虑他们的未来？我们！</br>
			喜车加盟店为洗车工提供这样一条职业的发展走向：大中专学生实习/普通工人->学徒->洗车工->优秀洗车工->领班->店长。
				我们还提供专业的洗车知识培训，完善的奖励考核制度，展示给您一个光明的发展前景。 </p>
			</div>
			 
		  </div>
		</div>
			
        </div><!-- row end -->
	  </div>
	  
	  <div class="col-md-2">
	  </div>
	
    </div><!-- row end -->	
    <?php 
Yii::app()->clientScript->registerScript('changeMenuStyle',
"
   $('#menu-jobs').addClass('active');

		",CClientScript::POS_READY);


?>
