<?php
	class interfaceController extends Controller{

		/*添加之前加盟的老板信息到企业号通讯录
		* yuan 2015/09/07
		*/
		public function actionaddall(){		

			// $access_token=UWeixinQYH::getaccess_token();
			// echo $access_token;
			// $Boss=Boss::model()->findAll();
			$User=User::model()->findAll();
			$WashShop=WashShop::model()->findAll();


			for ($i=0; $i <count($User); $i++) { 
		
				$Province=Province::model()->find('id=:id',array(":id"=>$WashShop["$i"]->ws_province_id));
				$City=City::model()->find('id=:id',array(":id"=>$WashShop["$i"]->ws_city_id));
				$Area=Area::model()->find('id=:id',array(":id"=>$WashShop["$i"]->ws_area_id));
				
				$weixin=array(
					"name"=>$User["$i"]->u_nick_name,
					"userid"=>$WashShop["$i"]->id,
					"sex"=>$User["$i"]->u_sex,
					"weixin"=>"  ",
					"tel"=>$User["$i"]->u_tel,
					"e_mail"=>"  ",
					"add"=>$Province->p_name.'/'.$City->c_name.'/'.$Area->a_name,
					"position"=>$WashShop["$i"]->ws_name,
					);

				print_r($weixin);
			}
			
			

			$this->render('yuan',array('$weixin'=>$weixin));

			/*
			if ($re->errcode==0) {
				echo '<div style="margin:0 auto;margin-top:200px;width:200px;height:300px; border:1 solid red;"><p>';
				echo '添加成员成功</p><p>';
				echo '<a href="http://www.woxiche.com">返回首页</a></p></div>';
			}else {
				echo '<div style="margin:0 auto;margin-top:200px;width:200px;height:300px; border:1 solid red;"><p>';
				echo '添加成员失败</p>';
				echo "<p>错误码：".$re->errcode;
				echo '</p><p>如有问题，请联系管理员。</p></div>';
			}*/
		}



		public function actiongetdepartment(){
			$re=UWeixinQYH::getdepartment();
			print_r($re);
			// print_r($re[1]->name);
		}


		public function actiongetarea(){
			$re=UWeixinQYH::addlist();
			print_r($re);
		}


/*
		public function actionyuan(){
			$CopyID="wx02fa1a2147676758";
				//sectect 权限id 可更改
			$Secrect="yMsdQ-r1j4XWr73ABQZdfzjXFb_jORo4IJYYA1GOv7yhoF4IS4WRqDB4rPkuQm6Y";

			$url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".$CopyID."&corpsecret=".$Secrect;
			$r=UWeixinQYH::getUrlContent($url);
			echo $url;
			echo "<br />";
			echo "<br />";
			echo "<br />";
			print_r($r);
			echo "<br />";
			echo "<br />";
			echo "<br />";
			var_dump($r);
		}

*/

		
		public function actionyuanzb(){
			$a=UWeixin::getToken();
			var_dump($a);
		}




	}




?>




