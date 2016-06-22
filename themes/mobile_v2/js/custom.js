//function customDropDown(ele) {
//	this.dropdown = ele;
//	this.placeholder = this.dropdown.find(".placeholder");
//	this.options = this.dropdown.find("ul.dropdown-menu > li");
//	this.val = '';
//	this.index = -1;// 默认为-1;
//	this.initEvents();
//}
//customDropDown.prototype = {
//	initEvents : function() {
//		var obj = this;
//		// 这个方法可以不写，因为点击事件被Bootstrap本身就捕获了，显示下面下拉列表
//		obj.dropdown.on("click", function(event) {
//			$(this).toggleClass("active");
//		});
//
//		// 点击下拉列表的选项
//		obj.options.on("click", function() {
//			var opt = $(this);
//			obj.text = opt.find("a").text();
//			obj.val = opt.attr("value");
//			obj.index = opt.index();
//			obj.placeholder.text(obj.text);
//		});
//	},
//	getText : function() {
//		return this.text;
//	},
//	getValue : function() {
//		return this.val;
//	},
//	getIndex : function() {
//		return this.index;
//	}
//}



//加载代码
jQuery(function($) {
	$('[data-toggle="tooltip"]').tooltip();
	notifyFlash();
	$('#sQ').on('keypress', function(event) {
		if (event.keyCode == "13") {
			list_search();
		}
	});
	$("#top-bar").removeClass("loader-inner ball-pulse");
	$("#filter-menu").insertAfter($("#top-bar"));
	$('#filter-menu').css("display", "");

//	$('#sOrder').on("click",function(){showCheckTel();});
	
	
});
// 全部加载后执行代码
$(window).load(function() {

});

// 动画显示通知条后消失
function notifyFlash() {
	$(".notify-flash").show();
	$(".notify-flash").slideUp(2000);
}
// 显示通知条
function notifyShow() {
	$(".notify").show();
}

function udpateOrderService(myurl){
	$.ajax({
		type:'GET',
		url:myurl,
			data:{			
		},
//	 	async:false,
	 	'beforeSend':function(){ },
	 		'complete':function(){},
			'success':function(rlt){
//	 		layer.msg('保存成功',2,1);
	 //		window.top.location.reload();
//	 		$('#sDateList').html(html);
	//window.location.href='".Yii::app()->createUrl('boss/card')."'; 
	 //	$('#svalue').val('');

	}
	});
}




function order_new_ini() {
	set_date_change_ini();
//	set_time_change_ini();
//	set_cartype_change_ini();
}
// 设置日期
function set_date_change_ini() {
	
	$("a[name='sDate']").on("click",function() {
		$('#sdatelist').find('.current').removeClass('current');
		$(this).addClass('current');
		document.cookie = 'sDate=' + $(this).data("value") + ';path=/;expires=60;';

		ajaxUpdateTimelist();
		ajaxUpdatePrice();
	});
}
//设置时间
function set_time_change_ini() {
	//alert("k");

	$("a[name='sTime']").on("click",function() {
		//$('#stimelist').find('.current').removeClass('current');
		$(this).addClass('current');
		document.cookie = 'sTime=' + $(this).data('value') + ';path=/';
		ajaxUpdatePrice();

	});
}
// 设置车型
function set_cartype_change_ini() {
	$("a[name='sCarType']").on("click",function() {
		$('#scartypelist').find('.current').removeClass('current');
		$(this).addClass('current');
		document.cookie = 'sCarType=' + $(this).data('value') + ';path=/;expires= 60';
		ajaxUpdatePrice();
//		$.cookie('sCarType', $(this).data("value"), {
//			expires : 60,
//			path : '/'
//		});
	});
}

// 切换城市
function set_city_ini() {
	$("a[name='cityname']").on("click",function() {
		$('.citylist').find('.current').removeClass('current');
		$(this).addClass('current');
		var cityname = $(this).html()
		$('#current_city').html(cityname);
		$('#current_city_name').html(cityname);
		$.cookie('_ucid', $(this).data('value'), {
			expires : 60,
			path : '/'
		});
		// document.cookie = '_ucid=' + $(this).data('value') + ';path=/';
	});
	$('#current_city').html($('.citylist').find('.current').html());
}

// 更新门店列表
function list_filter() {
	$.fn.yiiListView.update("ajaxList");
}

function list_search() {
	$.cookie('sQ', $('#sQ').val(), {
		expires : 1,
		path : '/'
	});
	list_filter();
	// location.href = "/order/list";
}

function select_service_ini() {
	[].slice.call($("#sTypeList")).forEach(function(el) {
		new SelectFx(el, {
			stickyPlaceholder : false,
			onChange : function(val) {
				document.cookie = 'sType=' + val + ';path=/';
				ajaxUpdateTimelist();
//				ajaxUpdatePrice();
//				$.cookie('sType', val, {
//					expires : 60,
//					path : '/'
//				});
			}
		});
	});
}

// 初始化搜索过滤项
function list_filter_ini() {
	[].slice.call($("#sTypeFilter")).forEach(function(el) {
		new SelectFx(el, {
			stickyPlaceholder : false,
			onChange : function(val) {
				$.cookie('sTypeFilter', val, {
					expires : 60,
					path : '/'
				});
				list_filter();
			}
		});
	});
	[].slice.call($("#sDateFilter")).forEach(function(el) {
		new SelectFx(el, {
			stickyPlaceholder : false,
			onChange : function(val) {
				$.cookie('sDateFilter', val, {
					expires : 60,
					path : '/'
				});
				list_filter();
			}
		});
	});
	[].slice.call($("#sOrderFilter")).forEach(function(el) {
		new SelectFx(el, {
			stickyPlaceholder : false,
			onChange : function(val) {
				$.cookie('sOrderFilter', val, {
					expires : 60,
					path : '/'
				});
				list_filter();
			}
		});
	});
	[].slice.call($("#sTimeFilter")).forEach(function(el) {
		new SelectFx(el, {
			stickyPlaceholder : false,
			onChange : function(val) {
				$.cookie('sTimeFilter', val, {
					expires : 60,
					path : '/'
				});
				list_filter();
			}
		});
	});


}

function iframe_resize(id){
	$("#"+id).load(function(){
		var mainheight = $(this).contents().find("body").height()+30;
		$(this).height(mainheight);
		}); 
}

function showInfoFlash(msg){
	new $.flavr({
	    content     : '<span class=\"h1\"><i class=\"glyphicon glyphicon-ok\"></i></span><br >'+msg,
	    autoclose   : true,
		buttons:false,
		 animateEntrance:'fadeInDown',
		 animateClosing:'fadeOutDown'
		 
	});
}

function showWarning(msg){
	new $.flavr({
	    content     :'<span class=\"h1\"><i class=\"glyphicon glyphicon-remove\"></i></span><br >'+ msg,
	    autoclose   : true,
		buttons:false,
		 animateEntrance:'fadeInDown',
		 animateClosing:'fadeOutDown'
//		buttons:{ close   : { text: '确定',},}
	});
}



