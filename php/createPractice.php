<?php
/**
 * Emerdency - createPractice.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 28/03/2018
 * Time: 12:29
 * Description :
 */

require_once ("../includes/db_connect.php");
include_once( "../includes/postcode.php" );

function createPractice ($practiceName,$address1, $address2, $city, $county, $postcode, $contactNo) {
	$db = dbConnect();

	// Get Geocodes for Practice
	$geocodes = getGeocodes($postcode);
	// If valid postcode entered
	if ($geocodes){
		$lat = $geocodes[0];
		$lng = $geocodes[1];

		$sql = "INSERT INTO `Practice` (`name`, `address_line_1`, `address_line_2`, `city`, `state`, `postcode`, `lat`, `lng`, `contact_no`) VALUES ('{$practiceName}', '{$address1}', '{$address2}', '{$city}', '{$county}', '{$postcode}', {$lat} , {$lng}, '{$contactNo}');";

		$result = $db->query($sql);
	} else {
		$result = 0;
	}

	return $result;
}

function editPractice ($practiceId, $practiceName,$address1, $address2, $city, $county, $postcode, $contactNo) {
	$db = dbConnect();

	// Get Geocodes for Practice
	$geocodes = getGeocodes($postcode);
	$lat = $geocodes[0];
	$lng = $geocodes[1];

	$sql = "UPDATE `Practice` SET `name`= '{$practiceName}',`address_line_1`= '{$address1}' ,`address_line_2`= '{$address2}',`city`= '{$city}',`state`= '{$county}', `postcode`= '{$postcode}', `contact_no` = '{$contactNo}' ,`lat`= {$lat} ,`lng`= {$lng} WHERE `id` = {$practiceId}";

	$db->query($sql);

	if (mysqli_affected_rows($db)){
		$success = 1;
	} else {
		$success = 0;
	}
	return $success;
}