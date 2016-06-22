<?php
/**
 * 项目无关通用php类
 * @author changxinliu
 * 20150831
 */
class UCom {
	const FORMAT_INT = 1;
	
	/**
	 * 检测是否为整数
	 *
	 * @param object $value
	 *        	带检测数值/字符串
	 * @param bool $isPositive
	 *        	是否为正 默认为true
	 * @return boolean 整数 TRUE，否则 FALSE
	 */
	public static function checkInt($value, $isPositive = TRUE) {
		
		// 方法1
		$temp = ( string ) ( int ) $value;
		if ($isPositive && $temp < 1) {
			return FALSE;
		}
		return $temp === ( string ) $value;
		
		// //方法二 正则表达式
		// if ($isPositive){
		// $reg = "/^[1-9][0-9]*$/";
		// }else {
		// $reg = "/^-?[1-9][0-9]*$/";
		// }
		// if (preg_match($reg,$obj)){
		// return TRUE;
		// }else {
		// return FALSE;
		// }
	}
	
	/**
	 * 检测是否时间
	 *
	 * @param object $value        	
	 * @return 是则返回时间戳，否则 FALSE
	 */
	public static function checkDatetime($value) {
		if (UCom::checkInt ( $value )) {
			return ( int ) $value;
		}
		return strtotime ( ( string ) $value );
	}
	
	/**
	 * 获取cookie值
	 *
	 * @param string $cookieName        	
	 * @param int $defaultValue        	
	 * @param bool $isPositive
	 *        	是否为正，默认true
	 * @return int cookieValue
	 */
	static function getCookieInt($cookieName, $defaultValue, $isPositive = TRUE) {
		if (isset ( $_COOKIE [$cookieName] )) {
			$cookieValue = $_COOKIE [$cookieName];
			if ( ! UCom::checkInt ( $cookieValue )) {
				$cookieValue = $defaultValue;
			}
		} else {
			$cookieValue = $defaultValue;
		}
		return $cookieValue;
	}
	
	/**
	 * 返回selected状态字符串
	 *
	 * @param int $currentValue        	
	 * @param int $selectedValue        	
	 * @return string
	 */
	static function selectedStr($currentValue, $selectedValue) {
		return $currentValue == $selectedValue ? 'selected' : '';
	}
	
	/* 返回current状态字符串
	*
	* @param int $currentValue
	* @param int $Value
	* @return string
	*/
	static function currentStr($currentValue, $value) {
		return $currentValue == $value ? 'current' : '';
	}
}

