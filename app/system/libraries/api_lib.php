<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_lib{
    public function __construct()
	{
		
	}


	public function post_api(string $url, array $headers=[], array $data=[], $type="php"){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		if(! empty($data)){
			if (in_array('Content-Type: application/json', $headers)) {
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			}else{
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}  
		}
		
		if(! empty($headers)){
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);


		$response = curl_exec($curl);


		if(curl_errno($curl)) {
			if($type=="php"||$type=="PHP"){
				return ['Curl error: ' . curl_error($curl)];
			}elseif($type=="json"||$type=="JSON"){
				return json_encode(['Curl error: ' . curl_error($curl)]);
			}else{
				die("Invalid Type");
			}
			//die('Curl error: ' . curl_error($curl));
		}

		curl_close($curl);
		if($type=="php"||$type=="PHP"){
			return json_decode($response, true);
		}
		elseif($type=="json"||$type=="JSON"){
			return $response;
		}
		else{
			die("Invalid type");
		}
	}

	public function fetch_api(string $urlink){
		$url = $urlink;
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

         $response = curl_exec($ch);

         curl_close($ch);

         $data = json_decode($response, true);
         $ret = ["error"=>"error"];

         if ($data) {
            $ret = $data;
         }

         return $ret;
	}
	
}


?>