<?php
/**
 * Emerdency-Live - availability.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 23/04/2018
 * Time: 15:05
 * Description :
 */

require("../includes/db_connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/includes/functions.php");

function checkIfAvailable($apptId, $userId){
	$db = dbConnect();
	$sql = "SELECT `timestamp`, `patient_id` FROM Appointment WHERE id = {$apptId}";
	$result = $db->query($sql);
	if ($result){
		while($row = mysqli_fetch_assoc($result)){
			$timestamp = $row["timestamp"];
			$patientId = $row["patient_id"];
		}
		$timeNow = $_SERVER["REQUEST_TIME"];
		$timestampCompare = strtotime($timestamp);
		// Check if timestamp is in future
		if ($timestampCompare > $timeNow){
			// Check if appointment is being held by current user
			if ($patientId == $userId){
				return $timestamp;
			} else {
				return 0;
			}
		} else {
			$_SESSION["incompleteBooking"] = 1;
			// Clear any previous appointments held by user
			clearUserHold($userId);
			// Hold appointment for user
			$timestamp = holdAppointment( $userId, $apptId );
			// Store timestamp in SESSION
			if ($timestamp){
				$_SESSION["timestamp"] = $timestamp;
			}
			return $timestamp;
		}
	}
}

function checkIfAvailableEmail($apptId){
	$db = dbConnect();
	$sql = "SELECT `timestamp` FROM Appointment WHERE id = {$apptId}";
	$result = $db->query($sql);
	if ($result){
		while($row = mysqli_fetch_assoc($result)){
			$timestamp = $row["timestamp"];
		}
		$timestampCompare = strtotime($timestamp);
		$timeNow = $_SERVER["REQUEST_TIME"];
		// Check if timestamp is in future
		if ($timestampCompare  > $timeNow){
			return $timestamp;
		} else {
			return 0;
		}
	}
}


function holdAppointment($userId, $apptId) {
	$db = dbConnect();
	$timeNow = time();
	// Time Now + 10 minutes
	$epoch = $timeNow + 600;
	// Convert to DateTime format
	$timestamp = date( "Y-m-d H:i:s", $epoch );
	// Update Appointment row with timestamp and user id
	$sql    = "UPDATE Appointment SET `timestamp` = '{$timestamp}', `patient_id` = {$userId}, `status` = 1 WHERE id = {$apptId}";
	$result = $db->query( $sql );
	if ( $result ) {
		return $timestamp;
	} else {
		return 0;
	}
}

function clearUserHold($userId){
	$db = dbConnect();
	$sql = "UPDATE Appointment SET `timestamp` = NOW(), `patient_id` = 0 WHERE `timestamp` > NOW() AND `patient_id` = {$userId} AND `status` = 1;";
	$result = $db->query($sql);
	return $result;
}


function hasMinors($userId){
	$db = dbConnect();
	$sql = "SELECT id, first_name, last_name FROM MinorPatient WHERE parent_id = {$userId}";
	$results = $db->query($sql);

	return $results;
}

function getPatientName($patientId){
	$db = dbConnect();
	$sql = "SELECT first_name,last_name FROM Patient WHERE id = {$patientId}";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_assoc($result)){
		$firstName = $row["first_name"];
		$lastName = $row["last_name"];
	}
	$name = $firstName." ".$lastName;
	return $name;
}