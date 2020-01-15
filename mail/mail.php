<?php
/**
 * Emerdency - mail.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 20/03/2018
 * Time: 19:23
 * Description :
 */
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/PHPMailer/PHPMailerAutoload.php";
require ($path);

function sendMail($email,$subject,$text){
	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = '	mail3.gridhost.co.uk';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'info@emerdency.co.uk';                 // SMTP username
	$mail->Password = '@emerd123';                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 	465;                                    // TCP port to connect to

	$mail->setFrom('info@emerdency.co.uk', 'Emerdency');
	$mail->addAddress($email);     // Add a recipient

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;

	$path = $_SERVER['DOCUMENT_ROOT'];
	$mail->AddEmbeddedImage($path.'/images/logo-web.jpg', 'logo-web');
	$mail->AddEmbeddedImage($path.'/images/logo-transparent.png', 'logo-transparent');

	$message = "<html>
                <head>    <link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700\" rel=\"stylesheet\"></head>
                <body style=\"font-family: 'Montserrat', sans-serif;background-color:#FFF;font-size:16px;min-width:483px!important;overflow-x: hidden;line-height: 27px;\">
						<div style=\"background-color: #e8541c;color: #fff;text-align: center;padding: 10px;\" >FIXED PRICE &bull; GDC CERTIFIED DENTISTS &bull; LIVE AVAILABILITY</div>
						<div style=\"background-color:#292930;display: inline-block;width: 100%;padding-top: 15px;text-align: center;\"><a href='https://www.emerdency.co.uk'><img src=\"cid:logo-web\" width=\"403\" height=\"199\" /></a></div>
						<div style='min-height:300px;' class=\"main-content\">
  					  		<div style=\"max-width: 1120px;margin: auto;\"class=\"inner-row\">
        						<div class=\"col-1\">
        						".$text." 
        						</div>
    						</div>
						</div>
						
						<div class=\"footer\">
    						<div class=\"row\">
       							 <div class=\"inner-row\">
           							<div style='text-align: center'>
                						<img src=\"cid:logo-transparent\" width=\"254\" height=\"127\"/>
            						</div>
       							 </div>
    						</div>
						</div>
						</body></html>";

	$mail->Body = $message;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
		$error = 'Message could not be sent.';
		$error .= 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		$error = 1;
	}
	return $error;
}