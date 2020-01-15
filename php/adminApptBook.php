<?php
/**
 * Emerdency-Live - adminApptBook.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/05/2018
 * Time: 16:40
 * Description :
 */

include_once("../includes/db_connect.php");
include_once("../mail/mail.php");

function createAppointment($dentistId, $practiceId, $startDate, $endDate, $disAccess) {
	$db = dbConnect();
	$sql = "INSERT INTO `Appointment`(`practiceDentist_id`, `start_date`, `end_date`, `text`, `timestamp`, `type`, `status`, `dis_access`) 
			VALUES ((SELECT id FROM PracticeDentist WHERE dentist_id = {$dentistId} AND practice_id = {$practiceId}), '{$startDate}', '{$endDate}', 'Created by Admin', DATE_ADD(NOW(), INTERVAL 30 MINUTE), 3, 0, {$disAccess})";
	$result = $db->query($sql);

	return $result;
}

function sendBookingEmail($dentistId, $practiceId, $startDate, $email){
	$db = dbConnect();
	$sql = "SELECT id FROM Appointment WHERE Appointment.practiceDentist_id = (SELECT id AS pdId FROM PracticeDentist WHERE dentist_id = {$dentistId} AND practice_id = {$practiceId}) AND start_date = '{$startDate}' AND type = 3;";
	$result = $db->query($sql);

	while ($row = mysqli_fetch_assoc($result)){
		$id = $row["id"];
	}
	$id64 = base64_encode($id);
	$url = "http://emerdency.co.uk/pages/email-booking-confirmation?id=".$id64;
	$message = "<p>Hi</p><p>We have found an appointment as requested.</p> <p>Please click on the button below to book the appointment. Once the booking is confirmed details of the dental practice and the treating dentist wil be revealed. </p> 
	<a style=' width: 40%;
    margin-top: 10px;
    text-align: left;
    font-size: 14px;
    text-decoration: none;
    border: 0px;
    background-color: #e8541c;
    color: #fff;
    padding: 5px 0px 5px 5px;
    background-image: url(http://emerdency.co.uk/images/arrow.png);
    background-repeat: no-repeat;
    background-position: 94%;
    background-size: 15px;
    display: inline-block;
    margin-bottom: 12.5px;' href='{$url}'>Complete Booking</a>";
	$result2 = sendMail($email, "Booking Request", $message);

	return $result2;
}

function getAppointment($apptId){
	$db = dbConnect();
	$sql = "SELECT start_date, dis_access, type, status FROM Appointment WHERE id = {$apptId};";
	$result = $db->query($sql);

	return $result;
}