// Avoid `console` errors in browsers that lack a console.
(function() {
    "use strict";
    for (var a, e = function() {
    }, b = "assert clear count debug dir dirxml error exception group groupCollapsed groupEnd info log markTimeline profile profileEnd table time timeEnd timeStamp trace warn".split(" "), c = b.length, d = window.console = window.console || {}; c--; )
        a = b[c], d[a] || (d[a] = e);




jQuery(window).ready(function($) {

    // Resize window


    /** 
     * Handle window resizieng on the fly
     * ======================================= */


    var wi = $(window).width();

    $(window).resize(function() {
         $('#mi-nav').height(($('#mi-nav a').length - 1) * ($('#mi-nav a').outerHeight() + parseInt($('#mi-nav a').css('margin-bottom'))));
  
//        var wi = $(window).width();
//
//        var first = '#special-offers';
//        var second = '#mi-slider img';
//
//        $(first).height() > $(second).height() ? $(second).height($(first).height()) : $(first).height($(second).height());


    });


    // Close search hotel from in featured section
    $('.open-close-btn').click(function() {
        if ($('.featured-overlay').hasClass('closed')) {//open it
            $('.opener-area').css('left', '-100px');
            setTimeout(function() {

                $('.featured-overlay').css('left', '0').removeClass('closed');
            }, 300);
        } else {//close it
            $('.featured-overlay').css('left', '-40%').addClass('closed');
            setTimeout(function() {
                $('.opener-area').css('left', '0px');

            }, 300);

        }

    });



});

/* Static Window Width */

jQuery(window).ready(function($) {


    // Static window

    var first1 = '#special-offers';
    var second1 = '#mi-slider img';
    var window_width = $(window).width();
    if (window_width < 9999) {


        $(first1).height() > $(second1).height() ? $(second1).height($(first1).height()) : $(first1).height($(second1).height());

    }


    if ($('.section-amazing-tours').length > 0) {
        $('.section-amazing-tours .items-holder').carouFredSel({
            auto: false,
            responsive: true

        });


        $(".section-amazing-tours  .next").click(function(event) {
            event.preventDefault();
            $('.section-amazing-tours .items-holder').trigger("next", 1);

        });


        $(".section-amazing-tours .previous").click(function(event) {
            event.preventDefault();
            $('.section-amazing-tours .items-holder').trigger("prev", 1);

        });

    }

    if ($('#frame').length > 0) {
        $('#frame').sly({
            scrollBar: $('#scrollBar'),
            dragHandle: 1,
            easing: 'easeOutExpo',
            dragging: 1,
            scrollBy: 20,
            cycleBy: 'items'
        });


    }

    if ($('.single-slider').length > 0) {
        var singlePSlider = $('.single-slider').carouFredSel({
            auto: false

        });

        $(".single-slider-holder .main-slide-nav .next-btn").click(function(event) {
            event.preventDefault();
            $('.single-slider').trigger("next", 1);

        });


        $(".single-slider-holder .main-slide-nav .prev-btn").click(function(event) {
            event.preventDefault();
            $('.single-slider').trigger("prev", 1);

        });



    }

    if ($('.single-slider-thumb-gallery').length > 0) {
        $('.single-slider-thumb-gallery ul').carouFredSel({
            auto: false,
        
            circular: true
        });

        $(".single-slider-thumb-gallery .next-btn").click(function(event) {
            event.preventDefault();
            $('.single-slider-thumb-gallery ul').trigger("next", 1);

        });


        $(".single-slider-thumb-gallery .prev-btn").click(function(event) {
            event.preventDefault();
            $('.single-slider-thumb-gallery ul').trigger("prev", 1);

        });


        $(".single-slider-thumb-gallery .horizontal-gallery-item").click(function(event) {
            event.preventDefault();
           var tid = $(this).attr('href');
          var  targetSlide = $(".single-slider " + tid);

            singlePSlider.trigger('slideTo', targetSlide);

        });



    }
    if ($('.bar-item').length > 0) {
        $('.bar-item').each(function() {
            var bar = $(this).find('.bar');
            var w = bar.attr('data-width');
            bar.append('<div class="pbar" ></div>');
            bar.find('.pbar').delay($(this).index() * 200).animate({
                width: w
            }, 1000, 'easeOutBack');
        });
    }
    if ($("#sliderz").length > 0) {
        $("#sliderz").rangeSlider();
    }


    if ($('#Grid').length > 0) {
        $('#Grid').mixitup();
    }
      
    if ($('.destination-lists').length > 0 &&  $(window).width()>779) {
       
      var $container = $('.destination-lists');
        // initialize
        $container.masonry({
            itemSelector: '.destination'
        });
        
        setTimeout(function(){
            $container.masonry('reloadItems');
        },500);
    }

	  $.datepicker.regional['zh-CN'] = { 
  
  
  
clearText: '清除', clearStatus: '清除已选日期',  
closeText: '关闭', closeStatus: '不改变当前选择',  
prevText: '<上月', prevStatus: '显示上月',  
nextText: '下月>', nextStatus: '显示下月',  
currentText: '今天', currentStatus: '显示本月',  
monthNames: ['一月','二月','三月','四月','五月','六月',  
'七月','八月','九月','十月','十一月','十二月'],  
monthNamesShort: ['一','二','三','四','五','六',  
'七','八','九','十','十一','十二'],  
monthStatus: '选择月份', yearStatus: '选择年份',  
weekHeader: '周', weekStatus: '年内周次',  
dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],  
dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],  
dayNamesMin: ['日','一','二','三','四','五','六'],  
dayStatus: '设置 DD 为一周起始', dateStatus: '选择 m月 d日, DD',  
dateFormat: 'yy-mm-dd', firstDay: 1,  
initStatus: '请选择日期', isRTL: false  
  
  
  }
  
   $.datepicker.setDefaults($.datepicker.regional['zh-CN']);  
	var myDate = new Date();
//myDate.getYear();        //获取当前年份(2位)
//myDate.getFullYear();    //获取完整的年份(4位,1970-????)
//myDate.getMonth();       //获取当前月份(0-11,0代表1月)
//myDate.getDate();        //获取当前日(1-31)
	
	
    if ($('.traveline_date_input').length > 0) {
        jQuery('.traveline_date_input').datepicker({
            dateFormat: 'yy-mm-dd', // Date format http://jqueryui.com/datepicker/#date-formats
	// showButtonPanel: true,
 minDate: 0,
maxDate:6, 
defaultDate:0
        });
		//jQuery( ".traveline_date_input" ).datepicker( "option", "defaultDate", +1 );
	//	$('.traveline_date_input').datepicker('option', 'defaultDate', +7); 
		  $(".traveline_date_input").prop("readOnly", true).datepicker();
		 //  $(".traveline_date_input").datepicker({ showButtonPanel: true });
    }
    if ($('#mi-slider').length > 0) {

        $('#mi-nav').height(($('#mi-nav a').length - 1) * ($('#mi-nav a').outerHeight() + parseInt($('#mi-nav a').css('margin-bottom'))));
        jQuery('#mi-slider').catslider();
        $('#mi-slider ul li').each(function() {
            var el = $(this).find('a');
            var img = el.find('img');
//            el.parent().css('min-width', img.width());
            el.css('background-image', 'url(' + img.attr('src') + ')');
            img.remove();
        });

    }


    if ($('#top-slider').length > 0) {
        jQuery('#top-slider').flexslider({
            animation: "slide"
        });
    }

    if ($('#sliding-testimony').length > 0) {
        jQuery('#sliding-testimony').flexslider({
            animation: "fade",
            controlNav: false
        });
    }





//Rating Star activator
    if ($('.star').length > 0) {
        if ($('.star.big').length > 0) {
            $('.star').raty({
                space: false,
                starOff: 'images/star-big-off.png',
                starOn: 'images/star-big-on.png',
                score: function() {
                    return $(this).attr('data-score');
                }
            });
        } else {
            $('.star').raty({
                space: false,
                starOff: 'images/star-off.png',
                starOn: 'images/star-on.png',
                score: function() {
                    return $(this).attr('data-score');
                }
            });
        }

    }


    var mapCreated = false;
    if ($('.tab-holder').length > 0) {
        $('.nav-tabs a').click(function(e) {
            e.preventDefault();

            $(this).tab('show');
            if ($('.tab-pane.active#map').length > 0) {
                createHotelMap();
                mapCreated = true;
            }
        });

    }

//PlaceHolders controller for input

    $('input,textarea').focus(function() {
        $(this).data('placeholder', $(this).attr('placeholder'))
        $(this).attr('placeholder', '');
    });
    $('input,textarea').blur(function() {
        $(this).attr('placeholder', $(this).data('placeholder'));
    });





    if ($(".custom-checkbox").length > 0) {
        $(".custom-checkbox").screwDefaultButtons({
            image: 'url("images/checkbox.png")',
            width: 16,
            height: 16
        });
    }
    if ($(".hotel-type-filter-widget input:checkbox").length > 0) {
        $(".hotel-type-filter-widget input:checkbox").screwDefaultButtons({
            image: 'url("images/checkbox.png")',
            width: 16,
            height: 16
        });
    }
    if ($(".rating-filter-widget input:checkbox").length > 0) {
        $(".rating-filter-widget input:checkbox").screwDefaultButtons({
            image: 'url("images/checkbox.png")',
            width: 16,
            height: 16
        });
    }


$('.top-drop-menu').change(function() {
        var loc = ($(this).find('option:selected').val());
        window.location = loc;

    });



    
    if ($(".chosen-select").length > 0) {
      $(".chosen-select").chosen({max_selected_options: 5,
  no_results_text: "未找到"
     //   	disable_search_threshold: 10,
     	});
    }
    if ($(".custom-select").length > 0) {
        $(".custom-select").chosen({disable_search_threshold: 10});
    }
    $('.toggle-menu').click(function(e) {
        e.preventDefault();
        var el = $(this);
        el.toggleClass('active');
        if (el.hasClass('active')) {
            $('.toggle-menu-holder .menu-body').removeClass('closed').addClass('opened');

        } else {
            $('.toggle-menu-holder .menu-body').removeClass('opened').addClass('closed');
        }
    });
    
  $('#StyleSwitcher .switcher-btn').click(function () {

    'use strict';

    $('#StyleSwitcher').toggleClass('open');
    return false;
});
$('.color-switch').click(function () {

    'use strict';

    var title = jQuery(this).attr('title');
    jQuery('#color-switch').attr('href', 'css/colors/' + title + '.css');
    return false;
});

			
});

$(window).bind("load", function() {
  $('#status').fadeOut(); // will first fade out the loading animation
			$('#preloader').delay(1000).fadeOut('slow'); // will fade out the white DIV that covers the website.
			$('body').delay(1000).css({'overflow-x':'hidden'}).css({'overflow-y':'auto'});
});

})();

var switcher='<div class="color-switcher"><form id="switchform"><select name="switchcontrol" size="1" onChange="chooseStyle(this.options[this.selectedIndex].value, 60)"><option value="none" selected="selected">Default style</option><option value="02">Style 02</option><option value="03">Style 03</option><option value="04">Style 04</option><option value="05">Style 05</option><option value="06">Style 06</option><option value="07">Style 07</option><option value="08">Style 08</option><option value="09">Style 09</option><option value="10">Style 10</option><option value="11">Style 11</option><option value="12">Style 12</option><option value="13">Style 13</option><option value="14">Style 14</option><option value="15">Style 15</option></select></form>    </div>';
$('body').append('<a class="goto-top" href="#gotop"></a>');

$('.switcher-colors a').click(function(e){
e.preventDefault();
var title=$(this).attr('title');

chooseStyle(title,60);
});

$('.goto-top').click(function(e){
e.preventDefault();
 $('html,body').animate({
          scrollTop: 0
        }, 2000);
});

// Sticky Nav
$(window).scroll(function(e) {
    var nav_anchor = $("#header");
     var gotop = $(document);

 if ($(this).scrollTop() >= gotop.height()/2) {
    $('.goto-top').css({'opacity':1});
 }else if ($(this).scrollTop() < gotop.height()/2)
 {
      $('.goto-top').css({'opacity':0});
 }
    if ($(this).scrollTop() >= nav_anchor.height() && nav_anchor.css('position') != 'fixed' && !nav_anchor.hasClass('fixed-menu')) 
    {    
        nav_anchor.css({
            'position': 'fixed',
            'top': '-200px'
        });
           setTimeout(function(){
               
                 nav_anchor.addClass('splited');
           },200);     
              

        
    } 
    else if ($(this).scrollTop() < nav_anchor.height() && nav_anchor.css('position') != 'relative' && !nav_anchor.hasClass('fixed-menu')) 
    {   

     

        nav_anchor.css({
            
              'top': '0px'
        });
        
        
         setTimeout(function(){
               
                 nav_anchor.css({
            'position': 'relative'
        }).removeClass('splited');
           },200);  
    }
});



