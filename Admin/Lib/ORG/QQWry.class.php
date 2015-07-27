<?php
class QQWry{
	private $version;
	private $fp;
	private $chr0;
	private $filepath = 'qqwry.dat';
 
	private static $instance;
 
	public function __construct() {
		/* 打开文件 */
		if( !($this->fp = @fopen($this->filepath, 'rb')) )
			die('Can\'t open qqwry file');
 
		$this->chr0 = chr(0);
 
		/* 获取索引区指针） */
		$tmp = unpack('L2', fread($this->fp, 8));
		$this->start = $tmp[1]; $this->tail = $tmp[2]+1;
	}
 
	public static function singleton() {
		if( !isset(self::$instance) ) {
			$clsname = __CLASS__;
			self::$instance = new $clsname();
		}
		return self::$instance;
	}
 
	public function location( $ip ) {
		if( !is_numeric($ip) )
			$ip = ip2long($ip);
		if( $ip === false ) return false;
		return $this->search( $this->longFormat($ip) );
	}
 
	public function version() {
		if( !isset($this->version) ) {
			$this->version = $this->location(-1);
			preg_match_all('/\d+/', $this->version[1], $match);
			$this->version = implode('.', $match[0]);
		}
		return $this->version;
	}
 
	private function search( $ip ) {
		/* 索引条数 */
		$ptail = ($this->tail - $this->start - 1) / 7;
		$pnums = intval($ptail / 2);
		$pstart = 0;
		/* 索引指针 */
		$pointer = $this->tail - $pnums * 7 - 1;
 
		while( $pointer >= $this->start && $pointer < $this->tail ) {
			fseek($this->fp, $pointer);
			$index = unpack('L2', fread($this->fp, 7).$this->chr0);
			fseek($this->fp, $index[2]);
			$index[3] = unpack('L', fread($this->fp, 4));
 
			$index[3] = $index[3][1];
			$index[4] = $this->longFormat( $index[1] );
			$index[5] = $this->longFormat( $index[3] );
 
			if( $index[4] <= $ip && $ip <= $index[5] ) { // 找到
				/* 获取地址 */
				return $this->getLocation($index[2]);
			}elseif( $index[4] > $ip ) { // 前面
				$ptail = $pnums;
				$pnums = $pstart + ceil(($pnums - $pstart) / 2);
				$pointer = $this->start + $pnums * 7;
			}else{ // 后面
				$pstart = $pnums;
				$pnums += ceil(($ptail - $pnums) / 2);
				$pointer = $this->start + $pnums * 7;
			}
			$index = NULL;
		}
		return NULL;
	}
 
	private function getLocation( $offset ) {
		/* 地址数组，0位国家，1位地区，空则未知地区 */
		$addr = array();
 
		/* 标识符 */
		$tmp = fread($this->fp, 1);
		$index = ord($tmp);
 
		/* 指针（4字节）+标识符（1字节） */
		$offset += 5;
 
		if( $index == 1 ) { // 模式1
			/* 获取跳转地址 */
			$tmp = unpack('L', fread($this->fp, 3).$this->chr0);
 
			/* 开始跳转 */
			fseek($this->fp, $offset = $tmp[1]);
 
			/* 读取地区 */
			for($i = 0; $i < 2; ++$i) {
				/* 获取标识符 */
				$tmp = fread($this->fp, 1);
				$index = ord($tmp);
				if( $index == 1 || $index == 2 ) { // 重定向
					$tmp = unpack('L', fread($this->fp, 3).$this->chr0);
					fseek($this->fp, $tmp[1]);
					$addr[$i] = $this->getStr();
					if( !isset($addr[$i]) ) unset($addr[$i]);
					$offset += 4;
				}elseif( $index == 0 ) { // 没有数据
					break;
				}else {
					$addr[$i] = $tmp . $this->getStr();
					if( !isset($addr[$i]) ) unset($addr[$i]);
					$offset += strlen($addr[$i])+1;
				}
				fseek($this->fp, $offset);
			}
		}elseif( $index == 2 ) { // 模式2
			/* 获取跳转地址 */
			$tmp = unpack('L', fread($this->fp, 3).$this->chr0);
			fseek($this->fp, $tmp[1]);
			$offset += 3;
			/* 读取地区 */
			for($i = 0; $i < 2; ++$i) {
				$addr[$i] = $this->getStr();
				if( !isset($addr[$i]) ) unset($addr[$i]);
				fseek($this->fp, $offset);
			}
		}else{ // 常规模式
			$addr[0] = $tmp;
			/* 读取地区 */
			for($i = 0; $i < 2; ++$i) {
				$addr[$i] .= $this->getStr();
				if( !isset($addr[$i]) ) unset($addr[$i]);
			}
		}
 
		return $addr;
	}
 
	/* 长整数格式化 */
	private function longFormat( $ip ) {
		return $ip + ($ip >= 0 ? -2147483647 : 2147483647);
	}
 
	private function getStr() {
		$str = '';
		while( ($tmp = fread($this->fp, 1)) != $this->chr0 )
			$str .= $tmp;
		return ord($str) < 32 || $str == ' CZ88.NET' ? NULL : $str;
	}
 
	public function __destruct() {
		if( $this->fp ) fclose($this->fp);
	}
}