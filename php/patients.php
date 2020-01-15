<?php
/**
 * Emerdency-Live - patients.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 17/05/2018
 * Time: 15:14
 * Description :
 */

include("../includes/db_connect.php");

function getAllPatients($row){
	$db = dbConnect();
	$sql = "SELECT concat(Patient.first_name, ' ' ,Patient.last_name) AS patientName, Patient.house_no_name, Patient.address_line_1, Patient.address_line_2, Patient.address_line_2, Patient.town_city, Patient.postcode, Patient.dob, Patient.contact_no, Users.email_address, Users.confirmed, Users.`terms-timestamp`, Users.marketing
			FROM Patient
				INNER JOIN Users
    				ON Users.id = Patient.id
			ORDER BY Patient.id DESC
			LIMIT {$row},100";
	$result = $db->query($sql);

	return $result;
}

function getLetters(){
	$db = dbConnect();
	$sql = "SELECT DISTINCT LEFT(first_name , 1) as firstCharacter,
  				( SELECT Count(*) FROM Patient WHERE LEFT(first_name , 1) = firstCharacter ) AS count
			FROM Patient 
				ORDER BY first_name ASC;";
	$results = $db->query($sql);
	return $results;
}

function getPatientsByLetter($row, $letter) {
	$db     = dbConnect();
	$sql    = "SELECT concat(Patient.first_name, ' ' ,Patient.last_name) AS patientName, Patient.house_no_name, Patient.address_line_1, Patient.address_line_2, Patient.town_city, Patient.postcode, Patient.dob, Patient.contact_no, Users.email_address, Users.confirmed, Users.`terms-timestamp`, Users.marketing
			FROM Patient
				INNER JOIN Users
    				ON Users.id = Patient.id
    		WHERE LEFT(first_name,1)='{$letter}'		
			ORDER BY Patient.first_name
			LIMIT {$row},100";
	$result = $db->query( $sql );

	return $result;
}

function getPatientDetailsByEmail($email){
	$db = dbConnect();
	$sql = "SELECT Users.id, Users.email_address, Patient.first_name, Patient.last_name,Patient.house_no_name, Patient.address_line_1, Patient.address_line_2, Patient.town_city, Patient.postcode, Patient.dob, Patient.contact_no
		  	FROM Patient 
		  	INNER JOIN Users
		  		ON Users.id = Patient.id
		  	WHERE Users.email_address = '{$email}';";
	$result = $db->query($sql);

	return $result;
}

function getPatientDetailsById($id){
	$db = dbConnect();
	$sql = "SELECT Users.id, Users.email_address, Patient.first_name, Patient.last_name,Patient.house_no_name, Patient.address_line_1, Patient.address_line_2, Patient.town_city, Patient.postcode, Patient.dob, Patient.contact_no
		  	FROM Patient 
		  	INNER JOIN Users
		  		ON Users.id = Patient.id
		  	WHERE Users.id = '{$id}';";
	$result = $db->query($sql);

	return $result;
}

function editPatient($patientId, $first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address){
	$db = dbConnect();

	$sql = "UPDATE `Patient` SET `first_name`= '{$first_name}',`last_name`= '{$last_name}',`house_no_name`= '{$house_no_name}',`address_line_1`= '{$address_line_1}',`address_line_2`= '{$address_line_2}',`town_city`= '{$town_city}',`postcode`= '{$postcode}',`dob`='{$dob}',`contact_no`='{$contact_no}' WHERE id = {$patientId};";
	$sql .= "UPDATE Users SET email_address = '{$email_address}' WHERE id = {$patientId}";

	$result = $db->multi_query($sql);

	return $result;
}

function getAssociatedMinors($id){
	$db = dbConnect();

	$sql = "SELECT concat(MinorPatient.first_name, ' ',MinorPatient.last_name) AS minorName, MinorPatient.dob 
			FROM MinorPatient 
			WHERE parent_id = $id";

	$result = $db->query($sql);
	return $result;
}

function getAssociatedMinorsById($id){
	$db = dbConnect();

	$sql = "SELECT MinorPatient.first_name, MinorPatient.last_name, MinorPatient.dob 
			FROM MinorPatient 
			WHERE id = $id";

	$result = $db->query($sql);
	return $result;
}

function getAssociatedMinorsByEmail($email){
	$db = dbConnect();

	$sql = "SELECT concat(MinorPatient.first_name, ' ',MinorPatient.last_name) AS minorName, MinorPatient.id
			FROM MinorPatient 
				INNER JOIN Patient 
					ON Patient.id = MinorPatient.parent_id
			  	INNER JOIN Users
			  		ON Users.id = Patient.id	
			WHERE email_address = '{$email}'";
	$result = $db->query($sql);
	return $result;
}

function editMinorPatient($id, $firstName, $lastName, $dob){
	$db = dbConnect();

	$sql = "UPDATE `MinorPatient` SET `first_name`= '{$firstName}',`last_name`= '{$lastName}',`dob`= '{$dob}' WHERE id = {$id} ";

	$result = $db->query($sql);
	return $result;

}