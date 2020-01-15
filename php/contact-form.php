<?php
/**
 * Emerdency - contact.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/04/2018
 * Time: 11:50
 * Description :
 */

include_once("mail/mail.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST['searchContact']){
		if ($_POST["type"] == "tel"){
			echo "tel";
			$contactNo = $_POST["contactNo"];
			$email = $_POST["email"];
			contactEmerdencySearchTel($contactNo, $email);
			header("Location:pages/contact-thank-you");
			exit;
		} else {
			$contactNo = $_POST["contactNo"];
			$email = $_POST["email"];
			$postcode = $_POST["postcode"];
			$distance = $_POST["distance"];
			$disAccess = $_POST["disAccess"];
			contactEmerdencySearch($contactNo, $email, $postcode,$distance,$disAccess);
			header("Location:pages/contact-thank-you");
			exit;
		}
	}
}

function contactEmerdency($reason, $name, $email, $contact, $message) {
	//$contactEmail = "info@emerdency.co.uk";
	$contactEmail = "am@aamirmadari.com";
	$subject = "Website - " .$reason;
	$message = nl2br($message);
	$text = "<p>A contact form has been submitted:  <br/><br/>
				Name: {$name} <br/>
				Email Address: {$email} <br/>
				Contact Number: {$contact} <br/>
				Message: {$message} <br/>
			</p>";
	return sendMail($contactEmail,$subject, $text);
}

function contactEmerdencySearch($contactNo, $email, $postcode,$distance,$disAccess) {
	$timeNow = date("Y-m-d H:i");
	$contactEmail = "info@emerdency.co.uk";
	$subject = "Appointment Request";
	if ($disAccess == '1') {
		$disAccess = "Yes";
	} else {
		$disAccess = "No";
	}
	$text = "<p>A search was performed at {$timeNow} which yielded no results. The search parameters were: <br/><br/>
				Postcode: {$postcode} <br/>
				Distance: {$distance} mi<br/>
				Wheel Chair Access: {$disAccess}
			</p>
			<p>Contact Details:</p>
			Phone Number: {$contactNo} <br/>
			Email Address: {$email} <br/>";
	return sendMail($contactEmail,$subject, $text);
}

function contactEmerdencySearchTel($contactNo, $email) {
	$timeNow = date("Y-m-d H:i");
	$contactEmail = "info@emerdency.co.uk";
	$subject = "Telephone Appointment Request";
	$text = "<p>A telephone booking search was performed at {$timeNow} which yielded no results. The contact details are: <br/><br/>
				Phone Number: {$contactNo} <br/>
				Email Address: {$email} <br/>
			</p>";
	return sendMail($contactEmail,$subject, $text);
}