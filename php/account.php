<?php
/**
 * Emerdency-Live - account.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 12:21
 * Description :
 */

include_once("../includes/db_connect.php");
include_once ("../mail/mail.php");


function suspendAccount($email){
	$db = dbConnect();
	$sql = "UPDATE Users SET confirmed = 2 WHERE email_address = '{$email}';";
	$result = $db->query($sql);
	return $result;
}

function activateAccount($email){
	$db = dbConnect();
	$sql = "UPDATE Users SET confirmed = 1 WHERE email_address = '{$email}';";
	$result = $db->query($sql);
	return $result;
}

function confirmAccount($email) {
	$db = dbConnect();

	if ($email){
		$token = generateToken();

		$sql = "UPDATE Users SET `confirmed` = 1 , `token` = '$token' WHERE email_address = '".$email."'";

		$result = $db->query($sql);

		if ($result) {
			$sql2 = "SELECT Patient.first_name FROM Patient INNER JOIN Users ON Users.id = Patient.id WHERE Users.email_address = '{$email}';";
			$result2 = $db->query($sql2);
			while ($row = mysqli_fetch_row($result2)){
				$firstName = $row[0];
			}
			$_SESSION["confirmed"] = 1;
			$message = "<p>Hi ".$firstName."</p><p>Thank you for confirming your account.</p><p>You can now book appointments online. If you have any questions, please get in touch with us at info@emerdency.co.uk</p>";
			$subject = "Registration Successful";
			sendMail($email,$subject,$message);
		}
	} else {
		$error = "An error has occurred. Please contact admin@emerdency.com.";
	}
	return $error;
}

function confirmDentistAccount($email, $marketing) {
	$db = dbConnect();

	if ($email){
		$token = generateToken();

		$sql = "UPDATE Users SET `confirmed` = 1 , `token` = '$token', `terms-timestamp` = NOW(), `marketing` = {$marketing} WHERE email_address = '".$email."'";

		$result = $db->query($sql);

		if ($result) {
			$sql2 = "SELECT concat(Dentist.first_name,' ',Dentist.last_name) AS dentistName FROM Dentist INNER JOIN Users ON Users.id = Dentist.id WHERE Users.email_address = '{$email}';";
			$result2 = $db->query($sql2);
			while ($row = mysqli_fetch_row($result2)){
				$dentistName = $row[0];
			}
			$_SESSION["confirmed"] = 1;
			$message = "<p>Hi Dr. ".$dentistName."</p><p>Thank you for confirming your account.</p><p>You are now ready to make online appointments available to the general public and welcome Emerdency patients to your practice. </p>";
			$subject = "Registration Successful";
			sendMail($email,$subject,$message);
		}
	} else {
		$error = "An error has occurred. Please contact admin@emerdency.com.";
	}
	return $error;
}