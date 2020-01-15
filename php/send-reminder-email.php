<?php
/**
 * Emerdency - send-reminder-email.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 16/03/2018
 * Time: 20:06
 * Description :
 */

include ("../includes/db_connect.php");
include ("../mail/mail.php");

function sendPatientReminderEmail($practiceName,$dentistName,$address,$date,$time,$email,$patientName,$contactNo,$disAccess){
	$subject = "Appointment Reminder";
	$message = "<p>Hi {$patientName}</p>
				<p>A reminder for your upcoming appointment.<p>
				<p>Your appointment details are as follows: <br/><br/>
					Practice Name:".$practiceName."<br/>
					Dentist Name:  Dr. ".$dentistName."<br/>
					Address: ".$address."<br/>
					Contact No: ".$contactNo."<br/>
					Date: ".$date."<br/>
					Time: ".$time."<br/>
					Wheelchair Access: ";
	if ($disAccess == 1){
		$message.= "Yes</p>";
	} else {
		$message.=  "No</p>";
	}
	$message .= "<ul>
					<li>Please ensure you arrive 10 minutes before the appointment time. The dentist may refuse to see you if you arrive any later than 10 minutes after the appointment time. </li>
					<li>Please ensure you bring with you a full list of the medications you are currently taking, along with any medical cards.</li>
					<li>Please note an interpreter will not be provided.</li>
				</ul>";

	sendMail($email,$subject,$message);
}

function sendDentistReminderEmail($email, $practiceName, $date, $time, $dentistName, $patientName, $minorName, $type, $disAccess){
	$message = "<p>Hi Dr. {$dentistName}</p>
				<p>A reminder for your upcoming appointment.</p>
 				<p>The appointment details are as follows:<br/><br/>
 				Practice Name:".$practiceName."<br/>
 				Date: ".$date."<br/>
 				Time: ".$time."<br/>
 				Patient Name: ";
				if (isset($minorName)){
					$message .= $minorName."<br/>";
				} else {
					$message .= $patientName."<br/>";
				}
 	$message .= "Patient Type: ";
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


	$subject = "Appointment Reminder";
	sendMail($email,$subject,$message);
}

// Find all appointments due in the next 30 minutes (* Gridhosted Limit *)
function findAppointmentsDue(){
	$db = dbConnect();

	$sql = "SELECT id FROM Appointment WHERE start_date > date_add(NOW(),INTERVAL 15 MINUTE) AND start_date <= date_add(NOW(),INTERVAL 30 MINUTE) AND status = 2 AND (type = 0 OR type = 1)";

	$results = $db->query($sql);

	return $results;
}

function retrieveAppointmentDetails ($apptId) {
	$db = dbConnect();

	$appt = array();

	$sql = "SELECT Appointment.start_date, Appointment.type, Appointment.dis_access, Practice.name AS `practiceName`, Practice.address_line_1, Practice.address_line_2, Practice.city, Practice.postcode, Practice.contact_no, Dentist.id AS 'dentistId', 
					Dentist.first_name, Dentist.last_name, Dentist.id AS `dentistId`, Patient.first_name AS p_firstName,Patient.last_name AS p_lastName, Patient.id AS `patientId`, concat(MinorPatient.first_name, ' ', MinorPatient.last_name) AS minorName
				FROM Appointment 
					INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
				INNER JOIN Practice
    				ON Practice.id = PracticeDentist.practice_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
    			INNER JOIN Patient 
    				ON Patient.id = Appointment.patient_id 
    			LEFT OUTER JOIN AppointmentPatientMinor
    				ON AppointmentPatientMinor.id = Appointment.id
    			LEFT OUTER JOIN MinorPatient
    				ON MinorPatient.id = AppointmentPatientMinor.minorPatient_id		
				WHERE Appointment.id = ".$apptId;
	$result = $db->query($sql);

	foreach ($result as $row){
		$patientId = $row["patientId"];
		$patientFirstName = $row["p_firstName"];
		$patientName = $row["p_firstName"].' '.$row["p_lastName"];
		$practiceName = $row["practiceName"];
		$dentistId = $row["dentistId"];
		$dentistName = $row["first_name"]." ".$row["last_name"];
		$minorName = $row["minorName"];
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
		$type = $row["type"];
		$disAccess = $row["disAccess"];
	}
	// Add details to Array
	array_push($appt, $practiceName, $dentistId, $dentistName, $address, $date, $time, $patientName, $patientId, $minorName, $patientFirstName, $type, $disAccess, $contactNo);

	return $appt;
}

function getEmail($id){
	$db = dbConnect();
	$email = "";

	$sql = "SELECT email_address FROM Users WHERE id = {$id}";

	$result = $db->query($sql);

	while ($row = mysqli_fetch_assoc($result)){
		$email = $row["email_address"];
	}
	return $email;
}

function sendReminderEmail($appts){
	// Loop through results
	while ($appt = mysqli_fetch_assoc($appts)) {
		// Get Appt ID
		$apptId = $appt["id"];

		// Get Appt Details
		$appt         = retrieveAppointmentDetails( $apptId );
		$patientFirstName = $appt[9];
		$practiceName = $appt[0];
		$date         = $appt[4];
		$time         = $appt[5];
		$patientName  = $appt[6];
		$minorName    = $appt[8];
		$dentistName  = $appt[2];
		$address      = $appt[3];
		$contactNo    = $appt[12];
		$patientId    = $appt[7];
		$dentistId    = $appt[1];
		$disAccess    = $appt[11];
		$type         = $appt[10];

		$patientEmail = getEmail($patientId);
		$dentistEmail = getEmail($dentistId);

		// Send Emails
		sendDentistReminderEmail($dentistEmail, $practiceName, $date, $time, $dentistName, $patientName, $minorName, $type, $disAccess);
		sendPatientReminderEmail($practiceName,$dentistName,$address,$date,$time,$patientEmail,$patientFirstName,$contactNo,$disAccess);
	}
}

$appts = findAppointmentsDue();

if (mysqli_num_rows($appts) >  0){
	sendReminderEmail($appts);
}