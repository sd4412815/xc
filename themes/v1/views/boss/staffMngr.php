<?php
$this->pageTitle = Yii::app ()->name . ' - 病事假管理';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        员工管理
                        <small>统计</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo Yii::app()->createUrl('user/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
                        <li class="active">预约列表</li>
                    </ol>
                </section>

                
                
                <!-- Main content -->
                <section class="content">
                  <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">员工列表
                                    </h3>
									
                                
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                


                                  <div id="list" >
 <?php 
  $this->renderPartial('_staffList',array(
 'dataProvider'=>$dataProvider,
 ));
 ?>
 </div>                         
                                        </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                </section><!-- /.content -->
                
                        <section class="container">
                
                <div class="form-horizontal">
                	               	          <div class="form-group">
                	     	<div class="col-sm-2 col-md-1">
                	     	 员工手机号
                	     	</div>
                	     		<div class="col-sm-9">

                	     	 <input type="text" class="form-control" maxlength="11" id="staffTel" placeholder="11位手机号">
                	     		</div>
                	     		<div class="col-sm-9">

                	     	 <input type="text" class="form-control" maxlength="2" id="staffTag" placeholder="员工编号">
                	     		</div>
                	     </div>
                	           <div class="form-group">
                	           
                	           <input type="button" onclick="staffAdd();" value="添加员工" class="btn btn-primary ">
                	           </div>
                	     
                
                </div>
                
                </section>
                
                
                
                
            <script type="text/javascript">
<!--


function staffWSUpdate(staffId){

	  
		$.ajax({
			type : 'POST',
			url:'<?php echo Yii::app()->createUrl("boss/staffMngr");?>',
// 			dataType: 'json',
			async:false, // 可去掉
			data:{'id':staffId},
			success:function(rlt) { 
		
				$('#list').html(rlt);

		}

		}); // end ajax

    
}
function staffAdd(){

	  
	$.ajax({
		type : 'POST',
		url:'<?php echo Yii::app()->createUrl("boss/staffMngr");?>',
// 		dataType: 'json',
		async:false, // 可去掉
		data:{'tel':$("#staffTel").val(),'tag':$("#staffTag").val()},
		success:function(rlt) { 
			if(rlt == '0'){
alert('员工电话不存在');
				}else{

					
					$('#list').html(rlt);
					}
		
//alert(rlt.state);
// 		if(rlt.state == true){
// 			location.reload();

		
// 			}
// 		else
// 		{
// 			alert("操作失败");

// 			}

	}

	}); // end ajax


}
//-->
</script>  
