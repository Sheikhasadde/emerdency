<?php
/**
 * Emerdency-Live - reports.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 02/05/2018
 * Time: 21:03
 * Description :
 */

include("../includes/db_connect.php");

function getNumOfMonthlyBookingsPractice($practiceId){
	$db = dbConnect();
	$sql = "SELECT COUNT(*) AS count, DATE_FORMAT(Appointment.start_date, \"%b %y\") AS date
			FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1) AND Practice.id = {$practiceId}
				GROUP BY MONTH(Appointment.start_date)";
	$result = $db->query($sql);

	return $result;
}

function getNumOfMonthlyBookingsDentist($dentistId){
	$db = dbConnect();
	$sql = "SELECT COUNT(*) AS count, DATE_FORMAT(Appointment.start_date, \"%b %y\") AS date
			FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Dentist.id = {$dentistId}
				GROUP BY MONTH(Appointment.start_date)";
	$result = $db->query($sql);

	return $result;
}

function getIncomeOfMonthlyBookingsPractice($practiceId){
	$db = dbConnect();
	$price = 15;
	$sql = "SELECT (COUNT(*)) * {$price} AS income, DATE_FORMAT(Appointment.start_date, \"%b %y\") AS date
			FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1) AND Practice.id = {$practiceId}
				GROUP BY MONTH(Appointment.start_date)";
	$result = $db->query($sql);

	$data = array();

	foreach ($result as $row) {
		$data[] = $row;
	}

	return $data;
}
function getNumberOfMonthlyBookingsDentist($dentistId){
	$db = dbConnect();
	$price = 15;
	$telPrice = 15;
	$sql = "SELECT (COUNT(*)) * {$price} AS income, DATE_FORMAT(Appointment.start_date, \"%b %y\") AS date
		  	FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
   			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1) AND Dentist.id = {$dentistId}
            UNION ALL
			SELECT (COUNT(*)) * {$telPrice} AS income, DATE_FORMAT(Appointment.start_date, \"%b %y - Tel\") AS date
		  	FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
   			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Appointment.type = 2 AND Dentist.id = {$dentistId}";
	$result = $db->query($sql);

	$data = array();

	foreach ($result as $row) {
		$data[] = $row;
	}

	return $data;
}

function getIncomeOfMonthlyBookingsDentist($dentistId){
	$db = dbConnect();
	$price = 15;
	$telPrice = 15;
	$sql = "SELECT (COUNT(*)) * {$price} AS income, DATE_FORMAT(Appointment.start_date, \"%b %y\") AS date
		  	FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
   			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Dentist.id = {$dentistId}";
	$result = $db->query($sql);

	$data = array();

	foreach ($result as $row) {
		$data[] = $row;
	}

	return $data;
}

function getNumberOfMonthlyTelBookingsDentist($dentistId){
	$db = dbConnect();
	$price = 15;
	$sql = "SELECT (COUNT(*)) * {$price}, DATE_FORMAT(Appointment.start_date, \"%b %y\") AS date
		  	FROM Appointment
    			INNER JOIN PracticeDentist
    				ON PracticeDentist.id = Appointment.practiceDentist_id	
        		INNER JOIN Practice
        			ON Practice.id = PracticeDentist.practice_id
        		INNER JOIN Dentist
        			ON Dentist.id = PracticeDentist.dentist_id
   			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Appointment.type = 2 AND Dentist.id = {$dentistId}
			GROUP BY MONTH(Appointment.start_date)";
	$result = $db->query($sql);

	$data = array();

	foreach ($result as $row) {
		$data[] = $row;
	}

	return $data;
}

function getPracticeAppointmentsByMonth($date,$practiceId){
	$db = dbConnect();
	$sql = "SELECT Appointment.id AS appointmentId, Appointment.start_date, Appointment.type, Dentist.first_name AS dFirstName, Dentist.last_name as dLastName,Patient.id AS patientId, 
			(CASE WHEN Appointment.type = 1 THEN concat(MinorPatient.first_name, ' ', MinorPatient.last_name)
        		ELSE concat(Patient.first_name, ' ', Patient.last_name) END) AS `patientName`
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
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND (Appointment.type = 0 OR Appointment.type = 1) AND Practice.id = {$practiceId} AND (Appointment.start_date BETWEEN first_day('$date') AND last_day('$date'))";
	$result = $db->query($sql);

	return $result;
}

function getDentistAppointmentsByMonth($date,$dentistId){
	$db = dbConnect();
	$sql = "SELECT Appointment.id AS appointmentId, Appointment.start_date, Appointment.type, Practice.name AS practiceName, Patient.id AS patientId,
			(CASE WHEN Appointment.type = 1 THEN concat(MinorPatient.first_name, ' ', MinorPatient.last_name)
        			ELSE concat(Patient.first_name, ' ', Patient.last_name) END) AS `patientName`
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
			WHERE (Appointment.status = 2 OR Appointment.status = 3 OR Appointment.status = 4) AND Dentist.id = {$dentistId} AND (Appointment.start_date BETWEEN first_day('$date') AND last_day('$date'))";
	$result = $db->query($sql);

	return $result;
}

if ($_GET["practiceId"]){
	header('Content-Type: application/json');
	$practiceId = $_GET["practiceId"];
	$data = getIncomeOfMonthlyBookingsPractice($practiceId);
	print json_encode($data);
}
if ($_GET["dentistId"]){
	header('Content-Type: application/json');
	$dentistId = $_GET["dentistId"];
	$data = getIncomeOfMonthlyBookingsDentist($dentistId);
	print json_encode($data);
}

