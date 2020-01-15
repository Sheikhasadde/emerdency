<?php
/**
 * Emerdency-Live - tel-search.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 14:00
 * Description :
 */

include ("includes/db_connect.php");

function performTelSearch(){
	$db = dbConnect();
	$sql = "SELECT Appointment.id, Appointment.start_date, Dentist.id AS 'dentist_id',  Dentist.rating
			FROM Appointment 
				INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id 
    			INNER JOIN Dentist ON PracticeDentist.dentist_id = Dentist.id
			WHERE (Appointment.status = 0 OR Appointment.status = 1) AND Appointment.start_date > NOW() AND Appointment.timestamp <= NOW() AND Appointment.type = 2
			ORDER BY Appointment.start_date ASC
			LIMIT 5";
	$result = $db->query($sql);
	return $result;
}