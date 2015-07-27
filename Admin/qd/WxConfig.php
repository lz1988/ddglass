<?php
class WxConfig {
	private $appid;
	private $appsecret;
	public function __construct($appid, $secret) {
		$this->appid = $appid;
		$this->appsecret = $secret;
	}
	public function http_post_data($url, $data = null) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		
		if (! empty ( $data )) {
			curl_setopt ( $curl, CURLOPT_POST, 1 );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
		}
		
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $curl );
		curl_close ( $curl );
		return $output;
	}
	public function get_token() {
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
		$contents = file_get_contents ( $url );
		$contents = stripslashes ( $contents );
		$contents = json_decode ( $contents, true );
		if (isset($contents ["access_token"])) {
			$token = $contents ["access_token"];
			return $token;
		} else {
			return "0";
		}
	}
	public function get_qrcode($mark) {
		$token = $this->get_token ();
		if ($token == "0") {
			return "0";
		}
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token ";
		
		$data = json_encode ( array (
				'action_name' => 'QR_LIMIT_SCENE',
				'action_info' => array (
						'scene' => array (
								'scene_id' => $mark 
						) 
				) 
		) );
		$contents = $this->http_post_data ( $url, $data );
		$contents = json_decode ( $contents, true );
		if (isset($contents ["ticket"])) 

		{
			$ticket = $contents ["ticket"];
			return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
		} else {
			
			return "1";
		}
	}
}

?>