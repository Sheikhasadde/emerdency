<?php
/**
 * Emerdency-Live - booking-timeout.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 14/06/2018
 * Time: 15:08
 * Description :
 */

include ("availability.php");
include ("search.php");

$userId = $_SESSION["userId"];
$success = clearUserHold($userId);
if ($success){
	unset($_SESSION["errUnavailable"]);
	unset($_SESSION["incompleteBooking"]);
	unset($_SESSION["timestamp"]);
	switch ($_SESSION["apptType"]){
		case "1" :
			// Re-Perform Search and re-direct to search results
			$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
			// Redirect to Search Results
			header("Location:../pages/search-results");
			exit();
			break;
		case "2" :
			header("Location:../tel-search-results");
			exit();
			break;
		case "3" :
			// Re-Perform Search and re-direct to search results
			$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
			// Redirect to Search Results
			header("Location:../pages/search-results");
			exit();
			break;
	}
}