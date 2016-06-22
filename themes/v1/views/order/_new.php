<?php $this->pageTitle = Yii::app ()->name . ' - 预约'; 
$shopId = 1;

?>
 

 


 		<!-- fullCalendar -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/inc/calendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/inc/calendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/inc/calendar/fullcalendar.min.js" type="text/javascript"></script>

        <div id="site">



























            <section class="section wide-fat hotel-detail">





                <div class="container">	



                    <div class="col-xs-12 col-sm-5">

                        <div class="single-product-gallery">
							<img src="images/shops/1/shop1.jpg" width="450px" height="350px"/>
						
                        </div>



                    </div>



                    <div class="col-xs-12 col-sm-7">

                        <div class="sidebar-holder">

                            <article class="entry-content">
								<div>
                               	 <h2 class="post-title" style="float:left; margin-right:20px;"><a href="#" title="Your Hotel Title Here" id="shop_name"></a></h2>
								 <div><span style="float:left">评价：</span><div id="fixed" style="float:left"></div></div>
								</div>



                                <div class="star-holder ">
									<span class="price" style="margin-right:50px;"><span class="higlight emphasize value" id="aCarCount"></span>可用 / 共<span id="allCarCount"></span></span><!--<br />-->
									<!--<div class="star big" data-score="3">--><!--</div>-->
								</div>
								
                                <!--<div class="star-holder "><div class="star big" data-score="3"></div></div>
-->


                                <div class="rating-area">

									<div class="col-xs-12 col-sm-6">
										<h1>简介</h1>
										<div>
											<p>
												洗车工作看似很简单，但是洗得又快又好又能让顾客满意就不容易了。可是洗车服务又是我们汽车美容店面招揽生意、固定客源的一种最重要的手段。如果说汽车美容行业分为两端的话，洗车就是前端，美容与装饰等就是后端。通过专业、快速的洗车服务会给顾客留下良好的印象，为我们销售其他汽车用品和施工服务奠定良好的信任基础。
											</p>
										</div>
									</div>
                                    <!--<div class="stats">

                                        <i class="fa fa-thumbs-o-up"></i>

                                        <span>3.29</span> average based on <span>127</span> ratings.

                                    </div>
-->
									<div class="col-xs-12 col-sm-6">
										<h1>满意度</h1>
										<div class="bars">
	
											<div class="bar-item" style="margin-bottom:10px;">
	
												<span class="lbl">服务满意度</span>
	
	
	
												<div class="bar"  data-width="80%"></div>
	
											</div>
	
											<div class="bar-item" style="margin-bottom:10px;">
	
												<span class="lbl">洗车满意度</span>
	
	
	
												<div class="bar"  data-width="85%"></div>
	
											</div>
	
											<div class="bar-item">
	
												<span class="lbl">服务金额比例</span>
	
	
	
												<div class="bar"  data-width="95%"></div>
	
											</div>
	
											
										</div>
									</div>

                                    <hr>

                                    <!--<a href="#" class="button wide-fat capital">add to favorite list</a>

                                    <a href="#" class="button green wide-fat capital">book now</a>-->

                                </div>
                            </article>
                        </div>
                    </div>
					<div class="col-xs-12 col-sm-12" style="margin-top:400px;">
						<div class="tab-holder">
							<!-- Nav tabs -->
							<div style="width:100%; background-color:#CCCCCC">
								<h2 style="text-align:center" class="higlight">洗车预定</h2>
							</div>
					

							<div class="tab-content" style="background-color:#F6F6F6">
								<div class="tab-pane active" id="overview">
									<div class="row">
										<div class="col-xs-12 col-sm-5">
											<table>
												<tr>
													<td style="height:50px;">
														<span>请选择车型：</span>
													</td>
													<td>
														<select id="carSelect" class="chosen-select" style="width:190px;" onChange="carTypeChange()">
														  <option value="1">五座及以下小型车</option>
														  <option value="2">SUV或五座以上中型车</option>
														</select>
													</td>
												</tr>
												<tr>
													<td style="height:50px;">
														<span>请选择服务：</span>
													</td>
													<td>
														<select id="serSelect" class="chosen-select" style="width:190px;" onChange="changeDiv(this.value)">
														</select>
													</td>
												</tr>
												<tr>
													<td style="height:50px;">
														<span>请选择员工：</span>
													</td>
													<td>
														<select id="staffSelect" data-placeholder="请选择时间" multiple class="chosen-select" style="width:190px;" onChange="staffChange()">
															<option></option>
														</select>
													</td>
												</tr>
											</table>
										</div>
										<div class="col-xs-12 col-sm-7">
											<div id="serviceNum" style="height:100px; padding-left:20%">
												<table>
													<tr>
														<td style="padding-bottom:4px;">
															已选服务项目:
														</td>
														<td style="padding-left:15px;;">
															<span id="serType"></span>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom:4px;">
															总花费:
														</td>
														<td style="padding-left:15px;">
															<span id="serviceMoney"></span>元
														</td>
													</tr>
													<tr>
														<td style="padding-bottom:4px;;">
															需要时间:
														</td>
														<td style="padding-left:15px;">
															<span id="serviceTime"></span>分
														</td>
													</tr>
													<tr>
														<td style="padding-bottom:4px;">
															洗车开始时间:
														</td>
														<td style="padding-left:15px;">
															<span id="stratSer"></span>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom:4px;">
															已选员工:
														</td>
														<td style="padding-left:15px;">
															<span id="staffed"></span>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
									<!--<h3><a data-toggle="collapse" data-target="#bedroom">选择车型</a></h3>
									<div id="bedroom" class="collapse in">-->
										<!--<p>
											Integer egestas, orci id condimentum eleifend, nibh nisi pulvinar eros, vitae ornare massa neque ut orci. Nam aliquet lectus sed odio eleifend, at iaculis dolor egestas. Nunc elementum pellentesque augue sodales porta. Etiam aliquet rutrum turpis, feugiat sodales ipsum consectetur nec. 
										</p>-->
										<!--<table>
											<tr>
												<td>
													<span>请选择车型：</span>
												</td>
												<td>
													<select id="carSelect" class="form-control" style="width:190px;" onChange="carTypeChange(2)">
													  <option value="1">五座及以下小型车</option>
													  <option value="2">SUV或五座以上中型车</option>
													</select>
												</td>
											</tr>
										</table>-->
									<!--</div>
									<h3><a data-toggle="collapse" data-target="#parking">选择服务</a></h3>
									<div id="parking" class="collapse">
										<div id="serviceTypeDiv">
										</div>
										<div style="text-align:right">
											<a href="javascript:void(0)" class="button capital" onClick="xxx()">确定</a>
										</div>
									</div>-->
									<h3><a data-toggle="collapse" data-target="#gym">选择时间</a></h3>
									<div id="gym" class="collapse">
										<!--<div id="SerTime">
										</div>-->
										<div id="sTim">
											<div id="calendar"></div>
										</div>
										<!--<div style="text-align:right" id="SerBtn">
											<a href="javascript:void(0)" class="button capital" onClick="getStaff()">确定</a>
										</div>-->
									</div>
									<!--<h3><a data-toggle="collapse" data-target="#rczone">选择员工</a></h3>
									<div id="rczone" class="collapse">
										请先选择时间
									</div>-->
									<a href="javascript:void(0)" class="button wide-fat capital" onClick="OrderSub()">确 认 预 约</a>
								</div>
							</div>
						</div>
					</div>
                </div>
            </section>


			


        </div><!-- /#site -->







		<script>
			var r=0;
			var www=[];
			var serviceType;
			var allTimes;
			var serIntervalNum=0;
			var carType=1;
			var allStaff;
			var shop_info;
			var ablCount;
			var ti="";
			var pt="";
			(function() {
				$(".chosen-select").chosen({max_selected_options: 2});
				getData();
				//$('#datetimepicker').datetimepicker();
			}());
			function getData()
			{
				 var par={type:"1",city_id:"1",shop_id:"1"};
				 $.ajax({
					 url: "userSelect.php",  
					 type: "POST",
					 data:par,
					 dataType:"json",
					 error: function(){  
						 alert('Error loading XML document');  
					 },  
					 success: function(data,status){//如果调用php成功   
					 	 serviceType=data[0];
						 shop_info=data[1];
						 ablCount=data[2];
						 $("#aCarCount").html(ablCount.data);
						 $("#allCarCount").html(shop_info.data.ws_count);
						 $("#shop_name").html(shop_info.data.ws_name);
						 $("#shop_name").attr("title",shop_info.data.ws_name);
						 $('#fixed').raty({
						   readOnly:true,
						   start: shop_info.data.ws_score,
						 });
						 carTypeChange();
					 }
				 });
			}
			function carTypeChange()
			{
				$("#serSelect").empty(); 
				$("#staffSelect").empty();
				$("#staffSelect").trigger("chosen:updated");
				var aaa="";
				var carSel=$("#carSelect");
				carType=carSel.val();
				for(var i=0;i<serviceType.data.length;i++)
				{
					if(serviceType.data[i].st_type==carType)
					{ 
						
						$("#serSelect").append("<option value=\""+i+"\">"+serviceType.data[i].st_name+"</option>");
						//sNum++;
						//aaa+="<div id=\"carSelDiv-"+i+"\" www=\""+i+"\" class=\"carSelect higlight\" onClick=\"changeDiv(this.id)\" style=\" border-color:#EAEAEA; border-style:solid; border-width:1px; margin-bottom:10px;cursor:hand; height:50px;\" dType=\"0\">";
//						aaa+=serviceType.data[i].st_name;
//						aaa+="花费"+serviceType.data[i].st_value;
//						aaa+="需要时间"+serviceType.data[i].st_interval_num*20;
//						aaa+="详细信息    ";
//						
//						aaa+="</div>";
 						 //var oOption=document.createElement("OPTION");  
//
//    					 oOption.value=i;  
//
//     					 oOption.text=serviceType.data[i].st_name;  
//
//						 document.getElementById("serSelect").options.add(oOption);
					}
				}
				$("#serSelect").trigger("chosen:updated");
				changeDiv($("#serSelect").val());
				
				//$("#serviceTypeDiv").html(aaa);
				//$("#serType").html("无");
//				$("#serviceMoney").html("0");
//				$("#serviceTime").html("0");
				//setSelCss();
			}
			
			function setSelCss()
			{
				$('.carSelect').mouseover(function(){
					$(this).css({
						'backgroundColor':'#EDEDED',
					});
				});
				$('.carSelect').mouseout(function(){
					if($(this).attr("dType")=="0")
					{
						$(this).css({
							'backgroundColor':'#fff',
						});
					}
				});
			}
			
			function changeDiv(val)
			{
				var allNum=0;
				var allTime=0;
				var allSerType="";
				allNum+=parseInt(serviceType.data[val].st_value);
				allTime+=parseInt(serviceType.data[val].st_interval_num)*20;
				allSerType+=serviceType.data[val].st_name+" ";
				$("#serType").html(allSerType);
				$("#serviceMoney").html(allNum);
				$("#serviceTime").html(allTime);
				serSel();
			}
			function serSel()
			{
				if(r!=0)
				{
					$('#calendar').fullCalendar('removeEventSource',www);
					www=[];
				}
				//$("#calendar").remove();
				//alert($('#calendar').html()+"1111");
//				$('#calendar').fullCalendar('destroy');
//				alert($('#calendar').html()+"2222");
				//$("#sTim").html("<div id=\"calendar\"></div>");
				var cNum=shop_info.data.ws_num;
				var cTime=shop_info.data.ws_count/cNum;
			    $("#staffed").html("暂无");
				$("#stratSer").html("暂无");
				$("#gym").collapse('hide');
				serIntervalNum=Math.ceil(parseInt($("#serviceTime").html())/20);
				var par={type:"2",shop_id:"1",IntervalNum:serIntervalNum,cDate:"0",saState:"true",carNum:cNum};
				$.ajax({
					 url: "userSelect.php",  
					 type: "POST",
					 data:par,
					 dataType:"json",
					 error: function(){  
						 alert('Error loading XML document');  
					 },  
					 success: function(data,status){//如果调用php成功
						allTimes=data;
						if(r==0)
						{
							$('#calendar').fullCalendar({
								minTime:7,
								maxTime:21,
								slotMinutes: 5,
								slotHeigh: 100,
								defaultView:'agendaDay',
								header:false,
								//header: {
									//left: 'prev,next today',
									//center: 'title',
									//right: 'month,agendaWeek,agendaDay'
									//right: 'agendaDay'
								//},
								buttonText: {//This is to add icons to the visible buttons
									//prev: "<span class='fa fa-caret-left'></span>",
									//next: "<span class='fa fa-caret-right'></span>",
									//today: 'today',
								   // month: 'month',
					//                        week: 'week',
									//day: 'day'
								},
								//Random default events
								
								//events:function(start,end,callback)
	//							{
	//								var events=[];
	//								for(var i=1;i<=cTime;i++)
	//								{
	//									for(var j=1;j<=cNum;j++)
	//									{
	//										
	//										var date=allTimes[j].data[i].timeStr;
	//										var y=parseInt(date.split('-')[0]);
	//										var m=parseInt(date.split('-')[1]);
	//										var d=parseInt(date.split('-')[2]);
	//										var startTime=date.split(' ')[1].split('-')[0];
	//										var endTime=date.split(' ')[1].split('-')[1];
	//										var bgc="";
	//										var bdc="";
	//										if(allTimes[j].data[i].available==true)
	//										{
	//											bgc="#6699CC";
	//											bdc="#6699CC";
	//										}
	//										else
	//										{
	//											bgc="#666666";
	//											bdc="#666666";
	//										}
	//										events.push({
	//											id:i+"-"+j,
	//											title: j+"号车位",
	//											start: new Date(y, m-1, d, startTime.split(':')[0], startTime.split(':')[1]),
	//											end: new Date(y, m-1, d, endTime.split(':')[0], endTime.split(':')[1]),
	//											allDay: false,
	//											backgroundColor: bgc, //Info (aqua)
	//											borderColor: bdc //Info (aqua)};
	//										});
	//									}
	//								}
	//								callback(events);
	//							},
								editable: false,
								droppable: true, // this allows things to be dropped onto the calendar !!!
								drop: function(date, allDay) { // this function is called when something is dropped
					
									// retrieve the dropped element's stored Event Object
									var originalEventObject = $(this).data('eventObject');
					
									// we need to copy it, so that multiple events don't have a reference to the same object
									var copiedEventObject = $.extend({}, originalEventObject);
					
									// assign it the date that was reported
									copiedEventObject.start = date;
									copiedEventObject.allDay = allDay;
									copiedEventObject.backgroundColor = $(this).css("background-color");
									copiedEventObject.borderColor = $(this).css("border-color");
					
									// render the event on the calendar
									// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
									$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					
									// is the "remove after drop" checkbox checked?
									if ($('#drop-remove').is(':checked')) {
										// if so, remove the element from the "Draggable Events" list
										$(this).remove();
									}
											
								},
								eventClick: function(event) {  // 定义了点击日历项的动作，这里将会调用jQueryUi的dialog显示日历项的内
									var w=event.id.split('-'); 
									if(allTimes[w[1]].data[w[0]].available==true)
									{
										$("#staffed").html("暂无");
										$("#gym").collapse('hide');
										$("#staffSelect").empty();
										var timer=allTimes[w[1]].data[w[0]].timeStr.split(' ');
										$("#stratSer").html(timer[0]+" "+timer[1].split('-')[0]);
										var par={type:"4",shop_id:"1",timeIndex:w[0],IntervalNum:serIntervalNum,cDate:"0"};
										 $.ajax({
											 url: "userSelect.php",  
											 type: "POST",
											 data:par,
											 dataType:"json",
											 error: function(){  
												 alert('Error loading XML document');  
											 },  
											 success: function(data,status){//如果调用php成功
												allStaff=data;   
												 //aaa="";
												 var bb="";
												 for(var i=0;i<data[1].data.length;i++)
												 {
													for(var j=0;j<data[0].data.length;j++)
													{
														if(data[0].data[j].id==data[1].data[i])
														{
															if(i<=1)
															{
																$("#staffSelect").append("<option selected = \"selected\" value=\""+data[1].data[i]+"\">"+data[0].data[j].s_name+"</option>");
																bb+=data[0].data[j].s_name+"  ";
															}
															else
															{
																$("#staffSelect").append("<option value=\""+data[1].data[i]+"\">"+data[0].data[j].s_name+"</option>");
															}
														}
													}
												 }
												 
												 $("#staffed").html(bb);
												 //$("#selStaff").html(aaa);
						//						 setSelCss();
												$("#staffSelect").trigger("chosen:updated");
											 }
										 });
										 ti=w[0];
										 pt=w[1];
									}
								}
							});
							r++;
						}
					    $("#gym").collapse('show');
						for(var i=1;i<=cTime;i++)
						{
							for(var j=1;j<=cNum;j++)
							{
								
								if(allTimes[j].data[i]!=undefined)
								{
									var date=allTimes[j].data[i].timeStr;
									var y=parseInt(date.split('-')[0]);
									var m=parseInt(date.split('-')[1]);
									var d=parseInt(date.split('-')[2]);
									var startTime=date.split(' ')[1].split('-')[0];
									var endTime=date.split(' ')[1].split('-')[1];
									var bgc="";
									var bdc="";
									if(allTimes[j].data[i].available==true)
									{
										bgc="#6699CC";
										bdc="#6699CC";
									}
									else
									{
										bgc="#666666";
										bdc="#666666";
									}
									www.push({
										id:i+"-"+j,
										title: j+"号车位",
										start: new Date(y, m-1, d, startTime.split(':')[0], startTime.split(':')[1]),
										end: new Date(y, m-1, d, endTime.split(':')[0], endTime.split(':')[1]),
										allDay: false,
										backgroundColor: bgc, //Info (aqua)
										borderColor: bdc //Info (aqua)};
									});
								}
							}
						}
						$('#calendar').fullCalendar('addEventSource',www);
						
                //var date = new Date();
//                var d = date.getDate(),
//                        m = date.getMonth(),
//                        y = date.getFullYear();
//						var asd=[];
//						for(var i=0;i<10;i++)
//						{
//							asd.push({
//								id:i+"-"+i,
//								title: 'asdasd'+i,
//								start: new Date(y, m, d, 13-i, 45),
//								end: new Date(y, m, d, 14+i, 35),
//								allDay: false,
//								backgroundColor: "#00c0ef", //Info (aqua)
//								borderColor: "#00c0ef" //Info (aqua)};
//							});
//						}
//						$('#calendar').fullCalendar('addEventSource',asd);
//						alert("asd");
//						 $('#calendar').fullCalendar('removeEventSource',asd);
//						 
//						 alert("asd2");
//						 asd=[];
//						 for(var i=0;i<20;i++)
//						{
//							asd.push({
//								id:i+"-"+i,
//								title: 'asdasd'+i,
//								start: new Date(y, m, d, 13-i, 45),
//								end: new Date(y, m, d, 14+i, 35),
//								allDay: false,
//								backgroundColor: "#00c0ef", //Info (aqua)
//								borderColor: "#00c0ef" //Info (aqua)};
//							});
//						}
//						$('#calendar').fullCalendar('addEventSource',asd);
//						alert("asd3");
					 }
				 });
				 
			}
			function setIck()
			{
				$('input').iCheck({
				checkboxClass: 'icheckbox_polaris',
				radioClass: 'iradio_polaris',
				increaseArea: '-10' // optional
				  });
				  $('lable').iCheck({
					checkboxClass: 'icheckbox_polaris',
					radioClass: 'iradio_polaris',
					increaseArea: '-10' // optional
				  });
			}
			
			function staffChange()
			{
				alert($("#staffSelect").val());
				//if()
				var staffs=$("#staffSelect").val();
				var bb="";
				if(staffs.length==0)
				{
					$("#staffed").html("暂无");
				}
				else
				{
					for(var i=0;i<staffs.length;i++)
					 {
						for(var j=0;j<allStaff[0].data.length;j++)
						{
							if(allStaff[0].data[j].id==staffs[i])
							{
									bb+=allStaff[0].data[j].s_name+"  ";
							}
						}
					 }
					$("#staffed").html(bb);
				}
			}
			function OrderSub()
			{

				if(ti=="")
				{
					alert("请选择时间段");
					return;
				}
				//alert($("#staffSelect").val().length);
				if($("#staffSelect").val().length!=2)
				{
					alert("请选择至少两位员工");
					return;
				}
				var serTypes=$("#serSelect").val();
				var serMoney=$("#serviceMoney").html();
				var staff1=$("#staffSelect").val()[0];
				var staff2=$("#staffSelect").val()[1];
				var par={type:"6",shop_id:"1",timeIndex:ti,position:pt,IntervalNum:serIntervalNum,order_value:serMoney,order_type:serTypes,staff1_id:staff1,staff2_id:staff2,user_id:"1",cDate:"0"};
				 $.ajax({
					 url: "userSelect.php",  
					 type: "POST",
					 data:par,
					 dataType:"json",
					 error: function(){  
						 alert('Error loading XML document');  
					 },  
					 success: function(data,status){//如果调用php成功
					 	if(data=="OK")
						{
							alert("预约成功！请按时到达！");
						    window.location.href="<?php echo Yii::app()->createUrl('user/profile');?>"; 
						}
						else
						{
							alert("预约失败！请重新预约！");
						}
					 }
				 });
			}
		</script>