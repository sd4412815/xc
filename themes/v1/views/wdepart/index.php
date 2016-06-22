<?php
$this->pageTitle ='测试';

//print_r($a) ;
//echo json_encode($a[0]);
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<input value="测试按钮" type="button" onclick="test()" >
<script type="text/javascript">
function test(){
	   $.ajax({
	            
	            url:"https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=wiNu8gXUpTf5tLkWrusj-hSfP_ZRzp9S26ZX_3Fb05hXCK8FaVxa1n2tPeYHUNliDAvIxpjk6zK16ddpJsMXcg",
	            type:"POST",
	            data:'{"name": "黑龙江","parentid": "1"}',
	            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".        
	            success:function(data){
	              $("#msg").html(decodeURI(data));            
	            }   ,
	            //调用执行后调用的函数
	            complete: function(XMLHttpRequest, textStatus){
	             //  alert(XMLHttpRequest.responseText);
	               //alert(textStatus);
	                //HideLoading();
	            },
	            //调用出错执行的函数
	            error: function(data){
	                //请求出错处理
	                alert(data.status);
	            }         
	         });

	  }
</script>
</body>
</html>