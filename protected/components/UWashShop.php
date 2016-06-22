<?php
class UWashShop {
	const ALL_DAY = 0;
	const MORNING = 1;
	const MIDDLE = 2;
	const AFTERNOON = 3;
	const EVENING = 4;
	const NIGHT = 5;
	public static function getTineZoneByType($type) {
		$timeZone = array ();
		switch ($type) {
			case 0 :
				$begin = '00:01';
				$end = "23:59";
				break;
			case 1 :
				$begin = '00:01';
				$end = "12:00";
				break;
			case 2 :
				$begin = '11:00';
				$end = "14:00";
				break;
			case 3 :
				$begin = '13:00';
				$end = "17:00";
				break;
			case 4 :
				$begin = '16:00';
				$end = "19:00";
				break;
			case 5 :
				$begin = '19:00';
				$end = "23:59";
				break;
			default :
				$begin = '00:01';
				$end = "23:59";
				break;
		}
// 		$begin = '00:01';
// 		$end = "23:59";
		return $timeZone = array (
				'begin' => $begin,
				'end' => $end 
		);
	}
	
	/**
	 * 根据车行等级，返回等级字符串
	 *
	 * @param int $level        	
	 * @return string
	 */
	public static function getLevel($level) {
		$levelStr = '';
		switch ($level) {
			case 0 :
				$levelStr = '体验版';
				break;
			case 1 :
				$levelStr = '白银级';
				break;
			case 2 :
				$levelStr = '黄金级';
				break;
			case 3 :
				$levelStr = '钻石级';
				break;
			
			default :
				$levelStr = '体验版';
				;
				break;
		}
		
		return $levelStr;
	}
	public static function getShortUrl($url) {
		return 'http://dwz.cn/' . $url;
	}
	public static function generateShortUrl($url) {
		$rlt = UTool::iniFuncRlt ();
		$curlPostFields = array (
				'url' => $url 
		);
		
		$urlRlt = UTool::curlPost ( 'http://dwz.cn/create.php', $curlPostFields );
		$urlRlt = CJSON::decode ( $urlRlt );
		if ($urlRlt ['status'] != 0) {
			$rlt ['msg'] = $urlRlt ['err_msg'];
		} else {
			$rlt ['status'] = true;
			// $rlt['data']=$urlRlt['tinyurl'];
			
			// $rlt['data'] = substr($rlt['data'], 14);
			$rlt ['data'] = substr ( $urlRlt ['tinyurl'], 14 );
		}
		return $rlt;
		// return CJSON::encode( $rlt);
	}
	
	public static function checkShopState() {
		
// 		WashShop::SHOP_STATE_BLACK,
// 		WashShop::SHOP_STATE_CLOSE,
// 		WashShop::SHOP_STATE_MASK,
// 		WashShop::SHOP_STATE_NORM
		
	} 
	
	
	/**
	 * 根据车行状态，返回状态字符串
	 * 刘长鑫
	 * 20150401
	 *
	 * @param int $state        	
	 * @return string
	 */
	public static function getStatus($state) {
		$statusStr = '';
		
		switch ($state) {
			case 0 :
				$statusStr = '申请中';
				break;
			case 1 :
				$statusStr = '正常';
				break;
			case 2 :
				$statusStr = '考核通过';
				break;
			case - 10 :
				$statusStr = '永久屏蔽';
				break;
			case - 20 :
				$statusStr = '已删除';
				break;
			
			default :
				$statusStr = '临时';
				;
				break;
		}
		
		return $statusStr;
	}
}

?>