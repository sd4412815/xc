
jQuery(window).ready(function($) {
//	 $(document).ready(function() {
////            $('.tooltip').tooltipster();
//        });
//		  $('.tooltip').tooltipster();
if( $('.icheck input').length>0){
					 $('.icheck input').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
		cursor:true,
    increaseArea: '20%' // optional
  });
}

$('.allFeatures input[name="SearchForm[features][]"]').on('ifChanged', function(event){
var content='';
 $('.allFeatures input:checked[name="SearchForm[features][]"]').each(function(){ 
  content = content+' '+$(this).parent().next().html();
 });		
$('#selectedFeatures').html(content);	
$('#btn_search').click();		
});

$('.allAreas input[name="SearchForm[areas]"]').on('ifChanged', function(event){
$('#btn_search').click();		
});

      		


   



});
function SetHome(obj,url){
    try{
        obj.style.behavior='url(#default#homepage)';
       obj.setHomePage(url);
   }catch(e){
       if(window.netscape){
          try{
              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
         }catch(e){
              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
          }
       }else{
        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");
       }
  }
}
function AddFavorite(title, url) {
	  try {
	      window.external.addFavorite(url, title);
	  }
	catch (e) {
	     try {
	       window.sidebar.addPanel(title, url, "");
	    }
	     catch (e) {
	         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
	     }
	  }
	}

function yd(){
	   $('#sType').html($(this).html());
	   getShopCount();
		getTimeList();
	userCardList();
	$("a[name='sType']").click(function(){
		   $("[name='sType']").attr("class","btn btn-app");
		   $(this).attr("class", "btn btn-app1");
		   $('#sType').html($(this).html());
		   getTimeList();
		   getShopCount();
	});	
	
	$("a[name='serviceDate']").click(function(){
		   $("[name='serviceDate']").attr("class","btn btn-app");
		   $(this).attr("class", "btn btn-app1");
		   getTimeList();
		   getShopCount();
		   userCardList();
	});	
	$("a[name='carType']").click(function(){
		   $("[name='carType']").attr("class","btn btn-app");
		   $(this).attr("class", "btn btn-app1");
		   getTimeList();
		   $('#carType').html($('#carTypeRatioStr'+$(this).data('value')).html());
	});	
	$("a[name='position']").click(function(){
		   $("[name='position']").attr("class","btn btn-app");
		   $(this).attr("class", "btn btn-app1");
		   getTimeList();
		 
	});	
	$("a[name='sdate']").click(function(){
		   $("[name='sdate']").attr("class","btn btn-app");
		   $(this).attr("class", "btn btn-app1");
//		   alert($('.sDateListRatio').find('.btn-app1').data('value'));
//		   getTimeList();
		 
	});	
	
	
	
}

function listSearch()
{
	alert('ddd');
}

function previewCard(cost, gRatio )
{
var sNum = $("#sNum").val();
var sValue = $("#sValue").val();

$("#lcType").html($("#cType").find("option:selected").text());
$("#lsNum").html(sNum);
$("#lsValue").html(sValue);
$("#lsDate").html($("#sDate").val());
$("#lsCValue").html(sNum*cost);
$("#lsGValue").html(sNum*sValue*gRatio);
$("#lsTValue").html(sNum*cost + sNum*sValue*gRatio);
}

function setRest(value){
	 $("#wsrest").attr("value",value);
}

function setWSInfoTimeP(){
	
	   $('#daterange').daterangepicker(
            {
                timePicker: true,  
                timePickerIncrement: 5, 
                timePicker12Hour:false,                    
                format: 'HH:mm',
                separator:'-',
                ranges: {
                    '7:00-21:00': [moment().format('YYYY/MM/DD 07:00'), moment().format('YYYY/MM/DD 21:00')],
                    '8:00-20:00': [moment().format('YYYY/MM/DD 08:00'), moment().format('YYYY/MM/DD 20:00')],
                    '8:00-19:00': [moment().format('YYYY/MM/DD 08:00'), moment().format('YYYY/MM/DD 19:00')]
                   
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
               
            }
    );
	
	}
	
function UpdateWsInfo(myurl,id){
	
	var sts = new Array();
	$('input[name="stype"]:checked').each(function(){
		 sts.push(this.value);
		});
	// var sfs = new Array();
	// $('input[name="sfeatures"]:checked').each(function(){
	// 	 sfs.push(this.value);
	// 	});	
	
	
	var loadi;
	$.ajax({
		type:'POST',
		url:myurl,
		data:{
			'id':id,
	  		// 'wno':$('#wno').val(),
			// 'wname':$('#wname').val(),
			// 'waddress':$('#waddress').val(),
			'wdesc':$('#wdesc').val(),
			'wowner':$('#wowner').val(),
			'wtel':$('#wtel').val(),
			'wkeywords':$('#keywords').val(),
			'wnum':$('#wnum').val(),
			'wsts':sts,
			'opentime':$('#date1').val(),
			'closetime':$('#date2').val(),
			// 'sfs':sfs,
			// 'waccount':$('#waccount').val(),
			// 'waccountOwner':$('#waccountOwner').val(),
		},
 		async:false,
	 	'beforeSend':function(){ loadi = layer.load("正在提交");},
 		'complete':function(){layer.close(loadi);},
		'success':function(html){
	 		layer.msg('保存成功',2,1);
		}
	});
}


function loadJScript() {
		var map = new BMap.Map("allmap");
		var geoc = new BMap.Geocoder(); 
	map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
	function showInfo(e){
		$('#wsp').val(e.point.lng + ", " + e.point.lat);
	
		geoc.getLocation(e.point, function(rs){
			var addComp = rs.addressComponents;
				$('#address').val(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
		});        
		
	}
	map.addEventListener("click", showInfo);
	}
	
	function disUpdateComment(url){
		$.layer({
		    type: 2,
		    shadeClose: true,
		    title: false,
		    closeBtn: [0, false],
		    shade: [0.8, '#000'],
		    border: [0],
		    offset: ['20px',''],
		    area: [ ($(window).width() - 50) +'px','220px'],
		    iframe: {src: url}
		}); 
	}

	function updateComment(myurl){
		var loadi;
		$.ajax({
			type:'POST',
			url:myurl,
			data:{
		  		'c':$('#comment').val(),
			},
	 		async:false,
	 		'complete':function(){layer.close(loadi);},
			'success':function(html){
		 		layer.msg(html,2,1);
		 		window.setTimeout("closeFrame()",1000);
		 		window.top.location.reload();
			}
		});
	}
		
		
function closeFrame(){
	parent.layer.close(parent.layer.getFrameIndex(window.name));
}


	
function add2Fav(myurl){
$.ajax({
	type:'POST',
	url:myurl,
 	async:false,
	'success':function(html){
 		layer.msg(html,2,1);
	}
});	
}


	
		//添加标注
	function addMarker(map, point, index){
	var myIcon = new BMap.Icon("http://api.map.baidu.com/img/markers.png", new BMap.Size(23, 25), {
	 offset: new BMap.Size(10, 25),
	 imageOffset: new BMap.Size(0, 0 - index * 25)
	});
	var marker = new BMap.Marker(point, {icon: myIcon});
	map.addOverlay(marker);
	return marker;
	}
	

	







