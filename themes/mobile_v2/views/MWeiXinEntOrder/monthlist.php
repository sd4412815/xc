<?php
$this->pageTitle = '订单统计';
?>
   
<div style="width: 100%;">
   
         
         <?php
        	$this->renderPartial ( '_profile', array (
        			'shop' => $shop
        	) );
         ?>
   
     <div class="box box-default collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">查找订单</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"> 输入条件
            </button>
          </div>
        </div>
        <div class="box-body">
            <!--  <div class="form-group col-xs-6">
                 
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                </div>
              
              </div>
              
               <div class="form-group col-xs-6">
                 
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                </div>
             
              </div> -->
              
               <div data-role="fieldcontain" class="form-group col-xs-6">
                    <input type="text" class="form-control" value="" readonly="readonly" id="date1" placeholder="开始时间">  
                </div>
             
             <div data-role="fieldcontain" class="form-group col-xs-6">
                    <input type="text" class="form-control" value="" readonly="readonly" id="date2" placeholder="截止时间">  
             </div> 
               
             <div class="form-group col-xs-6">
                <select id="state" class="form-control select2">
                  <option selected="selected">全部</option>
                  <option value="1">预约中</option>
                  <option value="-2">客户违约</option>
                  <option value="0">已取消</option>
                  <option value="3">车主已确认</option>
                  <option value="8">成功</option>
                </select>
              </div>
        
          
          
          
              <div class="form-group col-xs-6">
                <select id="type" class="form-control select2">
                  <option selected="selected">全部</option>
                  <option value="1">普洗</option>
                  <option value="3">普洗+打蜡</option>
                  <option value="5">精洗</option>
                  <option value="6">快洗</option>
                </select>
              </div>
              
               <div class="form-group col-xs-12">
                   <button type="button" onclick="search();" class="btn btn-warning" data-widget="collapse"> 查找订单
                   </button>
               </div>
        </div>
      </div>
        
        <div id="result"></div>
     
          
          
         
      
</div>



<script>  
$(function () {  
     var opt = {
        dateFormat:'yy/mm/dd',
        display: 'modal', //显示方式 
        mode : 'scroller', //日期选择模式 
        minute:'30',
        lang: "zh", 
        cancelText: null,  
        setText: '确定', 
        cancelText: '取消',
        headerText: function (valueText) { //自定义弹出框头部格式  
            array = valueText.split('/');  
            return array[0] + "年" + array[1] + "月" + array[2] + "日";  
        },
         minDate: new Date(2015, 7, 14, 16, 57),
    };

     $("#date1").mobiscroll().date(opt);
     $("#date2").mobiscroll().date(opt);
});

function search(){
  var state=$("#state  option:selected").val();
  var type=$("#type  option:selected").val();
  var timestart=$('#date1').val();
  var timeend=$('#date2').val();
  
  $.ajax({
    type:'POST',
    url:'searc',
    data:{
      'timestart':timestart,
      'timeend':timeend,
      'state':state,
      'type':type,
    },
    async:false,
    'beforeSend':function(){ loadi = layer.load("正在查找");},
    'complete':function(){layer.close(loadi);},
    'success':function(html){
      $('result').html();
    }
  });
}

</script>  


