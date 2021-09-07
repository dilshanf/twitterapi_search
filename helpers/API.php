<?php
	class API{
		
		public function __construct(){
		}
		
		// generic function for curl api calls
		public function Call($url){
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$token = getenv('TWITTER_TOKEN');

			$headers = [
				'Authorization: Bearer ' . $token
			];

			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

			$resp = curl_exec($curl);

			curl_close($curl);

			return json_decode($resp, true);
		}
		
	}
?>