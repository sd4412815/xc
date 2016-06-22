<?php
class UScore {
	public static function getLevel($score) {
		$rlt = UTool::iniFuncRlt();
		if (!is_numeric($score)) {
			$rlt['data']=array('level'=>0,'next'=>1);
		}
		$level = 0;
		if ($score<300) {
			$rlt['data']=array('level'=>1,'next'=>300);;
		}elseif ($score<800){
			$rlt['data']=array('level'=>2,'next'=>800);
		}elseif ($score<2000){
			$rlt['data']=array('level'=>3,'next'=>2000);
		}elseif ($level<5000){
			$rlt['data']=array('level'=>4,'next'=>5000);
		}elseif ($level<10000){
			$rlt['data']=array('level'=>5,'next'=>10000);
		}else {
			$rlt['data']=array('level'=>7,'next'=>1000000);
		}
		$rlt['status']=true;
		return $rlt;
	}
}

