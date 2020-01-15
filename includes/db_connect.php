<?php
	function dbConnect(){
		// $dbServer = '10.169.0.169';
  		// $dbUsername = 'emerdenc_web';
   		// $dbPassword = '?n_qdqBc9C';
		   // $database= 'emerdenc_db';
		$dbServer = 'nba02whlntki5w2p.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
  		$dbUsername = 's2hb541w4qgd4xhy';
   		$dbPassword = 'i0nbrvslkcfjvcxk';
   		$database= 'k6pxm0qh2379fwk3';
		
   		$db = new mysqli($dbServer,$dbUsername, $dbPassword, $database);
    
    	if($db->connect_errno > 0){
        	header("Location: pages/500");
        	exit();
    	}
		return $db;
	}

	// Create DB Connection and Execute Query, return Results
	function executeQuery($sql){
		$db = dbConnect();
		$results = $db->query($sql);
		return $results;
	}