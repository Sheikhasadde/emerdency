<?php

	include("includes/functions.php");
	include ("mail/mail.php");

	// Search DB for email - Return 1 = exists, 0 = doesn't exist
	function searchEmail($email){ 
		$db = dbConnect();
	
		$sql = "SELECT `email_address` FROM Users WHERE `email_address` = '" . $email . "'";
	
		$result = $db->query($sql);
	
		if ($result->num_rows > 0) {
			$exist = 1;
		} else {
			$exist = 0;
		}
		
		return $exist;
	}
		
	function sendResetEmail($email){	
		$db = dbConnect();
		
		$token = generateToken();
				
		$sql = "UPDATE Users SET `token`='" . $token . "' WHERE `email_address` = '" . $email . "'";

		$result = $db->query($sql);

		$url = 'https://'. $_SERVER['HTTP_HOST'].'/pages/reset-password?token='.$token;
		$subject = "Forgot your password?";
		$message = "<p>You have requested to reset your password to the Emerdency account.</p>
					<p>Please click on the button below to set a new password for your account.</p> 
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
                                margin-bottom: 12.5px;' href='{$url}'>Reset Password</a>";
		return sendMail($email,$subject,$message);

	}
