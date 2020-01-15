<?php
/**
 * Emerdency - registerDentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/03/2018
 * Time: 11:47
 * Description : Function to create Dentist
 */

include("../includes/functions.php");
include ("../mail/mail.php");

function getPracticesForSelect(){
	$db = dbConnect();
	$sql = "SELECT id, name FROM Practice";

	$result = $db->query($sql);

	return $result;
}

function registerDentist($first_name,$last_name,$contactNo,$gdcNo,$telAdvice, $email_address,$password1,$password2){
	$db = dbConnect();

	// Get length of password
	$passwordLen = strLen($password1);

	if ($passwordLen >= 6) {
		if ($password1 == $password2){
			// Hash password
			$password = password_hash($password1,PASSWORD_DEFAULT);
			// Generate tokens
			$token = generateToken();

			$sql = "INSERT INTO Users (`email_address`, `password`, `type`, `token`,`confirmed`) VALUES ('$email_address','$password',2,'$token',0);";
			$sql .= "INSERT INTO Dentist (id, first_name, last_name, contact_no, gdc_no, tel_advice) VALUES ((SELECT id FROM Users WHERE email_address = '$email_address'),'$first_name','$last_name', '$contactNo', $gdcNo, $telAdvice)";
			$result = $db->multi_query($sql);

			if ($result){
				$url = 'http://'. $_SERVER['HTTP_HOST'] ."/pages/dentist-confirm?token=".$token;
			    $subject = "Account Confirmation";
				$message = "<p>Hi Dr. ".$first_name." ".$last_name.", 
							</p>Here are your login details for the dentist portal:<br/>
							Username: ".$email_address." <br/>
							Temporary password: ".$password1."<br/><br/>
							<p>Please click on the button below to confirm and accept our terms and conditions. You will also be able to change your password. <br/>
				            <a style=' width: 30%;
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
                                margin-bottom: 12.5px;' href='{$url}'>Confirm Account</a>
							</p>";

				sendMail($email_address, $subject, $message);

				$error = 1;
			} else { $error = "An error has occurred. Please try again. An account may already exist with the entered email address."; }
		} else {
			$error = "Passwords do not match. Please try again.";
		}
	} else {
		$error = "Password length must be a minimum of 6 characters. Please try again";
	}
	return $error;
}

function assignPractice($email, $practiceId){
	$db = dbConnect();
	$sql = "INSERT INTO PracticeDentist (practice_id, dentist_id) VALUES ($practiceId, (SELECT id FROM Users WHERE email_address = '$email'))";
	$result = $db->query($sql);
	return $result;
}

// Check if Dentist is already assigned to practice
function checkIfPracticeAssigned ($dentistId, $practiceId){
	$db = dbConnect();
	$sql = "SELECT id FROM PracticeDentist WHERE practice_id = {$practiceId} AND dentist_id = {$dentistId};";
	$result = $db->query($sql);
	return $result;
}

function assignPracticeById($dentistId, $practiceId){
	$db = dbConnect();
	$exist = checkIfPracticeAssigned($dentistId, $practiceId);
	if (mysqli_num_rows($exist) > 0){
		$sql = "UPDATE PracticeDentist SET enabled = 0 WHERE dentist_id = {$dentistId} AND practice_id = {$practiceId}";
	} else {
		$sql = "INSERT INTO PracticeDentist (practice_id, dentist_id) VALUES ($practiceId, $dentistId);";
	}
	$result = $db->query($sql);
	return $result;
}