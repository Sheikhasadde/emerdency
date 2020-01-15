<?php
/**
 * Emerdency - booking.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 12/03/2018
 * Time: 12:46
 * Description : Booking Functions
 */

require("../includes/db_connect.php");

function bookAppointment($userId,$apptId) {
	$db = dbConnect();
	$sql = "UPDATE `Appointment` SET `patient_id`= '".$userId."' WHERE `id` = '".$apptId."'";
	$result = $db->query($sql);

	return $result;
}

function retrieveAppointmentDetails ($apptId) {
	$db = dbConnect();

	$appt = array();

	$sql = "SELECT Appointment.id AS 'appointmentId', Appointment.date_time, Practice.id AS 'practiceId', Practice.name AS 'practiceName', Practice.address_line_1, 
				Practice.address_line_2, Practice.city, Practice.postcode, Dentist.id AS 'dentistId', Dentist.first_name, Dentist.last_name 
				FROM Appointment INNER JOIN Practice INNER JOIN Dentist ON Appointment.practice_id = Practice.id WHERE Appointment.id = '".$_SESSION["apptId"]."';";

	$result = $db->query($sql);

	foreach ($result as $row){
		$practiceName = $row["practiceName"];
		$dentistName = $row["firstname"]." ".$row["last_name"];
		// Format Date
		$dateStr = strtotime($row["date_time"]);
		$date = date('l jS F Y',$dateStr);
		$time = date('g:i A',$dateStr);

		$address = $row["address_line_1"]." ".$row["address_line_2"].", ".$row["city"].", ".$row["postcode"]." .";
	}
	// Add details to Array
	array_push($appt, $practiceName, $dentistName, $address, $date, $time);

	return $appt;
}

function sendConfirmationEmail($userId, $practiceName, $dentistName, $address, $date, $time){
	$db = dbConnect();

	$sql = "SELECT email_address FROM User WHERE id = '".$userId."';";
	$result = $db->query($sql);

	foreach ($result as $row){
		$email = $row["email_address"];
		$message = "Thank you for booking an appointment with Emerdency. Your appointment  details are as follows:\r\n\r\nPractice Name:".$practiceName."\r\nDentist Name:  Dr. ".$dentistName."\r\nAddress: ".$address."\r\nDate: ".$date."\r\nTime: ".$time;
		$headers = 'From: Emerdency';
		$mail = mail($email, 'Emerdency - Booking Confirmation', $message, $headers);
	}
}