<?php

require_once(dirname(__FILE__).'/../helpers/Database.php');

class TwitterPosts extends Database{
  
	protected $table = 'twitter_posts';		
		
    public function __construct(){
        parent::__construct();
    }
  
    public function AddTweet($id, $date_posted, $hashtags, $text){
        return $this->Insert($this->table,array('id'=>$id, 'date_posted'=>$date_posted, 'hashtags'=>$hashtags, 'text'=>$text));
    }
    
}
?>