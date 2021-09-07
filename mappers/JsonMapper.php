<?php
	class JsonMapper{
		
		private $no_of_results = 0;
		private $tweets = array();
		
		// add each record to tweets property
		public function Add($response){
			
			foreach ($response['data'] as $data) {
			
				$id = $data['id'];
				$created_at = $data['created_at'];
				$hashtags = array();
				if (isset($data['entities']['hashtags']) ) {
					foreach ($data['entities']['hashtags'] as $tags) {
						array_push($hashtags, $tags['tag']);
					}
				}
				$hashtags = implode(' ',$hashtags);
				$text = $data['text'];
				
				array_push($this->tweets, array('id'=>$id, 'created_at'=>$created_at, 'hashtags'=>$hashtags, 'text'=>$text));
				$this->no_of_results++;
			}
		}
		
		// json output
		public function GetResponse(){
			
			$data = [ 
				'no_of_results' => $this->no_of_results, 
				'data' => $this->tweets
			];
			return $data;
		}
	}
?>