<?php
$this->pageTitle = Yii::app ()->name . ' - 积分记录';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        积分记录
                        <small>变更</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo Yii::app()->createUrl('staff/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
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
  $this->renderPartial('_score',array(
 'dataProvider'=>$dataProvider,
 ));
 ?>
 </div>
                            
                                           </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                </section><!-- /.content -->
                
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
            	url:'<?php echo Yii::app()->createUrl("staff/score");?>',
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

//     $('#daterange').on('apply.daterangepicker', function(ev, picker) {
//     	alert(picker.startDate.format('YYYY-MM-DD'));
// //     	  console.log(picker.endDate.format('YYYY-MM-DD'));
//     	});


//     $('#daterange').on('show.daterangepicker', function(ev, picker) {
//     	alert('dd');
// //     	  console.log(picker.endDate.format('YYYY-MM-DD'));
//     	});


    });


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
				
				if(ackType==1){
// 					alert(rlt.data);
if(rlt.data == 2){

	$('#spanState'+orderId).html('订单成功');
	$('#spanState'+orderId).attr('class','label label-success');
	
}
			
// 					$('#orderAck'+orderId).hide();
  				
//   				$('#aack'+orderId).attr("disabled",true);
//   				$('#aack'+orderId).html('已确认');
  				$('#aack'+orderId).hide();
  				}else if(ackType==0){
  			
//       				$('#orderCancel'+orderId).hide();
//       				$('#acan'+orderId).attr("disabled",true);
//       				$('#acan'+orderId).html('已取消');
//       				$('#aack'+orderId).hide();
      			}

			
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
