<?php
/**
 * Emerdency-Live - tel-payment-complete.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 15:49
 * Description :
 */

session_start();

require("../includes/db_connect.php");
include ("../mail/mail.php");

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

function bookAppointment($userId,$apptId) {
	$db = dbConnect();
	$patientName = getPatientName($userId);
	$text = "Tel: ".$patientName;
	$sql = "UPDATE `Appointment` SET `patient_id`= '".$userId."', status = 2, text = '{$text}' WHERE `id` = '".$apptId."';";
	$result = $db->query($sql);

	return $result;
}

function retrieveAppointmentDetails ($apptId) {
	$db = dbConnect();

	$appt = array();

	$sql = "SELECT Dentist.id AS 'dentistId', Dentist.first_name, Dentist.last_name, Patient.first_name AS `p_firstName`, Patient.last_name AS `p_lastName`, Patient.contact_no, Appointment.start_date
				FROM Appointment 
					INNER JOIN PracticeDentist 
						ON Appointment.practiceDentist_id = PracticeDentist.id
					INNER JOIN Dentist 
						ON PracticeDentist.dentist_id = Dentist.id
					INNER JOIN Patient
						ON Appointment.patient_id = Patient.id
				WHERE Appointment.id = ".$apptId;
	$result = $db->query($sql);

	foreach ($result as $row){
		$patientFirstName = $row["p_firstName"];
		$patientName = $row["p_firstName"]." ".$row["p_lastName"];
		$dentistId = $row["dentistId"];
		$dentistName = $row["first_name"]." ".$row["last_name"];
		$contactNo = $row["contact_no"];
		// Format Date
		$dateStr = strtotime($row["start_date"]);
		$date = date('l jS F Y',$dateStr);
		$time = date('g:i A',$dateStr);
	}
	// Add details to Array
	array_push($appt, $dentistId, $dentistName, $date, $time, $patientName, $contactNo, $patientFirstName);

	return $appt;
}

function sendBookingConfirmationEmail($userId, $dentistName, $date, $time, $patientName){
	$db = dbConnect();

	$sql = "SELECT email_address FROM Users WHERE id = '".$userId."';";
	$result = $db->query($sql);

	foreach ($result as $row){
		$email = $row["email_address"];
	}

	$subject = "Telephone Booking Confirmation";
	$message = "<p>Hi {$patientName}</p>
				<p>Thank you for booking a telephone consultation with Emerdency.<p>
				<p>Here are details of your telephone consultation: <br/><br/>
					Dentist : Dr. ".$dentistName."<br/>
					Date: ".$date."<br/>
					Time: ".$time."</p>
				<p>The dentist will contact you directly on the contact number you have provided.<br/>Please note the dentist can only give advice on the telephone, prescriptions will not be provided.</p>
				<p>If you have any questions with regards to this appointment, please get in contact with us at info@emerdency.co.uk</p>";

	//sendMail($email,$subject,$message);
	sendMail($email,$subject,$message);
}

function sendDentistEmail($dentistId, $date, $time, $patientName, $contactNo, $dentistName){
	$db = dbConnect();

	$sql = "SELECT email_address FROM Users WHERE id = '".$dentistId."';";
	$result = $db->query($sql);

	foreach ($result as $row){
		$email = $row["email_address"];
	}
	$subject = "Telephone Booking Notification";
	$message = "<p>Hi Dr. ".$dentistName."</p><p>A telephone consultation has been booked.</p>
 				<p>Here are the appointment details:<br/><br/>
 				Date: ".$date."<br/>
 				Time: ".$time."<br/>
 				Patient Name: ".$patientName."<br/>
 				Contact Number: ".$contactNo."</p>";
	sendMail($email,$subject,$message);
}
	// Initialise variables
	$userId = $_SESSION["userId"];
	$apptId = $_SESSION["apptId"];
	bookAppointment($userId,$apptId);
	$appt = retrieveAppointmentDetails($apptId);
	$_SESSION["appt"] = $appt;

	$dentistId = $appt[0];
	$dentistName = $appt[1];
	$date = $appt[2];
	$time = $appt[3];
	$patientName = $appt[4];
	$contactNo = $appt[5];
	$patientFirstName = $appt[6];

	sendBookingConfirmationEmail($userId, $dentistName, $date, $time, $patientFirstName);
	sendDentistEmail($dentistId, $date, $time, $patientName, $contactNo, $dentistName);

	unset($_SESSION["incompleteBooking"]);
	unset($_SESSION["timestamp"]);
	unset($_SESSION["availAppts"]);
	unset($_SESSION["searchParams"]);

	header("Location:../pages/tel-thank-you");

	exit();
