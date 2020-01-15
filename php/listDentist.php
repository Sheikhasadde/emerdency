<?php
/**
 * Emerdency-Live - listDentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/04/2018
 * Time: 15:54
 * Description :
 */

function getLetters(){
	$db = dbConnect();
	$sql = "SELECT DISTINCT LEFT(first_name , 1) as firstCharacter,
  				( SELECT Count(*) FROM Dentist WHERE LEFT(first_name , 1) = firstCharacter ) AS count
			FROM Dentist 
				ORDER BY first_name ASC;";
	$results = $db->query($sql);
	return $results;
}

function getDentistsByLetter($letter){
	$db = dbConnect();
	$sql = "SELECT id, first_name, last_name, rating FROM Dentist WHERE LEFT(first_name,1)='{$letter}' ORDER BY first_name ASC;";
	$results = $db->query($sql);
	return $results;
}

function getDentists(){
	$db = dbConnect();
	$sql = "SELECT Dentist.id, Dentist.first_name, Dentist.last_name, Dentist.rating, Users.confirmed FROM Dentist INNER JOIN Users ON Users.id = Dentist.id ORDER BY first_name ASC;";
	$results = $db->query($sql);
	return $results;
}

function getDentist($practiceId){
	$db = dbConnect();
	if ($practiceId == 0){
		$sql = "SELECT id AS dentistId, first_name, last_name FROM Dentist";
	} else {
		$sql = "SELECT Dentist.id AS dentistId, Dentist.first_name, Dentist.last_name, PracticeDentist.practice_id
                FROM Dentist 
	              INNER JOIN PracticeDentist 
    	            ON PracticeDentist.dentist_id = Dentist.id
                WHERE practice_id = {$practiceId}";
	}

	$results = $db->query($sql);

	return $results;
}
function getPracticesForSelect(){
	$db = dbConnect();
	$sql = "SELECT id, name FROM Practice";
	$result = $db->query($sql);
	return $result;
}
