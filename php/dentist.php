<?php
/**
 * Emerdency-Live - dentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 30/04/2018
 * Time: 18:22
 * Description :
 */

include_once("../includes/db_connect.php");

function editDentist($dentistId, $firstName, $lastName, $contactNo, $email, $gdcNo){
	$db = dbConnect();
	$sql = "UPDATE `Dentist` SET first_name = '{$firstName}', last_name = '{$lastName}', contact_no = '{$contactNo}', gdc_no = '{$gdcNo}' WHERE `id` = {$dentistId}; UPDATE `Users` SET email_address = '{$email}' WHERE id = {$dentistId}";
	$results = $db->multi_query($sql);

	return $results;
}

function editDentistAdmin($dentistId, $firstName, $lastName, $contactNo, $email, $gdcNo, $telAdvice){
	$db = dbConnect();
	$sql = "UPDATE `Dentist` SET first_name = '{$firstName}', last_name = '{$lastName}', contact_no = '{$contactNo}', gdc_no = '{$gdcNo}', tel_advice = {$telAdvice} WHERE `id` = {$dentistId}; UPDATE `Users` SET email_address = '{$email}' WHERE id = {$dentistId}";
	$results = $db->multi_query($sql);

	return $results;
}


function getDentistDetails($dentistId){
	$db = dbConnect();
	$sql = "SELECT Dentist.first_name, Dentist.last_name, Dentist.contact_no, Dentist.gdc_no, Dentist.tel_advice, Users.email_address, Users.`terms-timestamp`, Users.marketing FROM Dentist INNER JOIN Users ON Users.id = Dentist.id WHERE Dentist.id = {$dentistId}";
	$results = $db->query($sql);

	return $results;
}

function getAssociatedPractices($dentistId) {
	$db = dbConnect();
	$sql = "SELECT Practice.id, Practice.name 
			FROM Practice 
				INNER JOIN PracticeDentist
					ON PracticeDentist.practice_id = Practice.id 
				INNER JOIN Dentist 
					ON Dentist.id = PracticeDentist.dentist_id
			WHERE Dentist.id = {$dentistId} AND PracticeDentist.enabled = 0";
	$results = $db->query($sql);

	return $results;
}
function removeAppointments($practiceId, $dentistId){
	$db = dbConnect();
	$sql = "DELETE FROM `Appointment` WHERE practiceDentist_id = (SELECT id FROM PracticeDentist WHERE practice_id = {$practiceId} AND dentist_id = {$dentistId}) AND (status = 0 OR status = 1)";
	$result = $db->query($sql);

	return $result;
}

function removeDentistPracticeAssociation($practiceId, $dentistId){
	$db = dbConnect();
	// Remove free appointments
	removeAppointments($practiceId,$dentistId);
	$sql = "UPDATE PracticeDentist SET enabled = 1 WHERE practice_id = {$practiceId} AND dentist_id = {$dentistId}";
	$result = $db->query($sql);

	return $result;
}

function getDentistIdByName($dentistName){
	$db = dbConnect();
	$sql = "SELECT id FROM Dentist WHERE concat (Dentist.first_name, ' ' ,Dentist.last_name) = $dentistName";
	$result = $db->query($sql);

	if (mysqli_num_rows($result)>0){
		while ($row = mysqli_fetch_assoc($result)){
			$id = $row["id"];
		}
	}
	return $id;
}
function suspendAccount($email){
	$db = dbConnect();
	$sql = "UPDATE Users SET confirmed = 2 WHERE email_address = '{$email}';";
	$result = $db->query($sql);
	suspendAssocPracticeDentist($email);

	return $result;
}

function removeAppointmentsByPDID($pdId){
	$db = dbConnect();
	$sql = "DELETE FROM `Appointment` WHERE practiceDentist_id = {$pdId} AND (status = 0 OR status = 1)";
	$result = $db->query($sql);

	return $result;
}

function suspendPracticeDentist($id){
	$db = dbConnect();
	$sql = "UPDATE PracticeDentist SET enabled = 1 WHERE id = {$id} ;";
	$result = $db->query($sql);

	return $result;
}

function suspendAssocPracticeDentist($email){
	$db = dbConnect();
	$sql = "SELECT id FROM PracticeDentist WHERE dentist_id = (SELECT id FROM Users WHERE email_address = '{$email}');";
	$result = $db->query($sql);
	if ($result){
		while ($row = mysqli_fetch_assoc($result)){
			$pdId = $row["id"];
			suspendPracticeDentist($pdId);
			removeAppointmentsByPDID($pdId);
		}
	}

	return $result;
}

function reactivateAccount($email){
	$db = dbConnect();
	$sql = "UPDATE Users SET confirmed = 1 WHERE email_address = '{$email}';";
	reactivatePracticeDentist($email);
	$result = $db->query($sql);
	return $result;
}

function reactivatePracticeDentist($email){
	$db = dbConnect();
	$sql = "UPDATE PracticeDentist SET enabled = 0 WHERE dentist_id = (SELECT id FROM Users WHERE email_address = '{$email}');";

	$result = $db->query($sql);
	return $result;
}