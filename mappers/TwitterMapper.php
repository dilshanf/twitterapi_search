<?php
	require_once(dirname(__FILE__).'/../models/TwitterPosts.php');
	
	class TwitterMapper{
		
		public $next_token;
		
		// Take the response from service call and map & write to DB table
		public function MapDB($response){
			
			$this->next_token = isset($response['meta']['next_token']) ? $response['meta']['next_token'] : '';	
			$twitter = new TwitterPosts();
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
				
				$twitter->AddTweet($id , $created_at, $hashtags, $text);
				
			}
		}
		
		// return next token for twitter api results page
		public function GetNextToken(){
			return $this->next_token;
		}
	}
?>