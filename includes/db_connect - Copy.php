<?php
	function dbConnect(){
		$dbServer = '10.169.0.169';
  		$dbUsername = 'emerdenc_web';
   		$dbPassword = '?n_qdqBc9C';
   		$database= 'emerdenc_db';
		
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