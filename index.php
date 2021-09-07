<?php
	require('helpers\Env.php');
	require('models\TwitterAPI.php');
	include('mappers\TwitterMapper.php');
	include('mappers\JsonMapper.php');
	
	(new Env(__DIR__ . '/.env'))->load();
	
	$query = $_GET["search"];
	if ($query) {
		
		$twitter_service = new TwitterAPI( getenv('TWITTER_API_V2') , $query );
		$mapper = new TwitterMapper();
		$output_mapper = new JsonMapper();
		
		$next_token = '';
		$x = 1;
		
		// limited to 20 x 10 (per api call) results
		while($x <= 20) {
			
			// call twitter API
			$tweets = $twitter_service->SearchTweet($next_token);
			
			// write to db
			$mapper->MapDB($tweets);
			$next_token = $mapper->GetNextToken();
			
			if ($next_token == '') { $x = 999; }
			
			// map response back to client
			$output_mapper->Add($tweets);
			
			$x++;
		}
		
		// get the formatted searched tweets
		$resp = $output_mapper->GetResponse();
		
		echo json_encode ($resp, JSON_UNESCAPED_UNICODE);
	}
	
