<?php

require_once(dirname(__FILE__).'/../helpers/API.php');

class TwitterAPI extends API{
  		
	private $output_fields = '&tweet.fields=created_at,entities';
	private $query;
	private $url;
    public function __construct($url, $query){
		$this->url = $url;
		$this->query = $query;
		
        parent::__construct();
    }
  
	// format query params and send to API call function
    public function SearchTweet($next_token){
		$next = '';
		if ($next_token) { $next = '&next_token=' . $next_token; }
		$url = $this->url . '?query=' . $this->query . $this->output_fields . $next;
        return $this->Call($url);
    }
    
}
?>