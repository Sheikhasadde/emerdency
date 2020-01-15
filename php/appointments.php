<?php
/**
 * Emerdency-Live - appointments.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 30/04/2018
 * Time: 14:17
 * Description :
 */

include ("../mail/mail.php");
include_once ("../includes/db_connect.php");

function getDetails ($userId) {
	$db = dbConnect();
	$sql = "SELECT Appointment.id AS 'appointmentId', Appointment.start_date, Appointment.type, Appointment.status, Practice.id AS 'practiceId', Practice.name AS 'practiceName', Practice.address_line_1, 
                Practice.address_line_2, Practice.city, Practice.postcode,Practice.contact_no, Dentist.id AS 'DentistId', Dentist.first_name, Dentist.last_name, concat(Patient.first_name, ' ', Patient.last_name) AS patientName, concat(MinorPatient.first_name, ' ', MinorPatient.last_name) AS minorName
                FROM Appointment 
                INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
                INNER JOIN Practice ON PracticeDentist.practice_id = Practice.id 
                INNER JOIN Dentist ON PracticeDentist.dentist_id = Dentist.id
                INNER JOIN Patient ON Appointment.patient_id = Patient.id
                LEFT OUTER JOIN AppointmentPatientMinor ON AppointmentPatientMinor.id = Appointment.id
                LEFT OUTER JOIN  MinorPatient ON MinorPatient.id = AppointmentPatientMinor.minorPatient_id
                WHERE Appointment.patient_id = {$userId} AND (Appointment.status = 2 OR  Appointment.status = 3 || Appointment.status = 4) 
                ORDER BY Appointment.start_date DESC;";
	$results = $db->query( $sql );

	return $results;
}

function getFutureAppointments($dentistId){
	$db = dbConnect();

	$sql = "SELECT Appointment.id AS `appointmentId`, Appointment.start_date, Appointment.type, Appointment.dis_access, Patient.id AS `patientId`, 
	(CASE 
    	WHEN Appointment.type = 1 THEN concat(MinorPatient.first_name, ' ', MinorPatient.last_name)
        ELSE concat(Patient.first_name, ' ', Patient.last_name) END) AS `patientName`, Practice.name AS `practiceName`
    FROM Patient 
    	INNER JOIN Appointment 
    		ON Appointment.patient_id = Patient.id 
    	INNER JOIN PracticeDentist
    	    ON PracticeDentist.id = Appointment.practiceDentist_id	
        INNER JOIN Practice
        	ON Practice.id = PracticeDentist.practice_id
        INNER JOIN Dentist
        	ON Dentist.id = PracticeDentist.dentist_id
        LEFT OUTER JOIN AppointmentPatientMinor
        	ON AppointmentPatientMinor.id = Appointment.id	
        LEFT OUTER JOIN MinorPatient
        	ON MinorPatient.id = AppointmentPatientMinor.minorPatient_id    	
    WHERE Dentist.id = {$dentistId} AND Appointment.status = 2";
	$results = $db->query($sql);

	return $results;
}

function getPatientDetails($patientId){
	$db = dbConnect();
	$sql = "SELECT Patient.first_name, Patient.last_name, Patient.house_no_name, 
			Patient.address_line_1, Patient.address_line_2, Patient.town_city, Patient.postcode, Patient.contact_no, Patient.dob, Patient.type, Users.email_address
			FROM Patient 
				INNER JOIN Users
					ON Patient.id = Users.id
			WHERE Patient.id = {$patientId}";
	$result = $db->query($sql);
	return $result;
}

function getMinorPatientDetails($apptId){
	$db = dbConnect();
	$sql = "SELECT MinorPatient.first_name, MinorPatient.last_name, Patient.house_no_name, 
			Patient.address_line_1, Patient.address_line_2, Patient.town_city, Patient.postcode, Patient.contact_no, MinorPatient.dob, Patient.type, Users.email_address
			FROM Patient 
				INNER JOIN Appointment
					ON Patient.id = Appointment.patient_id
				INNER JOIN AppointmentPatientMinor
					ON AppointmentPatientMinor.id = Appointment.id
				INNER JOIN MinorPatient
					ON MinorPatient.id = AppointmentPatientMinor.minorPatient_id
				INNER JOIN Users
					ON Appointment.patient_id = Users.id
			WHERE Appointment.id = {$apptId}";
	$result = $db->query($sql);
	return $result;
}


function updateStatus($apptId){
	$db = dbConnect();
	$sql = "UPDATE Appointment SET status = 3 WHERE id = {$apptId};";
	$success = $db->query($sql);
	return $success;
}

function sendReviewEmail($apptId,$email){
	$db = dbConnect();
	$sql = "SELECT Patient.first_name, Appointment.type, Practice.name, concat('Dr. ', Dentist.first_name,' ',Dentist.last_name) AS dentistName 
			FROM Appointment INNER JOIN PracticeDentist ON PracticeDentist.id = Appointment.practiceDentist_id 
			INNER JOIN Practice ON Practice.id = PracticeDentist.practice_id 
			INNER JOIN  Dentist ON Dentist.id = PracticeDentist.dentist_id  
			INNER JOIN Patient ON Patient.id = Appointment.patient_id
			WHERE Appointment.id = {$apptId}";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_assoc($result)){
		$patientName = $row["first_name"];
		$practiceName = $row["name"];
		$dentistName = $row["dentistName"];
		$type = $row["type"];
	}
	$reviewId = base64_encode($apptId);
	$url = "http://emerdency.co.uk/pages/leave-review?appointment=".$reviewId;
	switch ($type){
		case 2 :
			$message = "<p>Hi ".$patientName."</p><p>Thank you for attending your telephone consultation with ".$dentistName.".</p><p>Please click the button below to leave a review of the service provided.</p>
    					<a style=' width: 30%;
						    margin-top: 10px;
						    text-align: left;
						    font-size: 14px;
						    text-decoration: none;
						    border: 0px;
						    background-color: #e8541c;
						    color: #fff;
						    padding: 5px 0px 5px 5px;
						    background-image: url(https://emerdency.co.uk/images/arrow.png);
						    background-repeat: no-repeat;
						    background-position: 94%;
						    background-size: 15px;
						    display: inline-block;
						    margin-bottom: 12.5px;' href='{$url}'>Leave Review</a>";
			break;
		default :
			$message = "<p>Hi ".$patientName."</p><p>Thank you for attending your appointment at ".$practiceName."</p><p>Please click the button below to leave a review of the service provided.</p>
    						<a style=' width: 30%;
							    margin-top: 10px;
							    text-align: left;
							    font-size: 14px;
							    text-decoration: none;
							    border: 0px;
							    background-color: #e8541c;
							    color: #fff;
							    padding: 5px 0px 5px 5px;
							    background-image: url(https://emerdency.co.uk/images/arrow.png);
							    background-repeat: no-repeat;
							    background-position: 94%;
							    background-size: 15px;
							    display: inline-block;
							    margin-bottom: 12.5px;' href='{$url}'>Leave Review</a>";
							    break;
	}
	$subject = "Thank you";
	$mail = sendMail($email,$subject,$message);

	return $mail;
}

function getPreviousAppointments($dentistId,$search){
	$db = dbConnect();
	$sql = "SELECT Appointment.id AS `appointmentId`, Appointment.start_date, Appointment.type, Patient.id AS `patientId`, (CASE 
    	WHEN Appointment.type = 1 THEN concat(MinorPatient.first_name, ' ', MinorPatient.last_name)
        ELSE concat(Patient.first_name, ' ', Patient.last_name) END) AS `patientName`, Practice.name AS `practiceName`
    FROM Patient 
    	INNER JOIN Appointment 
    		ON Appointment.patient_id = Patient.id 
    	INNER JOIN PracticeDentist
    		ON PracticeDentist.id = Appointment.practiceDentist_id	
        INNER JOIN Practice
        	ON Practice.id = PracticeDentist.practice_id
        INNER JOIN Dentist
        	ON Dentist.id = PracticeDentist.dentist_id
        LEFT OUTER JOIN AppointmentPatientMinor
        	ON AppointmentPatientMinor.id = Appointment.id	
        LEFT OUTER JOIN MinorPatient
        	ON MinorPatient.id = AppointmentPatientMinor.minorPatient_id    	
    WHERE (Patient.first_name like '%{$search}%' || Patient.last_name like '%{$search}%' || MinorPatient.first_name like '%{$search}%' || MinorPatient.last_name like '%{$search}%') AND Dentist.id = {$dentistId} AND (Appointment.status = 3 OR Appointment.status = 4)
    	ORDER BY Appointment.start_date DESC;";

	$results = $db->query($sql);

	return $results;
}


function getRecentPreviousAppointments($dentistId){
	$db = dbConnect();

	$sql = "SELECT Appointment.id AS `appointmentId`, Appointment.start_date, Appointment.type, Patient.id AS `patientId`, (CASE 
    	WHEN Appointment.type = 1 THEN concat(MinorPatient.first_name, ' ', MinorPatient.last_name)
        ELSE concat(Patient.first_name, ' ', Patient.last_name) END) AS `patientName`, Practice.name AS `practiceName`
    FROM Patient 
    	INNER JOIN Appointment 
    		ON Appointment.patient_id = Patient.id 
    	INNER JOIN PracticeDentist
    		ON PracticeDentist.id = Appointment.practiceDentist_id	
        INNER JOIN Practice
        	ON Practice.id = PracticeDentist.practice_id
        INNER JOIN Dentist
        	ON Dentist.id = PracticeDentist.dentist_id
        	
        LEFT OUTER JOIN AppointmentPatientMinor
        	ON AppointmentPatientMinor.id = Appointment.id	
        LEFT OUTER JOIN MinorPatient
        	ON MinorPatient.id = AppointmentPatientMinor.minorPatient_id    	
    WHERE Dentist.id = {$dentistId} AND (Appointment.status = 3 OR Appointment.status = 4)
    	ORDER BY Appointment.start_date DESC
  		LIMIT 10;";

	$results = $db->query($sql);

	return $results;
}

function getAppointmentDetails($apptId){
	$db = dbConnect();
	$sql = "SELECT Appointment.start_date, Appointment.dis_access, Practice.name
			FROM Appointment
				INNER JOIN PracticeDentist
					ON Appointment.practiceDentist_id = PracticeDentist.id
				INNER JOIN Practice
					ON PracticeDentist.practice_id = Practice.id
			WHERE Appointment.id = {$apptId};";
	$result = $db->query($sql);

	if (mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)){
			$name = $row["name"];
			$dateStr = strtotime($row["start_date"]);
			$date = date('l jS F Y',$dateStr);
			$time = date('g:i A',$dateStr);
			$disAccess = $row["dis_access"];
		}
		$details[] = $name;
		$details[] = $date;
		$details[] = $time;
		$details[] = $disAccess;
	}
	return $details;
}

function getPracticePreviousAppointments($practiceId,$page){
	$db = dbConnect();
	$sql = "SELECT Appointment.id AS `appointmentId`, Appointment.start_date, Appointment.type, Patient.id AS `patientId`, Patient.first_name, Patient.last_name, Practice.name AS `practiceName`, Dentist.first_name, Dentist.last_name
    FROM Patient 
    	INNER JOIN Appointment 
    		ON Appointment.patient_id = Patient.id 
    	INNER JOIN PracticeDentist
    		ON PracticeDentist.id = Appointment.practiceDentist_id	
        INNER JOIN Practice
        	ON Practice.id = PracticeDentist.practice_id
        INNER JOIN Dentist
        	ON Dentist.id = PracticeDentist.dentist_id
    WHERE Practice.id = {$practiceId} AND (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1)
	ORDER BY Appointment.start_date DESC
	LIMIT 0,10";

	$results = $db->query($sql);

	return $results;
}

function getAllFreeAppointments($row){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.status, Appointment.dis_access, Appointment.type, Practice.name, Practice.city, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name
			FROM Appointment
				INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
				INNER JOIN Practice
    				ON Practice.id = PracticeDentist.practice_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 0 OR Appointment.status = 1) AND Appointment.start_date >= NOW() AND (Appointment.type = 0 OR Appointment.type = 1)
			ORDER BY Appointment.start_date ASC
			LIMIT {$row},100;";
	$results = $db->query($sql);

	return $results;
}

function getAllFreeTelAppointments($row){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.status,  concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name
			FROM Appointment
				INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 0 OR Appointment.status = 1) AND Appointment.start_date >= NOW() AND Appointment.type = 2
			ORDER BY Appointment.start_date ASC
			LIMIT {$row},100;";
	$results = $db->query($sql);

	return $results;
}

function getUnbookedAppointments($row){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.type, Appointment.status, Appointment.dis_access, Practice.name, Practice.city, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name
			FROM Appointment
				INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
				INNER JOIN Practice
    				ON Practice.id = PracticeDentist.practice_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 0 OR Appointment.status = 1) AND Appointment.start_date <= NOW() AND Appointment.type = 0
			ORDER BY Appointment.start_date ASC
			LIMIT {$row},100";
	$results = $db->query($sql);

	return $results;
}

function getUnbookedTelAppointments($row){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.status, Appointment.dis_access, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name
			FROM Appointment
				INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 0 OR Appointment.status = 1) AND Appointment.start_date <= NOW() AND Appointment.type = 2
			ORDER BY Appointment.start_date ASC
			LIMIT {$row},100";
	$results = $db->query($sql);

	return $results;
}


function getBookedAppointments($row){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.type, Appointment.status, Appointment.dis_access, Practice.name, Practice.city, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name, concat(Patient.first_name,' ', Patient.last_name) AS patientName, concat(MinorPatient.first_name,' ',MinorPatient.last_name) AS minorPatientName
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
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1)
			ORDER BY Appointment.start_date DESC
			LIMIT {$row},100";

	$results = $db->query($sql);

	return $results;
}

function getBookedTelAppointments($row){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.status, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name, concat(Patient.first_name,' ', Patient.last_name) AS patientName
			FROM Appointment
				INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
    			INNER JOIN Patient 
    				ON Patient.id = Appointment.patient_id 
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Appointment.type = 2
			ORDER BY Appointment.start_date DESC
			LIMIT {$row},100";

	$results = $db->query($sql);

	return $results;
}

function getBookedAppointmentsByDate($date){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.type, Appointment.status, Practice.name, Practice.city, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name, concat(Patient.first_name,' ', Patient.last_name) AS patientName, concat(MinorPatient.first_name,' ',MinorPatient.last_name) AS minorPatientName
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
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1) AND Appointment.start_date >= '{$date}' AND Appointment.start_date < date_add('{$date}', INTERVAL 1 DAY)
			ORDER BY Appointment.start_date ASC";

	$results = $db->query($sql);

	return $results;
}

function getBookedTelAppointmentsByDate($date){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Appointment.status, concat(\"Dr. \", Dentist.first_name, \" \", Dentist.last_name) AS dentist_name, concat(Patient.first_name,' ', Patient.last_name) AS patientName
			FROM Appointment
				INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id
   				INNER JOIN Dentist
    				ON Dentist.id = PracticeDentist.dentist_id
    			INNER JOIN Patient 
    				ON Patient.id = Appointment.patient_id 		
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Appointment.type = 2 AND Appointment.start_date >= '{$date}' AND Appointment.start_date < date_add('{$date}', INTERVAL 1 DAY)
			ORDER BY Appointment.start_date ASC";
	$results = $db->query($sql);

	return $results;
}