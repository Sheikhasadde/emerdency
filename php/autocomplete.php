<?php
/**
 * Emerdency-Live - autocomplete.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/05/2018
 * Time: 10:42
 * Description :
 */

include ("../includes/db_connect.php");

function getAllDentistNames(){
	$db = dbConnect();
	$sql = "SELECT Dentist.id, concat (Dentist.first_name, ' ' ,Dentist.last_name, ' - ', Dentist.gdc_no) AS dentistName FROM Dentist 
				INNER JOIN Users
					ON Users.id = Dentist.id
			WHERE Users.confirmed = 1 AND Users.type = 2";
	$results = $db->query($sql);

	return $results;
}

function getAllPractices(){
	$db = dbConnect();
	$sql = "SELECT id, concat(name, ' - ', city) AS practiceName FROM Practice;";
	$results = $db->query($sql);

	return $results;
}


function outputResults($results){
	$array = array();
	if (mysqli_num_rows($results) > 0){
		while ($row = mysqli_fetch_assoc($results)){
			$array[] = $row;
		}
	}
	return $array;
}
switch ($_GET["type"]){
	case 1 :
		header('Content-Type: application/json');
		$dentists = getAllDentistNames();
		$json = outputResults($dentists);
		print json_encode($json);
		break;
	case 2 :
		header('Content-Type: application/json');
		$practices = getAllPractices();
		$json = outputResults($practices);
		print json_encode($json);
		break;
}

