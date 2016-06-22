/* 多级异步调用
	ajaxStart(your_url,your_function);
	function your_function(rlt){
		ajaxStart(your_url2,your_function2);
		//....
	}

*/

// function ajaxStart(url,  func, params, ajaxType){
// 	if(!arguments[2]) params=null;
// 	if(!arguments[3]) ajaxType='GET';
// 	    if (window.XMLHttpRequest)
// 	    {// code for IE7+, Firefox, Chrome, Opera, Safari
// 	        xmlhttp=new XMLHttpRequest();
// 	    }
// 	    else
// 	    {// code for IE6, IE5
// 	        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
// 	    }
// 	    xmlhttp.onreadystatechange=function()
// 	    {
// 	        if (xmlhttp.readyState==4 && xmlhttp.status==200)
// 	        {
// 	            func(xmlhttp.response);
// 	        }
// 	    }

// 	    xmlhttp.open(ajaxType, url, true);
// 	    xmlhttp.setRequestHeader("Content-length",params.length);
// 	    xmlhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded;charset=UTF-8");
	    
// 	    xmlhttp.send(params);
// 	}

