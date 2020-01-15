<?php
/**
 * Emerdency - test-mail.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 20/03/2018
 * Time: 15:18
 * Description :
 */

require '../includes/PHPMailer/PHPMailerAutoload.php';

function sendMail($email,$subject,$message){
	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = '	mail3.gridhost.co.uk';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'website@emerdency.co.uk';                 // SMTP username
	$mail->Password = 'Emerf94**';                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 	465;                                    // TCP port to connect to

	$mail->setFrom('website@emerdency.co.uk', 'Emerdency');
	$mail->addAddress($email);     // Add a recipient

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->AddEmbeddedImage('../images/logo-web.jpg', 'logo-web');
	$mail->AddEmbeddedImage('../images/logo-transparent.png', 'logo-transparent');
	//$mail->msgHTML(file_get_contents('mail-template.html'), __DIR__);
	$mail->Body = $message;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}
}


//echo $message;

sendMail("aamir@coolhandstudios.co.uk", "Test Email", $message);