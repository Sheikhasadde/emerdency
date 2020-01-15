<?php
/**
 * Emerdency - payment-complete.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 06/03/2018
 * Time: 19:56
 * Description : PayPal redirect to Thank You page
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

function getMinorPatientName($patientId){
	$db = dbConnect();
	$sql = "SELECT first_name,last_name FROM MinorPatient WHERE id = {$patientId}";

	$result = $db->query($sql);
	while ($row = mysqli_fetch_assoc($result)){
		$firstName = $row["first_name"];
		$lastName = $row["last_name"];
	}
	$name = $firstName." ".$lastName;
	return $name;
}


function bookAppointment($userId,$apptId,$disAccess) {
	$db = dbConnect();

	$patientName = getPatientName($userId);
	// Update Appointment row with details
	$sql = "UPDATE `Appointment` SET `patient_id`= '".$userId."', status = 2, text = '{$patientName}', type = 0, dis_access = {$disAccess} WHERE `id` = '".$apptId."';";
	$result = $db->query($sql);

	return $result;
}

function bookAppointmentMinor($patientId,$apptId, $minorId, $disAccess) {
	$db = dbConnect();
	// Get patient name for appointment calendar text
	$patientName = getMinorPatientName($minorId);

	// Create row in AppointmentPatientMinor to link patient and minor to appointment
	$sql = "INSERT INTO AppointmentPatientMinor (id, patient_id, minorPatient_id) VALUES ($apptId, $patientId, $minorId);";
	// Update Appointment row with details
	$sql .= "UPDATE `Appointment` SET `patient_id`= '".$patientId."', status = 2, text = '{$patientName}', type = 1, dis_access = {$disAccess} WHERE `id` = '".$apptId."';";

	$result = $db->multi_query($sql);

	return $result;
}

function retrieveAppointmentDetails ($apptId) {
	$db = dbConnect();
	// Initialise array
	$appt = array();
	// Get value for minor flag
	$minor = $_SESSION["minorId"];
	// If patient is minor get relevant details from DB
	if ($minor){
		$sql = "SELECT Practice.name AS 'practiceName', Practice.address_line_1, Practice.address_line_2, Practice.city, Practice.postcode, Practice.contact_no, Dentist.id AS 'dentistId', 
					Dentist.first_name, Dentist.last_name, MinorPatient.first_name AS `p_firstName`, MinorPatient.last_name AS `p_lastName`,Appointment.start_date, Appointment.dis_access, Patient.first_name AS parent_firstName
				FROM Appointment 
					INNER JOIN PracticeDentist 
						ON Appointment.practiceDentist_id = PracticeDentist.id
					INNER JOIN Practice 
						ON PracticeDentist.practice_id = Practice.id 
					INNER JOIN AppointmentPatientMinor
						ON AppointmentPatientMinor.id = Appointment.id	
					INNER JOIN Dentist 
						ON PracticeDentist.dentist_id = Dentist.id
					INNER JOIN MinorPatient
						ON AppointmentPatientMinor.minorPatient_id = MinorPatient.id
					INNER JOIN Patient
						ON Appointment.patient_id = Patient.id
				WHERE Appointment.id = ".$apptId;
	} else { //Patient is not minor
		$sql = "SELECT Practice.name AS 'practiceName', Practice.address_line_1, Practice.address_line_2, Practice.city, Practice.postcode, Practice.contact_no, Dentist.id AS 'dentistId', 
					Dentist.first_name, Dentist.last_name, Patient.first_name AS `p_firstName`, Patient.last_name AS `p_lastName`,Appointment.start_date, Appointment.dis_access
				FROM Appointment 
					INNER JOIN PracticeDentist 
						ON Appointment.practiceDentist_id = PracticeDentist.id
					INNER JOIN Practice 
						ON PracticeDentist.practice_id = Practice.id 
					INNER JOIN Dentist 
						ON PracticeDentist.dentist_id = Dentist.id
					INNER JOIN Patient
						ON Appointment.patient_id = Patient.id
				WHERE Appointment.id = ".$apptId;
	}
	$result = $db->query($sql);

	while($row = mysqli_fetch_assoc($result)){
		if (isset($row["parent_firstName"])){
			$patientFirstName = $row["parent_firstName"];
		} else {
			$patientFirstName = $row["p_firstName"];
		}
		$patientName = $row["p_firstName"]." ".$row["p_lastName"];
		$practiceName = $row["practiceName"];
		$dentistId = $row["dentistId"];
		$dentistName = $row["first_name"]." ".$row["last_name"];
		// Format Date
		$dateStr = strtotime($row["start_date"]);
		$date = date('l jS F Y',$dateStr);
		$time = date('g:i A',$dateStr);
		$address = $row["address_line_1"];
		if($row["address_line_2"]){
			$address .= ", ".$row["address_line_2"];
		}
		$address .= ", ".$row["city"].", ".$row["postcode"];
		$contactNo = $row["contact_no"];
		$disAccess = $row["dis_access"];
	}
	// Add details to Array
	array_push($appt, $practiceName, $dentistId, $dentistName, $address, $date, $time, $patientName, $contactNo, $disAccess, $patientFirstName);

	return $appt;
}

function sendBookingConfirmationEmail($userId, $practiceName, $dentistName, $address, $date, $time, $contactNo, $disAccess, $patientName){
	$db = dbConnect();

	$sql = "SELECT email_address FROM Users WHERE id = '".$userId."';";
	$result = $db->query($sql);

	foreach ($result as $row){
		$email = $row["email_address"];
	}

	$subject = "Booking Confirmation";
	$message = "<p>Hi {$patientName}</p>
				<p>Thank you for booking an appointment with Emerdency.<p>
				<p>Your appointment details are as follows: <br/><br/>
					Date: ".$date."<br/>
					Time: ".$time."<br/><br/>
					
					Dentist Name:  Dr. ".$dentistName."<br/>
					Practice Name: ".$practiceName."<br/>
					Address: ".$address."<br/>
					Contact No: ".$contactNo."<br/>
					Wheelchair Access: ";
					if ($disAccess == 1){
						$message.= "Yes</p>";
					} else {
						$message.=  "No</p>";
					}
	$message .= "<ul>
					<li>Please ensure you arrive 10 minutes before the appointment time. The dentist may refuse to see you if you arrive any later than 10 minutes after the appointment time. </li>
					<li>Please ensure you bring with you a full list of the medications you are currently taking, along with any medical cards.</li>
					<li>Please note an interpreter will not be provided. </li>
				</ul>";


	//sendMail($email,$subject,$message);
	sendMail($email,$subject,$message);
}

function sendDentistEmail($dentistId, $practiceName, $date, $time, $patientName, $type, $disAccess, $dentistName){
	$db = dbConnect();

	$sql = "SELECT email_address FROM Users WHERE id = '".$dentistId."';";
	$result = $db->query($sql);

	foreach ($result as $row){
		$email = $row["email_address"];
	}
	$subject = "Booking Notification";
	$message = "<p>Hi Dr. {$dentistName}</p>
				<p>An appointment slot has been booked.</p>
 				<p>The appointment details are as follows:<br/><br/>
 				Practice Name: ".$practiceName."<br/>
 				Date: ".$date."<br/>
 				Time: ".$time."<br/>
 				Patient Name: ".$patientName."<br/>
 				Patient Type: ";
				if ($type){
					$message .= "Child<br/>";
				} else{
					$message .= "Adult<br/>";
				}
 	$message .=		"Wheelchair Access: ";
					if ($disAccess == 1){
						$message.= "Yes</p>";
					} else {
						$message.= "No</p>";
					};

	//sendMail($email,$subject,$message);
	sendMail($email,$subject,$message);
}
if ($_SESSION["type"] == 2){
	header("Location:tel-payment-complete.php");
	exit();
} else {
	// Initialise variables
	$patientId = $_SESSION["userId"];
	$apptId = $_SESSION["apptId"];
	$minorId = $_SESSION["minorId"];
	$disAccess = $_SESSION["disAccess"];

// If patient is minor
	if ($minorId){
		bookAppointmentMinor($patientId,$apptId,$minorId, $disAccess);
		$type = "Minor Patient";

	} else { //Patient is not minor, proceed with normal booking
		bookAppointment($patientId,$apptId, $disAccess);
	}
// Get Appt details for email and booking confirmation screen
	$appt = retrieveAppointmentDetails($apptId);
// Store in session for thank you page
	$_SESSION["appt"] = $appt;

// Set variables with data from array
	$practiceName = $appt[0];
	$dentistId = $appt[1];
	$dentistName = $appt[2];
	$address = $appt[3];
	$date = $appt[4];
	$time = $appt[5];
	$patientName = $appt[6];
	$contactNo = $appt[7];
	$disAccess = $appt[8];
	$patientFirstName = $appt[9];

// Send confirmation emails
	sendBookingConfirmationEmail($patientId,$practiceName, $dentistName, $address, $date, $time, $contactNo, $disAccess, $patientFirstName);
	sendDentistEmail($dentistId,$practiceName,$date,$time,$patientName, $type, $disAccess, $dentistName);

// Clear variables that are no longer required
	unset($_SESSION["incompleteBooking"]);
	unset($_SESSION["timestamp"]);
	unset($_SESSION["availAppts"]);
	unset($_SESSION["searchParams"]);

// Redirect user to Thank you page
	header("Location:../pages/thank-you");
	exit();
}