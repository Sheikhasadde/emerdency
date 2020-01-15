<?php 	
	// require("../includes/functions.php");
	// include ("../mail/mail.php");

	function registerUser($first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address,$password1,$password2, $type, $marketing){
		$db = dbConnect();

		// Get length of password
		$passwordLen = strLen($password1);

		if ($passwordLen >= 6) {
			if ($password1 == $password2){
				// Hash password
				$password = password_hash($password1,PASSWORD_DEFAULT);
				// Generate tokens
				$token = generateToken();

				$sql = "INSERT INTO Users (`email_address`, `password`, `token`,`confirmed`,`type`,`terms-timestamp`, `marketing`) VALUES ('$email_address', '$password' ,'$token',0,1, NOW(), $marketing);";
				$result = $db->query($sql);
				$sql2 = "INSERT INTO Patient (`id`,`first_name`, `last_name`, `house_no_name`, `address_line_1`, `address_line_2`,`town_city`, `postcode`, `dob`, `contact_no`, `type`) 
						VALUES ((SELECT `id` FROM Users WHERE `email_address` = '$email_address'),'$first_name', '$last_name', '$house_no_name', '$address_line_1', 
						'$address_line_2','$town_city', '$postcode', '$dob', '$contact_no', '$type');";
				
				$result = $db->query($sql2);
			
				if ($result){

					sendPatientConfirmationEmail($first_name, $email_address, $password1, $token);
					
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

	function registerMinor($mFirstName,$mLastName,$mDOB,$email_address) {
		$db = dbConnect();
		$sql = "INSERT INTO MinorPatient (parent_id, first_name, last_name, dob) VALUES ((SELECT `id` FROM Users WHERE `email_address` = '$email_address'),  '$mFirstName', '$mLastName', '$mDOB')";
		$result = $db->query($sql);
		return $result;
	}

function getUserId($email_address) {
	$db = dbConnect();

	$sql = "SELECT id FROM Users WHERE email_address = '".$email_address."';";
	$result = $db->query($sql);
	foreach ($result as $row) {
		$userId = $row["id"];
	}
	return $userId;
}

function getEmailAddress($userId) {
	$db = dbConnect();

	$sql = "SELECT email_address FROM Users WHERE id = '".$userId."';";
	$result = $db->query($sql);
	foreach ($result as $row) {
		$email = $row["email_address"];
	}
	return $email;
}

function sendPatientConfirmationEmail($firstName, $email, $password, $token){
	$url = 'http://'. $_SERVER['HTTP_HOST'] . '/pages/register-confirm?token='.$token;
	$subject = "Account Confirmation";
	$message = "<p>Hi ".$firstName."</p><p>Thank you for registering with Emerdency.</p><p>Here are your login details: <br/>Username: ".$email."<br/>Password: ".$password."</p>
				<p>Please click on the button below to confirm your account.<br/>
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
    margin-bottom: 12.5px;
    '
     href='{$url}'>Confirm Account</a></p>";

	sendMail($email,$subject,$message);
}