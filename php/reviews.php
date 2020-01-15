<?php
/**
 * Emerdency - reviews.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 27/03/2018
 * Time: 13:26
 * Description :
 */

include ("../includes/db_connect.php");

function getDentistReviews(){
	$db = dbConnect();
	$sql = "SELECT DentistReview.id, DentistReview.text, DentistReview.rating, Dentist.id AS `dentistId`, concat(Dentist.first_name,' ', Dentist.last_name) AS `name`, Appointment.start_date, Patient.first_name, Patient.last_name 
            FROM DentistReview 
              INNER JOIN Appointment ON Appointment.id = DentistReview.id 
              INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
              INNER JOIN Dentist ON Dentist.id = PracticeDentist.dentist_id 
              INNER JOIN Patient ON Patient.id = Appointment.patient_id
           WHERE DentistReview.status = 0 
           ORDER BY `Appointment`.`start_date` ASC";

	$result = $db->query($sql);

	return $result;
}

function getApprovedDentistReviews(){
	$db = dbConnect();
	$sql = "SELECT DentistReview.id, DentistReview.text, DentistReview.rating, Dentist.id AS `dentistId`, concat(Dentist.first_name,' ', Dentist.last_name) AS `name`, Appointment.start_date, Patient.first_name, Patient.last_name 
            FROM DentistReview 
              INNER JOIN Appointment ON Appointment.id = DentistReview.id 
              INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
              INNER JOIN Dentist ON Dentist.id = PracticeDentist.dentist_id 
              INNER JOIN Patient ON Patient.id = Appointment.patient_id
           WHERE DentistReview.status = 1 
           ORDER BY `Appointment`.`start_date` ASC";

	$result = $db->query($sql);

	return $result;
}
function getSiteReviews(){
    $db = dbConnect();
    $sql = "SELECT Review.id, Review.text, Review.rating, Practice.name, Appointment.start_date, Patient.first_name, Patient.last_name  
            FROM `Review` INNER JOIN Appointment ON Appointment.id = Review.id 
                INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
              	INNER JOIN Practice ON Practice.id = PracticeDentist.practice_id 
                INNER JOIN Patient ON Patient.id = Appointment.patient_id
            WHERE Review.status = 0 
            ORDER BY `Appointment`.`start_date` ASC";

    $result = $db->query($sql);

    return $result;
}

function getAllSiteReviews(){
	$db = dbConnect();
	$sql = "SELECT Review.id, Review.text, Review.rating, Practice.name, Appointment.start_date, Patient.first_name, Patient.last_name  
            FROM `Review` INNER JOIN Appointment ON Appointment.id = Review.id 
                INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
              	INNER JOIN Practice ON Practice.id = PracticeDentist.practice_id 
                INNER JOIN Patient ON Patient.id = Appointment.patient_id
            WHERE Review.status = 1 
            ORDER BY `Appointment`.`start_date` DESC";

	$result = $db->query($sql);

	return $result;
}

function getAllDentistReviews(){
	$db = dbConnect();
	$sql = "SELECT DentistReview.id, DentistReview.text, DentistReview.rating, Dentist.id AS `dentistId`, Practice.name, Appointment.start_date, Patient.first_name, Patient.last_name 
            FROM DentistReview 
              INNER JOIN Appointment ON Appointment.id = DentistReview.id 
              INNER JOIN Practice ON Practice.id = Appointment.practice_id 
              INNER JOIN Patient ON Patient.id = Appointment.patient_id
           WHERE DentistReview.status = 1 
           ORDER BY `Appointment`.`start_date` DESC";

	$result = $db->query($sql);

	return $result;
}

function approveDentistReview($reviewId){
	$db = dbConnect();

	$sql = "UPDATE DentistReview SET `status`= 1 WHERE `id` = {$reviewId}";

	$result = $db->query($sql);

	return $result;
}

function approveSiteReview($reviewId){
    $db = dbConnect();

    $sql = "UPDATE `Review` SET `status`= 1 WHERE `id` = {$reviewId}";

    $result = $db->query($sql);

    return $result;
}


function declineDentistReview($reviewId){
	$db = dbConnect();

	$sql = "UPDATE DentistReview SET `status`= 2 WHERE `id` = {$reviewId}";

	$result = $db->query($sql);

	return $result;
}

function deleteSiteReview($reviewId){
	$db = dbConnect();

	$sql = "DELETE FROM Review WHERE id = {$reviewId};";

	$result = $db->query($sql);

	return $result;
}

function deleteDentistReview($reviewId){
	$db = dbConnect();

	$sql = "DELETE FROM DentistReview WHERE id = {$reviewId};";

	$result = $db->query($sql);

	return $result;
}

function calculateRatingAvg($dentistId){
	$db = dbConnect();

	$sql = "SELECT AVG (DentistReview.rating) AS average 
			FROM DentistReview 
				INNER JOIN Appointment ON Appointment.id = DentistReview.id 
				INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
				INNER JOIN Dentist ON PracticeDentist.dentist_id = Dentist.id
			WHERE Dentist.id = {$dentistId} AND DentistReview.status = 1 ";

	$result = $db->query($sql);

	while ($row = mysqli_fetch_assoc($result)){
		$avg = $row["average"];
	}
	return $avg;
}

function updateRatingAvg($dentistId){
	// Calculate Average
	$avg = calculateRatingAvg($dentistId);

	$db = dbConnect();
	$sql = "UPDATE Dentist SET rating = {$avg} WHERE id = $dentistId";
	$result = $db->query($sql);

	return $result;
}
