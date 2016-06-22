<?php
$this->pageTitle = Yii::app ()->name . ' - 病事假管理';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        病事假列表
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
                                    <h3 class="box-title">时间段设置
                                    </h3>
										
										   <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-left col-md-6" id="daterange"/>
                                            
                                        </div><!-- /.input group -->
                                
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                


                                  <div id="list" >
 <?php 
  $this->renderPartial('_eventList',array(
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
                	     	<div class="col-sm-1">
                	     	员工编号
                	     	</div>
                	     		<div class="col-sm-9">
          
       <?php

echo CHtml::dropDownList ( 'idStaff', '', CHtml::listData (Staff::model ()->findAllByAttributes (array(
	's_wash_shop_id'=>Boss::model()->findByAttributes(array(
'b_user_id'=>Yii::app()->user->id))->washShop['id'],
)), 'id', function($model){
	
	return CHtml::encode('编号:'.$model->s_tag.' (电话:'.$model->s_tel.')');
}  ), array (
		'prompt' => '选择员工',
		'class'=>'form-control',
) );
?> 
     
                	     		  
                	  
                	     		</div>
                	     </div>
                	     <div class="form-group">
                	     	<div class="col-sm-1">
                	     	请假 缘由
                	     	</div>
                	     		<div class="col-sm-9">
          
          <select id="etype" class="form-control">
          <option value="1">病假</option>
           <option value="2">事假</option>
          </select>
                	     		  
                	  
                	     		</div>
                	     </div>
                	            <div class="form-group">
                	     	<div class="col-sm-1">
                	     	 请假时间
                	     	</div>
                	     		<div class="col-sm-9">

                	     	 <input type="text" class="form-control" id="edate" placeholder="" >
                	     		</div>
                	     </div>
                	          <div class="form-group">
                	     	<div class="col-sm-1">
                	     	 备注
                	     	</div>
                	     		<div class="col-sm-9">

                	     	 <input type="text" class="form-control" maxlength="200" id="edesc" placeholder="不超过100字">
                	     		</div>
                	     </div>
                	           <div class="form-group">
                	           
                	           <input type="button" onclick="addE();" value="提交申请" class="btn btn-primary ">
                	           </div>
                	     
                
                </div>
                
                </section>
                
                
                
                
            <script type="text/javascript">
<!--
$(document).ready(function () {

	
	   //Date range picker
    $('#daterange').daterangepicker(
            {
                ranges: {
                    '今天': [moment(), moment()],
                    '昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    '最近7天': [moment().subtract('days', 6), moment()],
                    '最近30天': [moment().subtract('days', 29), moment()],
                    '本月': [moment().startOf('month'), moment().endOf('month')],
                    '上个月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                locale: {
                	applyLabel: '确认',
                	cancelLabel: '取消',
                	fromLabel: '从',
                	toLabel: '到',
                	customRangeLabel: '自定义',
                	daysOfWeek: ['日', '一', '二', '三', '四', '五','六'],
                	monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                	firstDay: 1
                	},
                startDate: moment().subtract('days', 29),
                endDate: moment(),
               
            },
            function(start, end, label){
            	$.ajax({
//            		type : 'GET',
            	url:'<?php echo Yii::app()->createUrl("boss/staffEvent");?>',
//            		dataType: 'json',
            	async:false,
            	data:{
            	 	'startTime':start.format('YYYY-MM-DD 00:00'),
            	 	'endTime':end.format('YYYY-MM-DD 23:59'),

            	},
            	success:function(data) { 
            		$('#list').html(data);


            }

            }); // end ajax
                }
    );


    $('#edate').daterangepicker(
            {
            	timePicker: true, 
            	timePickerIncrement: 1,
            	timePicker12Hour:false,
                ranges: {
//                     '今天': [moment(), moment()],
                    '明天': [moment().subtract('days', -1), moment().subtract('days', -1)],
                    '未来7天': [moment(),moment().subtract('days', -6) ],
//                     '最近30天': [moment().subtract('days', 29), moment()],
//                     '本月': [moment().startOf('month'), moment().endOf('month')],
//                     '上个月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                locale: {
                	applyLabel: '确认',
                	cancelLabel: '取消',
                	fromLabel: '从',
                	toLabel: '到',
                	customRangeLabel: '自定义',
                	daysOfWeek: ['日', '一', '二', '三', '四', '五','六'],
                	monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                	firstDay: 1
                	},
                startDate: moment(),
                endDate: moment().add('days', 1),
                minDate:moment().subtract('days',1),
//                 maxDate:moment()
                format: 'YYYY-MM-DD hh:mm'
               
            },
            function(start, end, label){
            	
                }
    );

//     $('#daterange').on('apply.daterangepicker', function(ev, picker) {
//     	alert(picker.startDate.format('YYYY-MM-DD'));
// //     	  console.log(picker.endDate.format('YYYY-MM-DD'));
//     	});


//     $('#daterange').on('show.daterangepicker', function(ev, picker) {
//     	alert('dd');
// //     	  console.log(picker.endDate.format('YYYY-MM-DD'));
//     	});


    });

function addE(){

	$.ajax({
    	type:'POST',
	url:'<?php echo Yii::app()->createUrl("staffEvent/add");?>',
	async:false,
	data:{
	 	'startTime':$('#edate').daterangepicker().data('daterangepicker').startDate.format('YYYY-MM-DD hh:mm'),
	 	'endTime':$('#edate').daterangepicker().data('daterangepicker').endDate.format('YYYY-MM-DD hh:mm'),
	 	'etype':$("#etype").val(),
	'edesc':$("#edesc").val(),
	'estaff':$("#idStaff").val(),

	},
	success:function(data) { 
// 		$('#list').html(data);
location.reload();

//         var start = $('#noteRangeInput').daterangepicker().data('daterangepicker').startDate.format('YYYY-MM-DD');
}

}); // end ajax
}

function orderAck(orderId,bossId, ackType){

var mydata;
if(ackType==1){

mydata={
id:orderId,
type:ackType,
score:$("#star"+orderId).raty('score'),
comment:$("#text"+orderId).val()
	};
}else{

mydata = {
id:orderId,
type:ackType
};
}
	  
		$.ajax({
			type : 'POST',
			url:'<?php echo UTool::getURLRandoms("orderhistory/orderAckbyStaff");?>',

			dataType: 'json',
			async:false, // 可去掉
			data:mydata,
			success:function(rlt) { 

			if(rlt.state == true){
				location.reload();

			
  			}
			else
			{
  			alert("确认失败");

  			}

		}

		}); // end ajax

    
}

//-->
</script>  
