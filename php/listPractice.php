<?php
/**
 * Emerdency-Live - listPractice.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/04/2018
 * Time: 14:29
 * Description :
 */

function getLetters(){
	$db = dbConnect();
	$sql = "SELECT DISTINCT LEFT(name , 1) as firstCharacter,
  				( SELECT Count(*) FROM Practice WHERE LEFT(name , 1) = firstCharacter ) AS count
			FROM Practice 
				ORDER BY name ASC;";
	$results = $db->query($sql);
	return $results;
}

function getPractices(){
	$db = dbConnect();
	$sql = "SELECT id, name FROM Practice ORDER BY name ASC";
	$results = $db->query($sql);
	return $results;
}

function getPracticesByLetter($letter){
	$db = dbConnect();
	$sql = "SELECT id, name FROM Practice WHERE LEFT(name,1)='{$letter}' ORDER BY name ASC;";
	$results = $db->query($sql);
	return $results;
}
