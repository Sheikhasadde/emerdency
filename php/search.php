<?php

session_start();


$path= "dentist/nnn/mail/mail.php";
require_once("$path");
require_once("../includes/functions.php");


// Notify Admin (via email) of search with no results
function notifyAdmin($postcode, $distance, $disAccess){
	$timeNow = date("Y-m-d H:i");
	$admin = "info@emerdency.co.uk";
	$subject = "Search Notification";
	if ($disAccess == '1') {
		$disAccess = "Yes";
	} else {
		$disAccess = "No";
	}
	$message = "<p>A search was performed at {$timeNow} which yielded no results. The search parameters were: <br/><br/>Postcode: {$postcode}<br/>Distance: {$distance} mi<br/>Wheelchair Access: {$disAccess}</p>";
	sendMail($admin, $subject, $message);
}

function performSearch($searchParams){
	// Initialise array
	$appts = array();

	$postcode = $searchParams[0];
	$distance = $searchParams[1];
	$disAccess = $searchParams[2];

	// Test is postcode valid (RegEx)
	$postcodeValid = isPostcodeValid($postcode);

	// if all input is valid execute search
	if ($postcodeValid) {
		// Execute Search
		$appts = search($postcode, $distance, $disAccess);

		if (count($appts)){
			if ($appts[0] == 2) {
				$appts[0] = "Please enter a valid postcode.";
			}
		} else {
			notifyAdmin($postcode, $distance, $disAccess);
			$appts[0] = "0";
		}
		// input is invalid, set error message
	} else {
		$appts[0] = "Please enter a valid postcode.";
	}

	return $appts;
}

// If form is sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["search"]) {
		$searchParams = array();
		// Get POST data and test input
		// Store input as Session Variables (for keeping search parameters)
		$postcode = testInput($_POST["postcode"]);
		$distance = $_POST["distance"];
		$disAccess = $_POST["disAccess"];

		$searchParams[0] = $postcode;
		$searchParams[1] =  $distance;
		$searchParams[2] = $disAccess;
		$_SESSION["searchParams"] = $searchParams;

		// Perform Search
		$search = performSearch($searchParams);
		$_SESSION["availAppts"] = $search;
		//var_dump($search);
		if ($search){
			header("Location:../pages/search-results");
			exit();
		}
	};
}